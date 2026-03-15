<?php 
require_once 'config.php';
include 'header.php';

$stmtTours = $pdo->query("SELECT * FROM tours WHERE status = 1 ORDER BY id DESC LIMIT 6");
$tours = $stmtTours->fetchAll();

$stmtCats = $pdo->query("SELECT * FROM categories");
$categories = $stmtCats->fetchAll();

$stmtNews = $pdo->query("SELECT * FROM news ORDER BY id DESC LIMIT 3");
$newsList = $stmtNews->fetchAll();
?>

<div class="max-w-7xl mx-auto px-4 mt-8">
    <header class="relative h-[400px] rounded-[2.5rem] overflow-hidden flex items-center justify-center text-white shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/60 z-10"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1')] bg-cover bg-center transition-transform duration-700 hover:scale-110"></div>
        <div class="relative z-20 text-center px-6 w-full max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-black mb-4 uppercase tracking-tighter italic">Hành trình mơ ước</h1>
            <p class="text-sm md:text-base mb-8 font-medium text-gray-200 uppercase tracking-[0.3em]">Khám phá vẻ đẹp bất tận cùng TravelPro</p>
            <form action="tours.php" method="GET" class="bg-white/10 backdrop-blur-md p-2 rounded-2xl flex shadow-2xl border border-white/20">
                <input type="text" name="search" placeholder="Bạn muốn đi đâu?" class="flex-1 bg-transparent px-4 py-3 text-white placeholder-gray-300 focus:outline-none text-sm font-bold">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 px-6 py-3 rounded-xl font-black text-xs uppercase transition-all">Tìm kiếm</button>
            </form>
        </div>
    </header>
</div>

<main class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex flex-col lg:flex-row gap-12">
        <aside class="w-full lg:w-1/4">
            <div class="sticky top-28">
                <h3 class="text-xs font-black uppercase tracking-widest text-blue-600 mb-6 flex items-center">
                    <span class="w-8 h-[2px] bg-blue-600 mr-3"></span> Danh mục Tour
                </h3>
                <div class="space-y-2">
                    <a href="tours.php" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-transparent hover:border-blue-100 hover:shadow-md transition-all group">
                        <span class="font-bold text-gray-700 group-hover:text-blue-600">Tất cả chuyến đi</span>
                        <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-blue-600"></i>
                    </a>
                    <?php foreach($categories as $cat): ?>
                    <a href="tours.php?category=<?= $cat['id'] ?>" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-transparent hover:border-blue-100 hover:shadow-md transition-all group">
                        <span class="font-bold text-gray-700 group-hover:text-blue-600"><?= htmlspecialchars($cat['name']) ?></span>
                        <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-blue-600"></i>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="mt-12 bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl">
                    <div class="relative z-10">
                        <h4 class="text-xl font-black leading-tight mb-4">Giảm giá 20% Tour Hè!</h4>
                        <p class="text-xs text-gray-400 mb-6 font-medium">Đăng ký ngay hôm nay để nhận ưu đãi đặc biệt.</p>
                        <a href="#" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest">Nhận mã ngay</a>
                    </div>
                    <i class="fas fa-gift absolute -bottom-4 -right-4 text-8xl text-white/5 -rotate-12"></i>
                </div>
            </div>
        </aside>

        <section class="w-full lg:w-3/4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-black text-gray-900 uppercase italic">Chuyến đi mới nhất</h2>
                <a href="tours.php" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:underline">Khám phá thêm <i class="fas fa-arrow-right ml-1"></i></a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach($tours as $tour): ?>
                <div class="bg-white rounded-[2rem] overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 group">
                    <div class="relative overflow-hidden h-56">
                        <img src="assets/uploads/<?= $tour['image'] ?: 'default-tour.jpg' ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-black text-blue-600 shadow-sm uppercase">
                            <?= $tour['duration'] ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-bold text-gray-800 leading-tight pr-4"><?= htmlspecialchars($tour['title']) ?></h3>
                            <div class="text-right">
                                <span class="block text-[10px] text-gray-400 font-bold line-through uppercase tracking-tighter">Giá cũ</span>
                                <span class="text-blue-600 font-black text-lg leading-none"><?= number_format($tour['price_base'], 0, ',', '.') ?>đ</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-4">
                            <div class="flex items-center text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> <?= $tour['departure_location'] ?>
                            </div>
                            <a href="tour-detail.php?id=<?= $tour['id'] ?>" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 transition-colors shadow-lg shadow-gray-200">Chi tiết</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <section class="mt-24">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-black text-gray-900 uppercase italic tracking-tighter">Cẩm nang du lịch</h2>
        <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.4em] mt-2">Tin tức & Sự kiện mới nhất</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php foreach($newsList as $n): ?>
        <a href="news-detail.php?id=<?= $n['id'] ?>" class="group block">
            <div class="relative h-48 rounded-[2rem] overflow-hidden mb-6 shadow-lg shadow-slate-200/50">
                <img src="assets/uploads/<?= $n['image'] ?: 'default-news.jpg' ?>" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                     alt="<?= htmlspecialchars($n['title']) ?>">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="absolute bottom-4 left-6 text-white text-[10px] font-black uppercase tracking-widest">
                    <i class="far fa-calendar-alt mr-2"></i><?= date('d.m.Y', strtotime($n['created_at'])) ?>
                </div>
            </div>
            
            <div class="px-2">
                <h3 class="text-lg font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition-colors uppercase italic tracking-tighter">
                    <?= htmlspecialchars($n['title']) ?>
                </h3>
                <p class="text-xs text-gray-500 mt-3 line-clamp-2 leading-relaxed font-medium">
                    <?= htmlspecialchars($n['summary']) ?>
                </p>
                <div class="mt-4 text-[10px] font-black text-blue-600 uppercase tracking-widest flex items-center opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                    Xem chi tiết <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
</main>

<?php include 'footer.php'; ?>