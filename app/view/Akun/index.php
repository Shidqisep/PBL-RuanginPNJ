<!-- Main Content -->
<main class="container mx-auto px-6 py-8 max-w-2xl">
    <h2 class="text-3xl font-bold text-[#171E29] mb-10 text-center">Akun</h2>

    <!-- Avatar Section -->
    <div class="flex justify-center mb-8 relative">
        <div class="relative">
            <!-- Avatar Utama -->
            <div id="" class="w-47 h-47 bg-white rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-user text-[#971048] text-9xl leading-none"></i>
            </div>
            <!-- Badge Status -->
            <!-- <div id="avatarBadge" class="absolute bottom-0 right-0 bg-pink-600 text-white text-xs px-3 py-1 rounded-full font-semibold">
                Guest Avatar
            </div> -->
        </div>
    </div>

    <!-- Ganti Avatar -->
    <div class="text-center mb-10">
        <button type="button" onclick="openAvatarModal()" 
                class="text-blue-600 hover:text-blue-800 text-sm font-medium transition hover:cursor-pointer">
            <i class="fas fa-sync-alt mr-1"></i> Ganti Avatar
        </button>
    </div>

    <!-- User Info -->
    <div class="space-y-6 mb-10">
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
            <div class="border-b border-gray-300 pb-2">
                <p class="text-gray-800 font-medium">Muhammad Reza Arifin</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <div class="border-b border-gray-300 pb-2">
                <p class="text-gray-800">email@stu.pnj.ac.id</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Jurusan</label>
            <div class="border-b border-gray-300 pb-2">
                <p class="text-gray-800">Akuntansi</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <a href="ganti-password.php" 
           class="bg-[#1E68FB] text-white hover:from-blue-600 hover:to-blue-700 text-center py-3 rounded-lg font-semibold transition duration-200">
            Ganti Password
        </a>
        <a href="hapus-akun.php" 
           class="bg-[#1E68FB] text-white hover:from-blue-600 hover:to-blue-700 text-center py-3 rounded-lg font-semibold transition duration-200">
            Hapus Akun
        </a>
    </div>

    <!-- Logout Button -->
    <a href="../../Login%20%26%20Auth/Login/logout.php"
       class="block w-full bg-[#C90B0B] text-white hover:bg-red-700 text-center py-3 rounded-lg font-semibold transition duration-200">
        Logout
    </a>
</main>

<!-- Modal Ganti Avatar -->
<!-- <div id="avatarModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Pilih Avatar</h3>
            <button onclick="closeAvatarModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-3 gap-4">

    
            <button onclick="selectAvatar(1)" class="avatar-option p-3 rounded-xl border-2 border-transparent hover:border-blue-500 transition">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-astronaut text-white text-3xl"></i>
                </div>
                <p class="text-xs text-center mt-2 text-gray-600">Astronaut</p>
            </button>
            <button onclick="selectAvatar(2)" class="avatar-option p-3 rounded-xl border-2 border-transparent hover:border-blue-500 transition">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-ninja text-white text-3xl"></i>
                </div>
                <p class="text-xs text-center mt-2 text-gray-600">Ninja</p>
            </button>
            <button onclick="selectAvatar(3)" class="avatar-option p-3 rounded-xl border-2 border-transparent hover:border-blue-500 transition">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-graduate text-white text-3xl"></i>
                </div>
                <p class="text-xs text-center mt-2 text-gray-600">Lulusan</p>
            </button>
            <button onclick="selectAvatar(4)" class="avatar-option p-3 rounded-xl border-2 border-transparent hover:border-blue-500 transition">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-tie text-white text-3xl"></i>
                </div>
                <p class="text-xs text-center mt-2 text-gray-600">Profesional</p>
            </button>
            <button onclick="selectAvatar(5)" class="avatar-option p-3 rounded-xl border-2 border-transparent hover:border-blue-500 transition">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-pink-400 to-red-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <p class="text-xs text-center mt-2 text-gray-600">Default</p>
            </button>
        </div>
    </div>
</div> -->

<!-- JavaScript -->
<!-- <script>
    // Daftar avatar (ikon + gradient)
    const avatars = [
        null,
        { icon: 'fa-user-astronaut', gradient: 'from-blue-400 to-blue-600', label: 'Astronaut' },
        { icon: 'fa-user-ninja', gradient: 'from-green-400 to-green-600', label: 'Ninja' },
        { icon: 'fa-user-graduate', gradient: 'from-purple-400 to-purple-600', label: 'Lulusan' },
        { icon: 'fa-user-tie', gradient: 'from-yellow-400 to-orange-500', label: 'Profesional' },
        { icon: 'fa-user', gradient: 'from-pink-400 to-red-500', label: 'Default' }
    ];

    // Load avatar saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        const saved = localStorage.getItem('selectedAvatar');
        if (saved) {
            applyAvatar(parseInt(saved));
        } else {
            applyAvatar(5); // default
        }
    });

    // Buka modal
    function openAvatarModal() {
        document.getElementById('avatarModal').classList.remove('hidden');
    }

    // Tutup modal
    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }

    // Pilih avatar
    function selectAvatar(id) {
        applyAvatar(id);
        localStorage.setItem('selectedAvatar', id);
        closeAvatarModal();
    }

    // Terapkan avatar ke UI
    function applyAvatar(id) {
        const avatar = avatars[id];
        const mainAvatar = document.getElementById('mainAvatar');
        const badge = document.getElementById('avatarBadge');

        // Update gradient
        mainAvatar.className = `w-32 h-32 bg-gradient-to-br ${avatar.gradient} rounded-full flex items-center justify-center shadow-lg`;
        
        // Update ikon
        mainAvatar.innerHTML = `<i class="fas ${avatar.icon} text-white text-5xl"></i>`;
        
        // Update badge
        badge.textContent = avatar.label;
    }
</script> -->