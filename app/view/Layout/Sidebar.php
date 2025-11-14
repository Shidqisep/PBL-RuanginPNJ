<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>RuanginPNJ - <?= $data['judul']; ?></title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sf-pro flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-48 bg-[linear-gradient(0deg,rgba(30,104,251,0.02)0%,rgba(30,104,251,0.02)100%),#FFF] shadow-lg flex flex-col">
        
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-gray-200">
        <h1 class="text-xl font-bold text-gray-800">ruanginPNJ</h1>
        </div>

        <!-- Menu Utama -->
        <nav class="flex-1 px-4 py-6 space-y-1 pr-0">
        
            <!-- Dashboard (AKTIF) -->
            <a href="/Admin/index" class="flex items-center px-4 my-3 text-[rgba(30,104,251,0.80)] border-r-3 border-[#1E68FB] font-medium text-sm">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="10" rx="1" fill="currentcolor"/>
                    <rect x="14" y="3" width="7" height="6" rx="1" fill="currentcolor"/>
                    <rect x="3" y="17" width="7" height="6" rx="1" fill="currentcolor"/>
                    <rect x="14" y="13" width="7" height="10" rx="1" fill="currentcolor"/>
                </svg>
                Dashboard
            </a>

            <!-- Data Anggota -->
            <a href="/Admin/Anggota" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition text-xs">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Data Anggota
            </a>

            <!-- Data Ruangan -->
            <a href="/Admin/Ruangan" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition text-xs">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Data Ruangan
            </a>

            <!-- Akun -->
            <a href="/Admin/Akun" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition text-xs">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
                </svg>
                Akun
            </a>

        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-gray-200">
            <a href="/auth/handleLogout" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg transition text-xs font-medium">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </a>
        </div>
    </aside>

    