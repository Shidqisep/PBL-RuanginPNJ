<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center font-sf-pro" style="background-image: url('/img/Background 1.png'); background-color: rgba(139, 92, 113, 0.7); background-blend-mode: multiply;">
    <section>
    
    <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-lg mt-10">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-[#171E29] mb-2">Registrasi Akun</h1>
            <p class="text-sm text-gray-600">Temukan, pinjam, dan nikmati fasilitas favortimu dengan mudah.</p>
        </div>

        <!-- Form -->
        <form action="/auth/handleRegister" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-2 gap-4">
                <!-- Nama -->
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" name="username" placeholder="Input nama" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- NIM -->
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                    <input type="text" name="nomor_induk" placeholder="Input NIM" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Email PNJ -->
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email PNJ</label>
                    <input type="email" name="email" placeholder="Input email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Jurusan -->
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                    <select name="jurusan" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected hidden>Jurusan</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Teknik Elektro">Teknik Elektro</option>
                        <option value="Teknik Mesin">Teknik Mesin</option>
                        <option value="Teknik Sipil">Teknik Sipil</option>
                        <option value="Akuntansi">Akuntansi</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="button" onclick="togglePassword('password', 'toggleIcon1')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye hover:cursor-pointer" id="toggleIcon1"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" name="confirmPassword" placeholder="••••••••" id="confirmPassword"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="button" onclick="togglePassword('confirm_password', 'toggleIcon2')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye hover:cursor-pointer" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Upload Foto -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload foto bukti akun KabacaPNJ (Halaman profil)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition duration-200 cursor-pointer">
                    <input type="file" name="buktiKubaca" id="buktiKubaca" accept="image/*" class="hidden" onchange="previewFile()">
                    <label for="buktiKubaca" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600" id="fileName">Upload foto bukti kubaca</p>
                    </label>
                </div>
            </div>

            <!-- Login Link -->
            <div class="mt-6 text-sm">
                <span class="text-gray-600">Sudah punya akun? </span>
                <a href="/auth/formLogin" class="text-blue-600 hover:underline font-medium">Login</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full mt-6 bg-[#38C55C] text-white py-3 rounded-lg font-semibold hover:bg-green-600 hover:cursor-pointer transition duration-200 shadow-lg">
                Daftar - Explore Ruangan Sekarang
            </button>
        </form>
    </div>

    <div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
            <div class="mb-4">
                <i class="fas fa-check-circle text-green-500 text-5xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Daftar Berhasil</h3>
            <p class="text-sm text-gray-600 mb-6">Tunggu approval dari admin dan selalau cek email kamu untuk mendapatkan informasi terbaru</p>
            <button onclick="window.location.href = '../Ruangan/index.php';" 
                    class="w-full px-6 py-3 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer">
                Kembali ke halaman Login
            </button>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>