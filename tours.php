<?php
require_once 'config.php';
include 'header.php';

$cat_id = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$min_price_filter = $_GET['min_price'] ?? null;
$max_price_filter = $_GET['max_price'] ?? null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

$price_range = $pdo->query("SELECT MIN(price_base) as min_p, MAX(price_base) as max_p FROM tours WHERE status = 1")->fetch();
$db_min = $price_range['min_p'] ?? 0;
$db_max = $price_range['max_p'] ?? 10000000;

$min_price = $min_price_filter ?? $db_min;
$max_price = $max_price_filter ?? $db_max;

$where = "WHERE status = 1";
$params = [];

if ($cat_id) { $where .= " AND category_id = ?"; $params[] = $cat_id; }
if ($search) { $where .= " AND title LIKE ?"; $params[] = "%$search%"; }
$where .= " AND price_base BETWEEN ? AND ?";
$params[] = $min_price;
$params[] = $max_price;

$count_sql = "SELECT COUNT(*) FROM tours $where";
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($params);
$total_rows = $count_stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT t.*, c.name as cat_name FROM tours t LEFT JOIN categories c ON t.category_id = c.id $where ORDER BY t.id DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tours = $stmt->fetchAll();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<main class="bg-[#f8fafc] min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-10">
            <aside class="w-full lg:w-1/4">
                <div class="sticky top-28 space-y-8">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-blue-600 mb-8 flex items-center">
                            <span class="w-6 h-1 bg-blue-600 rounded-full mr-3"></span> Bộ lọc tìm kiếm
                        </h3>

                        <form action="" method="GET" id="filterForm" class="space-y-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Từ khóa</label>
                                <div class="relative">
                                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Nhập tên tour..." 
                                           class="w-full pl-10 pr-4 py-3.5 bg-slate-50 border-0 rounded-2xl text-xs font-bold outline-none focus:ring-2 focus:ring-blue-500">
                                    <i class="fas fa-search absolute left-4 top-4 text-slate-300"></i>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Danh mục</label>
                                <select name="category" class="w-full p-3.5 bg-slate-50 border-0 rounded-2xl text-xs font-bold outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                                    <option value="">Tất cả danh mục</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $cat_id == $cat['id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="space-y-5">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-black uppercase text-slate-400 ml-1">Khoảng giá</label>
                                    <span class="text-[10px] font-black text-blue-600 uppercase italic" id="priceLabel"></span>
                                </div>
                                <input type="range" id="priceRange" min="<?= $db_min ?>" max="<?= $db_max ?>" value="<?= $max_price ?>" step="500000"
                                       class="w-full h-1.5 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-blue-600">
                                <input type="hidden" name="max_price" id="maxPriceInput" value="<?= $max_price ?>">
                                <div class="flex justify-between text-[9px] font-black text-slate-300 uppercase">
                                    <span><?= number_format($db_min) ?>đ</span>
                                    <span><?= number_format($db_max) ?>đ</span>
                                </div>
                            </div>

                            <div class="pt-4 flex gap-2">
                                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-blue-600 transition-all">Lọc kết quả</button>
                                <a href="tours.php" class="w-12 h-12 flex items-center justify-center bg-slate-100 text-slate-400 rounded-2xl hover:bg-red-50 hover:text-red-500 transition-all"><i class="fas fa-undo-alt text-xs"></i></a>
                            </div>
                        </form>
                    </div>

                    <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-200 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h4 class="text-xl font-black italic tracking-tighter mb-2 leading-none">Hotline hỗ trợ</h4>
                            <p class="text-[10px] font-bold text-blue-100 uppercase tracking-widest mb-6 italic opacity-70">Tư vấn miễn phí 24/7</p>
                            <a href="tel:0354781433" class="text-2xl font-black tracking-tighter">0354781433</a>
                        </div>
                        <i class="fas fa-headset absolute -bottom-6 -right-6 text-9xl text-white/10 -rotate-12 transition-transform duration-700 group-hover:rotate-0"></i>
                    </div>
                </div>
            </aside>

            <section class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-10">
                    <h2 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Danh sách tour du lịch</h2>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white px-4 py-2 rounded-full border border-slate-100 shadow-sm">Tìm thấy <?= $total_rows ?> kết quả</span>
                </div>

                <?php if (empty($tours)): ?>
                    <div class="bg-white rounded-[3rem] p-20 text-center border border-slate-100">
                        <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl"><i class="fas fa-search"></i></div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest italic">Rất tiếc, không tìm thấy chuyến đi phù hợp</p>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach($tours as $t): ?>
                    <div class="bg-white rounded-[2.5rem] overflow-hidden border border-slate-50 hover:shadow-2xl transition-all duration-500 group relative">
                        <div class="relative h-60 overflow-hidden">
                            <img src="assets/uploads/<?= $t['image'] ?: 'default-tour.jpg' ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                            <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-4 py-1.5 rounded-xl text-[9px] font-black text-blue-600 shadow-sm uppercase italic tracking-widest">
                                <i class="fas fa-clock mr-1"></i> <?= $t['duration'] ?>
                            </div>
                        </div>
                        <div class="p-8">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic leading-none mb-2 block"><?= $t['cat_name'] ?></span>
                            <h3 class="text-lg font-bold text-slate-800 leading-tight mb-4 min-h-[3rem] line-clamp-2"><?= htmlspecialchars($t['title']) ?></h3>
                            
                            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                <div>
                                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic leading-none mb-1">Giá chỉ từ</p>
                                    <span class="text-xl font-black text-blue-600 tracking-tighter"><?= number_format($t['price_base'], 0, ',', '.') ?>đ</span>
                                </div>
                                <a href="tour-detail.php?id=<?= $t['id'] ?>" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-slate-200 hover:bg-blue-600 transition-all">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                <div class="mt-16 flex justify-center space-x-3">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>&category=<?= $cat_id ?>&search=<?= urlencode($search) ?>&max_price=<?= $max_price ?>" 
                           class="w-12 h-12 flex items-center justify-center rounded-2xl text-xs font-black transition-all <?= $i == $page ? 'bg-blue-600 text-white shadow-xl shadow-blue-100' : 'bg-white text-slate-400 border border-slate-100 hover:text-blue-600' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</main>

<script>
    const range = document.getElementById('priceRange');
    const label = document.getElementById('priceLabel');
    const input = document.getElementById('maxPriceInput');

    function updatePrice(val) {
        label.innerText = `Dưới ${parseInt(val).toLocaleString('vi-VN')}đ`;
        input.value = val;
    }

    range.addEventListener('input', (e) => updatePrice(e.target.value));
    updatePrice(range.value);
</script>

<?php include 'footer.php'; ?>