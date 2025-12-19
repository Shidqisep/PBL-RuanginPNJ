<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>RuanginPNJ - Registrasi Dosen</title>
    <link href="/css/output.css" rel="stylesheet">
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

</head>
<body class="font-sf-pro" >
    
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center p-4"
         style="background-image: url('/img/Background 1.png'); ">

        <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-xl">
            <!-- Header -->
            <div class="mb-5">
                <form action="" method="post">
                    <div>
                    <input type="hidden" name="backToRole" value="anton">
                    <button type="submit" class="flex items-center space-x-2 text-[#1E68FB] hover:underline mb-3 hover:cursor-pointer text-sm" href="/auth/registerForms">
                    <img src="/icon/back.svg" alt="Back to Home" width="20" height="20">
                    <span>Kembali pilih role</span>
                    </button>
                    </div>
                </form>

                <h1 class="text-3xl font-bold text-[#171E29] mb-1">Registrasi Akun</h1>
                <p class="text-sm text-gray-600">Pinjam ruangan perpustakaan dengan mudah, praktis, dan cepat.</p>
            </div>

            <!-- Form -->
            <form action="/auth/handleRegister" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="role" value="<?= $role ?>">
                
                <!-- Nama -->
                <div class="col-span-2 sm:col-span-1 mb-3">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="username" placeholder="Input nama" value="<?=  $_SESSION['input']['username'] ?? '' ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                </div>

                <!-- Email PNJ -->
                <div class="col-span-2 sm:col-span-1 mb-3">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Email PNJ</label>
                    <input type="email" name="email" placeholder="Input email" value="<?=  $_SESSION['input']['email'] ?? '' ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <!-- NIM -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-medium text-gray-700 mb-2">NIP</label>
                        <input type="text" name="nomor_induk" placeholder="Input NIP" value="<?=  $_SESSION['input']['nomor_induk'] ?? '' ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                    </div>

                    <!-- Jurusan -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Jurusan/Unit</label>
                        <select name="jurusan_unit" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                            <option value="" disabled selected hidden>Jurusan/Unit</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                            <option value="Teknik Sipil">Teknik Sipil</option>
                            <option value="Akuntansi">Akuntansi</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="mb-5" data-toggle-password>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Password (minimal 6 huruf dan 1 angka)</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs focus:border-transparent">
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <img src="/icon/eye-on.svg" alt="Show Password" class="w-5 h-5 hover:cursor-pointer">
                            </button>
                        </div>
                    </div>

                    <!-- konfirmasiPassword -->
                    <div class="mb-5" data-toggle-password>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="••••••••" autocomplete="new-password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs focus:border-transparent">
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <img src="/icon/eye-on.svg" alt="Show Password" class="w-5 h-5 hover:cursor-pointer">
                            </button>
                        </div>
                    </div>
                    <!-- cloudflare brooo -->
                    <div class="mb-7 flex justify-left">
                        <div class="cf-turnstile" data-sitekey="<?= TURNSTILE_SITE_KEY ?>"></div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full mt-4 bg-[#38C55C] text-white py-3 rounded-lg font-semibold hover:bg-green-600 hover:cursor-pointer transition duration-200 shadow-lg">
                    Daftar - Explore Ruangan Sekarang
                </button>
            </form>

            <!-- Login Link -->
                <div class="mt-6 text-sm">
                    <span class="text-gray-600">Sudah punya akun? </span>
                    <a href="/auth/formLogin" class="text-blue-600 hover:underline font-medium">Login</a>
                </div>
        </div>

        <!-- **************************************************
        INI POPUP MODAL DAFTAR BERHASIL
        ******************************************************* -->
        <div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-[#38C55C] text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Daftar Berhasil</h3>
                <p class="text-sm text-gray-600 mb-6">Tunggu approval dari admin dan selalau cek email kamu untuk mendapatkan informasi terbaru</p>
                <button onclick="window.location.href = '../Ruangan/index.php';" 
                        class="w-full px-6 py-3 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer">
                    Kembali ke halaman Login
                </button>
            </div>
        </div>
    </div>

    <script src="/js/togglePassword.js" defer></script>