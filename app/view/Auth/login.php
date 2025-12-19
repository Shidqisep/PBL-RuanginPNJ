<?php Flasher::Flash() ?>
<?php Flasher::modalInfo(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>RuanginPNJ - Login</title>
    <link href="/css/output.css" rel="stylesheet">

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body class="font-sf-pro" >
    
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center p-6"
         style="background-image: url('/img/Background 1.png');">   

        <div class="flex items-center justify-center h-fit max-w-lg w-full my-8"> 
            <div class="bg-background1 rounded-2xl shadow-2xl p-8 w-lg h-fit max-w-lg md:h-fit sm:h-full mb-5 mt-1">
                <!-- Logo & Header -->
                <div class="text-center mb-5">
                    <div class="flex items-start justify-start mb-3">
                        <img src="/img/LOGO PNJ FIX 1.png" alt="Logo" class="w-auto h-10 mr-2">
                        <h1 class="text-4xl font-bold text-gray-800">ruanginPNJ</h1>
                    </div>
                    <p class="text-sm text-left  text-gray-600">Temukan, pinjam, dan nikmati fasilitas favortimu dengan mudah.</p>
                </div>

                <!-- Form -->
                <form id="loginForm" method="POST" action="/auth/handleLogin">
                    <!-- Email -->
                    <div class="mb-5">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" placeholder="Input email" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs">
                    </div>

                    <!-- Password -->
                    <div class="mb-5" data-toggle-password>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs">
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <img src="/icon/eye-on.svg" alt="Show Password" class="w-5 h-5 hover:cursor-pointer">
                            </button>
                        </div>
                    </div>

                    <!-- Links Row -->
                    <div class="flex items-center justify-between mb-4 text-xs">
                        <div>
                            <span class="text-gray-600">Belum punya akun? </span>
                            <a href="/auth/registerForms" class="text-blue-600 hover:underline font-medium">Registrasi</a>
                        </div>
                        <a href="/Auth/ForgetPassword" class="text-blue-600 hover:underline font-medium">Lupa Password?</a>
                    </div>
                    <!-- cloudflare brooo -->
                    <div class="mb-7 flex justify-left">
                        <div class="cf-turnstile" data-sitekey="<?= TURNSTILE_SITE_KEY ?>"></div>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center" for="remember">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-xs text-gray-700">Ingat Saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#38C55C] text-white py-3 text-sm rounded-lg font-medium hover:bg-green-600 transition duration-200 hover:cursor-pointer mb-2">
                        Login - Explore Ruangan Sekarang
                    </button>
                </form>
            </div>
        </div>    
    </div>
</body>
</html>

<script src="/js/togglePassword.js" defer></script>