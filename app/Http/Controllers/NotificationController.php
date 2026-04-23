<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the user.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $notifications = $user->notifications()
            ->latest()
            ->paginate(20);
            
        return view('notifications.index', compact('notifications'));
    }
    
    /**
     * Mark a specific notification as read.
     */
    public function markAsRead($id)
    {
        $user = auth()->user();
        
        $notification = $user->notifications()
            ->where('id', $id)
            ->firstOrFail();
            
        $notification->markAsRead();
        
        $unreadCount = $user->unreadNotifications()->count();
        
        return response()->json([
            'success' => true,
            'unreadCount' => $unreadCount
        ]);
    }
    
    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = auth()->user();
        
        $user->unreadNotifications()->update(['read_at' => now()]);
        
        return response()->json([
            'success' => true
        ]);
    }
    
    /**
     * Fetch notification count for real-time updates.
     */
    public function fetch()
    {
        $user = auth()->user();
        
        $unreadCount = $user->unreadNotifications()->count();
        
        return response()->json([
            'unreadCount' => $unreadCount
        ]);
    }
    
    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        
        $notification = $user->notifications()
            ->where('id', $id)
            ->firstOrFail();
            
        $notification->delete();
        
        return response()->json([
            'success' => true
        ]);
    }
    
    /**
     * Create a test notification (for development purposes).
     */
    public function createTestNotification(Request $request)
    {
        $user = auth()->user();
        
        $type = $request->input('type', 'general');
        $title = $request->input('title', 'Test Notification');
        $message = $request->input('message', 'This is a test notification.');
        
        $notification = [
            'title' => $title,
            'message' => $message,
            'type' => $type
        ];
        
        $user->notify(new \App\Notifications\DatabaseNotification($notification));
        
        return response()->json([
            'success' => true,
            'message' => 'Test notification created successfully'
        ]);
    }
}
