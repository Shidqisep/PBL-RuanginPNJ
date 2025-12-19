<?php
// Hanya untuk logika tab (tidak pakai database)
$tab = $_GET['tab'] ?? 'hariIni';
$tab = strtolower($tab);
$valid_tabs = ['hariIni', 'berlangsung', 'reschedule', 'riwayat'];
if (!in_array($tab, $valid_tabs)) {
    $tab = 'hariIni';
}

function isActive($current, $check) {
    return $current === $check;
}

$nomor = ($current_page - 1) * $limit + 1
?>


<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm">
        <a href="/Admin/Peminjaman" class="text-blue-overlay hover:text-blue-700">Data Peminjaman Ruangan</a>
        <span class="mx-2 text-dark-overlay6">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <span class="font-medium text-dark-overlay6">
            <?php 
            $tab_labels = [
                'hariIni' => 'Hari ini',
                'berlangsung' => 'Menunggu',
                'reschedule' => 'Reschedule',
                'riwayat' => 'Riwayat'
            ];
            echo $tab_labels[$tab] ?? 'Hari ini';
            ?>
        </span>
    </nav>

    <!-- Header dengan Title dan Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-dark-overlay"> 
            <?php 
            $title_labels = [
                'hariIni' => 'Peminjaman Hari ini',
                'berlangsung' => 'Menunggu',
                'reschedule' => 'Reschedule',
                'riwayat' => 'Riwayat Peminjaman'
            ];
            echo $title_labels[$tab] ?? 'Hari ini';
            ?>
        </h2>
        <a href="/Admin/buatPeminjaman"
           class="flex items-center gap-2 px-3 py-2 bg-blue-overlay hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition duration-200">
            Buat Peminjaman
            <div>
                <?= icon('plus', 'w-4 h-4') ?>
            </div>
        </a>
    </div>


    <div class="bg-background2 text-primary rounded-lg shadow-md">
        <!-- Tab Navigation & Search -->
        <div class="border-b border-dark-overlay1">
            <!-- Tabs -->
            <div class="grid grid-cols-4">             
                <a href="?tab=hariIni"
                class="px-6 py-2.5 rounded-tl-lg font-medium text-sm transition-all duration-200 text-center
                        <?= isActive($tab, 'hariIni') 
                            ? 'bg-blue-overlay text-white shadow-md' 
                            : 'bg-blue-overlay1 text-blue-overlay hover:bg-blue-overlay2' ?>">
                    Hari Ini
                </a>
                <a href="?tab=berlangsung"
                class="px-6 py-2.5 font-medium text-sm transition-all duration-200 text-center
                        <?= isActive($tab, 'berlangsung') 
                            ? 'bg-blue-overlay text-white shadow-md' 
                            : 'bg-blue-overlay1 text-blue-overlay hover:bg-blue-overlay2' ?>">
                    Menunggu
                </a></a>
                <a href="?tab=reschedule"
                class="px-6 py-2.5 font-medium text-sm transition-all duration-200 text-center
                        <?= isActive($tab, 'reschedule') 
                            ? 'bg-blue-overlay text-white shadow-md' 
                            : 'bg-blue-overlay1 text-blue-overlay hover:bg-blue-overlay2' ?>">
                    Reschedule
                </a></a>
                <a href="?tab=riwayat"
                class="px-6 py-2.5 rounded-tr-lg font-medium text-sm transition-all duration-200 text-center
                        <?= isActive($tab, 'riwayat') 
                            ? 'bg-blue-overlay text-white shadow-md' 
                            : 'bg-blue-overlay1 text-blue-overlay hover:bg-blue-overlay2' ?>">
                    Riwayat
                </a>
            </div>
        </div>

            <!-- KONTEN TAB -->
        
            <div class="flex justify-between items-center">
                <form method="GET" id="filterForm" class="flex justify-between items-center w-full">
                    <input type="hidden" name="tab" value="<?= $tab ?>">

                    <div class="flex items-center gap-3 py-4 px-8 bg-background2">
                        <!-- <?php 
                        // $filter_id = 'ruangan'; 
                        // $label = 'ruangan'; 
                        // $options = ['Ruang Duta' => 'Ruang Duta', 'Ruang Meeting Kecil' => 'Ruang Meeting Kecil']; 
                        // $current_values = $_GET[$filter_id] ?? ''; 
                        // include __DIR__ . '/../../template/filterDropDown.php';
                        ?> -->

                        <?php 
                        $filter_id = 'status'; 
                        $label = 'Status'; 
                        $options = ['Aktif' => 'ongoing', 'Menunggu' => 'pending', 'Selesai' => 'done',  'Dibatalkan' => 'cancelled']; 
                        $current_values = $_GET[$filter_id] ?? ''; 
                        include __DIR__ . '/../../template/filterDropDown.php';
                        ?>

                        <button type="button" id="filter-action-btn"
                                class="flex items-center px-3 py-1.5 hover:cursor-pointer text-dark-overlay5 hover:text-dark-overlay7 hover:bg-dark-overlay1 rounded-lg transition border border-dark-overlay5 bg-white">
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

                <!-- Search Bar -->
                <div class="py-4 px-8">
                    <div class="relative max-w-md ml-auto">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <div>
                                <?= icon('search', 'w-5 h-5') ?>
                            </div>
                        </div>
                        <input type="text" id="search-input" name="search" placeholder="Cari Penanggung Jawab"
                            class="block w-full pl-10 pr-10 py-2 border border-dark-overlay4 rounded-lg 
                                    bg-white text-dark-overlay placeholder-dark-overlay6 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                    transition duration-150">
                        <button type="button" id="clear-search" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-dark-overlay6 hover:text-dark-overlay7 hidden">
                            <div>
                                <?= icon('cross', 'w-4 h-4 hover:cursor-pointer') ?>
                            </div>
                        </button>
                    </div>
                </div>
                </form>
            </div>
            <?php if (!empty($Peminjamans)): ?>
            <div class="rounded-lg shadow-sm border border-dark-overlay4 overflow-hidden mx-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-dark-overlay4">
                                <th class="px-4 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">No</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Ruangan</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Kode Peminjaman</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Penanggung Jawab</th>      
                                <th class="px-4 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-dark-overlay4">
                            <?php foreach($Peminjamans as $Peminjaman) : ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4 text-xs text-dark-overlay"><?= $nomor ?></td>
                                <td class="px-4 py-4 text-xs font-medium text-dark-overlay"><?= tanggal_indonesia($Peminjaman['start_time']) ?>
                                    <br>
                                    <span><?= waktu_indonesia($Peminjaman['start_time']) . '-' . waktu_indonesia($Peminjaman['end_time']) ?></span>
                                </td>
                                <td class="px-4 py-4 text-xs text-dark-overlay"><?= htmlspecialchars( $Peminjaman['room_name'] ?? '-') ?></td>
                                <td class="px-4 py-4 text-xs text-dark-overlay"><?= $Peminjaman['booking_code']?></td>
                                <td class="px-4 py-4 text-xs text-dark-overlay"><?= $Peminjaman['username'] ?></td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex px-3 py-1 text-xs min-w-5/6 justify-center font-medium rounded-sm <?= getStyleStatus($Peminjaman['status']) ?> text-background2">
                                        <?= translateStatus($Peminjaman['status']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <a href="<?= BASEURL . '/admin/' . $link . '/'. $Peminjaman[$data['id_column']] ?>"
                                       class="inline-flex items-center px-4 py-2 text-xs font-medium text-dark-overlay bg-white border border-dark-overlay4 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            <?php $nomor++ ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

         <?php if ($total_page >= 1): ?>   
        <div class="flex items-center justify-center px-6 py-4 mx-8">
            
            <div class="flex items-center gap-2">
                
                    <?php $query = $_GET;
                    unset($query['page']); // reset page biar aman
                    $baseUrl = http_build_query($query); ?>
                    <!-- previous -->
                    <?php if ($current_page > 1): ?>
                        <a href="?<?= $baseUrl; ?>&page=<?= $current_page - 1; ?>" class="p-2 text-dark-overlay5 hover:text-dark-overlay hover:bg-dark-overlay1 rounded-lg transition-colors duration-150">
                            <?= icon('arrowLeft', 'w-6 h-6') ?>
                        </a>
                    <?php else: ?>
                        <button disabled class="p-2 text-dark-overlay cursor-not-allowed rounded-lg">
                            <?= icon('arrowLeft', 'w-6 h-6') ?>
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

                    <!-- next page -->
                    <?php if ($current_page < $total_page): ?>
                        <a href="?<?= $baseUrl; ?>&page=<?= $current_page + 1; ?>" class="p-2 text-dark-overlay5 hover:text-dark-overlay hover:bg-dark-overlay1 rounded-lg transition-colors duration-150">
                            <?= icon('arrowRight', 'w-6 h-6') ?>
                        </a>
                    <?php else: ?>
                        <button disabled class="p-2 text-gray-300 cursor-not-allowed rounded-lg">
                            <?= icon('arrowRight', 'w-6 h-6') ?>
                        </button>
                    <?php endif; ?>
                

            </div>

            <form action="" method="GET" class="flex items-center gap-2 ml-4">
                <?php 
                // 4. GENERATE HIDDEN INPUT UNTUK SEMUA FILTER YANG ADA
                // Agar saat tekan enter di input page, filter status/jurusan tidak hilang
                foreach ($query as $key => $value) {
                    if (is_array($value)) {
                        // Jika filter berupa array (misal checkbox status[])
                        foreach ($value as $v) {
                            echo '<input type="hidden" name="' . htmlspecialchars($key) . '[]" value="' . htmlspecialchars($v) . '">';
                        }
                    } else {
                        // Jika filter string biasa
                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                    }
                }?>
                <span class="text-sm text-dark-overlay7">Go to</span>
                <input type="number" name="page" min="1" max="<?= $total_page; ?>" value="<?= $current_page; ?>" 
                    class="w-16 px-3 py-2 text-center text-sm border border-dark-overlay4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <span class="text-sm text-dark-overlay7">Page</span>
                
                <button type="submit" class="hidden"></button>
            </form>
        </div>
        <?php endif; ?>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center p-20">
                <div class="mb-4">
                    <?= icon('fileList', 'h-20 w-20 text-gray-400') ?>
                </div>
                <div class="flex items-center flex-col justify-center">
                    <h3 class="text-lg font-semibold text-dark-overlay7 mb-2">Belum Ada Data Peminjaman</h3>
                    <p class="text-sm text-dark-overlay6 text-center mb-6">Tidak ada Peminjaman untuk filter ini</p>
                    <a href="/Admin/buatPeminjaman"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-overlay hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                        Buat Peminjaman Baru
                        <?= icon('plus', 'w-4 h-4') ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

</main>

<script src="/js/filterDropdown.js" defer></script>
<script src="/js/search.js" defer></script>