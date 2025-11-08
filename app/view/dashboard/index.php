<?php Flasher::Flash() ?>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Ruangan Yang Bisa Dipinjam</h2>

        <!-- Capacity Filters -->
        <div class="flex justify-start mb-6 space-x-4 mx-5">
            <button onclick="filterRooms('all')" id="filter-all" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-full font-medium hover:bg-blue-700 transition duration-200 hover:cursor-pointer">
                Semua
            </button>
            <button onclick="filterRooms('2-4')" id="filter-2-4" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition duration-200 hover:cursor-pointer">
                2-4 Orang
            </button>
            <button onclick="filterRooms('4-8')" id="filter-4-8" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition duration-200 hover:cursor-pointer">
                4-8 Orang
            </button>
        </div>

        <!-- Rooms Grid -->
        <div id="rooms-container" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-10 mb-8 mx-5">
            <!-- Ruangan akan di-render oleh JavaScript -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div>

            

            <!-- <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                        alt="${room.name}" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold flex items-center text-white ${statusColor}">
                        <i class="fas ${statusIcon} mr-1 bg-blue-800"></i>open
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Ruang Lentera Edukasi</h3>
                    <p class="text-sm text-gray-600 mb-4">Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.</p>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt 2</span>
                        <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> 30m<sup>2</sup></span>
                        <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> 2-4 Orang</span>
                    </div>
                    <a href="../Booking Ruangan/index.php" 
                    class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2 rounded-xl font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                    Booking Sekarang
                    </a>
                </div>
            </div> -->

        </div>

        <!-- Floating Action Button -->
        <button class="fixed bottom-8 right-8 bg-blue-600 text-white w-14 h-14 rounded-full shadow-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
            <i class="fas fa-bell text-xl"></i>
        </button>
    </main>


    <script>
        let currentFilter = 'all';
        // Filter Function
        function filterRooms(filter) {
            currentFilter = filter;

            // Update tombol aktif
            document.querySelectorAll('#filter-all, #filter-2-4, #filter-4-8').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-800');
            });
            const activeBtn = filter === 'all' ? 'filter-all' : filter === '2-4' ? 'filter-2-4' : 'filter-4-8';
            document.getElementById(activeBtn).classList.remove('bg-gray-200', 'text-gray-800');
            document.getElementById(activeBtn).classList.add('bg-blue-600', 'text-white');

            renderRooms();
        }

        // Init
        renderRooms();


        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        hamburgerBtn.addEventListener('click', () => {
            // Mengganti (toggle) kelas 'hidden'. 
            // Jika menu tersembunyi, maka akan ditampilkan, begitu juga sebaliknya.
            mobileMenu.classList.toggle('hidden');
        });
    </script>