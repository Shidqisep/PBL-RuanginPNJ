<main class="flex-1 p-8 overflow-y-auto bg-[#F9FAFC]">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm flex">
        <a href="/Admin/Peminjaman" class="text-blue-overlay hover:text-blue-700">Data Peminjaman Ruangan</a>
        <span class="mx-2 text-dark-overlay6">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <a href="/Admin/Peminjaman?tab=riwayat" class="text-blue-overlay hover:text-blue-700">Riwayat</a>
        <span class="mx-2 text-dark-overlay6">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <span class="font-medium text-gray-900">Detail Booking</span>
    </nav>

    <h2 class="text-2xl font-bold text-dark-overlay">Booking Yang Menunggu</h2>

    <div class="flex flex-col gap-8 lg:grid lg:grid-cols-[3fr_2fr] lg:gap-8 mt-2">
        <div class="bg-background2 rounded-2xl shadow-lg p-6 md:p-8 w-full">

            <!-- Nama Ruangan -->
            <div class="mb-5 w-full">
                <p class="block text-sm font-medium text-dark-overlay7 mb-2">Nama Ruangan</p>
                <span 
                    class="block w-full px-4 py-2 bg-white border border-dark-overlay4 rounded-lg text-dark-overlay">
                    <?= htmlspecialchars($detailBooking['room_name'] ?? '-') ?>
                    
                </span>
            </div>

            <!-- Waktu Peminjaman -->
            <div class="mb-5 w-full">
                <label class="block text-sm font-medium text-dark-overlay7 mb-2">Waktu Peminjaman</label>
                <div class="flex flex-row justify-between gap-3 border border-dark-overlay4 p-4 rounded-lg flex-wrap">
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Tanggal</p>
                        <span
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= tanggal_indonesia($detailBooking['start_time'] ?? '-') ?>
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Jam Mulai</p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= waktu_indonesia($detailBooking['start_time']) ?>
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Jam Selesai</p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= waktu_indonesia($detailBooking['end_time']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Penanggung Jawab -->
            <div class="mb-5 w-full">
                <p class="block text-sm font-medium text-dark-overlay7 mb-2">Penanggung Jawab</p>
                <div class="flex flex-col justify-between gap-3 border border-dark-overlay4 p-4 rounded-lg flex-wrap">
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7"><?= $detailBooking['username'] ? 'Nama' : 'email' ?></p>
                        <span
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($detailBooking['username'] ?? $detailBooking['external_email']) ?>
                        </span> 
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7"><?= $detailBooking['username'] ? 'NIM' : 'Nama Instansi' ?></p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($detailBooking['nomor_induk'] ?? $detailBooking['institution_name']) ?>
                        </span>
                    </div>  
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7"><?= $detailBooking['username'] ? 'Jurusan' : 'Tujuan' ?></p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($detailBooking['jurusan_unit'] ?? $detailBooking['purpose']) ?>
                        </span>
                    </div>
                    <?php if(!empty($detailBooking['booking_letter'])): ?>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Lampiran</p>
                        <a href="<?= BASEURL; ?>/File/downloadDokumen/<?= $detailBooking['booking_letter'] ?>" 
                                target="_blank"
                                class="flex items-center justify-between w-full px-3 py-2 bg-white border border-blue-300 rounded-lg text-left text-blue-600 hover:bg-blue-50 hover:border-blue-500 transition group cursor-pointer">
                            <span 
                                class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                                <?= htmlspecialchars($detailBooking['booking_letter'] ?? '-')?>
                            </span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(!empty($members)): ?>
            <!-- Informasi Anggota -->
            <div class="mb-5 w-full">
                <p class="block text-sm font-medium text-dark-overlay7 mb-2">Informasi Anggota</p>
                <div class="flex flex-col justify-between gap-3 border border-dark-overlay4 p-4 rounded-lg flex-wrap">
                <?php $i = 0 ?>
                <?php foreach($members as $member): ?>
                    <div class="flex-1">
                        <span
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($member['username']) ?>
                        </span>
                    </div>
                    <?php $i++ ?>
                <?php endforeach ?>
                </div>
            </div>

            <!-- Jumlah Orang -->
            <div class="mb-5 w-full">
                <p class="block text-sm font-medium text-dark-overlay7 mb-2">Jumlah Orang</p>
                <span 
                    class="block w-full px-4 py-2 bg-white border border-dark-overlay4 rounded-lg text-dark-overlay">
                    <?= $i ?>
                </span>
            </div>
             <?php endif ?>

            
        </div>

        <div class="order-1 lg:order-0 lg:col-span-1 space-y-6 lg:sticky">
    
            <!-- KARTU RUANGAN (TIDAK STICKY) -->
            <div class="bg-background2 rounded-xl shadow-lg overflow-hidden">
                <?php 
                    // Ambil URL gambar dari array PHP
                    //$imageUrl = "/img/" . $detailRuangan['img_room'];
                ?>

                <div class="h-56 relative overflow-hidden bg-background2" 
                    style="background-image: url('/img/DefaultRuangan.jpg'); 
                            background-size: cover; 
                            background-position: center;">
                    <!-- Overlay Rating (mirip gambar) -->
                    <div class="absolute bottom-2 left-2 flex items-center gap-3 px-5 py-1
                                    bg-dark-overlay5
                                    rounded-lg
                                    animate-in fade-in slide-in-from-bottom duration-500">
                        
                        <!-- Bintang -->
                        <div class="flex items-center gap-1">
                            <?php 
                            $max = 5;
                            for ($i = 1; $i <= $max; $i++):
                            if ($i <= $detailBooking['avg_rating']) {
                                echo icon('starFill', 'w-5 h-5 text-yellow1');   // bintang terisi
                            } else {
                                echo icon('starFill', 'w-5 h-5 text-dark-overlay5'); // bintang kosong/gelap
                            }
                                endfor; ?>  
                        </div>

                        <!-- Teks rating -->
                        <div class="text-white">
                            <span class="text-xl font-bold"><?= round($detailBooking['avg_rating']) ?>/5</span>
                            <span class="text-sm font-medium text-white ml-2">(<?= $detailBooking['total_review'] ?> Respon)</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                        <h3 class="font-bold text-2xl text-black mb-4"><?= htmlspecialchars($detailBooking['room_name']) ?></h3>
                        <div class="space-y-3 text-sm text-black3 mb-2 gap-4">
                            <div class="flex items-center">
                                <div class="flex items-center text-black2">
                                    <?= icon('location', 'w-5 h-5 mr-3') ?> 
                                </div>    
                                <p class="">Lantai <?= htmlspecialchars($detailBooking['floor']) ?></p>
                            </div>
    
                            <div class="flex items-center text-black">
                                <div class="flex items-center text-black2">
                                    <?= icon('userOutline', 'w-5 h-5 mr-3') ?> 
                                </div>    
                                <p ><?= htmlspecialchars($detailBooking['min_capacity'] ?? '-') . '-' . htmlspecialchars($detailBooking['max_capacity'] ?? '-') ?> orang</p>
                            </div>
                            
                        </div>
                        <details class="text-dark-overlay8 mt-4">
                            <summary class="text-base cursor-pointer text-dark-overlay8 flex items-center">
                                Deskripsi Ruangan
                                <div class="flex items-center">
                                    <?= icon('arrowDown', 'w-6 h-6 ml-2') ?> 
                                </div>
                            </summary>
                            <p class="mt-3 text-sm leading-relaxed text-justify">
                                <?= htmlspecialchars($detailBooking['description'] ?? '-') ?>
                            </p>
                        </details>
                    </div>
                </div>

                <div class="mt-6 pt-6 space-y-4 bg-background2 shadow-xl p-6 rounded-xl">
                    <div class="mb-3 w-full">
                        <p class="block text-sm font-medium text-dark-overlay7 mb-2">Kode Booking</p>
                        <span 
                            class="block w-full px-4 py-2 bg-white border border-dark-overlay4 rounded-lg text-dark-overlay">
                            <?= $detailBooking['booking_code'] ?>
                        </span>
                    </div>

                    <div class="mb-3 w-full">
                        <p class="text-sm font-medium text-dark-overlay7 mb-2">Status</p>
                        <a class="<?= getStyleStatusDetail($detailBooking['status']) ?> flex-row flex-wrap inline-flex justify-center py-1 px-4 rounded-md mt-2">
                            <div class="flex items-center gap-2 <?= getStyleStatustext($detailBooking['status']) ?>">
                                <?= icon('circleFill', 'w-3 h-3 mr-2') ?>        
                            </div>
                            <h2 class="text-md inline-block font-semibold <?= getStyleStatustext($detailBooking['status']) ?>"><?= translateStatus($detailBooking['status']) ?></h2>
                        </a>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="gap-4 pt-6 grid grid-cols-1">
                    <?php if ($detailBooking['status'] === 'pending') : ?>
                    <div class="grid grid-cols-2 gap-8">
                        <button onclick="konfirmasiCancel()" class="flex-1 bg-red1 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg transition hover:cursor-pointer">
                            Cancel Booking
                        </button>
                        <button onclick="konfirmasiMulai()" class="flex-1 bg-green1 hover:bg-green-700 text-white font-medium py-2.5 rounded-lg transition hover:cursor-pointer">
                            Mulai Peminjaman
                        </button>
                    </div>
                    <?php endif; ?>
                    <?php if ($detailBooking['status'] === 'ongoing') : ?>
                    <button onclick="konfirmasiSelesaikan()" class="flex-1 bg-blue-overlay hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition hover:cursor-pointer">
                    Selesaikan Peminjaman
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

        <form id="bookingForm" method="POST" action="<?= BASEURL; ?>/admin/startBooking">
            <input type="hidden" name="id_booking" value="<?= $detailBooking['id_booking']; ?>">
            <input type="hidden" name="status" value="ongoing"> 
        </form>

        <form id="declineForm" method="POST" action="<?= BASEURL; ?>/admin/cancelBooking">
            <input type="hidden" name="id_booking" value="<?= $detailBooking['id_booking']; ?>">
            <input type="hidden" name="status" value="cancelled">
        </form>

        <form id="finishForm" method="POST" action="<?= BASEURL; ?>/admin/finishBooking">
            <input type="hidden" name="id_booking" value="<?= $detailBooking['id_booking']; ?>">
        </form>
</main>

<script>
    function konfirmasiMulai() {
        Modal.confirm(
            'Mulai peminjaman',
            'Anda yakin ingin memulai peminjaman?',
            function() {
                document.getElementById('bookingForm').submit();
            },
            {
            icon: <?= json_encode(icon("calendar", "w-12 h-12 text-green1")) ?>,
            confirmText: 'Mulai',
            confirmClass: 'w-full px-6 py-2 bg-green1 text-white rounded-lg font-semibold hover:bg-green-700 transition hover:cursor-pointer',
            cancelText: 'Batalkan'
            }
        );
    }

    function konfirmasiCancel() {
    Modal.confirm(
        'Batalkan Booking',
        'Apakah Anda yakin ingin membatalkan peminjaman?',
        function() {
            document.getElementById('declineForm').submit();
        },
        {
            icon: <?= json_encode(icon("crossCircle", "w-12 h-12 text-red1")) ?>,
            confirmText: 'Ya',
            confirmClass: 'w-full px-6 py-2 bg-red1 text-white rounded-lg font-semibold hover:bg-red-700 transition hover:cursor-pointer',
            cancelText: 'Batalkan'
        }
    );
}

function konfirmasiSelesaikan() {
        Modal.confirm(
            'Selesaikan Peminjaman?',
            'Anda yakin ingin menyelesaikan peminjaman?',
            function() {
                document.getElementById('finishForm').submit();
            },
            {
            icon: <?= json_encode(icon("check", "w-12 h-12 text-green1")) ?>,
            confirmText: 'Selesaikan',
            confirmClass: 'w-full px-6 py-2 bg-green1 text-white rounded-lg font-semibold hover:bg-green-700 transition hover:cursor-pointer',
            cancelText: 'Batalkan'
            }
        );
    }
</script>