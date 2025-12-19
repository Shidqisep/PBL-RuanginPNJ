<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>RuanginPNJ - Registrasi</title>
    <link href="/css/output.css" rel="stylesheet">

</head>
<body class="font-sf-pro" >
    
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center p-4"
         style="background-image: url('/img/Background 1.png');">

        <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-lg">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="text-3xl font-bold text-dark-overlay mb-2">Registrasi Akun</h1>
                <p class="text-sm text-gray-600">Pilih role yang sesuai</p>
            </div>

            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="grid gap-4">
                    <!-- role -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sebagai apa</label>
                        <select name="role" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected hidden>Pilih Role</option>
                            <option value="3">Mahasiswa</option>
                            <option value="4">Dosen</option>
                            <option value="5">Tenaga Kependidikan</option>
                        </select>
                    </div>

                    <!-- Login Link -->
                    <div class="mt-2 text-sm">
                        <span class="text-gray-600">Sudah punya akun? </span>
                        <a href="/auth/formLogin" class="text-blue-600 hover:underline font-medium">Login</a>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                            class="w-full bg-[#38C55C] text-white font-medium px-4 py-2 rounded-lg hover:bg-green-600 transition duration-150 hover:cursor-pointer">
                            Lanjut
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>