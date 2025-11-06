<?php Flasher::Flash() ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Dashboard</title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-building text-blue-600 text-2xl mr-2"></i>
                    <h1 class="text-xl font-bold text-gray-800">ruanginPNJ</h1>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                        Ruangan
                    </a>
                    <a href="../History/index.php" class="text-gray-600 hover:text-gray-800 font-medium">
                        History
                    </a>
                    <a href="../Akun/index.php" class="text-gray-600 hover:text-gray-800 font-medium">
                        Akun
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Ruangan Yang Bisa Dipinjam</h2>
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Halo <?=  $_SESSION['user_username']?></h2>

        <!-- Capacity Filters -->
        <div class="flex justify-start mb-6 space-x-4">
            <button onclick="filterRooms('all')" id="filter-all" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-full font-medium hover:bg-blue-700 transition duration-200">
                Semua
            </button>
            <button onclick="filterRooms('2-4')" id="filter-2-4" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition duration-200">
                2-4 Orang
            </button>
            <button onclick="filterRooms('4-8')" id="filter-4-8" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full font-medium hover:bg-gray-300 transition duration-200">
                4-8 Orang
            </button>
        </div>

        <!-- Rooms Grid -->
        <div id="rooms-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            <!-- Ruangan akan di-render oleh JavaScript -->
        </div>

        <!-- Floating Action Button -->
        <button class="fixed bottom-8 right-8 bg-blue-600 text-white w-14 h-14 rounded-full shadow-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
            <i class="fas fa-bell text-xl"></i>
        </button>
    </main>

    <!-- JavaScript -->
    <script>
        // === DATA RUANGAN ===
        const rooms = [
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '2 - 4 Orang', status: 'Open', floor: '2', area: '30m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '2 - 4 Orang', status: 'Open', floor: '2', area: '30m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '2 - 4 Orang', status: 'Closed', floor: '2', area: '30m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '4 - 8 Orang', status: 'Open', floor: '2', area: '100m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '4 - 8 Orang', status: 'Open', floor: '2', area: '100m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '4 - 8 Orang', status: 'Open', floor: '2', area: '100m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '2 - 4 Orang', status: 'Closed', floor: '2', area: '30m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '2 - 4 Orang', status: 'Open', floor: '2', area: '30m' },
            { name: 'Ruang Lentera Edukasi', desc: 'Temukan, pinjam, dan nikmati bacaan favoritmu dengan mudah.', capacity: '4 - 8 Orang', status: 'Closed', floor: '2', area: '100m' },
        ];

        let currentFilter = 'all';

        // Render Ruangan
        function renderRooms() {
            const container = document.getElementById('rooms-container');
            const filtered = currentFilter === 'all' 
                ? rooms 
                : rooms.filter(r => r.capacity.includes(currentFilter.replace('-', ' - ')));

            let html = '';
            if (filtered.length === 0) {
                html = `<div class="col-span-full text-center py-12 text-gray-500">Tidak ada ruangan yang sesuai filter.</div>`;
            } else {
                filtered.forEach(room => {
                    const statusColor = room.status === 'Open' ? 'bg-blue-600' : 'bg-red-600';
                    const statusIcon = room.status === 'Open' ? 'fa-check-circle' : 'fa-times-circle';
                    html += `
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="relative h-48 bg-gradient-to-br from-gray-300 to-gray-400">
                            <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                                 alt="${room.name}" class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold flex items-center text-white ${statusColor}">
                                <i class="fas ${statusIcon} mr-1"></i> ${room.status}
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">${room.name}</h3>
                            <p class="text-sm text-gray-600 mb-4">${room.desc}</p>
                            <hr class="border-t border-gray-300 mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-4">
                                <span class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-2"></i> Lt ${room.floor}</span>
                                <span class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-2"></i> ${room.area}<sup>2</sup></span>
                                <span class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2"></i> ${room.capacity}</span>
                            </div>
                            <a href="../Booking Ruangan/index.php" 
                               class="block w-full bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-2.5 rounded-full font-semibold hover:from-green-500 hover:to-green-600 transition duration-200">
                                Booking Sekarang
                            </a>
                        </div>
                    </div>`;
                });
            }
            container.innerHTML = html;
        }

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
    </script>
</body>
</html>     