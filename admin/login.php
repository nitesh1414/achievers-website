<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (login_admin($username, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login • Achievers Academy CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css?v=20260909-compact-6">
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-3xl p-8 shadow-2xl">
            <div class="flex justify-center mb-6">
                <div class="w-11 h-11 bg-amber-400 flex items-center justify-center text-slate-900 rounded-full text-3xl font-extrabold">A</div>
            </div>
            <h1 class="text-center text-3xl font-bold text-slate-900">Achievers Academy</h1>
            <p class="text-center text-slate-500 text-sm mt-1 mb-7">Admin CMS Panel</p>
            
            <?php if ($error): ?>
                <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 text-sm rounded-lg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-slate-600">Username</label>
                    <input type="text" name="username" value="admin" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:border-amber-400">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-600">Password</label>
                    <input type="password" name="password" value="admin123" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:border-amber-400">
                    <p class="text-[10px] mt-1 text-amber-600">Demo: admin / admin123</p>
                </div>
                
                <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white py-3.5 rounded-2xl font-semibold">Sign In to CMS</button>
            </form>
            
            <div class="text-center mt-6 text-xs text-slate-400">Secure • PDO protected</div>
        </div>
    </div>
</body>
</html>