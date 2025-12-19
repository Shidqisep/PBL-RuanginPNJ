<!-- Main Content -->
<main class="container mx-auto px-4 w-97/100 lg:px-6 sm:px-6 py-6 sm:py-8 flex-1">
    <h2 class="text-2xl sm:text-3xl text-center font-bold text-dark-overlay mb-10 pt-5 left-align">Riwayat Peminjaman</h2>

    <?php if(!empty($bookings)): ?>
    <!-- Time Filters -->
    <div class="flex md:flex-row flex-col md:justify-between mb-6 gap-4">
        <form method="GET" id="filterForm" class="flex md:flex-row flex-col md:justify-between mb-6 gap-4">
        <div class="flex flex-wrap gap-3 left-align order-2 md:order-1 w-full justify-between md:justify-start lg:justify-start">

            <?php 
                $filter_id = 'Status'; 
                $label = 'Status'; 
                $options = ['Selesai' => 'done', 'Dibatalkan' => 'cancelled', 'Menunggu' => 'pending']; 
                $current_values = $_GET[$filter_id] ?? ''; 
                include __DIR__ . '/../../template/filterDropDown.php';
            ?>
            
            <button type="button" id="filter-action-btn"
                    class="flex items-center hover:cursor-pointer px-3 py-1 text-dark-overlay5 hover:text-dark-overlay7 hover:bg-dark-overlay1 rounded-lg transition border border-dark-overlay5 bg-white">
                <div id="filter-action-icon" class="text-dark-overlay5"
                     data-check="<?= htmlspecialchars(icon('check', 'w-4 h-4 text-blue-overlay'), ENT_QUOTES) ?>"
                     data-cross="<?= htmlspecialchars(icon('cross', 'w-4 h-4 text-red1'), ENT_QUOTES) ?>">
                    <?= icon('check', 'w-4 h-4') ?>
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
        <form method="GET" class="order-1 md:order-2">
        <div class="order-1 md:order-2">
            <div class="relative max-w-md ml-auto">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <div class="text-dark-overlay7">
                        <?= icon('search', 'w-5 h-5') ?>
                    </div>
                </div>
                <input type="text" id="search-input" placeholder="Cari nama ruangan" name="search"
                    class="block w-full p-10 py-2 border border-dark-overlay5 rounded-lg 
                            bg-white text-dark-overlay7 placeholder-dark-overlay7 text-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                            transition duration-150">
                            
                <button type="button" id="clear-search" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-dark-overlay7 hover:text-dark-overlay hidden">
                    <div class="hover:cursor-pointer">
                        <?= icon('cross', 'w-4 h-4') ?>
                    </div>
                </button>
            </div>
        </div>
        </form>
    </div>
    
    <!-- Table Content -->
    <div class="">
        <!-- Desktop Table -->
        <div id="desktop-table" class="md:block hidden overflow-x-auto bg-background2 rounded-xl">
            <table class="w-full text-sm border-separate border-spacing-0 border border-dark-overlay4 rounded-xl">
                <thead class="bg-blue-overlay1 rounded-xl">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-dark-overlay7 rounded-tl-xl">No.</th>
                        <th class="px-6 py-4 text-left font-semibold text-dark-overlay7">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold text-dark-overlay7">Ruangan</th>
                        <th class="px-6 py-4 text-left font-semibold text-dark-overlay7">Jam</th>
                        <th class="px-6 py-4 text-left font-semibold text-dark-overlay7">Jumlah Orang</th>
                        <th class="px-6 py-4 text-center font-semibold text-dark-overlay7">Status</th>
                        <th class="px-6 py-4 text-center font-semibold text-dark-overlay7 rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>


                <tbody id="" class="divide-y divide-dark-overlay5">
                <?php $nomor = ($current_page - 1) * $limit + 1?>
                <?php foreach($bookings as $booking) : ?>
                    <!-- **************************************************
                    INI Data pERTAMA
                    ******************************************************* -->
                    <tr class="hover:bg-dark-overlay1 transition border-b border-dark-overlay4">
                        <td class="px-6 py-4 text-left text-sm border-b border-dark-overlay4"><?= $nomor ?></td>
                        <td class="px-6 py-4 text-left text-sm border-b border-dark-overlay4"><?= tanggal_indonesia($booking['start_time']) ?></td>
                        <td class="px-6 py-4 text-left text-sm border-b border-dark-overlay4"><?= $booking['room_name'] ?></td>
                        <td class="px-6 py-4 text-left text-sm border-b border-dark-overlay4"><?= date('H:i', strtotime($booking['start_time'])) . '-' . date('H:i', strtotime($booking['end_time'])); ?></td>
                        <td class="px-6 py-4 text-left text-sm border-b border-dark-overlay4"><?= $booking['total_person'] ?></td>
                        <td class="px-6 py-4 text-left text-sm border-b border-dark-overlay4">
                            <div
                                    class="flex <?= getStyleStatus($booking['status']) ?> items-center justify-center text-white px-2 py-2 rounded-sm text-xs font-medium shadow-md min-w-1/2">
                                <span><?= translateStatus($booking['status']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center justify-center flex border-b border-dark-overlay4">
                            <?php if ($booking['status']  === 'done' && empty($booking['rating'])): ?>
                            <button onclick="kirimFeedback('<?= $booking['id_booking'] ?>', '<?= $_SESSION['user']['user_id']?>')" class="flex items-center justify-center w-full bg-blue-overlay text-white hover:bg-blue-700 py-2 hover:cursor-pointer rounded-sm text-sm font-medium transition shadow-md">
                                <span>Feedback</span>
                                <div class="bg-background2 rounded-xs ml-3"> 
                                    <div class="text-blue-overlay">
                                        <?= icon('plus', 'w-4 h-4') ?>
                                    </div>
                                </div>
                            </button>
                        <?php elseif ($booking['status'] == 'cancelled' || $booking['status'] == 'ongoing' || $booking['status'] == 'pending'): ?>
                            <button class="flex items-center justify-center w-full bg-[#8D9198] text-white cursor-not-allowed py-2 rounded-sm text-sm font-medium transition shadow-md">
                                <span>Feedback</span>
                                <div class="bg-background2 rounded-xs ml-3"> 
                                     <div class="text-black">
                                        <?= icon('cross', 'w-4 h-4', 'black') ?>
                                    </div>
                                </div>
                            </button>
                        <?php else : ?>
                                <button class="flex items-center justify-center w-full bg-[#8D9198] text-white cursor-not-allowed py-2 rounded-sm text-sm font-medium transition shadow-md">
                                <span>Feedback</span>
                                <div class="bg-background2 rounded-xs ml-3"> 
                                    <div class="text-blue-overlay">
                                        <?= icon('check', 'w-4 h-4', 'black') ?>
                                    </div>
                                </div>
                            </button>
                        <?php endif ?>
                        </td>
                    </tr>
                    <?php $nomor++ ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>


        <!-- **************************************************
        INI TAMPILAN MOBILE
        ******************************************************* --> 
        <!-- Mobile Cards -->
            <?php foreach($bookings as $booking) : ?>
        <div id="mobile-cards" class="block md:hidden space-y-4 flex flex-col items-center mb-6">
            <!-- Row 1 -->
            <div class="bg-background2 rounded-xl shadow-lg border border-dark-overlay4 p-5 hover:shadow-md transition-shadow w-full">                    
                <div class="grid grid-cols-1 gap-x-4 gap-y-3 text-sm pb-3 mb-3">
                    <div class="grid grid-cols-2 border-b border-dark-overlay4">
                        <div>
                            <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Ruangan</div>
                            <div class="font-semibold text-lg text-dark-overlay"><?= $booking['room_name'] ?></div>
                        </div>
                        <div class="w-full flex justify-end items-start">
                            <div class="<?= getStyleStatus($booking['status']) ?> font-semibold text-sm text-white1 py-1 w-1/2 text-center rounded-md">
                                <span><?= translateStatus($booking['status']) ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 border-b border-dark-overlay4">
                        <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Tanggal</div>
                        <div class="font-semibold text-dark-overlay"><?= tanggal_indonesia($booking['start_time']) ?></div>
                    </div>

                    <div class="grid grid-cols-2 border-b border-dark-overlay4">
                        <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Jam</div>
                        <div class="font-semibold text-dark-overlay"><?= date('H:i', strtotime($booking['start_time'])) . '-' . date('H:i', strtotime($booking['end_time'])); ?></div>
                    </div>
                    
                    <div class="grid grid-cols-2">
                        <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Orang</div>
                        <div class="font-semibold text-dark-overlay"><?= $booking['total_person'] ?></div>
                    </div>  
                </div>
                <div class="mt-4 grid grid-cols-1 justify-center w-full">
                 <?php if ($booking['status']  === 'done' && !isset($booking['rating'])): ?>
                    <button onclick="kirimFeedback('<?= $booking['id_booking'] ?>', '<?= $_SESSION['user']['user_id']?>')" class="flex items-center justify-center w-full bg-blue-overlay text-white hover:bg-blue-700 py-2 rounded-sm text-sm font-medium transition shadow-md">
                        <span>Feedback</span>
                        <div class="bg-background2 rounded-xs ml-3"> 
                            <div class="text-blue-overlay">
                                <?= icon('plus', 'w-4 h-4') ?>
                            </div>
                        </div>
                    </button>
                <?php elseif ($booking['status'] == 'cancelled' || $booking['status'] == 'ongoing' || $booking['status'] == 'pending'): ?>
                     <button class="flex items-center justify-center w-full bg-gray-600 text-white hover:bg-blue-700 py-2 rounded-sm text-sm font-medium transition shadow-md">
                        <span>Feedback</span>
                        <div class="bg-background2 rounded-xs ml-3"> 
                            <div class="text-bllack">
                                <?= icon('cross', 'w-4 h-4') ?>
                            </div>
                        </div>
                    </button>
                <?php else : ?>
                    <button class="flex items-center justify-center w-full bg-gray-600 text-white hover:bg-blue-700 py-2 rounded-sm text-sm font-medium transition shadow-md">
                        <span>Feedback</span>
                        <div class="bg-background2 rounded-xs ml-3"> 
                            <div class="text-black">
                                <?= icon('check', 'w-4 h-4') ?>
                            </div>
                        </div>
                    </button>
                <?php endif ?>
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
    <?php else: ?>
            <div class="p-12 rounded-lg shadow-sm border border-dark-overlay1 flex flex-col items-center gap-6">
                <?= icon('fileList', 'w-20 h-20 text-dark-overlay2') ?>
                <p class="text-center">Kamu belum pernah meminjam ruangan.</p>
                <a href="/Dashboard" class="bg-blue-overlay text-white px-6 py-2 rounded-md text-sm hover:bg-blue-700 transition">
                    Pinjam Ruangan Sekarang
                </a>
            </div>
    <?php endif ?>
</main>


<script>const BASEURL = '<?= BASEURL ?>'</script>
<script src="/js/search.js"></script>
<script src="/js/filterDropDown.js"></script>
<script src="/js/feedback.js"></script>