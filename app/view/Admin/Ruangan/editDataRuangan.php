<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm">
        <a href="/Admin/Ruangan" class="text-blue-overlay hover:text-blue-700">Data Ruangan</a>
        <span class="mx-2 text-dark-overlay6">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <a href="#" class="text-dark-overlay6 hover:text-blue-overlay">Edit Ruangan</a>
    </nav>

    <h2 class="text-2xl font-bold text-dark-overlay">Edit Data Ruangan</h2>
    <form id="editRoomForm" action="<?= BASEURL; ?>/admin/handleUpdateRoom" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?= $room['id_room'] ?>" name="id_room" >
    <div class="grid lg:grid-cols-1 xl:grid-cols-2 gap-10 mt-6">

        <!-- KOLOM KIRI – Foto + Form Utama -->
        <div class="space-y-8 bg-background2 shadow-xl rounded-xl">

            <!-- Foto + Rating + Upload -->
            <div class="relative rounded-t-2xl overflow-hidden mb-0">
               <?php if($room['img_room'] !== 'DefaultRuangan.jpg'): ?>
                    <img src="<?= BASEURL; ?>/File/showPhoto/<?= $room['img_room']; ?>" id="preview-image"
                        alt="<?= $room['room_name'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <img src="/img/DefaultRuangan.jpg" id="preview-image"
                        alt="<?= $room['room_name'] ?>" class="w-full h-full object-cover">
                <?php endif ?>

        
                <!-- Overlay Rating (mirip gambar) -->
                <div class="absolute top-6 left-6 flex items-center gap-3 px-5 py-1
                                bg-dark-overlay2
                                rounded-lg
                                animate-in fade-in slide-in-from-bottom duration-500">
                    
                    <!-- Bintang -->
                    <div class="flex items-center gap-1">
                        < <?php 
                            $max = 5;
                            for ($i = 1; $i <= $max; $i++):
                            if ($i <= $room['avg_rating']) {
                                echo icon('starFill', 'w-5 h-5 text-yellow1');   // bintang terisi
                            } else {
                                echo icon('starFill', 'w-5 h-5 text-dark-overlay5'); // bintang kosong/gelap
                            }
                                endfor; ?>
                    </div>

                    <!-- Teks rating -->
                    <div class="text-background2">
                        <span class="text-xl font-bold"><?= round($room['avg_rating']) ?>/5</span>
                        <span class="text-sm font-medium text-background2 ml-2">(<?= $room['total_review'] ?> Respon)</span>
                    </div>
                </div>
        

                <!-- Upload Foto Baru -->
                <div class="flex justify-between items-center absolute bottom-0 left-0 right-0 p-6 bg-linear-to-t from-black/70 to-transparent">
                    <label class="flex items-center gap-3 text-white cursor-pointer transition">
                        <span class="flex items-center font-medium py-2 px-3 rounded-full text-xs bg-blue-overlay hover:bg-blue-overlay7">Ganti Foto
                            <div>
                                <?= icon('uploadFoto', 'h-5 w-5 ml-2') ?>
                            </div>
                        </span>
                        <input type="file" id="input-foto" name="roomPhoto" accept=".png,.jpg,.jpeg" class="hidden">
                        <input type="hidden" name="old_roomPhoto" value="<?= $room['img_room']; ?>">
                    </label>
                    <p class="font-medium py-2 px-3 rounded-full text-xs bg-blue-overlay text-white">.png, .jpg, .jpeg</p>
                </div>
            </div>

            <!-- Form Input -->
            <div class="space-y-4 p-8 rounded-xl">

                <div>
                    <label class="block text-sm font-medium text-dark-overlay7 mb-2">Nama Ruangan</label>
                    <input type="text" value="<?= htmlspecialchars($room['room_name']) ?>" name="room_name"
                            class="w-full px-4 py-2 border border-dark-overlay4 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none placeholder:text-dark-overlay transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-overlay7 mb-2">Lantai</label>
                    <input type="text" value="<?= htmlspecialchars($room['floor']) ?>" name="floor"
                            class="w-full px-4 py-2 border border-dark-overlay4 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none placeholder:text-dark-overlay">
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-overlay7 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-dark-overlay4 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none placeholder:text-dark-overlay">
                        <option value="active" <?= ($room['status'] == 'active') ? 'selected' : '' ?>>Tersedia</option>
                        <option value="non-active" <?= ($room['status'] == 'non-active') ? 'selected' : '' ?>>Tidak Tersedia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-overlay7 mb-2">Kapasitas Ruangan</label>
                    <div class="flex justify-between items-center gap-4">
                        <input name="min_capacity" type="number" value="<?= htmlspecialchars((int)$room['min_capacity'] ?? '') ?>" min="1" class="w-full px-4 py-2 border border-dark-overlay4 rounded-lg text-center">
                            <span class="text-dark-overlay7">Sampai</span>
                        <input name="max_capacity" type="number" value="<?= htmlspecialchars((int)$room['max_capacity'] ?? '') ?>" min="1" class="w-full px-4 py-2 border border-dark-overlay4 rounded-lg text-center">
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN – Deskripsi + Tombol Aksi -->
        <div class="space-y-4 bg-background2 shadow-xl rounded-xl p-8 self-start">

            <div>
                <label class="block text-sm font-medium text-dark-overlay7 mb-2">
                Deskripsi Lengkap
                </label>
                <textarea rows="6" placeholder="Tuliskan deskripsi lengkap ruangan..." name="description"
                        class="w-full px-5 py-4 border border-dark-overlay4 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 outline-none placeholder:text-dark-overlay"><?= htmlspecialchars($room['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-dark-overlay7 mb-2">
                Deskripsi Singkat
                </label>
                <textarea rows="3" placeholder="Tuliskan deskripsi singkat yang muncul di kartu ruangan..." name="short_description"
                    class="w-full px-5 py-4 border border-dark-overlay4 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 outline-none placeholder:text-dark-overlay"><?= htmlspecialchars($room['short_description'] ?? '') ?></textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-8 pt-2">
                <button type="button" onclick="konfirmasiHapus()" class="flex-1 bg-red1 hover:bg-red-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transition transform hover:cursor-pointer">
                Hapus Ruangan
                </button>
                <button type="button" onclick="konfirmasiEdit()" class="flex-1 bg-green1 hover:bg-green-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transition transform hover:cursor-pointer">
                Edit Ruangan
                </button>
            </div>

        </div>
    </div>
    </form>
    <form id="deleteRoomForm" action="<?= BASEURL; ?>/admin/handleDeleteRoom" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?= $room['id_room'] ?>" name="id_room" >
    </form>
</main>

<?php include __DIR__ . '/../../template/modal.php'; ?>

<script src="/js/modal.js" defer></script>
<script>

    const inputFoto = document.getElementById('input-foto');
    const previewImage = document.getElementById('preview-image');
    const defaultBadge = document.getElementById('default-badge');

    inputFoto.addEventListener('change', function(e) {
        const file = e.target.files[0];

        // Cek apakah ada file yang dipilih
        if (file) {
            const reader = new FileReader();

            // Saat file selesai dibaca, update src gambar
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                
                // Opsional: Sembunyikan badge "INI FOTO DEFAULT" jika user upload foto baru
                if(defaultBadge) {
                    defaultBadge.style.display = 'none';
                }
            }

            // Membaca file sebagai URL data (base64)
            reader.readAsDataURL(file);
        }
    });


function konfirmasiEdit() {
    Modal.confirm(
        'Edit Ruangan?',
        'Data ruangan akan terganti',
        function() {
            document.getElementById('editRoomForm').submit();
        },
        {
            icon: '/icon/pencil.svg',
            confirmText: 'Edit',
            confirmClass: 'w-full px-6 py-2 bg-green1 text-white rounded-lg font-semibold hover:bg-green-700 transition hover:cursor-pointer',
            cancelText: 'Batalkan'
        }
    );
}

function konfirmasiHapus() {
    Modal.confirm(
        'Hapus Ruangan?',
        'Data ruangan akan terhapus untuk selamanya dan tidak bisa dikembalikan',
        function() {
            document.getElementById('deleteRoomForm').submit();
        },
        {
            icon: '/icon/trash.svg',
            confirmText: 'Hapus',
            confirmClass: 'w-full px-6 py-2 bg-red1 text-white rounded-lg font-semibold hover:bg-red-700 transition hover:cursor-pointer',
            cancelText: 'Batalkan'
        }
    );
}
</script>