<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
        #mobile-menu.open { max-height: 500px; }
        .user-dropdown { display: none; }
        .user-dropdown.show { display: block; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800">
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="index.php" class="text-2xl font-black text-blue-600 flex items-center italic tracking-tighter">
                        <i class="fas fa-plane-departure mr-2"></i>TRAVEL<span class="text-yellow-500">PRO</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8 text-[11px] font-black uppercase tracking-widest text-slate-400">
                    <a href="index.php" class="hover:text-blue-600 transition">Trang chủ</a>
                    <a href="tours.php" class="hover:text-blue-600 transition">Tour du lịch</a>
                    <a href="news.php" class="hover:text-blue-600 transition">Tin tức</a>
                    <a href="contact.php" class="hover:text-blue-600 transition">Liên hệ</a>
                </div>

                <div class="hidden md:flex items-center">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="relative">
                            <button onclick="toggleUserMenu()" class="flex items-center space-x-3 bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100 hover:bg-white hover:shadow-md transition-all group">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['fullname']) ?>&background=random" class="w-8 h-8 rounded-xl border-2 border-white shadow-sm">
                                <span class="text-xs font-black text-slate-700 uppercase tracking-tighter"><?= $_SESSION['user']['fullname'] ?></span>
                                <i class="fas fa-chevron-down text-[10px] text-slate-400 group-hover:text-blue-600"></i>
                            </button>

                            <div id="user-dropdown" class="user-dropdown absolute right-0 mt-3 w-56 bg-white rounded-[2rem] shadow-2xl border border-slate-50 overflow-hidden py-3">
                                <div class="px-6 py-3 border-b border-slate-50 mb-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Tài khoản</p>
                                    <p class="text-xs font-bold text-slate-800 truncate"><?= $_SESSION['user']['email'] ?></p>
                                </div>
                                <a href="profile.php" class="flex items-center px-6 py-3 text-xs font-black text-slate-600 uppercase tracking-tighter hover:bg-blue-50 hover:text-blue-600 transition">
                                    <i class="fas fa-user-circle mr-3 w-4"></i> Hồ sơ cá nhân
                                </a>
                                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                    <a href="admin/index.php" class="flex items-center px-6 py-3 text-xs font-black text-purple-600 uppercase tracking-tighter hover:bg-purple-50 transition">
                                        <i class="fas fa-user-shield mr-3 w-4"></i> Trang quản trị
                                    </a>
                                <?php endif; ?>
                                <div class="px-4 mt-2">
                                    <a href="logout.php" class="flex items-center px-4 py-3 bg-red-50 rounded-2xl text-[10px] font-black text-red-500 uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all text-center justify-center">
                                        Đăng xuất
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="bg-slate-900 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-xl shadow-slate-200">Đăng nhập</a>
                    <?php endif; ?>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="menu-btn" class="outline-none text-2xl text-blue-600">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden bg-white border-t">
            <div class="px-6 py-8 space-y-4 font-black uppercase text-xs tracking-widest">
                <a href="index.php" class="block py-2 text-slate-400 hover:text-blue-600">Trang chủ</a>
                <a href="tours.php" class="block py-2 text-slate-400 hover:text-blue-600">Tour du lịch</a>
                <a href="news.php" class="block py-2 text-slate-400 hover:text-blue-600">Tin tức</a>
                <a href="contact.php" class="block py-2 text-slate-400 hover:text-blue-600">Liên hệ</a>
                <div class="pt-6 border-t">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="flex items-center space-x-4 mb-6">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['fullname']) ?>&background=random" class="w-12 h-12 rounded-2xl">
                            <div>
                                <p class="text-sm font-black text-slate-800 uppercase italic tracking-tighter"><?= $_SESSION['user']['fullname'] ?></p>
                                <a href="profile.php" class="text-[10px] text-blue-600 font-black">Xem hồ sơ</a>
                            </div>
                        </div>
                        <a href="logout.php" class="block bg-red-500 text-white py-4 rounded-2xl text-center shadow-lg">Đăng xuất</a>
                    <?php else: ?>
                        <a href="login.php" class="block bg-slate-900 text-white py-4 rounded-2xl text-center shadow-xl">Đăng nhập</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleUserMenu() {
            document.getElementById('user-dropdown').classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.relative')) {
                const dropdowns = document.getElementsByClassName("user-dropdown");
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].classList.remove('show');
                }
            }
        }

        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('open');
            btn.querySelector('i').classList.toggle('fa-bars');
            btn.querySelector('i').classList.toggle('fa-times');
        });
    </script>