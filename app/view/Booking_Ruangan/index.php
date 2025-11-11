<?php
$formAction = '/Booking/handleBooking'; 
?>

<main class="container mx-auto px-6 py-8">
    <nav class="mb-6 text-sm text-dark-overlay/60">
        <a href="/Dashboard" class="text-gray-900 hover:text-[#1E68FB]">Ruangan</a>
        <span class="mx-2">></span>
        <span class="text-dark-overlay/60 font-medium hover:cursor-pointer">Booking Ruangan</span>
    </nav>

    <h2 class="text-3xl font-bold text-[#1A1A1A] mb-6">Booking Ruangan</h2>

    <div class="flex flex-col gap-8 lg:grid lg:grid-cols-3 lg:gap-8">
        <div class="order-2 lg:order-none lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <form id="bookingForm" action="<?php echo $formAction; ?>" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Tanggal Pinjam <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" id="tanggalPinjam" name="tanggalPinjam" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                            <i class="fas fa-calendar absolute left-3 top-10 text-gray-400"></i>
                        </div>
                        <div class="flex items-end">
                            <div class="w-full">
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    Total Jam
                                </label>
                                <div id="totalTime" class="inline-flex items-center px-4 py-2 text-gray-800 font-bold rounded-full text-lg">
                                    <i class="fas fa-hourglass-half mr-2 text-gray-500"></i> 
                                    0 Jam 0 Menit
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Jam Mulai <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select id="jamMulai" name="jamMulai" required class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white appearance-none text-sm">
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
                                Jam Selesai <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select id="jamSelesai" name="jamSelesai" required class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white appearance-none text-sm">
                                <option value="" disabled selected hidden>Pilih jam selesai</option>
                                <option>09:00</option><option>09:30</option><option>10:00</option><option>10:30</option>
                                <option>11:00</option><option>11:30</option><option>12:00</option><option>12:30</option>
                                <option>13:00</option><option>13:30</option><option>14:00</option><option>14:30</option>
                                <option>15:00</option><option>15:30</option><option>16:00</option>
                            </select>
                            <i class="fas fa-clock absolute left-3 top-10 text-gray-400"></i>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-4 flex items-center">
                            Daftar Anggota <span class="text-red-500 ml-1">*</span>
                            <span class="ml-2 text-xs text-gray-500 font-normal">(Minimal 2 orang)</span>
                        </label>
                        <div id="membersContainer" class="space-y-4">
                            <div class="member-card p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-blue-600 text-white rounded-full text-xs font-bold">1</span>
                                    <span class="ml-2 font-medium text-sm text-blue-800">Penanggung Jawab</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <input type="text" maxlength="10" max="10" placeholder="NIM/NIP Perwakilan *" name="nim[]" required
                                        class="nim-input w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                    <input type="text" placeholder="Nama Lengkap Perwakilan" name="nama[]" readonly
                                        class="nama-input w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                </div>
                            </div>
                            <div class="member-card p-4 bg-gray-50 rounded-xl border border-gray-300">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-600 text-white rounded-full text-xs font-bold">2</span>
                                        <span class="ml-2 font-medium text-sm text-gray-800">Anggota</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <input type="text" maxlength="10" placeholder="NIM/NIP Anggota *" name="nim[]" required
                                        class="nim-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                    <input type="text" placeholder="Nama Lengkap Anggota" name="nama[]" readonly
                                        class="nama-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                class="mt-4 flex items-center text-blue-600 hover:text-blue-800 hover:cursor-pointer text-sm font-medium transition">
                            <i class="fas fa-plus mr-1"></i> Tambah Anggota
                        </button>
                    </div>

                    <div id="errorMessage" class="hidden mb-6 p-4 bg-red-50 border border-red-300 text-red-700 rounded-xl flex items-start text-sm">
                        <i class="fas fa-exclamation-triangle mt-0.5 mr-2"></i>
                        <span></span>
                    </div>

                    <button type="button"
                            class="w-full py-3 hover:cursor-pointer bg-[#38C55C] text-white font-bold rounded-xl hover:bg-emerald-600 transition shadow-sm text-base">
                        Booking Ruangan Ini
                    </button>
                </form>
            </div>
        </div>

        <div class="order-1 lg:order-none lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-24">
                <div class="h-56">
                    <img src="/img/DefaultRuangan.jpg" 
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
                            <i class="fas fa-chevron-down text-sm ml-1 transform details-arrow-icon transition duration-300"></i>
                        </summary>
                        <p class="mt-3 text-sm leading-relaxed text-justify">
                            Ruang Lentera Edukasi adalah ruangan modern yang dirancang untuk mendukung kegiatan pembelajaran dan diskusi kelompok.
                        </p>
                    </details>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- **************************************************
INI POP UP KONFIRMASI
******************************************************* -->
<div id="confirmModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center">
        <div class="mb-4">
            <i class="fas fa-calendar-check text-green-500 text-5xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Booking</h3>
        <p class="text-sm text-gray-600 mb-6">Data anggota akan tersimpan untuk selamanya dan tidak bisa diubah.</p>
        <div class="grid grid-cols-2 gap-3">
            <button type="button"
                    class="px-6 py-2 bg-white text-[#171E29] rounded-lg border font-semibold hover:bg-gray-300 transition hover:cursor-pointer text-sm">
                Batalkan
            </button>
            <button type="button" 
                    class="px-6 py-2 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer text-sm">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<!-- **************************************************
INI POP UP SUCCESS
******************************************************* -->
<div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
        <div class="mb-4">
            <i class="fas fa-check-circle text-green-500 text-5xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Request Booking Berhasil</h3>
        <p class="text-sm text-gray-600 mb-6">Tunggu approval dari admin</p>
        <button
                class="w-full px-6 py-2 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer">
            OK
        </button>
    </div>
</div>


<!-- **************************************************
JS DIGUNAKAN UNTUK MENAMBAH & MENGHAPUS MEMBER
******************************************************* -->
<script>
    // Add member (WAJIB JS)
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
                <input type="text" maxlength="10" placeholder="NIM/NIP Anggota" name="nim[]" class="nim-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                <input type="text" placeholder="Nama Lengkap Anggota" name="nama[]" readonly class="nama-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
            </div>
        `;
        container.appendChild(newCard);
    }

    // Remove member (WAJIB JS)
    function removeMember(button) {
        const cards = document.querySelectorAll('.member-card');
        if (cards.length <= 2) {
            // Mengganti showError() dengan alert sederhana
            alert('Minimal harus ada 2 orang (perwakilan + 1 anggota).');
            return;
        }
        button.closest('.member-card').remove();
        document.querySelectorAll('.member-card').forEach((card, i) => {
            card.querySelector('span.rounded-full').textContent = i + 1;
        });
        memberCount = document.querySelectorAll('.member-card').length;
    }
</script>