<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm">
        <a href="/Admin/superAdmin" class="text-blue-overlay hover:text-blue-700">Data Admin</a>
            <span class="mx-2">
                <div class="text-dark-overlay6">
                    <?= icon('arrowRight', 'w-5 h-5') ?>
                </div>
            </span>
        <a href="/Admin/tambahAdmin" class="text-dark-overlay6 hover:text-blue-700">Tambah Admin</a>
    </nav>

    <!-- Header dengan Title dan Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-dark-overlay">Tambah Admin</h2>
    </div>

    <div class="bg-background2 rounded-2xl w-full shadow-xl p-6">
        <h3 class="text-xl font-semibold text-dark-overlay mb-6">Isi Data Admin</h3>
            
        <form class="space-y-4" id="formDaftar" method="POST" action="/superadmin/handleTambahAdmin"> 
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-dark-overlay mb-2">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" placeholder="Input nama" name="username"
                        class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-dark-overlay mb-2">Email</label>
                <input type="email" id="email" placeholder="Input Email" name="email"
                        class="w-full px-4 py-2 border border-dark-overlay4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label for="nim_nip" class="block text-sm font-medium text-dark-overlay mb-2">NIP</label>
                <input type="text" id="nim_nip" placeholder="Input NIP" name="nomor_induk"
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
            
            <div class="flex justify-between gap-8 mt-8">
                <button type="button" onclick="window.location.href='/superadmin'" class="px-6 py-2 border border-dark-overlay4 text-dark-overlay7 font-semibold rounded-lg hover:bg-dark-overlay1 transition shadow-sm w-full hover:cursor-pointer">
                    Batal
                </button>
                <button onclick="konfirmasiTambahAdmin()" type="button" class="px-6 py-2 bg-green1 text-white font-semibold rounded-lg hover:bg-green-600 transition shadow-sm w-full hover:cursor-pointer">
                    Tambah Admin
                </button>
            </div>
        </form>
    </div>
</main>

<script src="/js/togglePassword.js" defer></script> 
<script src="/js/modal.js" defer></script>
<script>
    function konfirmasiTambahAdmin() {
    Modal.confirm(
        'Tambah Admin?',
        'Anda yakin ingin tambah Admin?',
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