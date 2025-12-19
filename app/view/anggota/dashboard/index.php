<!-- Main Content -->
<main class="container mx-auto md:px-6 lg:px-6 px-1 py-8">
    <h2 class="lg:text-3xl md:text-2xl text-2xl font-bold text-black1 mb-8 text-center">Ruangan Yang Bisa Dipinjam</h2>

    <!-- Rooms Grid -->
    <div id="rooms-container" class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 md:grid-cols-2 mb-8 mx-5 md:gap-10 lg:gap-12 gap-5">
        <!-- **************************************************
        INI UNTUK CARD RUANGAN
        ******************************************************* -->
        <?php foreach($ruangan as $r) : ?>
        <div class="bg-white1 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
            <div class="relative h-48 bg-gray-200">
                <?php if($r['img_room'] !== 'DefaultRuangan.jpg'): ?>
                    <img decoding="async" src="<?= BASEURL; ?>/File/showPhoto/<?= $r['img_room']; ?>"
                        alt="<?= $r['room_name'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <img loading="lazy" src="/img/DefaultRuangan.jpg" 
                        alt="<?= $r['room_name'] ?>" class="w-full h-full object-cover">
                <?php endif ?>
            </div>
            <div class="grid grid-rows-[2fr_1fr] px-5 pt-5 pb-3">
                <div>
                    <h3 class="font-bold text-lg text-black3 mb-2"><?= $r['room_name'] ?></h3>
                    <p class="text-dark-overlay8 mb-4 text-justify text-sm"><?= $r['short_description'] ?></p>
                    <hr class="border-t border-dark-overlay mb-4">
                </div>
                <div class="grid grid-cols-[3fr_2fr] items-center justify-center text-sm text-black2">
                    <div class="grid grid-cols-2 gap-1 justify-items-start mb-2 md:text-md text-xs">
                        <div class="flex md:flex-col lg:flex-row flex-col justify-center items-center md:mr-2">
                            <div class="flex items-center gap-2 text-black2">
                                <?= icon('location', 'w-5 h-5') ?>        
                            </div>
                            <span class="inline-flex items-center lg:flex-row flex-col text-black2">
                                Lantai <?= $r['floor'] ?>
                            </span>
                        </div>
                        <div class="flex md:flex-col lg:flex-row flex-col justify-center items-center text-black2">                            
                            <div class="flex items-center gap-2 text-black2">
                                <?= icon('userOutline', 'w-5 h-5') ?>        
                            </div>
                            <span class="inline-flex items-center lg:flex-row flex-col"><?= $r['min_capacity'] . '-' . $r['max_capacity']  ?> orang </span>
                        </div>                          
                    </div>
                    <div class="w-full flex justify-end">
                        <a href="/Dashboard/Booking/<?= $r['id_room'] ?>"
                            class="flex items-center justify-center w-full bg-blue-overlay text-white1 text-center rounded-xl font-semibold text-xs hover:bg-green1 transition duration-200 py-3">
                            Pinjam Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
            <?php endforeach ?>
    </div>
</main>