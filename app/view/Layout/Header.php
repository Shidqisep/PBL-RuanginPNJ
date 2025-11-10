<?php Flasher::Flash();

// Dapatkan nama file yang sedang dieksekusi (misalnya 'index.php')
$current_page_file = basename($_SERVER['PHP_SELF']);

// Tentukan apakah halaman ini adalah halaman 'Ruangan' (Dashboard)
// Asumsi: Dashboard/Ruangan dijalankan dari 'index.php' di view directory-nya
$is_dashboard_active = ($current_page_file === 'index.php');

// Definisikan set kelas untuk keadaan aktif dan tidak aktif
$dashboard_classes = $is_dashboard_active ? 
    'bg-[#1E68FB] text-white px-6 py-1.5 rounded-full font-medium hover:bg-blue-700 transition duration-200' : 
    'text-[#171E29] hover:text-[#1E68FB] font-medium px-6 py-1.5'; 
    // Catatan: Kelas inaktif harus disesuaikan agar cocok dengan link lainnya

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Dashboard</title>
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen font-sf-pro">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-0.5 mx-5">
                    <img src="/img/LOGO PNJ FIX 1.png" alt="Logo" class="w-10 h-10 mr-3">
                    <h1 class="text-xl font-bold text-[#171E29]">ruanginPNJ</h1>
                </div>

                <div class="hidden md:flex items-center space-x-20 mx-10">
                    <a href="/Dashboard" class="bg-[#1E68FB] text-white px-6 py-1.5 rounded-full font-medium hover:bg-blue-700 transition duration-200">
                        Ruangan
                    </a>
                    <a href="/History" class="text-[#171E29] hover:text-gray-800 font-medium">
                        History
                    </a>
                    <a href="../Akun/index.php" class="text-[#171E29] hover:text-gray-800 font-medium">
                        Akun
                    </a>
                </div>

                <button id="hamburger-btn" class="p-2 rounded-md text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <div class="flex flex-col space-y-2 px-6 mt-4">
                    <a href="#" class="bg-[#1E68FB] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-blue-700 transition duration-200">
                        Ruangan
                    </a>
                    <a href="/History" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 hover:bg-gray-100 rounded-lg text-center">
                        History
                    </a>
                    <a href="../Akun/index.php" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 hover:bg-gray-100 rounded-lg text-center">
                        Akun
                    </a>
                </div>
            </div>
        </div>
    </nav>

<script>
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    hamburgerBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');

    
    const icon = hamburgerBtn.querySelector('svg');
    if (mobileMenu.classList.contains('hidden')) {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
    } else {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
    }

    });
</script>

    <section>