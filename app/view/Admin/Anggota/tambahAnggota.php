<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <nav class="mb-6 text-sm text-dark-overlay6 flex">
        <a href="/Admin/Anggota" class="text-blue-overlay hover:text-blue-700">Data Anggota</a>
        <span class="mx-2">
            <div>
                <?= icon('arrowRight', 'w-5 h-5') ?>
            </div>
        </span>
        <span class="font-medium hover:cursor-pointer">Tambah Anggota</span>
    </nav>

    <h2 class="text-xl font-bold text-dark-overlay mb-6">Tambah Anggota</h2>

    <div class="bg-background2 rounded-2xl w-full shadow-xl p-6">
        <h3 class="text-xl font-semibold text-dark-overlay mb-6">Isi Data Anggota</h3>
            
        <form class="space-y-4" id="formDaftar" action="<?= BASEURL ?>admin/handleRegisterByAdmin" method="POST"> 
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-dark-overlay mb-2">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" placeholder="Input nama" name="username"
                        class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-dark-overlay mb-2">Email</label>
                    <input type="email" id="email" placeholder="Input Email" name="email"
                            class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                
                <div>
                    <label for="jenis_anggota" class="block text-sm font-medium text-dark-overlay mb-2">Jenis Anggota</label>
                    <select id="jenis_anggota" name="jenis_anggota"
                            class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value=""disabled selected hidden>Pilih Jenis Anggota</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="tendik">Staff</option>
                    </select>
                </div>

                <div>
                    <label for="jurusan" class="block text-sm font-medium text-dark-overlay mb-2">Jurusan/Unit Kerja</label>
                    <select id="jurusan_select" name="jurusan_unit"
                            class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="" disabled selected hidden>Pilih Jurusan</option>
                    </select>
                    <input type="text" id="jurusan_text" name="jurusan_text" placeholder="Masukkan Unit Kerja" class="hidden w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                
                <div id="container_prodi" class="hidden">
                    <label for="prodi" class="block text-sm font-medium text-dark-overlay mb-2">Prodi (Untuk Mahasiswa)</label>
                    <select id="prodi" name="prodi"
                            class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="" disabled selected hidden>Pilih Prodi</option>
                        </select>
                </div>

                <div>
                    <label for="nim_nip" class="block text-sm font-medium text-dark-overlay mb-2">NIM/NIP</label>
                    <input type="text" id="nim_nip" placeholder="Input NIM/NIP" name="nomor_induk"
                            class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                
                <!-- Password -->
                <div class="mb-5" data-toggle-password>
                    <label class="block text-sm font-medium text-dark-overlay mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password"
                            class="w-full px-4 py-2 border border-dark-overlay4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-overlay5">
                            <img src="/icon/eye-on.svg" alt="Show Password" class="w-5 h-5 hover:cursor-pointer">
                        </button>
                    </div>
                </div>
                
            </div>
            
            <div class="flex justify-between gap-8">
                <button type="button" class="px-6 py-2 border border-dark-overlay4 text-dark-overlay7 font-semibold rounded-lg hover:bg-dark-overlay1 transition shadow-sm w-full hover:cursor-pointer">
                    Batal
                </button>
                <button onclick="konfirmasiTambahAnggota()" type="button" class="px-6 py-2 bg-green1 text-white font-semibold rounded-lg hover:bg-green-600 transition shadow-sm w-full hover:cursor-pointer">
                    Tambah Anggota
                </button>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../../template/modal.php'; ?>
<script>
    // Ambil data dari PHP
    // Pastikan variabel ini ter-render dengan benar di page source
    const registerDataJurusan = <?= json_encode($dataJurusan) ?>; 
    const registerDataProdi = <?= json_encode($dataProdi) ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('jenis_anggota');
        
        const jurusanSelect = document.getElementById('jurusan_select');
        const jurusanText = document.getElementById('jurusan_text');
        
        const prodiContainer = document.getElementById('container_prodi');
        const prodiSelect = document.getElementById('prodi');

        // --- 1. Logic Ganti Role (Mahasiswa/Dosen/Staff) ---
        roleSelect.addEventListener('change', function() {
            const selectedRole = this.value;

            // Reset Form
            jurusanSelect.value = "";
            jurusanText.value = "";
            prodiSelect.innerHTML = '<option value="" disabled selected hidden>Pilih Prodi</option>';

            if (selectedRole === 'mahasiswa') {
                // Tampilkan Mode Mahasiswa (Dropdown Jurusan & Prodi)
                jurusanSelect.classList.remove('hidden');
                jurusanText.classList.add('hidden');
                prodiContainer.classList.remove('hidden');

                // Isi Dropdown Jurusan
                populateJurusan();
            } else {
                // Tampilkan Mode Staff/Dosen (Input Text Jurusan)
                jurusanSelect.classList.add('hidden');
                jurusanText.classList.remove('hidden');
                prodiContainer.classList.add('hidden');
            }
        });

        // --- 2. Fungsi Mengisi Dropdown Jurusan ---
        function populateJurusan() {
            jurusanSelect.innerHTML = '<option value="" disabled selected hidden>Pilih Jurusan</option>';
            
            // Loop array biasa
            registerDataJurusan.forEach(namaJurusan => {
                const option = document.createElement('option');
                // Value kita set sama dengan Text agar bisa dipakai untuk kunci ambil data Prodi
                option.value = namaJurusan; 
                option.textContent = namaJurusan;
                jurusanSelect.appendChild(option);
            });
        }

        // --- 3. Logic Ganti Jurusan (Mengisi Prodi) ---
        jurusanSelect.addEventListener('change', function() {
            const selectedJurusan = this.value; // Contoh: "Teknik Mesin"

            // Bersihkan prodi lama
            prodiSelect.innerHTML = '<option value="" disabled selected hidden>Pilih Prodi</option>';

            // Ambil array prodi langsung dari Object berdasarkan Key (Nama Jurusan)
            // Cek apakah data prodi untuk jurusan tersebut ada?
            if (registerDataProdi[selectedJurusan]) {
                
                const listProdi = registerDataProdi[selectedJurusan];

                listProdi.forEach(namaProdi => {
                    const option = document.createElement('option');
                    option.value = namaProdi; 
                    option.textContent = namaProdi;
                    prodiSelect.appendChild(option);
                });
                
                prodiSelect.disabled = false;
            } else {
                // Handle jika jurusan tidak punya prodi di data JSON
                const option = document.createElement('option');
                option.textContent = "Data prodi tidak ditemukan";
                prodiSelect.appendChild(option);
                prodiSelect.disabled = true;
            }
        });
    });

    function konfirmasiTambahAnggota() {
    Modal.confirm(
        'Tambah Anggota?',
        'Anda yakin ingin Tambah Anggota?',
        function() {
            document.getElementById('formDaftar').submit();
        },
        {
            icon: <?= json_encode(icon("usersAdmin", "w-24 h-24 text-green1")) ?>,
            confirmText: 'Tambah',
            confirmClass: 'w-full px-6 py-2 bg-green1 text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer',
            cancelText: 'Batalkan'
        }
    );
}
</script>
<script src="/js/togglePassword.js" defer></script> 
<script src="/js/modal.js" defer></script>
