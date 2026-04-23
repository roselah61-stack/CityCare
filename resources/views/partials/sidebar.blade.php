<div class="sidebar">

    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    @can('isReceptionist')
    <a href="{{ route('patient.list') }}" class="{{ request()->is('patient*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        Patients
    </a>
    @endcan

    @if(Gate::check('isReceptionist') || Gate::check('isDoctor') || Gate::check('isPatient'))
    <a href="{{ route('appointments.index') }}" class="{{ request()->is('appointments*') ? 'active' : '' }}">
        <i class="bi bi-calendar-event"></i>
        Appointments
    </a>
    @endif

    @can('isDoctor')
    <a href="{{ route('consultations.index') }}" class="{{ request()->is('consultations*') ? 'active' : '' }}">
        <i class="bi bi-clipboard-pulse"></i>
        Consultations
    </a>
    @endcan

    @can('isPharmacist')
    <a href="{{ route('pharmacy.prescriptions') }}" class="{{ request()->is('pharmacy/prescriptions*') ? 'active' : '' }}">
        <i class="bi bi-prescription"></i>
        Dispense Meds
    </a>
    <a href="{{ route('drug.list') }}" class="{{ request()->is('drug*') ? 'active' : '' }}">
        <i class="bi bi-capsule"></i>
        Inventory
    </a>
    <a href="{{ route('categories.index') }}" class="{{ request()->is('category*') ? 'active' : '' }}">
        <i class="bi bi-folder"></i>
        Drug Categories
    </a>
    @endcan

    @can('isCashier')
    <a href="{{ route('billing.index') }}" class="{{ request()->is('billing*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i>
        Billing & Payments
    </a>
    @endcan

    @can('isAdmin')
    <a href="{{ route('reports.index') }}" class="{{ request()->is('reports*') ? 'active' : '' }}">
        <i class="bi bi-graph-up"></i>
        Reports & Analytics
    </a>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
        <i class="bi bi-person-gear"></i>
        User Management
    </a>
    @endcan

    <div class="sidebar-logout">
        <a href="{{ route('logout') }}" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>
    </div>

</div>
