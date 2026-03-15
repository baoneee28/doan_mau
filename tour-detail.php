<?php
require_once 'config.php';
include 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT t.*, c.name as cat_name FROM tours t LEFT JOIN categories c ON t.category_id = c.id WHERE t.id = ? AND t.status = 1");
$stmt->execute([$id]);
$tour = $stmt->fetch();

if (!$tour) { header("Location: index.php"); exit; }

$user_booking = null;
if (isset($_SESSION['user'])) {
    $stmt_check = $pdo->prepare("SELECT status FROM bookings WHERE user_id = ? AND tour_id = ? AND status != 'cancelled' ORDER BY id DESC LIMIT 1");
    $stmt_check->execute([$_SESSION['user']['id'], $id]);
    $user_booking = $stmt_check->fetch();
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .tour-content-scroll { max-height: 550px; overflow-y: auto; padding-right: 15px; }
    .tour-content-scroll::-webkit-scrollbar { width: 4px; }
    .tour-content-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .tour-content-scroll::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
    .font-black-italic { font-weight: 900; font-style: italic; }
</style>

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-8">
                <div class="mb-8">
                    <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] text-blue-600 mb-4 items-center">
                        <a href="index.php" class="hover:opacity-70 transition">Trang chủ</a>
                        <i class="fas fa-chevron-right mx-3 text-[8px] text-gray-300"></i>
                        <span class="text-gray-400 italic"><?= $tour['cat_name'] ?></span>
                    </nav>
                    <h1 class="text-4xl md:text-6xl font-black-italic text-slate-900 leading-[1.1] uppercase tracking-tighter mb-6">
                        <?= htmlspecialchars($tour['title']) ?>
                    </h1>
                </div>

                <div class="rounded-[3.5rem] overflow-hidden shadow-2xl shadow-blue-100/50 mb-12 border-[12px] border-white relative group">
                    <img src="assets/uploads/<?= $tour['image'] ?: 'default-tour.jpg' ?>" class="w-full h-[550px] object-cover transition-transform duration-1000 group-hover:scale-105">
                    <div class="absolute bottom-8 left-8 flex gap-4">
                        <div class="bg-white/90 backdrop-blur-md px-6 py-3 rounded-2xl shadow-xl border border-white/50">
                            <p class="text-[9px] font-black text-blue-600 uppercase mb-1">Thời gian</p>
                            <p class="text-sm font-bold text-slate-800"><?= $tour['duration'] ?></p>
                        </div>
                        <div class="bg-white/90 backdrop-blur-md px-6 py-3 rounded-2xl shadow-xl border border-white/50">
                            <p class="text-[9px] font-black text-orange-600 uppercase mb-1">Khởi hành</p>
                            <p class="text-sm font-bold text-slate-800"><?= $tour['departure_location'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 md:p-14 rounded-[3.5rem] shadow-xl shadow-slate-200/40 border border-slate-50 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50/50 rounded-full -mr-20 -mt-20"></div>
                    <h3 class="text-2xl font-black-italic uppercase text-slate-800 mb-10 flex items-center relative z-10">
                        <span class="w-12 h-2 bg-blue-600 rounded-full mr-5 shadow-lg shadow-blue-200"></span> 
                        Lịch trình chi tiết
                    </h3>
                    <div class="tour-content-scroll prose prose-slate max-w-none text-slate-600 leading-relaxed font-medium text-lg relative z-10">
                        <?= $tour['content'] ?>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-28 space-y-8">
                    <div class="bg-white rounded-[3.5rem] p-10 shadow-2xl border border-slate-50 relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                        
                        <div class="mb-10 text-center">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 italic">Giá vé trọn gói</p>
                            <div class="inline-flex items-baseline bg-blue-50 px-6 py-2 rounded-2xl">
                                <span class="text-4xl font-black text-blue-600 tracking-tighter"><?= number_format($tour['price_base'], 0, ',', '.') ?>đ</span>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($user_booking && $user_booking['status'] == 'pending'): ?>
                                <div class="p-8 bg-amber-50 rounded-[2.5rem] text-center border border-amber-100 shadow-inner">
                                    <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center mx-auto mb-5 text-amber-500 shadow-sm"><i class="fas fa-history animate-spin-slow"></i></div>
                                    <p class="text-xs font-black text-amber-800 uppercase leading-relaxed tracking-tighter">Đã nhận yêu cầu<br><span class="text-[10px] opacity-60">Vui lòng đợi quản trị viên duyệt</span></p>
                                </div>
                            <?php elseif ($user_booking && $user_booking['status'] == 'confirmed'): ?>
                                <div class="p-8 bg-emerald-50 rounded-[2.5rem] text-center border border-emerald-100 shadow-inner">
                                    <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center mx-auto mb-5 text-emerald-500 shadow-sm"><i class="fas fa-check-double"></i></div>
                                    <p class="text-[10px] font-black text-emerald-800 uppercase leading-relaxed tracking-tighter px-2">Tuyệt vời! Ban quản trị đã duyệt. Hãy chuẩn bị cho hành trình của bạn.</p>
                                </div>
                            <?php else: ?>
                                <form id="bookingForm" action="booking_process.php" method="POST" class="space-y-5">
                                    <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
                                    <input type="hidden" name="total_price" id="final_price_input" value="<?= $tour['price_base'] ?>">
                                    
                                    <div class="space-y-3">
                                        <input type="text" name="customer_name" value="<?= $_SESSION['user']['fullname'] ?>" required class="w-full p-4.5 bg-slate-50 border-0 rounded-2xl text-xs font-black outline-none focus:ring-2 focus:ring-blue-500 transition-all text-center">
                                        <input type="text" name="customer_phone" value="<?= $_SESSION['user']['phone'] ?>" required class="w-full p-4.5 bg-slate-50 border-0 rounded-2xl text-xs font-black outline-none focus:ring-2 focus:ring-blue-500 transition-all text-center">
                                    </div>

                                    <div class="pt-8 border-t border-dashed border-slate-200 mt-8">
                                        <button type="button" onclick="handleBooking()" class="w-full bg-slate-900 text-white py-5 rounded-[1.8rem] font-black uppercase text-[11px] tracking-[0.2em] shadow-2xl shadow-slate-300 hover:bg-blue-600 transition-all active:scale-95 flex items-center justify-center">
                                            ĐẶT TOUR NGAY <i class="fas fa-chevron-right ml-3 text-[8px]"></i>
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="login.php" class="block w-full bg-slate-900 text-white py-5 rounded-[1.8rem] font-black uppercase text-[11px] tracking-[0.2em] text-center shadow-2xl">ĐĂNG NHẬP ĐỂ ĐẶT VÉ</a>
                        <?php endif; ?>
                    </div>

                    <div class="bg-slate-900 rounded-[3rem] p-10 text-white relative overflow-hidden group shadow-2xl shadow-slate-900/30">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-3 italic leading-none">Cần hỗ trợ?</p>
                            <a href="tel:0354781433" class="flex items-center group-hover:translate-x-1 transition-transform">
                                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-blue-500/30"><i class="fas fa-phone-alt text-sm"></i></div>
                                <span class="text-2xl font-black tracking-tighter">0354781433</span>
                            </a>
                        </div>
                        <i class="fas fa-globe-asia absolute -bottom-6 -right-6 text-9xl text-white/5 -rotate-12 transition-transform duration-1000 group-hover:rotate-0"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleBooking() {
        const total = <?= $tour['price_base'] ?>;
        const deposit = (total * 0.3).toLocaleString('vi-VN');
        const qrUrl = `https://img.vietqr.io/image/CAKE-0817289830-compact2.png?amount=${total*0.3}&addInfo=PAYTOUR_${Date.now()}&accountName=DAO%20THI%20LAM`;

        Swal.fire({
            title: '<span class="uppercase font-black text-sm italic tracking-[0.2em]">Thanh toán đặt cọc 30%</span>',
            html: `
                <div class="text-center p-2">
                    <img src="${qrUrl}" class="mx-auto w-56 h-56 border-8 border-slate-50 rounded-[2.5rem] mb-6 shadow-sm">
                    <div class="text-left space-y-2 bg-slate-50 p-6 rounded-[2.5rem] text-[11px] font-bold text-slate-500 border border-slate-100">
                        <div class="flex justify-between uppercase"><span>Ngân hàng:</span><span class="text-slate-900">CAKE (VPBank)</span></div>
                        <div class="flex justify-between border-t border-slate-200 pt-2 uppercase"><span>Số tài khoản:</span><span class="text-slate-900 text-sm">0817289830</span></div>
                        <div class="flex justify-between border-t border-slate-200 pt-2 uppercase"><span>Chủ tài khoản:</span><span class="text-slate-900 font-black">DAO THI LAM</span></div>
                        <div class="flex justify-between border-t border-slate-300 pt-3 text-blue-600 uppercase"><span>Tiền cọc:</span><span class="text-lg font-black">${deposit}đ</span></div>
                    </div>
                    <p class="mt-6 text-[10px] text-slate-400 font-bold italic leading-relaxed px-4 underline decoration-blue-500/30 underline-offset-4 decoration-2">Vui lòng liên hệ hotline: 0354781433 sau khi thanh toán thành công.</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check-circle mr-2"></i> ĐÃ CHUYỂN KHOẢN',
            cancelButtonText: '<i class="fas fa-times-circle mr-2"></i> HỦY BỎ',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            reverseButtons: true,
            customClass: { popup: 'rounded-[3.5rem] border-0', confirmButton: 'rounded-2xl px-8 py-4 font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-200', cancelButton: 'rounded-2xl px-8 py-4 font-black uppercase text-[10px] tracking-widest shadow-xl shadow-slate-100' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Đang xử lý...', didOpen: () => Swal.showLoading(), allowOutsideClick: false });
                setTimeout(() => { document.getElementById('bookingForm').submit(); }, 1000);
            }
        });
    }
</script>

<?php include 'footer.php'; ?>