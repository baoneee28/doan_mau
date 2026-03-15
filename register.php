<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->execute([$username, $email]);
    
    if ($check->rowCount() > 0) {
        $error = "Tên đăng nhập hoặc email đã được sử dụng!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, fullname, email, role) VALUES (?, ?, ?, ?, 'user')");
        if ($stmt->execute([$username, $password, $fullname, $email])) {
            header("Location: login.php?success=1");
            exit;
        }
    }
}

include 'header.php';
?>

<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <div class="text-3xl font-bold text-blue-600 inline-flex items-center">
                <i class="fas fa-plane-departure mr-2"></i>TRAVEL<span class="text-yellow-500">PRO</span>
            </div>
            <p class="text-gray-500 mt-2 font-medium">Tạo tài khoản du lịch của bạn</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm border border-red-200">
                <i class="fas fa-exclamation-triangle mr-2"></i><?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Họ và tên</label>
                <input type="text" name="fullname" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tên đăng nhập</label>
                <input type="text" name="username" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mật khẩu</label>
                <input type="password" name="password" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-lg font-bold hover:bg-yellow-600 transform hover:scale-[1.02] transition duration-200 shadow-md mt-4">
                TẠO TÀI KHOẢN
            </button>
        </form>

        <div class="text-center mt-6 border-t pt-6">
            <span class="text-gray-600">Đã có tài khoản?</span>
            <a href="login.php" class="text-blue-600 font-bold hover:underline ml-1">Đăng nhập</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>