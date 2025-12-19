<?php

function isActive($current, $check) {
    return $current === $check;
}
$nomor = ($current_page - 1) * $limit + 1
?>

<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm">
        <a href="/Admin/Anggota" class="text-blue-overlay hover:text-blue-700">Data Anggota</a>
        <span class="mx-2 text-dark-overlay6">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <span class="font-medium text-dark-overlay6">Daftar Anggota</span>
    </nav>

    <!-- Header dengan Title dan Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-dark-overlay">Daftar Anggota</h2>
        <a href="/Admin/tambahAnggota"
           class="flex items-center gap-2 px-3 py-1.5 bg-blue-overlay hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition duration-200">
            Tambah Anggota
            <div>
                <?= icon('plus', 'h-4 w-4') ?>
            </div>
        </a>
    </div>

    <div class="bg-background2 rounded-lg shadow-md">
        <!-- Tab Navigation & Search -->
        <div class="">
            <!-- Tabs -->
            <div class="grid grid-cols-2">             
                <a href="?tab=approval"
                class="px-6 py-2.5 rounded-tl-lg font-medium text-sm transition-all duration-200 text-center
                        <?= isActive($tab, 'approval') 
                            ? 'bg-blue-overlay text-white shadow-md' 
                            : 'bg-blue-overlay1 text-blue-overlay hover:bg-blue-overlay2' ?>">
                    Approval
                </a>
                <a href="?tab=semua"
                class="px-6 py-2.5 rounded-tr-lg font-medium text-sm transition-all duration-200 text-center
                        <?= isActive($tab, 'semua') 
                            ? 'bg-blue-overlay text-white shadow-md' 
                            : 'bg-blue-overlay1 text-blue-overlay hover:bg-blue-overlay2' ?>">
                    Daftar Anggota
                </a>
            </div>
        </div>

        <!-- ============================================
        LOGIKA IF-ELSE DI SINI (SETELAH TAB NAVIGATION)
        ============================================ -->
        <?php if ($tab === 'approval'): ?>
            
            <!-- KONTEN TAB approval -->

            <div class="flex justify-between items-center">
                <form method="GET" id="filterForm">

                    <div class="flex items-center gap-3 py-4 px-8 bg-background1">
     
                        <?php 
                        $filter_id = 'jenis'; 
                        $label = 'Jenis Anggota'; 
                        $options = ['Mahasiswa' => 'Mahasiswa', 'Dosen' => 'Dosen', 'Tendik' => 'Tendik']; 
                        $current_values = $_GET[$filter_id] ?? ''; 
                        include __DIR__ . '/../../template/filterDropDown.php';
                        ?>
                        
                        <?php 
                        $filter_id = 'jurusan'; 
                        $label = 'Jurusan/Unit Kerja'; 
                        $options = ['Teknik Informatika & Komputer' => 'Teknik Informatika dan Komputer', 'Teknik Elektro' => 'Teknik Elektro', 'Teknik Mesin' => 'Teknik Mesin', 'Teknik Sipil' => 'Teknik Sipil']; 
                        $current_values = $_GET[$filter_id] ?? ''; 
                        include __DIR__ . '/../../template/filterDropDown.php';
                        ?>

                        <button type="button" id="filter-action-btn"
                                class="px-3 py-1.5 flex items-center hover:cursor-pointer text-dark-overlay5 hover:text-dark-overlay7 hover:bg-dark-overlay1 rounded-lg transition border border-dark-overlay5 bg-white">
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
                <div class="py-4 px-8">
                    <div class="relative max-w-md ml-auto">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <div>
                                <?= icon('search', 'w-5 h-5') ?>
                            </div>
                        </div>
                        <input type="text" id="search-input" placeholder="Cari Nama Anggota"
                            class="block w-full pl-10 pr-10 py-2 border border-dark-overlay4 rounded-lg 
                                    bg-white text-dark-overlay7 placeholder-dark-overlay7 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                    transition duration-150">
                        <button type="button" id="clear-search" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-dark-overlay7 hover:text-dark-overlay7 hidden">
                            <div class="hover:cursor-pointer">
                                <?= icon('cross', 'w-4 h-4') ?>
                            </div>
                        </button>
                    </div>
                </div>
            </div>


            <?php if (!empty($users)): ?>
            <!-- Table Daftar Anggota -->
            <div class="rounded-lg shadow-sm border border-dark-overlay4 overflow-hidden mx-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-background1 border-b border-dark-overlay4">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Jenis Anggota</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Jurusan/Unit Kerja</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Tangal Daftar</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach($users as $user) : ?>
                            <tr class="hover:bg-background1 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-dark-overlay"><?= $nomor ?></td>
                                <td class="px-6 py-4 text-sm font-medium text-dark-overlay"><?= htmlspecialchars($user['username'] ?? '-') ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-sm <?= getStyleRole($user['role_name']) ?> min-w-24 justify-center">
                                        <?= htmlspecialchars($user['role_name']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-dark-overlay"><?= htmlspecialchars($user['jurusan_unit'] ?? '-') ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex py-1 text-xs font-medium rounded-full">
                                        <?= htmlspecialchars(tanggal_indonesia($user['created_at']) ?? '-') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="/Admin/selesaikan/<?= $user['id_user'] ?>"
                                       class="inline-flex items-center px-4 py-1.5 text-xs font-medium text-dark-overlay bg-white border border-dark-overlay4 rounded-lg hover:bg-background1 transition-colors duration-150 shadow-md">
                                        Selesaikan
                                    </a>
                                </td>
                            </tr>
                            <?php $nomor += 1 ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else: ?>
                <!-- Empty State untuk Tab Approval -->
                <div class="flex flex-col items-center justify-center py-20 px-8">
                    <div>
                        <?= icon('fileList', 'h-24 w-24') ?>
                    </div>
                    <h3 class="text-xl font-semibold text-dark-overlay mb-2">Belum Ada Anggota yang Perlu Diapprove</h3>
                    <p class="text-dark-overlay7 text-center">Saat ini tidak ada anggota baru yang menunggu approval</p>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <!-- KONTEN TAB daftar ANggota -->
            
            <div class="flex justify-between items-center">
                <form method="GET" id="filterForm">
                    <input type="hidden" name="tab" value="<?= $tab ?>">

                    <div class="flex items-center gap-3 py-4 px-8 bg-background1">
                        
                        <?php 
                        $filter_id = 'jenis'; 
                        $label = 'Jenis Anggota'; 
                        $options = ['Mahasiswa' => 'Mahasiswa', 'Dosen' => 'Dosen', 'Tendik' => 'Tendik']; 
                        $current_values = $_GET[$filter_id] ?? ''; 
                        include __DIR__ . '/../../template/filterDropDown.php';
                        ?>
                        
                        <?php 
                        $filter_id = 'jurusan'; 
                        $label = 'Jurusan/Unit Kerja'; 
                        $options = [
                            'Teknik Informatika & Komputer' => 'Teknik Informatika dan Komputer', 
                            'Teknik Elektro' => 'Teknik Elektro', 
                            'Teknik Mesin' => 'Teknik Mesin', 
                            'Teknik Sipil' => 'Teknik Sipil',
                            'Akuntansi' => 'Akuntansi',
                            'Administrasi Niaga' => 'Administrasi Niaga',
                            'Teknik Grafika Penerbitan' => 'Teknik Grafika Penerbitan'
                        ];
                        $current_values = $_GET[$filter_id] ?? ''; 
                        include __DIR__ . '/../../template/filterDropDown.php';
                        ?>

                        <?php 
                        $filter_id = 'status'; 
                        $label = 'Status'; 
                        $options = ['Aktif' => 'active', 'Belum Aktif' => 'pending', 'NonAktif' => 'non-active', 'suspended' => 'suspended']; 
                        $current_values = $_GET[$filter_id] ?? ''; 
                        include __DIR__ . '/../../template/filterDropDown.php';
                        ?>

                        <button type="button" id="filter-action-btn"
                                class="px-3 py-1.5 flex items-center text-dark-overlay5 hover:text-dark-overlay7 hover:bg-dark-overlay1 rounded-lg transition border border-dark-overlay5 bg-white">
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
                <div class="py-4 px-8">
                    <div class="relative max-w-md ml-auto">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <div>
                                <?= icon('search', 'w-5 h-5') ?>
                            </div>
                        </div>
                        <input type="text" id="search-input" placeholder="Cari Anggota"
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
            </div>

            <!-- Table Approval -->
            <div class="rounded-lg shadow-sm border border-dark-overlay4 overflow-hidden mx-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-background1 border-b border-dark-overlay4">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Jenis Anggota</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Jurusan/Unit Kerja</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <?php if (!empty($users)): ?>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach($users as $user) : ?>
                            <tr class="hover:bg-background1 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-dark-overlay"><?= $nomor ?></td>
                                <td class="px-6 py-4 text-sm font-medium text-dark-overlay"><?= htmlspecialchars($user['username'] ?? '-') ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-sm <?= getStyleRole($user['role_name']) ?> min-w-24 justify-center">
                                        <?= htmlspecialchars($user['role_name'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-dark-overlay"><?= $user['jurusan_unit'] ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-sm <?= getStyleStatus($user['status']) ?> text-background2 min-w-24 justify-center">
                                        <?= htmlspecialchars(translateStatusUser($user['status']) ?? '-') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?= BASEURL . "admin/" . $data['link'] .'/' . ($user['id_user'] ?? '')?>"
                                       class="inline-flex items-center px-4 py-1.5 text-xs font-medium text-dark-overlay bg-white border border-dark-overlay4 rounded-lg hover:bg-background1 transition-colors duration-150">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            <?php $nomor += 1 ?>
                            <?php endforeach ?>
                        </tbody>
                        <?php else: ?>
                        <tbody>
                            <tr>
                                <td colspan="6" class="px-6 py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="mb-4">
                                            <?= icon('fileList', 'h-20 w-20 text-dark-overlay4') ?>
                                        </div>
                                        <h3 class="text-lg font-semibold text-dark-overlay mb-2">Belum Ada Data Anggota</h3>
                                        <p class="text-sm text-dark-overlay7 text-center">Tidak ada anggota yang ditemukan untuk filter yang Anda pilih</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

        <?php endif; ?>
        
        
        <!-- pagination total euyy -->
        <?php if (!empty($users) && $total_page >= 1): ?>   
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
    </div>
</main>

<script src="/js/filterDropdown.js" defer></script>
<script src="/js/search.js" defer></script>