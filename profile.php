<?php
require_once 'config.php';
include 'header.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$user = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user->execute([$user_id]);
$curr_user = $user->fetch();

$tab = $_GET['tab'] ?? 'info';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3;
$offset = ($page - 1) * $limit;

$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE user_id = ?");
$count_stmt->execute([$user_id]);
$total_bookings = $count_stmt->fetchColumn();
$total_pages = ceil($total_bookings / $limit);

$bookings = $pdo->prepare("SELECT b.*, t.title, t.image FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.user_id = ? ORDER BY b.id DESC LIMIT $limit OFFSET $offset");
$bookings->execute([$user_id]);
$my_bookings = $bookings->fetchAll();
?>

<div class="bg-[#f8fafc] min-h-screen pb-20">
    <div class="max-w-6xl mx-auto px-4 pt-10">
        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="w-full lg:w-1/3 space-y-6">
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-slate-900"></div>
                    <div class="relative z-10 text-center">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($curr_user['fullname']) ?>&background=random&size=128" 
                             class="w-24 h-24 rounded-[2rem] mx-auto border-4 border-white shadow-lg mb-4">
                        <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter"><?= htmlspecialchars($curr_user['fullname']) ?></h2>
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mt-1"><?= $curr_user['role'] ?></p>
                    </div>

                    <nav class="mt-10 space-y-2">
                        <a href="?tab=info" class="flex items-center justify-between p-4 rounded-2xl transition-all <?= $tab == 'info' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' ?>">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle w-8"></i>
                                <span class="text-xs font-black uppercase tracking-widest">Thông tin cá nhân</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                        <a href="?tab=tours" class="flex items-center justify-between p-4 rounded-2xl transition-all <?= $tab == 'tours' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' ?>">
                            <div class="flex items-center">
                                <i class="fas fa-map-marked-alt w-8"></i>
                                <span class="text-xs font-black uppercase tracking-widest">Chuyến đi của tôi</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                        <a href="logout.php" class="flex items-center p-4 rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                            <i class="fas fa-sign-out-alt w-8"></i>
                            <span class="text-xs font-black uppercase tracking-widest">Đăng xuất</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <div class="w-full lg:w-2/3">
                <?php if ($tab == 'info'): ?>
                    <div class="bg-white rounded-[3rem] p-10 shadow-xl border border-white">
                        <h3 class="text-2xl font-black italic uppercase text-slate-800 mb-8 flex items-center tracking-tighter">
                            <span class="w-10 h-1.5 bg-blue-600 rounded-full mr-4"></span> Hồ sơ cá nhân
                        </h3>
                        <form action="profile_process.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-2">Họ và tên</label>
                                <input type="text" name="fullname" value="<?= htmlspecialchars($curr_user['fullname']) ?>" class="w-full p-4 bg-slate-50 border-0 rounded-2xl text-xs font-black outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-2">Email</label>
                                <input type="email" value="<?= $curr_user['email'] ?>" readonly class="w-full p-4 bg-slate-100 border-0 rounded-2xl text-xs font-black text-slate-400 cursor-not-allowed">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-2">Số điện thoại</label>
                                <input type="text" name="phone" value="<?= $curr_user['phone'] ?>" class="w-full p-4 bg-slate-50 border-0 rounded-2xl text-xs font-black outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-2">Mật khẩu mới</label>
                                <input type="password" name="new_password" placeholder="Bỏ trống nếu không đổi" class="w-full p-4 bg-slate-50 border-0 rounded-2xl text-xs font-black outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="md:col-span-2 pt-4">
                                <button type="submit" class="w-full md:w-auto bg-slate-900 text-white px-10 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-blue-600 shadow-xl transition-all">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>

                <?php elseif ($tab == 'tours'): ?>
                    <div class="bg-white rounded-[3rem] p-10 shadow-xl border border-white">
                        <h3 class="text-2xl font-black italic uppercase text-slate-800 mb-8 flex items-center tracking-tighter">
                            <span class="w-10 h-1.5 bg-blue-600 rounded-full mr-4"></span> Lịch sử đặt Tour
                        </h3>
                        <div class="space-y-4">
                            <?php if (empty($my_bookings)): ?>
                                <p class="text-center text-slate-400 py-10 font-bold uppercase text-[10px] tracking-widest italic">Bạn chưa thực hiện chuyến đi nào</p>
                            <?php endif; ?>

                            <?php foreach($my_bookings as $b): ?>
                                <div class="flex flex-col md:flex-row items-center gap-6 p-5 bg-slate-50 rounded-[2rem] border border-slate-100 hover:shadow-lg transition-all group">
                                    <img src="assets/uploads/<?= $b['image'] ?: 'default.jpg' ?>" class="w-24 h-24 rounded-2xl object-cover shadow-sm">
                                    <div class="flex-1 text-center md:text-left">
                                        <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1"><?= date('d/m/Y', strtotime($b['booking_date'])) ?></p>
                                        <h4 class="text-sm font-black text-slate-800 uppercase italic tracking-tighter leading-none mb-2"><?= htmlspecialchars($b['title']) ?></h4>
                                        <p class="text-sm font-black text-slate-900"><?= number_format($b['total_price'], 0, ',', '.') ?>đ</p>
                                    </div>
                                    <div class="text-right">
                                        <?php if ($b['status'] == 'pending'): ?>
                                            <span class="inline-block px-4 py-2 bg-amber-100 text-amber-600 rounded-xl text-[9px] font-black uppercase tracking-widest">Đang chờ duyệt</span>
                                        <?php elseif ($b['status'] == 'confirmed'): ?>
                                            <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-600 rounded-xl text-[9px] font-black uppercase tracking-widest">Đã duyệt</span>
                                        <?php elseif ($b['status'] == 'completed'): ?>
                                            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-xl text-[9px] font-black uppercase tracking-widest">Hoàn thành</span>
                                        <?php else: ?>
                                            <span class="inline-block px-4 py-2 bg-slate-200 text-slate-500 rounded-xl text-[9px] font-black uppercase tracking-widest">Đã hủy</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($total_pages > 1): ?>
                        <div class="flex justify-center gap-2 mt-8">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?tab=tours&page=<?= $i ?>" class="w-10 h-10 flex items-center justify-center rounded-xl font-black text-xs transition-all <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400 hover:bg-slate-200' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>