<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="font-sf-pro" >
    
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center"
         style="background-image: url('/img/Background 1.png'); 
             background-color: rgba(139, 92, 113, 0.7); background-blend-mode: multiply;">
 <div class="flex items-center justify-center w-fit h-fit max-w-lg my-8git"> 
        <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-lg">

            <!-- Links Row -->
                <div class="flex items-center mb-2 mt-1 text-sm lg:hidden md:hidden sm:hidden">
                    <i class="fas fa-arrow-left"></i>
                    <a href="/auth/formLogin" class="text-blue-600 hover:text-blue-800 hover:underline font-medium ml-2">Kembali ke Login</a>
                </div>

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#171E29] mb-2">Booking Ruang Rapat</h1>
                <p class="text-sm text-gray-600">Pinjam ruangan perpustakaan dengan mudah, praktis, dan cepat.</p>
            </div>

            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="grid gap-4">
                    <!-- Nama -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi</label>
                        <input type="text" name="instansi" placeholder="Nama instansi" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Email PNJ -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Perwakilan</label>
                        <input type="email" name="email" placeholder="Email perwakilan" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Jumlah orang -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah orang</label>
                        <input type="email" name="email" placeholder="Jumlah orang" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Upload Foto -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload surat peminjaman
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition duration-200 cursor-pointer">
                        <input type="file" name="Surat_Peminjaman" id="Surat_Peminjaman" class="hidden">
                        <label for="Surat_Peminjaman" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600" id="fileName">Upload surat peminjaman</p>
                        </label>
                    </div>
                </div>

                <!-- Links Row -->
                <div class="flex items-center mb-2 mt-4 text-sm hidden lg:flex md:flex sm:flex">
                    <i class="fas fa-arrow-left"></i>
                    <a href="/auth/formLogin" class="text-blue-600 hover:text-blue-800 hover:underline font-medium ml-2">Kembali ke Login</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full mt-3 bg-[#38C55C] text-white py-3 rounded-lg font-semibold hover:bg-green-600 hover:cursor-pointer transition duration-200 shadow-lg">
                    Booking
                </button>
            </form>
        </div>
    </div>
        <!-- **************************************************
        INI KONFIRMASI BOOKING DAN SUCCESS MODAL
        ******************************************************* -->
        <div id="confirmModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center">
                <div class="mb-4">
                    <i class="fas fa-calendar-check text-green-500 text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Booking</h3>
                <p class="text-sm text-gray-600 mb-6">Periksa kembali apakah data yang dimasukan sudah benar</p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" 
                            class="px-6 py-2 bg-white text-[#171E29] rounded-lg border font-semibold hover:bg-gray-300 transition hover:cursor-pointer text-sm">
                        Batalkan
                    </button>
                    <button type="button" 
                            class="px-6 py-2 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer text-sm">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>

        <!-- **************************************************
        INI POP UP SUCCESS MODAL
        ******************************************************* -->
        <div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Request Booking Berhasil</h3>
                <p class="text-sm text-gray-600 mb-6">Tunggu approval dari admin</p>
                <button type="button"
                        class="w-full px-6 py-3 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer text-sm">
                    OK
                </button>
            </div>
        </div>
    </div>