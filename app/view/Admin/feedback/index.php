<main class="flex-1 p-8 max-w-7xl mx-auto">
    <nav class="mb-6 text-sm">
        <a href="/Admin/Feedback" class="text-dark-overlay6 hover:text-blue-overlay">Data Feedback</a>
    </nav>
    <h2 class="text-xl font-bold text-dark-overlay mb-6">Data Feedback</h2>
    
    <form method="POST" id="filterForm">
    <div class="flex items-center gap-3 pb-2 ">
        <?php 
            $filter_id = 'ruangan'; 
            $label = 'Ruangan'; 
            $options = [];
            if (isset($data['list_ruangan'])) {
                foreach ($data['list_ruangan'] as $row) {
                    // Format: 'Label yang muncul' => 'Value yang dikirim'
                    // Karena logic filter kamu pakai room_name, maka value-nya juga room_name
                    $options[$row['room_name']] = $row['room_name'];
                }
            }
            $current_values = $_GET[$filter_id] ?? ''; 
            include __DIR__ . '/../../template/filterDropDown.php';
            ?>

        <?php 
            $filter_id = 'bulan'; 
            $label = 'Bulan'; 
           $options = [
                        'Januari'   => '1',
                        'Februari'  => '2',
                        'Maret'     => '3',
                        'April'     => '4',
                        'Mei'       => '5',
                        'Juni'      => '6',
                        'Juli'      => '7',
                        'Agustus'   => '8',
                        'September' => '9',
                        'Oktober'   => '10',
                        'November'  => '11',
                        'Desember'  => '12',
                    ];
            $current_values = $_GET[$filter_id] ?? ''; 
            include __DIR__ . '/../../template/filterDropDown.php';
            ?>

        <?php 
            $filter_id = 'tahun'; 
            $label = 'Tahun'; 
            $options = ['2025' => '2025', '2024' => '2024']; 
            $current_values = $_GET[$filter_id] ?? ''; 
            include __DIR__ . '/../../template/filterDropDown.php';
            ?>

        <button type="button" id="filter-action-btn"
                class="flex items-center px-3 py-1.5 hover:cursor-pointer text-dark-overlay5 hover:text-dark-overlay7 hover:bg-dark-overlay1 rounded-lg transition border border-dark-overlay5 bg-white">
            <div id="filter-action-icon" class="text-dark-overlay5"
                    data-check="<?= htmlspecialchars(icon('check', 'w-4 h-4 text-blue-overlay'), ENT_QUOTES) ?>"
                    data-cross="<?= htmlspecialchars(icon('cross', 'w-4 h-4 text-red1'), ENT_QUOTES) ?>">
                <?= icon('check', 'w-4 h-4 text-blue-overlay') ?>
            </div>
             <span id="filter-action-text" 
                        class="ms-2 text-blue-overlay" 
                        data-text-check="Terapkan" 
                        data-text-cross="Reset">
                        Terapkan
            </span> 
        </button>
    </div>
    </form>


    <!-- Feedback Cards Grid -->
    <div id="feedbackGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

                <?php if (empty($feedbacks)): ?>
        
        <div class="col-span-2">
            <div class="bg-white border border-gray-200 rounded-lg p-6 text-center">
                <p class="text-dark-overlay6 text-sm">Belum ada data feedback</p>
            </div>
        </div>

    <?php else: ?>

        <?php foreach($feedbacks as $feedback) : ?>
        <!-- Feedback Card -->
        <div class="feedback-card card-hover bg-background2 rounded-lg shadow-md p-6">
            
            <!-- Header -->
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-lg font-bold text-dark-overlay"><?= htmlspecialchars($feedback['room_name']) ?></h3>
                <span class="bg-blue-overlay-15 text-sm px-2 py-1 rounded-full text-dark-overlay7 font-medium">Kode: <?= htmlspecialchars($feedback['booking_code']) ?></span>
            </div>

            <!-- Date & Time -->
            <div class="flex items-center gap-2 text-sm text-dark-overlay mb-2">
                <?= icon('calendar', 'w-4 h-4') ?>
                <span><?= tanggal_indonesia($feedback['start_time']) . ', ' . waktu_indonesia($feedback['start_time']) .  '-' . waktu_indonesia($feedback['end_time']) ?></span>
            </div>

            <!-- Rater -->
            <div class="flex items-center gap-2 text-sm text-dark-overlay mb-3">
                <?= icon('user', 'w-4 h-4') ?>
                <span>Penanggung Jawab: <strong><?= htmlspecialchars($feedback['booker_name']) ?></strong></span>
            </div>

             <div class="flex items-center gap-2 text-sm text-dark-overlay mb-3">
                <?= icon('user', 'w-4 h-4') ?>
                <span>Pengisi Ulasan: <strong><?= htmlspecialchars($feedback['username'])?></strong></span>
            </div>

            <!-- Rating -->
            <div class="mb-3">
                <div class="flex items-center gap-1">
                    <span class="text-sm text-dark-overlay mr-2">Rating:</span>
                     <?php 
                        $rating = (int)$feedback['rating']; // contoh: 4
                        $max = 5;

                        for ($i = 1; $i <= $max; $i++):
                            if ($i <= $rating) {
                                echo icon('starFill', 'w-5 h-5 text-yellow1');   // bintang terisi
                            } else {
                                echo icon('starFill', 'w-5 h-5 text-dark-overlay5'); // bintang kosong/gelap
                            }
                        endfor;
                        ?>
                    <span class="text-sm text-dark-overlay ml-2">(<?= $feedback['rating'] ?>/5)</span>
                </div>
            </div>

            <!-- Comment -->
            <div class="">
                <p class="text-sm text-dark-overlay mb-1">Komentar/Pesan:</p>
                <textarea id="feedbackText" readonly
                          placeholder="Data menyusul" 
                          class="w-full px-4 py-3 text-sm rounded-lg focus:outline-none resize-none bg-blue-overlay-15" 
                          rows="5"><?= htmlspecialchars($feedback['comment']) ?></textarea>
            </div>
        </div>

        
        <?php endforeach ?>


        <!-- <?php //endif; ?> -->
    </div>

    <?php if ($total_page >= 1): ?>
            
        <div class="flex items-center justify-center px-6 py-4 mx-8 mt-4">
            
            <div class="flex items-center gap-2">
                
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?= $current_page - 1; ?>" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
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


                <?php for ($p = 1; $p <= $total_page; $p++) : ?>
                    
                    <?php if ($p == $current_page) : ?>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-[#1E68FB] rounded-lg">
                            <?= $p; ?>
                        </button>
                    
                    <?php else : ?>
                        <a href="?&page=<?= $p; ?>" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150 block">
                            <?= $p; ?>
                        </a>
                    <?php endif; ?>

                <?php endfor; ?>


                <?php if ($current_page < $total_page): ?>
                    <a href="?&page=<?= $current_page + 1; ?>" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
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
                        <span class="text-sm text-gray-600">Go to</span>
                        <input type="number" 
                            name="page" 
                            min="1" 
                            max="<?= $total_page; ?>"
                            value="<?= $current_page; ?>" 
                            class="w-16 px-3 py-2 text-center text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <span class="text-sm text-gray-600">Page</span>
                        
                        <button type="submit" class="hidden"></button>
                    </form>
        </div>
        <?php endif; ?>
</main>

<script src="/js/filterDropdown.js" defer></script>
<script src="/js/search.js" defer></script>