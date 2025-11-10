<?php
// $pageTitle = "Booking Ruangan - ruanginPNJ";
// $showNav = true;
// $activePage = "ruangan";
// include '../Layout/Header.php';

// $roomId = isset($_GET['id']) ? $_GET['id'] : 'R001';
?>

<!-- Main Content -->
<main class="container mx-auto px-6 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-dark-overlay/60">
        <a href="/Dashboard" class="text-gray-900 hover:bg-[#1E68FB]">Ruangan</a>
        <span class="mx-2">></span>
        <span class="text-dark-overlay/60 font-medium hover:cursor-pointer">Booking Ruangan</span>
    </nav>

    <h2 class="text-3xl font-bold text-[#1A1A1A] mb-6">Booking Ruangan</h2>

    <div class="flex flex-col gap-8 lg:grid lg:grid-cols-3 lg:gap-8">
        <!-- Form Section -->
        <div class="order-2 lg:order-none lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <form id="bookingForm" onsubmit="return handleSubmit(event)">
                    <!-- Date & Total Jam -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <!-- <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>  -->
                                Tanggal Pinjam <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" id="tanggalPinjam" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                            <i class="fas fa-calendar absolute left-3 top-10 text-gray-400"></i>
                        </div>
                        <div class="flex items-end">
                            <div class="w-full">
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    <!-- <i class="fas fa-clock text-green-600 mr-2"></i>  -->
                                    Total Jam
                                </label>
                                <div id="totalTime" class="inline-flex items-center px-4 py-2 text-gray-800 font-bold rounded-full text-lg">
                                    <i class="fas fa-hourglass-half mr-2"></i> 
                                    0 Jam 0 Menit
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jam Mulai & Selesai -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <!-- <i class="fas fa-play-circle text-blue-600 mr-2"></i>  -->
                                Jam Mulai <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select id="jamMulai" required class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white appearance-none text-sm">
                                <option value="" disabled selected hidden>Pilih jam mulai</option>
                                <option>09:00</option><option>09:30</option><option>10:00</option><option>10:30</option>
                                <option>11:00</option><option>11:30</option><option>12:00</option><option>12:30</option>
                                <option>13:00</option><option>13:30</option><option>14:00</option><option>14:30</option>
                                <option>15:00</option><option>15:30</option><option>16:00</option>
                            </select>
                            <i class="fas fa-clock absolute left-3 top-10 text-gray-400"></i>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <!-- <i class="fas fa-stop-circle text-red-600 mr-2"></i>  -->
                                Jam Selesai <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select id="jamSelesai" required class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white appearance-none text-sm">
                                <option value="" disabled selected hidden>Pilih jam selesai</option>
                                <option>09:00</option><option>09:30</option><option>10:00</option><option>10:30</option>
                                <option>11:00</option><option>11:30</option><option>12:00</option><option>12:30</option>
                                <option>13:00</option><option>13:30</option><option>14:00</option><option>14:30</option>
                                <option>15:00</option><option>15:30</option><option>16:00</option>
                            </select>
                            <i class="fas fa-clock absolute left-3 top-10 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Anggota -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-users text-indigo-600 mr-2"></i> 
                            Daftar Anggota <span class="text-red-500 ml-1">*</span>
                            <span class="ml-2 text-xs text-gray-500 font-normal">(Minimal 2 orang)</span>
                        </label>
                        <div id="membersContainer" class="space-y-4">
                            <!-- Perwakilan -->
                            <div class="member-card p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-blue-600 text-white rounded-full text-xs font-bold">1</span>
                                    <span class="ml-2 font-medium text-sm text-blue-800">Penanggung Jawab</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <input type="text" placeholder="NIM Perwakilan *" required
                                           class="nim-input w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                    <input type="text" placeholder="Nama Lengkap Perwakilan" readonly
                                           class="nama-input w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                </div>
                            </div>
                            <!-- Anggota 1 -->
                            <div class="member-card p-4 bg-gray-50 rounded-xl border border-gray-300">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-600 text-white rounded-full text-xs font-bold">2</span>
                                        <span class="ml-2 font-medium text-sm text-gray-800">Anggota</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <input type="text" placeholder="NIM Anggota *" required
                                           class="nim-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                    <input type="text" placeholder="Nama Lengkap Anggota" readonly
                                           class="nama-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Tambah -->
                        <button type="button" onclick="addMember()" 
                                class="mt-4 flex items-center text-blue-600 hover:text-blue-800 hover:cursor-pointer text-sm font-medium transition">
                            <i class="fas fa-plus mr-1"></i> Tambah Anggota
                        </button>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" class="hidden mb-6 p-4 bg-red-50 border border-red-300 text-red-700 rounded-xl flex items-start text-sm">
                        <i class="fas fa-exclamation-triangle mt-0.5 mr-2"></i>
                        <span></span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3 hover:cursor-pointer bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl hover:from-green-600 hover:to-emerald-700 transition shadow-lg text-base">
                        <!-- <i class="fas fa-check-circle mr-2"></i>  -->
                        Booking Ruangan Ini
                    </button>
                </form>
            </div>
        </div>

        <!-- Room Preview -->
        <div class="order-1 lg:order-none lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-24">
                <div class="h-56">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=600" 
                         alt="Ruangan" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-2xl text-gray-800 mb-4">Ruang Lentera Edukasi</h3>
                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <p class="flex items-center"><i class="fas fa-layer-group text-blue-600 mr-3"></i> Lantai 2</p>
                        <p class="flex items-center"><i class="fas fa-vector-square text-green-600 mr-3"></i> 30m²</p>
                        <p class="flex items-center"><i class="fas fa-users text-indigo-600 mr-3"></i> 4 - 8 Orang</p>
                    </div>
                    <details class="text-gray-600">
                        <summary class="text-base font-semibold cursor-pointer text-blue-600 hover:text-blue-800 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i> Deskripsi Lengkap
                        </summary>
                        <p class="mt-3 text-sm leading-relaxed">
                            Ruang Lentera Edukasi adalah ruangan modern yang dirancang untuk mendukung kegiatan pembelajaran dan diskusi kelompok.
                        </p>
                    </details>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Konfirmasi Booking -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center">
        <div class="mb-4">
            <i class="fas fa-calendar-check text-green-500 text-5xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Booking</h3>
        <p class="text-sm text-gray-600 mb-6">Data anggota akan tersimpan untuk selamanya dan tidak bisa diubah.</p>
        <div class="grid grid-cols-2 gap-3">
            <button onclick="closeConfirmModal()" 
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                Batalkan
            </button>
            <button onclick="confirmBooking()" 
                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-600 hover:to-emerald-700 transition">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<!-- Modal Success -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center">
        <div class="mb-4">
            <i class="fas fa-check-circle text-green-500 text-5xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Request Booking Berhasil</h3>
        <p class="text-sm text-gray-600 mb-6">Tunggu approval dari admin</p>
        <button onclick="closeSuccessModal()" 
                class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-600 hover:to-emerald-700 transition">
            OK
        </button>
    </div>
</div>

<script>
    // Calculate total time
    function calculateTotal() {
        const start = document.getElementById('jamMulai').value;
        const end = document.getElementById('jamSelesai').value;
        const totalEl = document.getElementById('totalTime');
        if (!start || !end) {
            totalEl.innerHTML = '<i class="fas fa-hourglass-half mr-2 text-gray-500"></i> 0 Jam 0 Menit';
            return;
        }
        const [sh, sm] = start.split(':').map(Number);
        const [eh, em] = end.split(':').map(Number);
        let diff = (eh * 60 + em) - (sh * 60 + sm);
        if (diff <= 0) {
            totalEl.innerHTML = '<i class="fas fa-hourglass-half mr-2 text-gray-500"></i> 0 Jam 0 Menit';
            return;
        }
        const hours = Math.floor(diff / 60);
        const minutes = diff % 60;
        totalEl.innerHTML = `<i class="fas fa-hourglass-half mr-2 text-gray-500"></i> ${hours} Jam ${minutes} Menit`;
    }

    // Add member
    let memberCount = 2;
    function addMember() {
        memberCount++;
        const container = document.getElementById('membersContainer');
        const newCard = document.createElement('div');
        newCard.className = 'member-card p-4 bg-gray-50 rounded-xl border border-gray-300';
        newCard.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-600 text-white rounded-full text-xs font-bold">${memberCount}</span>
                    <span class="ml-2 font-medium text-sm text-gray-800">Anggota</span>
                </div>
                <button type="button" onclick="removeMember(this)" class="text-red-600 hover:text-red-800 transition">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input type="text" placeholder="NIM Anggota" class="nim-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                <input type="text" placeholder="Nama Lengkap Anggota" readonly class="nama-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
            </div>
        `;
        container.appendChild(newCard);
    }

    // Remove member
    function removeMember(button) {
        const cards = document.querySelectorAll('.member-card');
        if (cards.length <= 2) {
            showError('Minimal harus ada 2 orang (perwakilan + 1 anggota).');
            return;
        }
        button.closest('.member-card').remove();
        document.querySelectorAll('.member-card').forEach((card, i) => {
            card.querySelector('span.rounded-full').textContent = i + 1;
        });
        memberCount = document.querySelectorAll('.member-card').length;
    }

    // Show error
    function showError(msg) {
        const errorDiv = document.getElementById('errorMessage');
        errorDiv.querySelector('span').textContent = msg;
        errorDiv.classList.remove('hidden');
        setTimeout(() => errorDiv.classList.add('hidden'), 5000);
    }

    // Handle submit
    function handleSubmit(e) {
        e.preventDefault();
        
        const tanggal = document.getElementById('tanggalPinjam').value;
        const jamMulai = document.getElementById('jamMulai').value;
        const jamSelesai = document.getElementById('jamSelesai').value;
        const rows = document.querySelectorAll('.member-card');

        if (!tanggal || !jamMulai || !jamSelesai) {
            showError('Tanggal dan jam harus diisi.');
            return false;
        }
        if (jamMulai >= jamSelesai) {
            showError('Jam selesai harus lebih lambat dari jam mulai.');
            return false;
        }
        if (rows.length < 2) {
            showError('Minimal harus ada 2 orang.');
            return false;
        }

        // Check all fields filled
        let allFilled = true;
        rows.forEach(row => {
            const nim = row.querySelector('.nim-input').value.trim();
            const nama = row.querySelector('.nama-input').value.trim();
            if (!nim || !nama) allFilled = false;
        });
        
        if (!allFilled) {
            showError('Semua NIM dan Nama Anggota harus diisi.');
            return false;
        }

        // Show confirmation modal
        document.getElementById('confirmModal').classList.remove('hidden');
        return false;
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function confirmBooking() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('successModal').classList.remove('hidden');
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
        window.location.href = '../Ruangan/index.php';
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        const jamSelects = document.querySelectorAll('#jamMulai, #jamSelesai');
        jamSelects.forEach(select => select.addEventListener('change', calculateTotal));
        calculateTotal();   
    });
</script>