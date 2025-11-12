<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil</title>
    <link href="/css/output.css" rel="stylesheet">

</head>
<body class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center font-sf-pro" style="background-image: url('/img/Background 1.png'); background-color: rgba(139, 92, 113, 0.7); background-blend-mode: multiply;">


<div id="successModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
            <div class="mb-4">
                <i class="fas fa-check-circle text-green-500 text-5xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Daftar Berhasil</h3>
            <p class="text-sm text-gray-600 mb-6">Tunggu approval dari admin dan selalau cek email kamu untuk mendapatkan informasi terbaru</p>
            <button onclick="window.location.href = '/Auth/formLogin';" 
                    class="w-full px-6 py-3 bg-[#38C55C] text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer">
                Kembali ke halaman Login
            </button>
        </div>  
</div>