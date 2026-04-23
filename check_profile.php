<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check users with profile images
$users = App\Models\User::whereNotNull('profile_image')->get();

echo "Users with profile images:\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Image: {$user->profile_image}\n";
    
    // Check if file exists
    $imagePath = public_path($user->profile_image);
    echo "  File exists: " . (file_exists($imagePath) ? "YES" : "NO") . "\n";
    echo "  Full path: " . $imagePath . "\n\n";
}

echo "Total users with profile images: " . $users->count() . "\n";
