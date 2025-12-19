<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="/Admin/Ruangan" class="text-blue-overlay hover:text-blue-700">Data Ruangan</a>
    </nav>

    <!-- Header dengan Title dan Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-dark-overlay">Data Ruangan</h2>
        <div class="flex justify-between items-center gap-8">
            <a href="/Admin/editTataTertib"
                class="flex items-center gap-2 px-3 py-1.5 bg-blue-overlay hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition duration-200">
                Edit tata Tertib
                <div>
                    <?= icon('pencil', 'w-4 h-4') ?>
                </div>
            </a>
            <a href="/Admin/tambahDataRuangan"
                class="flex items-center gap-2 px-3 py-1.5 bg-blue-overlay hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition duration-200">
                Tambah Ruangan
                <div>
                    <?= icon('plus', 'w-4 h-4') ?>
                </div>
            </a>
        </div>
        
    </div>

    <div class="flex justify-between items-center">
        <form method="POST" id="filterForm">

            <div class="flex items-center gap-3 pt-6 pb-2 bg-gray-50">
                <?php 
                $filter_id = 'status'; 
                $label = 'status'; 
                $options = ['Tersedia' => 'active', 'Tidak Tersedia' => 'non-active']; 
                $current_values = $_GET[$filter_id] ?? ''; 
                include __DIR__ . '/../../template/filterDropDown.php';
                ?>
                <button type="button" id="filter-action-btn"
                        class="flex items-center px-3 py-1.5 text-dark-overlay5 hover:text-dark-overlay7 hover:bg-dark-overlay1 hover:cursor-pointer rounded-lg transition border border-dark-overlay5 bg-white">
                    <div id="filter-action-icon" class="text-dark-overlay5"
                        data-check="<?= htmlspecialchars(icon('check', 'w-4 h-4 text-blue-overlay'), ENT_QUOTES) ?>"
                        data-cross="<?= htmlspecialchars(icon('cross', 'w-4 h-4 text-red1'), ENT_QUOTES) ?>">
                        <?= icon('check', 'w-4 h-4 text-blue-overlay') ?>
                    </div>
                    
                    <span id="filter-action-text" 
                        class="ms-2" 
                        data-text-check="Terapkan" 
                        data-text-cross="Reset">
                        Terapkan
                    </span> 
                </button>
            </div>
        </form>

        <!-- Search Bar -->
        <div class="pt-6 pb-2">
            <div class="relative max-w-md ml-auto">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <div class="text-dark-overlay7">
                        <?= icon('search', 'w-5 h-5') ?>
                    </div>
                </div>
                <input type="text" id="search-input" placeholder="Cari Nama Ruangan"
                    class="block w-full pl-10 pr-10 py-2 border border-dark-overlay4 rounded-lg 
                            bg-white text-dark-overlay7 placeholder-dark-overlay7 text-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                            transition duration-150">
                <button type="button" id="clear-search" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-dark-overlay7 hover:text-dark-overlay hidden">
                    <div class="text-dark-overlay7">
                        <?= icon('cross', 'w-4 h-4 hover:cursor-pointer') ?>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div id="rooms-container" class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 md:grid-cols-2 mb-8 mt-6 md:gap-6 lg:gap-8 gap-4">

    <?php foreach($rooms as $room): ?>
        <div class="bg-background2 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
            <div class="relative h-48 from-dark-overlay4 to-dark-overlay7">
                <?php if($room['img_room'] !== 'DefaultRuangan.jpg'): ?>
                    <img loading="lazy" src="<?= BASEURL; ?>/File/showPhoto/<?= $room['img_room']; ?>"
                        alt="<?= $room['room_name'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <img loading="lazy" src="/img/DefaultRuangan.jpg" 
                        alt="<?= $room['room_name'] ?>" class="w-full h-full object-cover">
                <?php endif ?>
            </div>
            <div class="grid grid-rows-[2fr_1fr] px-5 p-3">
                <div>
                    <h3 class="font-bold text-lg text-black3 mb-1"><?= htmlspecialchars($room['room_name'] ?? '-') ?></h3>
                    <p class="text-dark-overlay8 mb-2 text-justify text-sm"><?= htmlspecialchars($room['short_description'] ?? '-') ?></p>
                    <hr class="border-t border-dark-overlay">
                </div>
                <div class="grid grid-cols-[1fr_2fr] mb-2 md:text-md text-xs">
                    <div class="flex items-center justify-start w-full">
                        <div class="flex items-center gap-2 text-black2">
                            <?= icon('userOutline', 'w-5 h-5 mr-2') ?>        
                        </div>
                        <span class="inline-flex items-center justify-center lg:flex-row flex-col"><?= htmlspecialchars($room['min_capacity'] ?? 'no data') .'-' . htmlspecialchars($room['max_capacity'] ?? 'no data')  ?> orang </span>
                    </div>
                    <div class="flex items-center justify-end w-full">
                        <a class="<?= getStyleStatusDetail($room['status']) ?> flex-row flex-wrap inline-flex justify-center py-1 px-4 rounded-md mt-2">
                            <div class="flex items-center gap-2 <?= getStyleStatustext($room['status']) ?>">
                                <?= icon('circleFill', 'w-3 h-3 mr-2') ?>        
                            </div>
                            <h2 class="text-sm inline-block font-medium <?= getStyleStatustext($room['status']) ?>"><?= translateStatusRoom($room['status']) ?></h2>
                        </a>
                    </div>           
                </div>
                <div class="w-full flex justify-end">
                    <a href="/Admin/EditDataRuangan/<?= $room['id_room'] ?>"
                        class="flex items-center justify-center w-full bg-blue-overlay text-white text-center rounded-xl font-semibold text-sm hover:bg-green1 transition duration-200 py-2">
                        Edit Ruangan
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
      <?php $query = $_GET;
        unset($query['page']); // reset page biar aman
        $baseUrl = http_build_query($query); ?>
        <?php if ($total_page >= 1): ?>
            
        <div class="flex items-center justify-center px-6 py-4 mx-8">
            
            <div class="flex items-center gap-2">
                
            <!-- Previous -->
                <?php if ($current_page > 1): ?>
                    <a href="?<?= $baseUrl ?>&page=<?= $current_page - 1 ?>" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <button disabled class="p-2 text-gray-300 cursor-not-allowed rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                <?php endif; ?>

                <?php 
                    // 1. Tentukan range halaman yang mau ditampilkan
                    $range = [];
                    $delta = 1; // Jumlah halaman yang muncul di kiri-kanan halaman aktif

                    for ($i = 1; $i <= $total_page; $i++) {
                        // Kondisi ambil halaman:
                        // 1. Halaman pertama atau terakhir
                        // 2. Halaman saat ini
                        // 3. Halaman di sekitar halaman saat ini (sesuai delta)
                        if ($i == 1 || $i == $total_page || ($i >= $current_page - $delta && $i <= $current_page + $delta)) {
                            $range[] = $i;
                        }
                    }

                    // 2. Sisipkan titik-titik (...) jika ada lompatan halaman
                    $pages_to_show = [];
                    $l = null; // last page number processed

                    foreach ($range as $i) {
                        if ($l) {
                            if ($i - $l === 2) {
                                // Jika selisih cuma 2 (misal 1 dan 3), tampilkan angka 2 (jangan titik-titik)
                                $pages_to_show[] = $l + 1; 
                            } elseif ($i - $l > 1) {
                                // Jika selisih jauh, tampilkan titik-titik
                                $pages_to_show[] = '...'; 
                            }
                        }
                        $pages_to_show[] = $i;
                        $l = $i;
                    }
                    ?>

                    <?php foreach ($pages_to_show as $p) : ?>

                        <?php if ($p === '...') : ?>
                            <span class="px-2 py-2 text-sm text-dark-overlay6">...</span>
                        
                        <?php elseif ($p == $current_page) : ?>
                            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-overlay rounded-lg">
                                <?= $p; ?>
                            </button>
                        
                        <?php else : ?>
                            <a href="?<?= $baseUrl; ?>&page=<?= $p; ?>" class="px-4 py-2 text-sm font-medium text-dark-overlay hover:bg-dark-overlay1 rounded-lg transition-colors duration-150 block">
                                <?= $p; ?>
                            </a>
                        <?php endif; ?>

                    <?php endforeach; ?>

                <!-- Next -->
                <?php if ($current_page < $total_page): ?>
                    <a href="?<?= $baseUrl ?>&page=<?= $current_page + 1 ?>" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <button disabled class="p-2 text-gray-300 cursor-not-allowed rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                <?php endif; ?>
            <?php endif; ?>

            </div>
                    <form action="" method="GET" class="flex items-center gap-2 ml-4">
                        <?php foreach($query as $key => $val): ?>
                        <?php if ($key === 'Status') continue; ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($val) ?>">
                        <?php endforeach; ?>

                        <span class="text-sm text-gray-600">Go to</span>
                        <input type="number" name="page" min="1" max="<?= $total_page ?>" value="<?= $current_page ?>"
                            class="w-16 px-3 py-2 text-center text-sm border border-gray-300 rounded-lg">

                        <span class="text-sm text-gray-600">Page</span>
                        <button type="submit" class="hidden"></button>
                    </form>
                </div>
            </div>
    </div>
</main>

<script src="/js/search.js" defer></script>
<script src="/js/filterDropdown.js" defer></script>