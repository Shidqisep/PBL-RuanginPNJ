<?php Flasher::Flash() ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title></title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

<!-- Header -->
    <navbar class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-building text-blue-600 text-2xl mr-2"></i>
                    <h1 class="text-xl font-bold text-gray-800">ruanginPNJ</h1>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                        Ruangan
                    </a>
                    <a href="../History/index.php" class="text-gray-600 hover:text-gray-800 font-medium">
                        History
                    </a>
                    <a href="../Akun/index.php" class="text-gray-600 hover:text-gray-800 font-medium">
                        Akun
                    </a>
                </div>

                <button id="hamburger-btn" class="md:hidden p-2 rounded-md text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-2 px-6">
                <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-blue-700 transition duration-200">
                    Ruangan
                </a>
                <a href="../History/index.php" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 hover:bg-gray-100 rounded-lg">
                    History
                </a>
                <a href="../Akun/index.php" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 hover:bg-gray-100 rounded-lg">
                    Akun
                </a>
            </div>
        </div>
    </navbar>

    <section>