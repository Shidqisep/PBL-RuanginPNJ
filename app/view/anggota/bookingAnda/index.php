<?php $tab = $_GET['tab'] ?? 'booking'; ?>

<main class="container mx-auto lg:px-11 md:px-9 px-6 py-8 min-h-screen">

    <h1 class="text-3xl font-semibold text-center mb-12">Bookingan Anda</h1>

    <div class="flex justify-center mb-6 flex-col shadow-xl">
        <div class="overflow-hidden w-full">
            <div class="flex mx-auto rounded-t-xl overflow-hidden">
                <a href="?tab=booking" 
                class="flex-1 text-center py-3 font-semibold transition <?= ($_GET['tab'] ?? 'booking') === 'booking' ? 'bg-blue-overlay9 text-white rounded-tl-xl' : 'bg-blue-overlay1 text-blue-overlay hover:bg-gray-200' ?>">
                    Booking
                </a>
                <a href="?tab=reschedule" 
                class="flex-1 text-center py-3 font-semibold transition <?= ($_GET['tab'] ?? 'booking') === 'reschedule' ? 'bg-blue-overlay9 text-white rounded-tr-xl' : 'bg-blue-overlay1 text-blue-overlay hover:bg-gray-200' ?>">
                    Status Reschedule
                </a>
            </div>
                <?php if ($tab === 'booking' || empty($tab)): ?>
                    <?php if (!empty($activeBooking)): ?>
                    <!-- Booking Details -->
                    <div class="w-full mx-auto bg-background2 rounded-b-xl shadow-xl lg:p-12 p-4">
                        <div class="">
                            <div class="relative lg:h-96 md:h-96 h-48">
                                <?php if($activeBooking['img_room'] !== 'DefaultRuangan.jpg'): ?>
                                    <img loading="lazy" src="<?= BASEURL; ?>/File/showPhoto/<?= $activeBooking['img_room']; ?>"
                                        alt="<?= $activeBooking['room_name'] ?>" class="w-full h-full object-cover rounded-xl">
                                <?php else: ?>
                                    <img loading="lazy" src="/img/DefaultRuangan.jpg" 
                                        alt="<?= $activeBooking['room_name'] ?>" class="w-full h-full object-cover rounded-xl">
                                <?php endif ?>
                            </div>
                            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 lg:justify-center justify-start items-center border border-dark-overlay7 mt-6 p-3 rounded-md pb-4 lg-pb-0">
                                <div class="">
                                    <p class="text-dark-overlay7 lg:text-sm text-xs">Nama Ruangan</p>
                                    <h2 class="lg:text-3xl text-xl font-semibold text-dark-overlay"><?= htmlspecialchars($activeBooking['room_name'] ?? '-')?></h2>
                                </div>

                                <div class="">         
                                    <p class="text-dark-overlay7 lg:text-sm text-xs">Status</p>
                                    <div>
                                        <a class="bg-blue-overlay-25 inline-flex items-center whitespace-nowrap py-2 px-4 text-white1 rounded-md mt-2">
                                            <div class="text-blue-overlay">
                                                <?= icon('circleFill', 'h-5 w-5 mr-2') ?>
                                            </div>
                                            <h2 class="text-sm font-semibold text-blue-overlay mb-0"><?= htmlspecialchars($status) ?></h2>
                                        </a>
                                    </div>         
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 justify-start items-start border border-dark-overlay7 mt-6 p-4 rounded-md">
                                <div class="border-dark-overlay7 py-4">         
                                    <p class="text-dark-overlay7 lg:text-sm text-xs">Tanggal Peminjaman</p>
                                    <div class="max-w-3/6">
                                        <h2 class="text-sm inline-block font-semibold pr-2 1y-1 text-dark-overlay rounded-lg mt-2"><?= htmlspecialchars($bookingDate) ?></h2>
                                    </div>           
                                </div>
                                <div class="border-dark-overlay7 py-4">
                                    <p class="text-dark-overlay7 lg:text-sm text-xs">Jumlah Orang</p>
                                    <h2 class="text-sm font-semibold"><?= htmlspecialchars($activeBooking['total_person'] ?? '-') ?></h2>     
                                </div>
                                <div class="border-dark-overlay7 py-4">         
                                    <p class="text-dark-overlay7 lg:text-sm text-xs">Jam Peminjaman</p>
                                    <div class="max-w-3/6">
                                        <h2 class="text-sm inline-block font-semibold pr-2 1y-1 text-dark-overlay rounded-lg mt-2"><?= htmlspecialchars($start_time)?> -  <?= htmlspecialchars($end_time) ?></h2>
                                    </div>           
                                </div>

                                <div class="border-dark-overlay7 py-4">         
                                    <p class="text-dark-overlay7 lg:text-sm text-xs">Kode Booking</p>
                                    <div class="max-w-3/6">
                                        <h2 class="text-sm inline-block font-semibold pr-2 1y-1 text-dark-overlay rounded-lg mt-2"><?= htmlspecialchars($activeBooking['booking_code'] ?? '-')?></h2>
                                    </div>           
                                </div>
                            </div>
                            <div class="flex space-x-4 py-4">
                                <button  type="button" id="buttonCancel" class="bg-red1 text-white px-6 py-2 rounded-sm text-sm hover:bg-red-700 hover:cursor-pointer">
                                    Batalkan Booking
                                </button>
                                <a href="/Booking/Reschedule/<?= $booking['id_booking'] ?>" class="bg-blue-overlay text-white px-6 py-2 rounded-sm text-sm hover:bg-blue-700 hover:cursor-pointer">
                                    Reschedule
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <form id="cancelForm" action="<?= BASEURL ?>/Booking/cancelBooking" method="post">
                        <input type="hidden" value="<?= $activeBooking['id_booking'] ?? '' ?>" name="id_booking">
                    </form>

                    <?php else: ?>
                        <!-- Empty State untuk Booking -->
                        <div class="w-full mx-auto bg-background2 rounded-b-xl shadow-xl lg:p-12 p-4">
                            <div class="flex flex-col items-center justify-center py-16">
                                <svg class="w-24 h-24 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Booking Aktif</h3>
                                <p class="text-gray-500 text-center mb-6">Anda belum memiliki booking yang sedang aktif saat ini</p>
                                <a href="/Dashboard" class="bg-blue-overlay text-white px-6 py-2 rounded-md text-sm hover:bg-blue-700 transition">
                                    Pinjam Ruangan Sekarang
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

            <?php elseif ($tab === 'reschedule'): ?>
                <?php if (!empty($reschedules)): ?>
                <div id="desktop-table" class="md:block hidden overflow-x-auto bg-white rounded-t-xl lg:p-12 p-4">
                    
                    <table class="w-full text-sm border-separate border-spacing-0 border border-dark-overlay4 rounded-t-xl">
                        <thead class="bg-blue-overlay1 rounded-t-xl">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-dark-overlay7 rounded-tl-xl">No.</th>
                                <th class="px-4 py-3 text-left font-semibold text-dark-overlay7">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold text-dark-overlay7">Ruangan</th>
                                <th class="px-4 py-3 text-left font-semibold text-dark-overlay7">Jam</th>
                                <th class="px-4 py-3 text-center font-semibold text-dark-overlay7 rounded-tr-xl">Status</th>
                            </tr>
                        </thead>
                        <tbody id="" class="divide-y divide-dark-overlay4">


                        <?php $i = 1 ?>
                        <?php foreach($reschedules as $reschedule): ?>
                            <tr class="hover:bg-gray-50 transition border-b font-medium text-dark-overlay dark-overlay4ay-300">
                                <td class="px-4 py-3 text-left text-sm border-b font-medium text-dark-overlay border-dark-overlay4"><?= $i ?></td>
                                <td class="px-4 py-3 text-left text-sm border-b font-medium text-dark-overlay border-dark-overlay4"><?= htmlspecialchars(tanggal_indonesia($reschedule['new_start_time']) ?? '-') ?></td>
                                <td class="px-4 py-3 text-left text-sm border-b font-medium text-dark-overlay border-dark-overlay4"><?= htmlspecialchars($reschedule['room_name']) ?? '-' ?></td>
                                <td class="px-4 py-3 text-left text-sm border-b font-medium text-dark-overlay border-dark-overlay4"><?= htmlspecialchars_decode(waktu_indonesia($reschedule['new_start_time']) ?? '')?> - <?= htmlspecialchars_decode(waktu_indonesia($reschedule['new_end_time']) ?? '')?></td>
                                <td class="px-4 py-3 text-left justify-center flex border-b font-medium text-dark-overlay border-dark-overlay4">
                                    <div class="flex <?= getStyleStatus($reschedule['status_reschedule']) ?> items-center justify-center text-white px-5 py-2 rounded-sm text-xs font-medium shadow-md min-w-1/2">
                                        <span><?= htmlspecialchars(translateStatus($reschedule['status_reschedule']) ?? '')?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>   
                </div>


                <!-- **************************************************
                INI TAMPILAN MOBILE
                ******************************************************* --> 
                <!-- Mobile Cards -->
                <div id="mobile-cards" class="block md:hidden space-y-4 flex flex-col items-center mx-4 my-4">
                <?php $i = 1 ?>
                <?php foreach($reschedules as $reschedule): ?>
                    <!-- Card Item -->
                    <div class="bg-background2 rounded-xl shadow-lg border border-dark-overlay4 p-5 hover:shadow-md transition-shadow w-full">                    
                        <div class="grid grid-cols-1 gap-x-4 gap-y-3 text-sm">
                            <div class="grid grid-cols-1 border-b border-dark-overlay4">
                                <div>
                                    <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Ruangan</div>
                                    <div class="font-semibold text-lg text-dark-overlay"><?= htmlspecialchars($reschedule['room_name']) ?? '-' ?></div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 border-b border-dark-overlay4">
                                <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Tanggal</div>
                                <div class="font-semibold text-dark-overlay"><?= htmlspecialchars(tanggal_indonesia($reschedule['new_start_time']) ?? '-') ?></div>
                            </div>

                            <div class="grid grid-cols-2 border-b border-dark-overlay4">
                                <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Jam</div>
                                <div class="font-semibold text-dark-overlay"><?= htmlspecialchars_decode(waktu_indonesia($reschedule['new_start_time']) ?? '')?> - <?= htmlspecialchars_decode(waktu_indonesia($reschedule['new_end_time']) ?? '')?></div>
                            </div>

                            <div class="grid grid-cols-2 items-center">
                                <div class="text-dark-overlay7 text-xs uppercase tracking-wider">Status</div>
                                <div class="<?= getStyleStatus($reschedule['status_reschedule']) ?> items-center justify-center text-white px-5 py-2 rounded-sm text-xs font-medium shadow-md min-w-1/2 text-center"><?= htmlspecialchars(translateStatus($reschedule['status_reschedule']) ?? '')?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                
                <?php else: ?>
                <div class="text-center py-16 text-dark-overlay7">
                    sepertinya kamu belum ada riwayat pengajuan reschedule.
                </div>
                <?php endif; ?>
            <?php endif; ?>
            </div>
    </div>
</main>

<script>

    const buttonCancel = document.getElementById('buttonCancel')

    function konfirmasiCancel() {
        Modal.confirm(
            'Konfirmasi Pembatalan Booking',
            'Anda akan mendapatkan suspend jika membatalkan booking, baca panduan untuk informasi lebih lanjut',
            function() {
            // ini yang benar untuk POST form, bukan window.location.href
            document.getElementById('cancelForm').submit();
            },
            {
            icon: <?= json_encode(icon("calendar", "w-12 h-12", "green1")) ?>,
            confirmText: 'Batalkan Booking',
            confirmClass: 'w-full px-6 py-2 bg-red1 text-white rounded-lg font-semibold hover:bg-red-800 transition hover:cursor-pointer',
            cancelText: 'Kembali'
            }
        );
    }

    buttonCancel.addEventListener('click', konfirmasiCancel)
</script>