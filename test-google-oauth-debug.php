<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "===========================================\n";
echo "Google OAuth Debug - Email Verification\n";
echo "===========================================\n\n";

// Test 1: Cek struktur tabel users
echo "📊 Test 1: Struktur Tabel Users\n";
echo "-------------------------------------------\n";
$columns = DB::select("SHOW COLUMNS FROM users");
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type}) " . ($column->Null === 'YES' ? 'NULLABLE' : 'NOT NULL') . "\n";
}
echo "\n";

// Test 2: Cek data users
echo "👥 Test 2: Data Users (dengan google_id)\n";
echo "-------------------------------------------\n";
$users = DB::table('users')
    ->select('id', 'name', 'email', 'google_id', 'email_verified_at', 'created_at')
    ->get();

if ($users->isEmpty()) {
    echo "❌ Tidak ada user di database\n";
} else {
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Google ID: " . ($user->google_id ?? '(null)') . "\n";
        echo "Email Verified: " . ($user->email_verified_at ?? '(NOT VERIFIED)') . "\n";
        echo "Created: {$user->created_at}\n";
        echo "---\n";
    }
}
echo "\n";

// Test 3: Cek User Model - hasVerifiedEmail() method
echo "🔍 Test 3: Test hasVerifiedEmail() Method\n";
echo "-------------------------------------------\n";
$testUser = App\Models\User::first();
if ($testUser) {
    echo "Testing user: {$testUser->email}\n";
    echo "email_verified_at: " . ($testUser->email_verified_at ?? 'NULL') . "\n";
    echo "hasVerifiedEmail(): " . ($testUser->hasVerifiedEmail() ? 'TRUE ✅' : 'FALSE ❌') . "\n";
    echo "MustVerifyEmail interface: " . ($testUser instanceof Illuminate\Contracts\Auth\MustVerifyEmail ? 'YES ✅' : 'NO ❌') . "\n";
} else {
    echo "❌ Tidak ada user untuk di-test\n";
}
echo "\n";

// Test 4: Cek middleware verified configuration
echo "⚙️  Test 4: Middleware Configuration\n";
echo "-------------------------------------------\n";
$kernel = app(\App\Http\Kernel::class);
$middlewares = (new ReflectionClass($kernel))->getProperty('middlewareAliases');
$middlewares->setAccessible(true);
$aliases = $middlewares->getValue($kernel);

if (isset($aliases['verified'])) {
    echo "Middleware 'verified' registered as: {$aliases['verified']}\n";
    
    // Cek apakah custom atau default Laravel
    if ($aliases['verified'] === \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class) {
        echo "⚠️  Using DEFAULT Laravel middleware (tidak ada special handling untuk Google OAuth)\n";
    } else {
        echo "✅ Using CUSTOM middleware\n";
    }
} else {
    echo "❌ Middleware 'verified' TIDAK TERDAFTAR!\n";
}
echo "\n";

// Test 5: Check routes dengan middleware verified
echo "🛣️  Test 5: Routes with 'verified' Middleware\n";
echo "-------------------------------------------\n";
$routes = Route::getRoutes();
$verifiedRoutes = [];

foreach ($routes as $route) {
    $middleware = $route->middleware();
    if (in_array('verified', $middleware)) {
        $verifiedRoutes[] = [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
        ];
    }
}

if (empty($verifiedRoutes)) {
    echo "❌ Tidak ada route yang menggunakan middleware 'verified'\n";
} else {
    echo "Found " . count($verifiedRoutes) . " routes with 'verified' middleware:\n";
    foreach ($verifiedRoutes as $route) {
        echo "- [{$route['method']}] {$route['uri']} (name: {$route['name']})\n";
    }
}
echo "\n";

// Test 6: Simulate Google OAuth user creation
echo "🧪 Test 6: Simulate Google OAuth Flow\n";
echo "-------------------------------------------\n";
echo "Creating test user with Google OAuth data...\n";

$testData = [
    'name' => 'Test Google User',
    'email' => 'test.google.oauth@example.com',
    'google_id' => '123456789012345678901',
    'password' => Hash::make(Str::random(16)),
    'email_verified_at' => now(),
    'role' => 'customer',
];

echo "Test data:\n";
foreach ($testData as $key => $value) {
    if ($key === 'password') {
        echo "- {$key}: [HASHED]\n";
    } else {
        echo "- {$key}: {$value}\n";
    }
}

// Check if test user already exists
$existingTest = DB::table('users')->where('email', $testData['email'])->first();
if ($existingTest) {
    echo "\n⚠️  Test user already exists (ID: {$existingTest->id})\n";
    echo "Deleting test user...\n";
    DB::table('users')->where('email', $testData['email'])->delete();
}

try {
    $newUser = App\Models\User::create($testData);
    echo "\n✅ Test user created successfully!\n";
    echo "ID: {$newUser->id}\n";
    echo "hasVerifiedEmail(): " . ($newUser->hasVerifiedEmail() ? 'TRUE ✅' : 'FALSE ❌') . "\n";
    
    // Clean up
    $newUser->delete();
    echo "\nTest user deleted (cleanup).\n";
} catch (\Exception $e) {
    echo "\n❌ Failed to create test user: {$e->getMessage()}\n";
}

echo "\n";
echo "===========================================\n";
echo "Debug completed!\n";
echo "===========================================\n";
