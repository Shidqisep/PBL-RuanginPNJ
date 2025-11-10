<?php
// $pageTitle = "History - ruanginPNJ";
// $showNav = true;
// $activePage = "history";
// include '../../includes/header.php';
?>

<!-- Main Content -->
<main class="container mx-auto px-4 sm:px-6 py-6 sm:py-8 flex-1">
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-10 left-align">History Peminjaman</h2>

    <!-- Time Filters -->
    <div class="flex flex-wrap gap-3 left-align mb-6">
    <button onclick="filterTime('all')" id="filter-all" 
        class="filter-btn px-6 py-2.5 rounded-full font-medium text-sm transition-all duration-200
           shadow-sm bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700">Semua</button>
    <button onclick="filterTime('thisMonth')" id="filter-thisMonth" 
        class="filter-btn px-6 py-2.5 rounded-full font-medium text-sm transition-all duration-200
           shadow-sm bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800 hover:from-gray-300 hover:to-gray-400">Bulan Ini</button>
    <button onclick="filterTime('last3Months')" id="filter-last3Months" 
        class="filter-btn px-6 py-2.5 rounded-full font-medium text-sm transition-all duration-200
           shadow-sm bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800 hover:from-gray-300 hover:to-gray-400">3 Bulan Terakhir</button>
    </div>

    <!-- Lihat Bookingan Anda -->
    <div class="flex justify-end mb-6">
        <a href="bookingan.php" class="text-blue-600 font-medium flex items-center text-sm transition px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700">
            Lihat Bookingan Anda <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <!-- Table Content -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 sm:p-6">
            <!-- Desktop Table -->
            <div id="desktop-table" class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">No.</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">ID Ruangan</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Ruangan</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Jam</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Orang</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="desktop-tbody" class="divide-y divide-gray-200">
                        <!-- JS isi -->
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div id="mobile-cards" class="block md:hidden space-y-5">
                <!-- JS isi -->
            </div>

            <!-- Pagination -->
            <div id="pagination" class="mt-8 flex justify-center space-x-2"></div>
        </div>
    </div>
</main>

<!-- Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden px-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
        <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Bagaimana pengalamanmu?</h3>
        <p class="text-sm text-gray-600 mb-6 text-center">Bantu kami dengan memberikan feedback</p>
        
        <div class="flex justify-center gap-4 mb-6">
            <button onclick="selectEmoji(1)" class="emoji-btn hover:scale-110 transition p-1">
                <div class="text-4xl w-9 h-9 flex items-center justify-center">😢</div>
                <p class="text-[10px] mt-0.5">Buruk</p>
            </button>
            <button onclick="selectEmoji(2)" class="emoji-btn hover:scale-110 transition p-1">
                <div class="text-4xl w-9 h-9 flex items-center justify-center">🙁</div>
                <p class="text-[10px] mt-0.5">Kurang</p>
            </button>
            <button onclick="selectEmoji(3)" class="emoji-btn hover:scale-110 transition p-1">
                <div class="text-4xl w-9 h-9 flex items-center justify-center">😐</div>
                <p class="text-[10px] mt-0.5">Biasa</p>
            </button>
            <button onclick="selectEmoji(4)" class="emoji-btn hover:scale-110 transition p-1">
                <div class="text-4xl w-9 h-9 flex items-center justify-center">🙂</div>
                <p class="text-[10px] mt-0.5">Bagus</p>
            </button>
            <button onclick="selectEmoji(5)" class="emoji-btn hover:scale-110 transition p-1">
                <div class="text-4xl w-9 h-9 flex items-center justify-center">😍</div>
                <p class="text-[10px] mt-0.5">Luar Biasa</p>
            </button>
        </div>

        <textarea id="feedbackComment" placeholder="Tulis komentar (opsional)" 
                  class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-5 resize-none" 
                  rows="3"></textarea>

        <div class="grid grid-cols-2 gap-3">
            <button onclick="closeFeedbackModal()" class="px-4 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800 rounded-lg font-medium hover:from-gray-300 hover:to-gray-400 transition">Batal</button>
            <button onclick="submitFeedback()" class="px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-medium hover:from-green-600 hover:to-emerald-700 transition shadow-sm">Kirim</button>
        </div>
    </div>
</div>

<script>
    // DATA FIX + LABEL STATUS LENGKAP
    const historyData = [
        { roomId: "R001", roomName: "Ruang Lentera Edukasi", date: "8 November 2025", time: "09:00 - 11:00", people: "4 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R003", roomName: "Ruang Inovasi Teknologi", date: "5 November 2025", time: "13:00 - 15:00", people: "6 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R002", roomName: "Ruang Kreasi Digital", date: "1 November 2025", time: "10:00 - 12:00", people: "3 Orang", status: "Telat", badge: "bg-yellow-100 text-yellow-800", icon: "fa-exclamation-triangle", label: "Telat" },
        { roomId: "R007", roomName: "Ruang Meeting Eksekutif", date: "28 Oktober 2025", time: "14:00 - 16:00", people: "8 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R005", roomName: "Ruang Diskusi Mahasiswa", date: "25 Oktober 2025", time: "11:00 - 13:00", people: "2 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R009", roomName: "Ruang Seminar Mini", date: "20 Oktober 2025", time: "09:00 - 10:30", people: "4 Orang", status: "Telat", badge: "bg-yellow-100 text-yellow-800", icon: "fa-exclamation-triangle", label: "Telat" },
        { roomId: "R004", roomName: "Ruang Kolaborasi Bisnis", date: "15 Oktober 2025", time: "13:00 - 15:00", people: "7 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R006", roomName: "Ruang Belajar Interaktif", date: "10 Oktober 2025", time: "10:00 - 12:00", people: "5 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R008", roomName: "Ruang Workshop Kreatif", date: "5 Oktober 2025", time: "14:00 - 16:00", people: "8 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R001", roomName: "Ruang Lentera Edukasi", date: "1 Oktober 2025", time: "09:00 - 11:00", people: "4 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R003", roomName: "Ruang Inovasi Teknologi", date: "28 September 2025", time: "13:00 - 15:00", people: "6 Orang", status: "Finished", badge: "bg-gray-100 text-gray-800", icon: "fa-check-circle", label: "Selesai" },
        { roomId: "R005", roomName: "Ruang Diskusi Mahasiswa", date: "20 September 2025", time: "10:00 - 12:00", people: "3 Orang", status: "Telat", badge: "bg-yellow-100 text-yellow-800", icon: "fa-exclamation-triangle", label: "Telat" }
    ];

    let currentTimeFilter = 'all';
    let desktopPage = 1, mobilePage = 1;

    function filterTime(filter) {
        currentTimeFilter = filter;
        document.querySelectorAll('.filter-btn').forEach(btn => {
            const isActive = btn.id === `filter-${filter}`;
            if (isActive) {
                btn.classList.remove('bg-gradient-to-r', 'from-gray-200', 'to-gray-300', 'text-gray-800', 'hover:from-gray-300', 'hover:to-gray-400');
                btn.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'hover:from-blue-600', 'hover:to-blue-700');
            } else {
                btn.classList.remove('bg-gradient-to-r', 'from-gray-200', 'to-gray-300', 'text-white', 'hover:from-gray-300', 'hover:to-gray-400');
                btn.classList.add('bg-gradient-to-r', 'from-gray-200', 'to-gray-300', 'text-gray-800', 'hover:from-gray-300', 'hover:to-gray-400');
            }
        });
        desktopPage = mobilePage = 1;
        renderData();
    }

    function renderData() {
        const filtered = historyData.filter(item => {
            const [day, monthName, year] = item.date.split(' ');
            const months = { 'Januari':0, 'Februari':1, 'Maret':2, 'April':3, 'Mei':4, 'Juni':5, 'Juli':6, 'Agustus':7, 'September':8, 'Oktober':9, 'November':10, 'Desember':11 };
            const date = new Date(year, months[monthName], day);
            const now = new Date();
            if (currentTimeFilter === 'thisMonth') return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear();
            if (currentTimeFilter === 'last3Months') {
                const threeMonthsAgo = new Date(); threeMonthsAgo.setMonth(threeMonthsAgo.getMonth() - 3);
                return date >= threeMonthsAgo;
            }
            return true;
        });

        const desktopData = filtered.slice((desktopPage-1)*10, desktopPage*10);
        const mobileData = filtered.slice((mobilePage-1)*5, mobilePage*5);

        renderDesktopTable(desktopData);
        renderMobileCards(mobileData);
        renderPagination(filtered.length);
    }

    function renderDesktopTable(data) {
        const tbody = document.getElementById('desktop-tbody');
        tbody.innerHTML = data.length === 0 
            ? '<tr><td colspan="8" class="text-center py-12 text-gray-500 text-sm">Tidak ada riwayat peminjaman</td></tr>'
            : data.map((item, i) => `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-sm">${(desktopPage-1)*10 + i + 1}</td>
                    <td class="px-4 py-3 text-sm font-medium">${item.roomId}</td>
                    <td class="px-4 py-3 text-sm">${item.date}</td>
                    <td class="px-4 py-3 text-sm">${item.roomName}</td>
                    <td class="px-4 py-3 text-sm">${item.time}</td>
                    <td class="px-4 py-3 text-sm">${item.people}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold ${item.badge} shadow-sm">
                            <i class="fas ${item.icon} mr-1.5"></i> ${item.label}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <button onclick="openFeedbackModal()" 
                                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-lg text-xs font-medium hover:from-blue-600 hover:to-blue-700 transition shadow-md transform hover:scale-105">
                            Beri Feedback
                        </button>
                    </td>
                </tr>`).join('');
    }

    function renderMobileCards(data) {
        const container = document.getElementById('mobile-cards');
        container.innerHTML = data.length === 0 
            ? '<div class="text-center py-12 text-gray-500 text-sm">Tidak ada riwayat peminjaman</div>'
            : data.map(item => `
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-gray-500 font-medium">ID: ${item.roomId}</p>
                            <h3 class="font-bold text-base text-gray-800 mt-1 line-clamp-2">${item.roomName}</h3>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold ${item.badge} flex items-center shadow-sm">
                            <i class="fas ${item.icon} mr-1.5"></i>
                            ${item.label}
                        </span>
                    </div>
                    <div class="space-y-2.5 text-sm text-gray-600 mb-6">
                        <p class="flex items-center"><i class="fas fa-calendar-alt text-blue-600 mr-2 text-xs"></i> ${item.date}</p>
                        <p class="flex items-center"><i class="fas fa-clock text-green-600 mr-2 text-xs"></i> ${item.time}</p>
                        <p class="flex items-center"><i class="fas fa-users text-indigo-600 mr-2 text-xs"></i> ${item.people}</p>
                    </div>
                    <button onclick="openFeedbackModal()" 
                            class="block w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center py-3.5 rounded-xl font-semibold text-sm hover:from-blue-600 hover:to-blue-700 transition shadow-lg transform hover:scale-[1.02] active:scale-95">
                        Beri Feedback
                    </button>
                </div>`).join('');
    }

    function renderPagination(total) {
        const deskPages = Math.ceil(total / 10);
        const mobPages = Math.ceil(total / 5);
        const el = document.getElementById('pagination');
        el.innerHTML = `
            <div class="hidden md:flex space-x-2">${deskPages > 1 ? Array.from({length: deskPages}, (_,i) => 
                `<button onclick="desktopPage=${i+1};renderData()" class="px-4 py-2 rounded-lg text-sm font-medium ${i+1===desktopPage?'bg-blue-600 text-white':'bg-gray-200 hover:bg-gray-300'} transition">${i+1}</button>`).join('') : ''}</div>
            <div class="flex md:hidden space-x-2">${mobPages > 1 ? Array.from({length: mobPages}, (_,i) => 
                `<button onclick="mobilePage=${i+1};renderData()" class="px-4 py-2 rounded-lg text-sm font-medium ${i+1===mobilePage?'bg-blue-600 text-white':'bg-gray-200 hover:bg-gray-300'} transition">${i+1}</button>`).join('') : ''}</div>`;
    }

    // Feedback Modal
    let selectedEmojiRating = 0;
    function openFeedbackModal() { 
        document.getElementById('feedbackModal').classList.remove('hidden'); 
    }
    function closeFeedbackModal() { 
        document.getElementById('feedbackModal').classList.add('hidden'); 
        selectedEmojiRating = 0; 
        document.getElementById('feedbackComment').value = '';
        document.querySelectorAll('.emoji-btn').forEach(b => b.classList.remove('scale-125', 'opacity-100'));
    }
    function selectEmoji(r) {
        selectedEmojiRating = r;
        document.querySelectorAll('.emoji-btn').forEach((b, i) => {
            b.classList.toggle('scale-125', i+1 === r);
            b.classList.toggle('opacity-100', i+1 === r);
            b.classList.toggle('opacity-60', i+1 !== r);
        });
    }
    function submitFeedback() {
        if (!selectedEmojiRating) return alert('Pilih rating dulu ya!');
        alert(`Terima kasih atas feedback-nya! Rating: ${selectedEmojiRating}/5`);
        closeFeedbackModal();
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => {
        renderData();
    });
</script>