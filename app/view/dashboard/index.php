<?php Flasher::Flash();

echo $_SESSION['user_id'];

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
        <div id="rooms-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:gap-6 mb-8 mx-5 md:gap-3 gap-3">
            <!-- **************************************************
            INI UNTUK CARD RUANGAN
            ******************************************************* -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="/img/DefaultRuangan.jpg" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-[#1A1A1A] mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-dark-overlay/80 mb-4 text-justify text-sm">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m&sup2</span>
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="/booking" 
                    class="block w-full bg-[#1E68FB] text-white text-center py-2 rounded-xl font-semibold text-sm hover:bg-[#38C55C] transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>






            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="/img/DefaultRuangan.jpg" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-[#1A1A1A] mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-dark-overlay/80 mb-4 text-justify text-sm">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m&sup2</span>
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="/booking" 
                    class="block w-full bg-[#1E68FB] text-white text-center py-2 rounded-xl font-semibold text-sm hover:bg-[#38C55C] transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="/img/DefaultRuangan.jpg" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-[#1A1A1A] mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-dark-overlay/80 mb-4 text-justify text-sm">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m&sup2</span>
                        <span class="inline-flex items-center lg:flex-row flex-col"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="/booking" 
                    class="block w-full bg-[#1E68FB] text-white text-center py-2 rounded-xl font-semibold text-sm hover:bg-[#38C55C] transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

        </div>
    </main>