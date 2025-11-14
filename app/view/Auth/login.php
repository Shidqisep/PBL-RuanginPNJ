<?php Flasher::Flash() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="/css/output.css" rel="stylesheet">

</head>
<body class="font-sf-pro" >
    
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center"
         style="background-image: url('/img/Background 1.png');>   

        <div class="flex items-center justify-center w-fit h-fit max-w-lg my-8git"> 
            <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-lg h-fit max-w-lg md:h-fit sm:h-full mb-5 mt-1">
                <!-- Logo & Header -->
                <div class="text-center mb-5">
                    <div class="flex items-start justify-start mb-3">
                        <img src="/img/LOGO PNJ FIX 1.png" alt="Logo" class="w-auto h-10 mr-2">
                        <h1 class="text-4xl font-bold text-gray-800">ruanginPNJ</h1>
                    </div>
                    <p class="text-xs text-left  text-gray-600">Temukan, pinjam, dan nikmati fasilitas favortimu dengan mudah.</p>
                </div>

                <!-- Form -->
                <form id="loginForm" method="POST" action="/auth/handleLogin">
                    <!-- Email -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" placeholder="Input email" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <i class="fas fa-eye hover:cursor-pointer" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Links Row -->
                    <div class="flex items-center justify-between mb-4 text-sm">
                        <div>
                            <span class="text-gray-600">Belum punya akun? </span>
                            <a href="/auth/registerForm" class="text-blue-600 hover:underline font-medium">Registrasi</a>
                        </div>
                        <a href="/Auth/ForgetPassword" class="text-blue-600 hover:underline font-medium">Lupa Password?</a>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Ingat Saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#38C55C] text-white py-3 text-sm rounded-lg font-semibold hover:bg-green-600 transition duration-200 hover:cursor-pointer mb-2">
                        Login - Explore Ruangan Sekarang
                    </button>

                    <div class="flex items-center text-center w-full max-w-md py-2">
                        <div class="flex-1 border-t border-gray-300 mx-3"></div>
                        <span class="text-xs text-gray-600 font-normal px-2">atau lanjut dengan</span>
                        <div class="flex-1 border-t border-gray-300 mx-3"></div>
                    </div>

                    <!-- Booking Ruang Rapat Link -->
                    <div class="text-center mt-2">
                        <a href="/RuangRapat/index" class="w-full inline-block bg-[#1E68FB] text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-[0_1px_2.7px_0_rgba(0,0,0,0.15)] duration-200">
                            Booking Ruang Rapat
                        </a>
                    </div>
                </form>
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
