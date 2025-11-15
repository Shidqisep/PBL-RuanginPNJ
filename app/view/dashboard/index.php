<?php Flasher::Flash();

?>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-black mb-8 text-center">Ruangan Yang Bisa Dipinjam</h2>

        <!-- Capacity Filters -->
        <div class="flex justify-start mb-6 space-x-4 mx-5">
            <button id="filter-all" 
                    class="px-4 py-2 bg-[#1E68FB] text-white rounded-full font-medium text-sm hover:bg-blue-700 transition duration-200 hover:cursor-pointer">
                Semua
            </button>
            <button id="filter-2-4" 
                    class="px-4 py-2 bg-white text-[#171E29] rounded-full font-medium text-sm hover:bg-gray-300 transition duration-200 hover:cursor-pointer">
                2-4 Orang
            </button>
            <button id="filter-4-8" 
                    class="px-4 py-2 bg-white text-[#171E29] rounded-full font-medium text-sm hover:bg-gray-300 transition duration-200 hover:cursor-pointer">
                4-8 Orang
            </button>
        </div>

        <!-- Rooms Grid -->
        <div id="rooms-container" class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 md:grid-cols-2 mb-8 mx-5 md:gap-10 lg:gap-12 gap-5">
            <!-- **************************************************
            INI UNTUK CARD RUANGAN
            ******************************************************* -->
            <?php foreach($ruangan as $r) : ?>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="/img/<?= $r['img_ruangan'] ?>" 
                        alt="Ruang Lentera Edukasi" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-[#1A1A1A] mb-2"><?= $r['nama_ruangan'] ?></h3>
                    <p class="text-dark-overlay/80 mb-4 text-justify text-sm"><?= $r['deskripsi_singkat'] ?></p>
                    <hr class="border-t border-[#171E29] mb-4">
                    <div class="grid grid-cols-2 items-center text-sm text-gray-600">
                        <div class="grid grid-cols-2 justify-items-start mb-2 mr-6 md:text-md text-xs">
                            <div class="flex md:flex-col lg:flex-row flex-col justify-center items-center md:mr-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        stroke-width="1.5" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round"/>
                                </svg>
                                <span class="inline-flex items-center lg:flex-row flex-col">
                                    <?= $r['lantai'] ?>
                                </span>
                            </div>
                            <div class="flex md:flex-col lg:flex-row flex-col justify-center items-center">                            
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        stroke-width="1.5"  
                                        stroke-linecap="round" 
                                        stroke-linejoin="round"/>
                                </svg>
                                <span class="inline-flex items-center lg:flex-row flex-col"><?= $r['jumlah_minimal'] . '-' . $r['jumlah_maksimal']  ?> orang </span>
                            </div>                          
                        </div>
                        <a href="/Dashboard/Booking/<?= $r['id_ruangan'] ?>"
                            class="flex items-center justify-center w-full bg-[#1E68FB] text-white text-center rounded-xl font-semibold text-sm hover:bg-[#38C55C] transition duration-200 mr-2 p-3">
                            Booking Sekarang
                        </a>
                    </div>
                </div>
            </div>
                <?php endforeach ?>
        </div>
    </main>