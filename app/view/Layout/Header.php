<?php Flasher::Flash();
// Logika untuk menentukan Controller/Halaman aktif
$url = isset($_GET['url']) ? $_GET['url'] : '';
$urlSegments = explode('/', rtrim(filter_var($url, FILTER_SANITIZE_URL), '/'));
// $lastSegment = end($urlSegments);

// Ambil segmen pertama sebagai nama Controller
// Jika kosong, default ke 'Home' atau 'Dashboard' tergantung flow aplikasi
// Di sini kita asumsikan Controller aktif adalah segmen pertama, dikapitalisasi
$activeController = !empty($urlSegments[0]) ? ucfirst($urlSegments[0]) : 'Dashboard';

// Definisikan kelas CSS untuk link aktif dan tidak aktif (desktop)
$activeClass = 'bg-[#1E68FB] text-white px-6 py-1.5 rounded-full font-medium hover:bg-blue-700 transition duration-200';
$inactiveClass = 'text-[#171E29] hover:text-gray-800 font-medium';

// Definisikan kelas CSS untuk link aktif dan tidak aktif (mobile)
$activeClassMobile = 'bg-[#1E68FB] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-blue-700 transition duration-200';
$inactiveClassMobile = 'text-gray-600 hover:text-gray-800 font-medium px-4 py-2 hover:bg-gray-100 rounded-lg text-center';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>RuanginPNJ - <?= $judul; ?></title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body class="bg-[#F3F5FA] min-h-screen font-sf-pro">

    <nav class="bg-[#F3F5FA] shadow-sm sticky top-0 z-50">
        <div class="mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-0.5 mx-5">
                    <img src="/img/LOGO PNJ FIX 1.png" alt="Logo" class="w-10 h-10 mr-3">
                    <h1 class="text-xl font-bold text-[#171E29]">ruanginPNJ</h1>
                </div>

                <div class="hidden md:flex items-center space-x-20 mx-10">
                    <a href="/Dashboard" class="<?php echo ($activeController == 'Dashboard') ? $activeClass : $inactiveClass; ?>">
                        Ruangan
                    </a>
                    <a href="/History" class="<?php echo ($activeController == 'History') ? $activeClass : $inactiveClass; ?>">
                        Histori
                    </a>
                    <a href="/Akun" class="<?php echo ($activeController == 'Akun') ? $activeClass : $inactiveClass; ?>">
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
                    <a href="/Dashboard" class="<?php echo ($activeController == 'Dashboard') ? $activeClass : $inactiveClass; ?>">
                        Ruangan
                    </a>
                    <a href="/History" class="<?php echo ($activeController == 'History') ? $activeClass : $inactiveClass; ?>">
                        Histori
                    </a>
                    <a href="/Akun" class="<?php echo ($activeController == 'Akun') ? $activeClass : $inactiveClass; ?>">
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