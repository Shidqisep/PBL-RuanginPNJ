<?php
?>
<main class="container mx-auto md:px-6 lg:px-6 px-1 py-8">
    <div class="mx-5">
        <nav class="mb-6 text-sm text-dark-overlay6 flex items-center">
            <a href="/Booking" class="text-blue-overlay hover:text-blue-700">Bookingan Anda</a>
            <span class="mx-2">
                <div>
                    <?= icon('arrowRight', 'w-5 h-5') ?>
                </div>
            </span>
            <span class="text-dark-overlay6 font-medium hover:cursor-pointer">Reschedule</span>
        </nav>

        <h2 class="text-3xl font-bold text-black3 mb-6">Reschedule</h2>

        <div class="flex flex-col gap-8 lg:grid lg:grid-cols-3 lg:gap-8">
            <div class="order-2 lg:order-0 lg:col-span-2">
                <div class="bg-background2 rounded-2xl shadow-lg p-6 md:p-8">

                    <form id="rescheduleForm" action="<?= BASEURL ?>Booking/handleReschedule" method="POST">
                        <input type="hidden" id="id_room" name="id_room" value="<?= $detailRuangan['id_room'] ?>">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="relative">
                                <label class="block text-sm font-semibold text-dark-overlay7 mb-2 flex items-center">
                                    Tanggal Pinjam
                                </label>
                                <input type="date" id="tanggalPinjam" name="tanggalBaru" required
                                    class="w-full p-4 py-2 border border-dark-overlay4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                            </div>
                            <div class="flex items-end">
                                <div class="w-full">
                                    <label class="block text-sm font-semibold text-dark-overlay7 mb-2 flex items-center">
                                        Total Jam
                                    </label>
                                    <div id="totalTime" class="inline-flex items-center py-2 text-dark-overlay font-bold rounded-full text-xl">
                                        0 Jam 0 Menit
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="relative">
                                <label class="block text-sm font-semibold text-dark-overlay7 mb-2 flex items-center">
                                    Jam Mulai
                                </label>
                                <select id="jamMulai" name="jamMulai" disabled required class="w-full p-4 py-2 border border-dark-overlay4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white appearance-none text-sm">
                                    <option value="" disabled selected hidden>Pilih jam mulai</option>
                                </select>
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-semibold text-dark-overlay7 mb-2 flex items-center">
                                    Jam Selesai
                                </label>
                                <select id="jamSelesai" name="jamSelesai" disabled required class="w-full p-4 py-2 border border-dark-overlay4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white appearance-none text-sm">
                                    <option value="" disabled selected hidden>Pilih jam selesai</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-dark-overlay7 mb-4 flex items-center">
                                Daftar Anggota
                                <span class="ml-2 text-xs text-dark-overlay5 font-normal">(Minimal <?=  $detailRuangan['min_capacity']?> orang)</span>
                            </label>
                            <div id="membersContainer" class="space-y-4">
                                <div class="member-card p-4 bg-blue-overlay1 rounded-xl border border-dark-overlay4">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-blue-overlay text-white rounded-full text-xs font-bold">1</span>
                                        <span class="ml-2 font-medium text-sm text-blue-overlay">Penanggung Jawab</span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <input type="text" maxlength="10" max="10" placeholder="<?= $user['nomor_induk'] ?>" name="nim[]" value="<?= $user['nomor_induk'] ?>" readonly
                                            class="nim-input w-full px-4 py-2.5 border border-dark-overlay4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                        <input type="text" placeholder="<?= $user['username'] ?>" name="nama[]" readonly
                                            class="nama-input w-full px-4 py-2.5 border border-dark-overlay4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                    </div>
                                </div>
                                <?php $i = 0 ?>
                                <?php foreach($members as $member) :?>
                                <div class="member-card p-4 bg-background1 rounded-xl border border-dark-overlay4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center justify-center w-7 h-7 bg-dark-overlay7 text-white rounded-full text-xs font-bold"><?= $i + 2?></span>
                                            <span class="ml-2 font-medium text-sm text-dark-overlay7">Anggota</span>
                                        </div>
                                        <button type="button" onclick="removeMember(this)" class="text-red1 hover:text-red-800 transition hover:cursor-pointer">
                                            <div>
                                                <?= icon('trash', 'w-6 h-6') ?>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <input type="text" maxlength="10" placeholder="NIM/NIP Anggota *" name="nim[]" value="<?= $member['nomor_induk'] ?>" required
                                            class="nim-input w-full px-4 py-2.5 border border-dark-overlay4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                        <input type="text" placeholder="<?= $member['username'] ?>" name="nama[]" readonly
                                            class="nama-input w-full px-4 py-2.5 border border-dark-overlay4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm">
                                    </div>
                                </div>
                                <?php $i++ ?>
                                <?php endforeach ?>
                            </div>
                            <button type="button" id="addMember" onclick="addMember()"
                                    class="rounded-md mt-4 flex items-center bg-blue-overlay1 text-blue-overlay hover:text-blue-700 hover:bg-blue-overlay2 hover:cursor-pointer text-sm font-medium transition px-4 py-1">
                                Tambah Anggota
                                <div class="ml-2 font-semibold">
                                    <?= icon('plus', 'w-4 h-4') ?>
                                </div>
                            </button>
                        </div>

                        <div id="errorMessage" class="hidden mb-6 p-4 bg-red-50 border border-red-300 text-red1 rounded-xl flex items-start text-sm">
                            <div>
                                <?= icon('warning', 'w-16 h-16') ?>
                            </div>
                            <span></span>
                        </div>
                        

                        <button type="submit"
                                class="w-full py-3 hover:cursor-pointer bg-green1 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-sm text-base">
                                <input type="hidden" value="<?= $detailRuangan['id_booking'] ?>" name="id_booking" >
                            Reschedule
                        </button>
                    </form>
                </div>
            </div>

            <div class="order-1 lg:order-0 lg:col-span-1 space-y-6 lg:sticky">
        
                <!-- KARTU RUANGAN (TIDAK STICKY) -->
                <div class="bg-background2 rounded-2xl shadow-lg overflow-hidden">
                    <?php 
                        // Ambil URL gambar dari array PHP
                        $imageUrl = "/img/" . $detailRuangan['img_room'];
                    ?>

                    <div class="h-56 relative overflow-hidden bg-dark-overlay2" 
                        style="background-image: url('<?= htmlspecialchars($imageUrl) ?>'); 
                                background-size: cover; 
                                background-position: center;">
                        <!-- Overlay Rating (mirip gambar) -->
                        <div class="absolute bottom-2 left-2 flex items-center gap-3 px-5 py-1
                                        bg-dark-overlay5
                                        rounded-lg border border-dark-overlay1
                                        animate-in fade-in slide-in-from-bottom duration-500">
                            
                            <!-- Bintang -->
                            <div class="flex items-center gap-1">
                                <svg class="w-7 h-7 text-yellow1 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l2.4 7.3h7.7l-6.2 4.5 2.4 7.3-6.3-4.5-6.3 4.5 2.4-7.3-6.2-4.5h7.7z"/>
                                </svg>
                                <svg class="w-7 h-7 text-yellow1 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l2.4 7.3h7.7l-6.2 4.5 2.4 7.3-6.3-4.5-6.3 4.5 2.4-7.3-6.2-4.5h7.7z"/>
                                </svg>
                                <svg class="w-7 h-7 text-yellow1 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l2.4 7.3h7.7l-6.2 4.5 2.4 7.3-6.3-4.5-6.3 4.5 2.4-7.3-6.2-4.5h7.7z"/>
                                </svg>
                                <svg class="w-7 h-7 text-yellow1 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l2.4 7.3h7.7l-6.2 4.5 2.4 7.3-6.3-4.5-6.3 4.5 2.4-7.3-6.2-4.5h7.7z"/>
                                </svg>
                                <svg class="w-7 h-7 text-background2 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l2.4 7.3h7.7l-6.2 4.5 2.4 7.3-6.3-4.5-6.3 4.5 2.4-7.3-6.2-4.5h7.7z"/>
                                </svg>
                            </div>

                            <!-- Teks rating -->
                            <div class="text-background2">
                                <span class="text-xl font-bold">4/5</span>
                                <span class="text-sm font-medium text-background2 ml-2">(67 Respon)</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="font-bold text-2xl text-dark-overlay mb-4"><?= $detailRuangan['room_name'] ?></h3>
                        <div class="space-y-3 text-sm text-black3 mb-6">
                            <p class="flex items-center">
                                <div class="flex items-center gap-2 text-black2">
                                    <?= icon('location', 'w-5 h-5') ?> 
                                    lantai <?= $detailRuangan['floor'] ?>       
                                </div>          
                            </p>
    
                            <p class="flex items-center">
                                <div class="flex items-center gap-2 text-black2">
                                <?= icon('userOutline', 'w-5 h-5') ?> 
                                <?= $detailRuangan['min_capacity'] . ' - ' . $detailRuangan['max_capacity'] ?> orang
                            </div>        
                            </p>
                        </div>
                        <details class="text-dark-overlay8">
                            <summary class="text-base cursor-pointer text-dark-overlay8 flex items-center">
                                Deskripsi Ruangan
                                <div class="flex items-center gap-2">
                                    <?= icon('arrowDown', 'w-6 h-6') ?> 
                                </div>
                            </summary>
                            <p class="mt-3 text-sm leading-relaxed text-justify">
                                <?=  $detailRuangan['description'] ?>
                            </p>
                        </details>
                    </div>
                </div>

                <!-- KARTU TATA TERTIB (STICKY) -->
                <details class="lg:top-6 bg-background2 rounded-xl shadow-xl p-4 z-10">
                    <summary class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center gap-2">
                                <?= icon('law', 'w-6 h-6') ?> 
                            </div>
                            <span class="text-lg font-semibold text-black3">Tata Tertib</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <?= icon('arrowDown', 'w-6 h-6') ?> 
                        </div>
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-justify">
                        <?=  $detailRuangan['description'] ?>
                    </p>
                </details>
            </div>
        </div>
    </div>
</main>

<script>const BASEURL = "<?= BASEURL ?>";</script>
<script src="/js/bookingRoom.js"></script>
<script>

    const MIN_CAPACITY = <?= (int)$detailRuangan['min_capacity'] ?>;
    const MAX_CAPACITY = <?= (int)$detailRuangan['max_capacity'] ?>;

    // Add member (WAJIB JS)
    const addButton = document.getElementById('addMember');
    addButton.addEventListener('click', addMember)
    let memberCount = <?= $i + 1?>;

                                    // 2. FUNGSI UPDATE NOMOR URUT
    // Fungsi ini dipanggil setiap kali tambah/hapus untuk merapikan angka 1, 2, 3...
    function updateMemberNumbers() {
        const cards = document.querySelectorAll('.member-card');
        
        cards.forEach((card, index) => {
            const numberSpan = card.querySelector('.member-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1; // Update angka (Index 0 jadi 1)
            }
        });

        // Cek visibilitas tombol tambah
        if (cards.length >= MAX_CAPACITY) {
            addButton.classList.add('hidden');
        } else {
            addButton.classList.remove('hidden');
        }
    }

    function addMember() {

        memberCount++;
        const container = document.getElementById('membersContainer');
        const newCard = document.createElement('div');
        newCard.className = 'member-card p-4 bg-white1 rounded-xl border border-dark-overlay5';
        newCard.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center w-7 h-7 bg-dark-overlay7 text-white rounded-full text-xs font-bold"><?= $i + 2?></span>
                    <span class="ml-2 font-medium text-sm text-dark-overlay7">Anggota</span>
                </div>
                <button type="button" onclick="removeMember(this)" class="text-red1 hover:text-red-800 transition hover:cursor-pointer">
                    <div>
                        <?= icon('trash', 'w-6 h-6') ?>
                    </div>
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input type="text" maxlength="10" placeholder="NIM/NIP Anggota" name="nim[]" required
                    class="nim-input w-full px-4 py-2.5 border border-dark-overlay5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-dark-overlay bg-white text-sm">
                <input type="text" placeholder="Nama Lengkap Anggota" name="nama[]" readonly
                    class="nama-input w-full px-4 py-2.5 border border-dark-overlay5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-dark-overlay bg-white text-sm">
            </div>
        `;
        container.appendChild(newCard);
        if (memberCount == <?= $detailRuangan['max_capacity'] ?>) {
        addButton.classList.add('hidden'); // sembunyikan tombol
        return; // hentikan eksekusi fungsi 
        }
        updateMemberNumbers();
    }

    // Remove member (WAJIB JS)
    function removeMember(button) {
        const cards = document.querySelectorAll('.member-card');
        if (cards.length <= MIN_CAPACITY) {
            // Mengganti showError() dengan alert sederhana
            alert(`Minimal anggota untuk ruangan ini adalah ${MIN_CAPACITY} orang.`);
            return;
        }
        button.closest('.member-card').remove();
        document.querySelectorAll('.member-card').forEach((card, i) => {
            card.querySelector('span.rounded-full').textContent = i + 1;
        });
        memberCount = document.querySelectorAll('.member-card').length;
        addButton.classList.remove('hidden')
    }
    </script>

            