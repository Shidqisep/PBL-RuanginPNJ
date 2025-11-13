<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ruanginPNJ - Dashboard</title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sf-pro">

    <!-- SIDEBAR -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg flex flex-col z-50">
        
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-gray-200">
        <h1 class="text-xl font-bold text-gray-800">ruanginPNJ</h1>
        </div>

        <!-- Menu Utama -->
        <nav class="flex-1 px-4 py-6 space-y-1">
        
        <!-- Dashboard (AKTIF) -->
        <a href="#" class="flex items-center px-4 py-3 text-blue-600 bg-blue-50 rounded-lg border-l-4 border-blue-600 font-medium">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        <!-- Data Anggota -->
        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Data Anggota
        </a>

        <!-- Data Ruangan -->
        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Data Ruangan
        </a>

        <!-- Akun -->
        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
            </svg>
            Akun
        </a>

        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-gray-200">
        <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg transition text-sm font-medium">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Logout
        </a>
        </div>
    </aside>

    