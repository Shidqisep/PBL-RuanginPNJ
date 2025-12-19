<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <nav class="mb-6 text-sm flex">
        <span class="font-medium text-dark-overlay6">Dashboard</span>
    </nav>
    <h2 class="text-xl font-bold text-dark-overlay mb-6">Dashboard Laporan</h2>

    <!-- Section Booking yang Sedang Berjalan -->
    <div class="bg-background2 p-6 shadow-md rounded-lg">
        <div class="flex flex-row justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-dark-overlay mb-4">Booking yang Sedang Berjalan</h2>
            <?php if(!empty($bookings)): ?>
            <a href="<?= BASEURL; ?>/Admin/cetakLaporan" target="_blank" class="bg-blue-overlay hover:bg-blue-700 text-white1 font-medium my-1 px-3 py-2 rounded-lg flex items-center gap-2 shadow-md transition text-sm hover:cursor-pointer ml-auto w-fit mt-2">
                <?= icon('documentExport', 'w-5 h-5') ?>
                        Export Laporan Peminjaman
            </a>
            <?php endif ?>
        </div>
        <?php if(!empty($bookings)): ?>
        <!-- Grid untuk kartu-kartu booking (2 kolom di layar besar, 1 di kecil) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <?php foreach($bookings as $booking): ?>
            <!-- Kartu 1 -->
            <div class="p-4 rounded-lg shadow-md border border-dark-overlay5">
                <h3 class="text-lg font-medium text-dark-overlay"><?= htmlspecialchars($booking['room_name'] ?? '-') ?></h3>
                <p class="text-sm text-dark-overlay7"><?= waktu_indonesia($booking['start_time']) . '-' . waktu_indonesia($booking['end_time']) ?></p>
                <span class="inline-block bg-blue-overlay text-background2 px-2 py-1 rounded-xl text-sm font-semibold mt-2"><?= $booking['total_person'] ?> Orang</span>
                <p class="text-sm text-dark-overlay mt-2">Penanggung Jawab: <?= $booking['username'] ?></p>
            </div>
        <?php endforeach ?>
        </div>
        <?php else: ?>
            <div class="p-12 rounded-lg shadow-sm border border-dark-overlay2 flex flex-col items-center gap-6">
                <?= icon('fileList', 'w-20 h-20') ?>
                <p>Belum ada Peminjaman yang sedang berlangsung</p>
            </div>
        <?php endif ?>
            
        
        
    </div>


    <div class="bg-background2 p-6 shadow-md mt-12 rounded-lg">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-row justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-dark-overlay">Booking</h1>
                <div class="flex gap-4">
                    <a onclick="exportData('<?= BASEURL; ?>/Admin/cetakLaporan')" target="_blank" class="bg-blue-overlay hover:bg-blue-700 text-white1 font-medium my-1 px-3 py-2 rounded-lg flex items-center gap-2 shadow-md transition text-sm hover:cursor-pointer ml-auto w-fit mt-2">
                <?= icon('documentExport', 'w-5 h-5') ?>
                        Export PDF Laporan Peminjaman
                    </a>
                    <a onclick="exportData('<?= BASEURL; ?>/Admin/cetakLaporan', 'excel')" target="_blank" class="bg-blue-overlay hover:bg-blue-700 text-white1 font-medium my-1 px-3 py-2 rounded-lg flex items-center gap-2 shadow-md transition text-sm hover:cursor-pointer ml-auto w-fit mt-2">
                <?= icon('documentExport', 'w-5 h-5') ?>
                        Download Excel Laporan Peminjaman
                    </a>
                </div>
            </div>

            
        </div>

        <form method="GET" id="filterForm">
        <div class=" filter-scope flex items-center gap-3 pb-2">
            <!-- Filter Hari Ini -->

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
                        include __DIR__ . '/../template/filterDropDown.php';
            ?>

            <?php 
                $filter_id = 'tahun'; 
                $label = 'Tahun'; 
                $options = ['2025' => '2025', '2024' => '2024']; 
                $current_values = $_GET[$filter_id] ?? ''; 
                include __DIR__ . '/../template/filterDropDown.php';
            ?>

            <button type="button"
                    class="filter-action-btn px-3 py-1.5 flex items-center hover:cursor-pointer text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition border border-gray-300 bg-white"
                    data-filter-list="bulan,tahun">
                    <div id="filter-action-icon" class="filter-action-icon text-dark-overlay5"
                        data-check="<?= htmlspecialchars(icon('check', 'w-4 h-4 text-blue-overlay'), ENT_QUOTES) ?>"
                        data-cross="<?= htmlspecialchars(icon('cross', 'w-4 h-4 text-red1'), ENT_QUOTES) ?>">
                        <?= icon('check', 'w-4 h-4 text-blue-overlay') ?>
                    </div>

                <span
                        class="filter-action-text ms-2 text-blue-overlay" 
                        data-text-check="Terapkan" 
                        data-text-cross="Reset">
                        Terapkan
                </span> 
            </button>
        </div>
        </form>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 gap-6 mt-6">
            <div class="grid grid-cols-3 gap-6">
                <!-- Total Booking -->
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Total Booking</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_booking['total_booking'] ?> Orang</p>
                </div>

                <!-- Reschedule -->
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Reschedule</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_booking['reschedule'] ?> Reschedule</p>
                </div>

                <!-- Selesai -->
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Selesai</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_booking['selesai'] ?> Booking</p>
                </div>
            </div>
            

            <div class="grid grid-cols-2 gap-6">
                <!-- Dibatalkan -->
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Dibatalkan</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_booking['dibatalkan'] ?> Booking</p>
                </div>

                <!-- Dipinjam -->
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Dipinjam</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_booking['dipinjam'] ?> Booking</p>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-background2 p-6 shadow-md mt-12 rounded-lg">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-dark-overlay">Anggota</h1>
                <div class="flex gap-4">
                    <a onclick="exportData('<?= BASEURL; ?>/Admin/cetakAnggota')" target="_blank" class="bg-blue-overlay hover:bg-blue-700 text-white1 font-medium my-1 px-3 py-2 rounded-lg flex items-center gap-2 shadow-md transition text-sm hover:cursor-pointer ml-auto w-fit mt-2">
                <?= icon('documentExport', 'w-5 h-5') ?>
                        Export PDF Laporan Anggota
                    </a>
                    <a onclick="exportData('<?= BASEURL; ?>/Admin/cetakAnggota', 'excel')" target="_blank" class="bg-blue-overlay hover:bg-blue-700 text-white1 font-medium my-1 px-3 py-2 rounded-lg flex items-center gap-2 shadow-md transition text-sm hover:cursor-pointer ml-auto w-fit mt-2">
                <?= icon('documentExport', 'w-5 h-5') ?>
                        Download Excel Laporan Anggota
                    </a>
                </div>
            </div>
        </div>

        <form method="GET" id="filterForm">
        <div class="filter-scope flex items-center gap-3 pb-2">
            <!-- program studi -->

            <?php 
                // $filter_id = 'Prodi'; 
                // $label = 'Prodi'; 
                // $options = ['' => 'Ruang Duta', 'Ruang Meeting Kecil' => 'Ruang Meeting Kecil']; 
                // $current_values = $_GET[$filter_id] ?? ''; 
                // include __DIR__ . '/../template/filterDropDown.php';
                ?>

            <?php 
                $filter_id = 'Role'; 
                $label = 'Jenis Anggota'; 
                $options = ['Dosen' => 'Dosen', 'Mahasiswa' => 'Mahasiswa', 'Tendik' => 'Tendik']; 
                $current_values = $_GET[$filter_id] ?? ''; 
                include __DIR__ . '/../template/filterDropDown.php';
            ?>

            <!-- jurusan -->
            <?php 
                $filter_id = 'Jurusan'; 
                $label = 'Jurusan'; 
                $options = [
                    'Teknik Informatika dan Komputer' => 'Teknik Informatika dan Komputer', 
                    'Teknik Elektro' => 'Teknik Elektro', 
                    'Teknik Mesin' => 'Teknik Mesin',
                    'Teknik Sipil' => 'Teknik Sipil',
                    'Akutansi' => 'Akutansi',
                    'Administrasi Niaga' => 'Administrasi Niaga',
                    'Teknik Grafika dan Penerbitan' => 'Teknik Grafika dan Penerbitan'
                ]; 
                $current_values = $_GET[$filter_id] ?? ''; 
                include __DIR__ . '/../template/filterDropDown.php';
                ?>
            <button type="button"
                    class="filter-action-btn px-3 py-1.5 flex items-center hover:cursor-pointer text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition border border-gray-300 bg-white"
                    data-filter-list="Prodi, Jurusan, Role">
                    <div class="filter-action-btn text-dark-overlay5"
                        data-check="<?= htmlspecialchars(icon('check', 'w-4 h-4 text-blue-overlay'), ENT_QUOTES) ?>"
                        data-cross="<?= htmlspecialchars(icon('cross', 'w-4 h-4 text-red1'), ENT_QUOTES) ?>">
                        <?= icon('check', 'w-4 h-4 text-blue-overlay') ?>
                    </div>

                <span
                        class="filter-action-text ms-2 text-blue-overlay" 
                        data-text-check="Terapkan" 
                        data-text-cross="Reset">
                        Terapkan
                </span> 
            </button>
        </div>
        </form>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 gap-6 mt-6">
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Total Anggota</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_anggota['total_anggota'] ?> Orang</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Dosen</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_anggota['total_dosen'] ?> Orang</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Mahasiswa</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_anggota['total_mahasiswa'] ?> Orang</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Tenaga Pendidik</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_anggota['total_tendik'] ?> Orang</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Aktif</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_anggota['aktif'] ?> Orang</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Tidak Aktif</p>
                    <p class="text-2xl font-bold mt-2"><?= ($stats_anggota['total_anggota'] - $stats_anggota['aktif']) ?> Orang</p>
                </div>   
            </div>
            

            <div class="grid grid-cols-2 gap-6">
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Menunggu Approval</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_anggota['menunggu'] ?> Orang</p>
                </div>
                
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Ditolak</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_anggota['ditolak'] ?> Orang</p>
                </div>

            </div>

            
            
        </div>
    </div>


    <div class="bg-background2 p-6 shadow-md mt-12 rounded-lg">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-dark-overlay">Ruangan</h1>
                 <div class="flex gap-4">
                    <a onclick="exportData('<?= BASEURL; ?>/Admin/cetakRuangan')" target="_blank" class="bg-blue-overlay hover:bg-blue-700 text-white1 font-medium my-1 px-3 py-2 rounded-lg flex items-center gap-2 shadow-md transition text-sm hover:cursor-pointer ml-auto w-fit mt-2">
                <?= icon('documentExport', 'w-5 h-5') ?>
                        Export PDF Laporan Ruangan
                    </a>
                    <a onclick="exportData('<?= BASEURL; ?>/Admin/cetakRuangan', 'excel')" target="_blank" class="bg-blue-overlay hover:bg-blue-700 text-white1 font-medium my-1 px-3 py-2 rounded-lg flex items-center gap-2 shadow-md transition text-sm hover:cursor-pointer ml-auto w-fit mt-2">
                <?= icon('documentExport', 'w-5 h-5') ?>
                        Download Excel Laporan Ruangan
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mt-6">
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Total Ruangan</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_ruangan['total_ruangan'] ?> Ruangan</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Tersedia</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_ruangan['tersedia'] ?> Ruangan</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Tidak Tersedia</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_ruangan['tidak_tersedia'] ?> Ruangan</p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Ruangan Terpopuler</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_ruangan['populer_nama'] ?></p>
                </div>

                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Rating Terbaik</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_ruangan['rating_terbaik_nama'] . ' ' . $stats_ruangan['rating_terbaik_nilai'] ?></p>
                </div>

                <!-- Reschedule -->
                <div class="bg-blue-overlay9 text-white1 p-6 rounded-2xl shadow-lg">
                    <p class="text-white1 text-sm font-medium">Rating Terendah</p>
                    <p class="text-2xl font-bold mt-2"><?= $stats_ruangan['rating_terendah_nama'] . ' ' . $stats_ruangan['rating_terendah_nilai'] ?></p>
                </div>
            </div>
        </div>
    </div>
        
</main>

<script src="/js/filterAdmin.js" defer></script>
</body>
</html>