<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm flex">
        <a href="/Admin/Peminjaman" class="text-blue-overlay hover:text-blue-700">Data Peminjaman Ruangan</a>
        <span class="mx-2 text-dark-overlay6">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <a href="/Admin/Peminjaman?tab=reschedule" class="text-blue-overlay hover:text-blue-700">Reschedule</a>
        <span class="mx-2 text-dark-overlay6">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <span class="font-medium text-dark-overlay6">Detail Reschedule</span>
    </nav>

    <h2 class="text-2xl font-bold text-dark-overlay">Detail Reschedule</h2>

    <div class="flex flex-col gap-8 lg:grid lg:grid-cols-[3fr_2fr] lg:gap-8 mt-2">
        <div class="bg-background2 rounded-2xl shadow-lg p-6 md:p-8 w-full">

            <!-- Nama Ruangan -->
            <div class="mb-5 w-full">
                <p class="block text-sm font-medium text-dark-overlay7 mb-2">Nama Ruangan</p>
                <span 
                    class="block w-full px-4 py-2 bg-white border border-dark-overlay4 rounded-lg text-dark-overlay">
                    <?= htmlspecialchars($reschedule['room_name'] ?? '-') ?>
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
                            <?= tanggal_indonesia($reschedule['new_start_time']??'-') ?>
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Jam Mulai</p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= waktu_indonesia($reschedule['new_start_time']) ?>
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Jam Selesai</p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= waktu_indonesia($reschedule['new_end_time']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Penanggung Jawab -->
            <div class="mb-5 w-full">
                <p class="block text-sm font-medium text-dark-overlay7 mb-2">Penanggung Jawab</p>
                <div class="flex flex-col justify-between gap-3 border border-dark-overlay4 p-4 rounded-lg flex-wrap">
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Nama</p>
                        <span
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($reschedule['username'] ?? '-') ?>
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">NIM</p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($reschedule['nomor_induk'] ?? '-') ?>
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-dark-overlay7">Jurusan</p>
                        <span 
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($reschedule['jurusan_unit'] ?? '-') ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informasi Anggota -->
            <div class="mb-5 w-full">
                <p class="block text-sm font-medium text-dark-overlay7 mb-2">Informasi Anggota</p>
                <div class="flex flex-col justify-between gap-3 border border-dark-overlay4 p-4 rounded-lg flex-wrap">
                <?php $i = 0 ?>
                <?php foreach($members as $member): ?>
                    <div class="flex-1">
                        <span
                            class="block w-full px-3 py-2 bg-white border border-dark-overlay4 rounded-lg text-left">
                            <?= htmlspecialchars($member['username'] ?? '-') ?>
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
                    <?= $i + 1 ?>
                </span>
            </div>
            
            <?php if($reschedule['status_reschedule'] === 'pending'): ?>
            <div class="grid grid-cols-2 gap-8">
                <button type="button" id="buttonDecline" class="flex-1 bg-red1 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg transition hover:cursor-pointer">
                    Decline
                </button>
                <button type="button" id="buttonApprove" class="flex-1 bg-green1 hover:bg-green-700 text-white font-medium py-2.5 rounded-lg transition hover:cursor-pointer">
                    Approve
                </button>
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
                            if ($i <= $reschedule['avg_rating']) {
                                echo icon('starFill', 'w-5 h-5 text-yellow1');   // bintang terisi
                            } else {
                                echo icon('starFill', 'w-5 h-5 text-dark-overlay5'); // bintang kosong/gelap
                            }
                                endfor; ?>  
                        </div>

                        <!-- Teks rating -->
                        <div class="text-white">
                            <span class="text-xl font-bold"><?= round($reschedule['avg_rating']) ?>/5</span>
                            <span class="text-sm font-medium text-white ml-2">(<?= $reschedule['total_review'] ?> Respon)</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                        <h3 class="font-bold text-2xl text-black mb-4"><?= htmlspecialchars($reschedule['room_name']) ?></h3>
                        <div class="space-y-3 text-sm text-black3 mb-2 gap-4">
                            <div class="flex items-center">
                                <div class="flex items-center text-black2">
                                    <?= icon('location', 'w-5 h-5 mr-3') ?> 
                                </div>    
                                <p class="">Lantai <?= htmlspecialchars($reschedule['floor']) ?></p>
                            </div>
    
                            <div class="flex items-center text-black">
                                <div class="flex items-center text-black2">
                                    <?= icon('userOutline', 'w-5 h-5 mr-3') ?> 
                                </div>    
                                <p ><?= $reschedule['min_capacity'] . '-' . $reschedule['max_capacity'] ?> orang</p>
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
                                <?= htmlspecialchars($reschedule['description'] ?? '-') ?>
                            </p>
                        </details>
                    </div>
                </div>

                <div class="mt-6 pt-6 space-y-4 bg-background2 shadow-xl p-6 rounded-xl">
                    <div class="mb-3 w-full">
                        <p class="block text-sm font-medium text-dark-overlay7 mb-2">Kode Booking</p>
                        <span 
                            class="block w-full px-4 py-2 bg-white border border-dark-overlay4 rounded-lg text-dark-overlay">
                            <?= $reschedule['booking_code'] ?>
                        </span>
                    </div>

                    <div class="mb-3 w-full">
                        <p class="text-sm font-medium text-dark-overlay7 mb-2">Status</p>
                        <a class="<?= getStyleStatusDetail($reschedule['status_reschedule']) ?> flex-row flex-wrap inline-flex justify-center py-1 px-4 rounded-md mt-2">
                            <div class="flex items-center gap-2 <?= getStyleStatustext($reschedule['status_reschedule']) ?>">
                                <?= icon('circleFill', 'w-3 h-3 mr-2') ?>        
                            </div>
                            <h2 class="text-md inline-block font-semibold <?= getStyleStatustext($reschedule['status_reschedule']) ?>"><?= translateStatus($reschedule['status_reschedule']) ?></h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <form id="approveForm" method="POST" action="<?= BASEURL; ?>/admin/approveReschedule/<?= $reschedule['id_reschedule'] ?>">
                <input type="hidden" name="id_reschedule" value="<?= $reschedule['id_reschedule']; ?>">
                <input type="hidden" name="id_booking" value="<?= $reschedule['id_booking']; ?>">
                <input type="hidden" name="new_start_time" value="<?= $reschedule['new_start_time']; ?>">
                <input type="hidden" name="new_end_time" value="<?= $reschedule['new_end_time']; ?>">
                <input type="hidden" name="username" value="<?= $reschedule['username']; ?>">
                <input type="hidden" name="email" value="<?= $reschedule['email']; ?>">
            </form>

            <form id="declineForm" method="POST" action="<?= BASEURL; ?>/admin/declineReschedule">
                <input type="hidden" name="id_reschedule" value="<?= $reschedule['id_reschedule']; ?>">
                <input type="hidden" name="username" value="<?= $reschedule['username']; ?>">
                <input type="hidden" name="email" value="<?= $reschedule['email']; ?>">
            </form>
</main>

<script>
    const buttonDecline = document.getElementById('buttonDecline');
    const buttonApprove = document.getElementById('buttonApprove');

    function openApproveModal() {
        Modal.confirm(
            'Approve Reschedule?',
            'Anda yakin ingin menyetujui reschedule ini?',
            function() {
                // Callback ketika tombol konfirmasi ditekan
                document.getElementById('approveForm').submit();
            },
            {
                icon: <?= json_encode(icon("usersAdmin", "w-24 h-24 text-green1")) ?>,
                confirmText: 'Ya',
                confirmClass: 'w-full px-6 py-2 bg-green1 text-white rounded-lg font-semibold hover:bg-green-600 hover:cursor-pointer transition',
                cancelText: 'Batalkan'
            }
        );
    }
    
    function openDeclineRescheduleModal() {
        Modal.prompt(
            'Decline Reschedule?',
            'Anda yakin ingin menolak permintaan reschedule',
            function(alasan) {
                // Callback dengan nilai input
                console.log('Alasan decline:', alasan);
                
                // Submit form dengan alasan
                const form = document.getElementById('declineForm');
                
                // Buat hidden input untuk alasan
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'alasan';
                hiddenInput.value = alasan;
                form.appendChild(hiddenInput);
                
                // Submit form
                form.submit();
            },
            {
                icon: <?= json_encode(icon("usersAdmin", "w-24 h-24 text-red1")) ?>,
                label: 'Alasan',
                value: 'Tulis alasan disini',
                rows: 4,
                required: true, // Wajib diisi
                confirmText: 'Ya',
                confirmClass: 'w-full px-6 py-2 bg-red1 text-white rounded-lg font-semibold hover:bg-red-800 hover:cursor-pointer transition',
                cancelText: 'Batalkan'
            }
        );
    }
    
    if(buttonDecline) {
        buttonDecline.addEventListener('click', openDeclineRescheduleModal);
    }
    if(buttonApprove) {
        buttonApprove.addEventListener('click', openApproveModal);
    }
</script>