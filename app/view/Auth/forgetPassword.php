<?php Flasher::Flash() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>Lupa Password</title>
    <link href="/css/output.css" rel="stylesheet">

</head>
<body class="font-sf-pro" >
    
    
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center"
         style="background-image: url('/img/Background 1.png'); 
             background-color: rgba(139, 92, 113, 0.7); background-blend-mode: multiply;">

        <!-- **************************************************
        INI UNTUK BAGIAN PERTAMA YANG UNTUK MENGISI Email
        ******************************************************* -->
        <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-md md:h-full sm:h-full mb-5 mt-10">
            <!-- Logo & Header -->
            <div class="text-center mb-6">
                <div class="flex items-start justify-start mb-1">
                    <h1 class="text-4xl font-bold text-gray-800">Lupa Password?</h1>
                </div>
                <p class="text-sm text-left text-gray-600">Masukkan email yang kamu gunakan di ruanginPNJ</p>
            </div>

            <!-- Form -->
            <form id="LupaPassword" method="POST" action="">
                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" placeholder="Input email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Links Row -->
                <div class="flex items-center mb-4 text-sm">
                    <i class="fas fa-arrow-left"></i>
                    <a href="/auth/formLogin" class="text-blue-600 hover:text-blue-800 hover:underline font-medium ml-2">Kembali ke Login</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#38C55C] text-white py-3 text-sm rounded-lg font-semibold hover:bg-green-600 transition duration-200 hover:cursor-pointer mb-2">
                    Kirim Kode Verifikasi
                </button>
            </form>
        </div>

        <!-- **************************************************
        INI UNTUK BAGIAN KEDUA YANG UNTUK MENGISI KODE VERIFIKASI
        ******************************************************* -->
        <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-md md:h-full sm:h-full mb-5 mt-10 hidden">
            <!-- Logo & Header -->
            <div class="text-center mb-6">
                <div class="flex items-start justify-start mb-1">
                    <h1 class="text-4xl font-bold text-gray-800">Verifikasi</h1>
                </div>
                <p class="text-sm text-left text-gray-600">Masukkan kode yang sudah dikirim di email yang kamu berikan</p>
            </div>

            <div class="flex justify-between gap-3 mb-6">
                <input type="text" maxlength="1" id="otp-1" class="otp-input w-1/5 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" id="otp-2" class="otp-input w-1/5 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" id="otp-3" class="otp-input w-1/5 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" id="otp-4" class="otp-input w-1/5 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" id="otp-5" class="otp-input w-1/5 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
            </div>

            <div class="text-center text-red-600 font-semibold mb-6" id="timer">
                09:55
            </div>

            <!-- Form -->
            <form id="" method="POST" action="">
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#38C55C] text-white py-2 text-sm rounded-lg font-semibold hover:bg-green-600 transition duration-200 hover:cursor-pointer mb-2">
                    Verifikasi
                </button>
            </form>

            <div class="flex flex-col items-start justify-between text-xs gap-4 mt-4">
                <div>
                    <span class="text-gray-600">Tidak mendapatkan kode? </span>
                    <a href="" class="text-blue-600 hover:underline font-medium">Kirim ulang kode</a>
                </div>

                <div>
                    <span class="text-gray-600">Email salah? </span>
                    <a href="" class="text-blue-600 hover:underline font-medium">Kirim ulang Email</a>
                </div>
            </div>
        </div>


        <!-- **************************************************
        INI UNTUK BAGIAN KETIGA YANG UNTUK MENGISI PASSWORD BARU
        ******************************************************* -->
        <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-md md:h-full sm:h-full mb-5 mt-10 hidden">
            <!-- Logo & Header -->
            <div class="text-center mb-6">
                <div class="flex items-start justify-start mb-1">
                    <h1 class="text-4xl font-bold text-gray-800">Password Baru</h1>
                </div>
                <p class="text-sm text-left text-gray-600">Buat password baru untuk akunmu</p>
            </div>

            <!-- Form -->
            <form id="" method="POST" action="">

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <div class="relative">
                        <input type="password" id="passwordBaru" name="passwordBaru" placeholder="••••••••"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye hover:cursor-pointer" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="••••••••"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye hover:cursor-pointer" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#38C55C] text-white py-2 text-sm rounded-lg font-semibold hover:bg-green-600 transition duration-200 hover:cursor-pointer mb-2">
                    Verifikasi
                </button>
            </form>
        </div>

        <!-- **************************************************
        POP UP SUCCESS MODAL
        ******************************************************* -->
        <div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Ganti Password Berhasil</h3>
                <p class="text-sm text-gray-600 mb-6">Kamu berhasil mengganti password!</p>
                <button type="button" onclick="window.location.href='/auth/formLogin'"
                        class="w-full px-6 py-2 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer text-sm">
                    Kembali ke halaman Login
                </button>
            </div>
        </div>
    </div>


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