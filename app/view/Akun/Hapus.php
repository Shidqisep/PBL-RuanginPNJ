<!-- Main Content -->
<main class="container mx-auto px-6 pt-8 pb-22 w-97/100 flex-1 flex flex-col justify-center items-center min-h-9/10 bg-cover">

    <nav class="text-sm text-dark-overlay/60 w-full mb-12">
        <a href="/Akun" class="text-gray-900 hover:text-[#1E68FB]">Akun</a>
        <span class="mx-2">></span>
        <span class="text-dark-overlay/60 font-medium hover:cursor-pointer">Hapus Akun</span>
    </nav>
    
    <h2 class="text-2xl sm:text-3xl text-center font-bold text-[#171E29] mb-5 left-align">Hapus Akun</h2>

    <div class="bg-[#F3F5FA] rounded-2xl w-full max-w-xl p-8">
        <!-- Links Row -->
        <!-- <div class="flex items-center mb-2 mt-1 text-sm lg:hidden md:hidden sm:hidden">
            <i class="fas fa-arrow-left"></i>
            <a href="/auth/formLogin" class="text-blue-600 hover:text-blue-800 hover:underline font-medium ml-2">Kembali ke Login</a>
        </div> -->

        <!-- Form -->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="grid gap-4">
                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="passwordLama" placeholder="••••••••"
                            class="w-full bg-white px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye hover:cursor-pointer" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ketik "Konfirmasi"</label>
                    <input type="text" name="nomor_induk" placeholder="Ketik di sini" 
                        class="w-full bg-white  px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-3 mt-2">
                    <button class="px-4 py-3 bg-white text-gray-800 rounded-lg font-medium hover:bg-gray-100 border border-gray-400 transition hover:cursor-pointer">Batal</button>
                    <button class="px-4 py-3 bg-[#1E68FB] text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-sm hover:cursor-pointer">Konfirmasi</button>
                </div>
            </div>
        </form>
        
    </div>

    <!-- **************************************************
        INI POPUP MODAL HAPUS AKUN
        ******************************************************* -->
    <div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
            <div class="mb-4">
                <i class="fas fa-trash-alt text-5xl text-[#C90B0B]"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Akun?</h3>
            <p class="text-sm text-gray-600 mb-6">Akun akan terhapus untuk selamanya dan tidak bisa dikembalikan</p>
            <div class="grid grid-cols-2 gap-3">
                <button class="px-4 py-1 bg-white text-gray-800 rounded-lg font-medium hover:bg-gray-100 border border-gray-400 transition hover:cursor-pointer">Batal</button>
                <button class="px-4 py-1 bg-[#C90B0B] text-white rounded-lg font-medium hover:bg-red-800 transition shadow-sm hover:cursor-pointer">Hapus</button>
            </div>
        </div>
    </div>
    
</main>


<!-- JavaScript -->
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>