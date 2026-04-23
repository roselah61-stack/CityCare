<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Models\Drug;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::with(['user', 'cashier']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('total_amount', 'like', "%{$search}%")
                  ->orWhere('bill_type', 'like', "%{$search}%")
                  ->orWhere('payment_status', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhere('merchant_reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('cashier', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by bill type
        if ($request->filled('bill_type')) {
            $query->where('bill_type', $request->bill_type);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by amount range
        if ($request->filled('amount_from')) {
            $query->where('total_amount', '>=', $request->amount_from);
        }
        if ($request->filled('amount_to')) {
            $query->where('total_amount', '<=', $request->amount_to);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by cashier
        if ($request->filled('cashier_id')) {
            $query->where('cashier_id', $request->cashier_id);
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['total_amount', 'payment_status', 'bill_type', 'created_at'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        // Pagination
        $bills = $query->paginate(15)->withQueryString();

        // Get cashiers for filter dropdown
        $cashiers = User::whereHas('role', function($q) {
            $q->whereIn('name', ['admin', 'cashier']);
        })->get();

        if ($request->ajax()) {
            return response()->json([
                'bills' => $bills,
                'html' => view('billing.partials.bills_table', compact('bills'))->render()
            ]);
        }

        return view('billing.index', compact('bills', 'cashiers'));
    }

    // Product selection for billing
    public function products()
    {
        $drugs = Drug::with('category')->where('quantity', '>', 0)->latest()->get();
        $cart = session('cart', []);
        return view('billing.products', compact('drugs', 'cart'));
    }

    // Cashier dashboard
    public function dashboard()
    {
        $cashier = Auth::user();
        
        // Get today's payments
        $todayPayments = Bill::with(['user'])
            ->where('cashier_id', $cashier->id)
            ->where('payment_status', 'completed')
            ->whereDate('created_at', today())
            ->get();

        // Get pending payments
        $pendingPayments = Bill::with(['user'])
            ->where('payment_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate statistics
        $stats = [
            'today_revenue' => $todayPayments->sum('total_amount'),
            'today_transactions' => $todayPayments->count(),
            'pending_payments' => Bill::where('payment_status', 'pending')->count(),
            'total_revenue' => Bill::where('payment_status', 'completed')->sum('total_amount'),
        ];

        return view('cashier.dashboard', compact('todayPayments', 'pendingPayments', 'stats'));
    }

    // Payment tracking for cashiers
    public function paymentTracking(Request $request)
    {
        $query = Bill::with(['user']);

        // If cashier, only show their transactions
        if (Auth::user()->role->name === 'cashier') {
            $query->where('cashier_id', Auth::id());
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by patient name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $bills = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('cashier.payments', compact('bills'));
    }

    // Enhanced payment processing for cashiers
    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,mobile_money,card',
            'amount_paid' => 'required|numeric|min:0',
            'payment_notes' => 'nullable|string|max:1000'
        ]);

        $bill = Bill::findOrFail($id);
        
        if ($bill->payment_status === 'completed') {
            return back()->with('error', 'This bill has already been paid.');
        }

        // Check if amount paid is sufficient
        if ($request->amount_paid < $bill->total_amount) {
            return back()->with('error', 'Amount paid is insufficient. Total amount: UGX ' . number_format($bill->total_amount, 0));
        }

        // Generate receipt number
        $receiptNumber = 'RCT-' . date('Y') . '-' . str_pad($bill->id, 6, '0', STR_PAD_LEFT);
        
        // Update bill with payment details
        $bill->update([
            'payment_status' => 'completed',
            'payment_method' => $request->payment_method,
            'cashier_id' => Auth::id(),
            'merchant_reference' => $receiptNumber,
            'pesapal_tracking_id' => $request->payment_method === 'mobile_money' ? $request->phone_number : null
        ]);

        // Create payment record
        $paymentData = [
            'bill_id' => $bill->id,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount_paid,
            'amount_paid' => $request->amount_paid,
            'change_due' => $request->amount_paid - $bill->total_amount,
            'payment_date' => now(),
            'receipt_number' => $receiptNumber,
            'cashier_id' => Auth::id(),
            'notes' => $request->payment_notes
        ];

        // Add payment method specific details
        if ($request->payment_method === 'mobile_money') {
            $paymentData['phone_number'] = $request->phone_number;
            $paymentData['mobile_provider'] = $request->mobile_provider;
        } elseif ($request->payment_method === 'card') {
            $paymentData['card_last4'] = $request->card_last4;
            $paymentData['card_holder'] = $request->card_holder;
        }

        // Store payment details in session for receipt
        session(['payment_data' => $paymentData]);

        return redirect()->route('billing.show', $bill->id)
            ->with('success', 'Payment processed successfully! Receipt: ' . $receiptNumber);
    }

    // Add to cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $drug = Drug::findOrFail($request->drug_id);
        
        if ($drug->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cart = session('cart', []);
        
        if (isset($cart[$drug->id])) {
            $cart[$drug->id]['quantity'] += $request->quantity;
        } else {
            $cart[$drug->id] = [
                'name' => $drug->name,
                'price' => $drug->price,
                'quantity' => $request->quantity,
                'description' => $drug->description ?? 'No description available'
            ];
        }
        
        session(['cart' => $cart]);
        
        return back()->with('success', 'Product added to cart successfully.');
    }

    // Update cart
    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session('cart', []);
        
        if (isset($cart[$request->id])) {
            $drug = Drug::find($request->id);
            if ($drug && $drug->quantity >= $request->quantity) {
                $cart[$request->id]['quantity'] = $request->quantity;
                session(['cart' => $cart]);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Insufficient stock'], 400);
            }
        }
        
        return response()->json(['error' => 'Item not found in cart'], 404);
    }

    // Remove from cart
    public function removeFromCart(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        
        $cart = session('cart', []);
        unset($cart[$request->id]);
        session(['cart' => $cart]);
        
        return response()->json(['success' => true]);
    }

    // View cart
    public function cart()
    {
        $cart = session('cart', []);
        return view('billing.cart', compact('cart'));
    }

    // Checkout
    public function checkout()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('billing.products')->with('error', 'Your cart is empty.');
        }
        
        // Use logged-in user automatically
$currentUser = Auth::user();
        
        return view('billing.checkout', compact('cart', 'currentUser'));
    }

    // Process checkout
    public function processCheckout(Request $request)
    {
        // Use logged-in user automatically
        $currentUser = Auth::user();
        
        if (!$currentUser) {
            return redirect()->route('login')->with('error', 'Please login to continue checkout.');
        }

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $totalAmount = 0;
        $items = [];

        foreach ($cart as $id => $details) {
            $drug = Drug::find($id);
            if (!$drug || $drug->quantity < $details['quantity']) {
                return back()->with('error', 'Some items in your cart are no longer available.');
            }
            
            $totalAmount += $details['price'] * $details['quantity'];
            $items[] = [
                'drug_id' => $id,
                'name' => $details['name'],
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'subtotal' => $details['price'] * $details['quantity']
            ];
            
            // Update drug quantity
            $drug->decrement('quantity', $details['quantity']);
        }

        $bill = Bill::create([
            'user_id' => $currentUser->id,
            'total_amount' => $totalAmount,
            'bill_type' => 'pharmacy',
            'items' => $items,
            'payment_status' => 'pending',
            'cashier_id' => Auth::id()
        ]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('billing.payment', $bill->id)->with('success', 'Bill generated successfully. Please complete payment.');
    }

    public function create($patient_id)
    {
        $patient = User::findOrFail($patient_id);
        $prescriptions = Prescription::with('items.drug')
            ->where('patient_id', $patient_id)
            ->where('status', 'dispensed')
            ->get();

        return view('billing.create', compact('patient', 'prescriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'total_amount' => 'required|numeric'
        ]);

        $bill = Bill::create([
            'user_id' => $request->user_id,
            'total_amount' => $request->total_amount,
            'bill_type' => $request->bill_type ?? 'consultation',
            'items' => $request->items,
            'payment_status' => 'pending',
            'cashier_id' => Auth::id()
        ]);

        return redirect()->route('billing.show', $bill->id)->with('success', 'Bill generated successfully.');
    }

    public function show($id)
    {
        $bill = Bill::with(['user', 'cashier'])->findOrFail($id);
        return view('billing.show', compact('bill'));
    }

    
    // Show payment page
    public function payment($id)
    {
        $bill = Bill::with(['user', 'cashier'])->findOrFail($id);
        
        if ($bill->payment_status === 'completed') {
            return redirect()->route('billing.show', $bill->id)->with('info', 'This bill has already been paid.');
        }
        
        return view('billing.payment', compact('bill'));
    }

    // Confirm payment
    public function confirmPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,mobile_money,card',
            'phone_number' => 'required_if:payment_method,mobile_money|regex:/^07[0-9]{8}$/',
            'mobile_provider' => 'required_if:payment_method,mobile_money|in:airtel,mtn',
            'card_last4' => 'required_if:payment_method,card|digits:4',
            'card_holder' => 'required_if:payment_method,card|string|max:255',
            'payment_notes' => 'nullable|string|max:1000'
        ]);

        $bill = Bill::findOrFail($id);
        
        if ($bill->payment_status === 'completed') {
            return back()->with('error', 'This bill has already been paid.');
        }

        // Generate receipt number
        $receiptNumber = 'RCT-' . date('Y') . '-' . str_pad($bill->id, 6, '0', STR_PAD_LEFT);
        
        // Update bill with payment details
        $bill->update([
            'payment_status' => 'completed',
            'payment_method' => $request->payment_method,
            'cashier_id' => Auth::id(),
            'merchant_reference' => $receiptNumber,
            'pesapal_tracking_id' => $request->payment_method === 'mobile_money' ? $request->phone_number : null
        ]);

        // Create payment record (optional - for detailed payment tracking)
        $paymentData = [
            'bill_id' => $bill->id,
            'payment_method' => $request->payment_method,
            'amount' => $bill->total_amount,
            'payment_date' => now(),
            'receipt_number' => $receiptNumber,
            'cashier_id' => Auth::id(),
            'notes' => $request->payment_notes
        ];

        // Add payment method specific details
        if ($request->payment_method === 'mobile_money') {
            $paymentData['phone_number'] = $request->phone_number;
            $paymentData['mobile_provider'] = $request->mobile_provider;
        } elseif ($request->payment_method === 'card') {
            $paymentData['card_last4'] = $request->card_last4;
            $paymentData['card_holder'] = $request->card_holder;
        }

        // Store payment details in session for receipt
        session(['payment_data' => $paymentData]);

        return redirect()->route('billing.show', $bill->id)
            ->with('success', 'Payment processed successfully! Receipt: ' . $receiptNumber);
    }

    // Print receipt
    public function printReceipt($id)
    {
        $bill = Bill::with(['user', 'cashier'])->findOrFail($id);
        $paymentData = session('payment_data', []);
        
        return view('billing.receipt', compact('bill', 'paymentData'));
    }
}
