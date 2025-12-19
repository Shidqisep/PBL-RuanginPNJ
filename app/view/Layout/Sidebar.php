
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>RuanginPNJ - <?= $data['judul']; ?></title>
    <link href="/css/output.css" rel="stylesheet">
    <link href="js/script.js" rel="script">
</head>
<body class="bg-background1 font-sf-pro flex min-h-screen">

    <?php include __DIR__ . '/../template/iconComponent.php'; ?>
    <!-- SIDEBAR -->
    <aside class="w-56 bg-background2 shadow-lg flex flex-col h-screen sticky top-0 overflow-auto z-20">
        
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-dark-overlay2">
            <h1 class="text-xl font-bold text-dark-overlay">ruanginPNJ</h1>
        </div>

        <!-- Menu Utama -->
        <nav class="flex-1 px-4 py-6 space-y-1 pr-0">
        
            <!-- Dashboard (AKTIF) -->
            <a href="/Admin/index"
                class="flex items-center px-4 py-2 mb-4
                    <?= ($data['navbar'] === 'dashboard')
                ? 'text-blue-overlay8 border-r-4 border-blue-overlay font-medium'
                : 'text-gray-700 hover:bg-dark-overlay1 rounded-lg' ?>
                transition text-sm">
                <div>
                    <?= icon('dashboardAdmin', 'w-6 h-6 mr-3') ?>
                </div>
                Dashboard
            </a>

            <!-- Data Anggota -->
            <a href="/Admin/Anggota"
                class="flex items-center px-4 py-2 mb-4
                    <?= ($data['navbar'] === 'Anggota')
                ? 'text-blue-overlay8 border-r-4 border-blue-overlay font-medium'
                : 'text-gray-700 hover:bg-dark-overlay1 rounded-lg' ?>
                transition text-sm">
                <div>
                    <?= icon('usersAdmin', 'w-6 h-6 mr-3') ?>
                </div>
                Data Anggota
            </a>

            <!-- Data Peminjaman -->
            <a href="/Admin/Peminjaman"
                class="flex items-center px-4 py-2 mb-4
                    <?= ($data['navbar'] === 'Peminjaman')
                ? 'text-blue-overlay8 border-r-4 border-blue-overlay font-medium'
                : 'text-gray-700 hover:bg-dark-overlay1 rounded-lg' ?>
                transition text-sm">
                <div>
                    <?= icon('document', 'w-6 h-6 mr-3') ?>
                </div>
                Data Peminjaman
            </a>

            <!-- Data Ruangan -->
            <a href="/Admin/Ruangan"
                class="flex items-center px-4 py-2 mb-4
                    <?= ($data['navbar'] === 'Ruangan')
                ? 'text-blue-overlay8 border-r-4 border-blue-overlay font-medium'
                : 'text-gray-700 hover:bg-dark-overlay1 rounded-lg' ?>
                transition text-sm">
                <div>
                    <?= icon('book', 'w-6 h-6 mr-3') ?>
                </div>
                Data Ruangan    
            </a>

            <!-- Data Ruangan -->
            <a href="/Admin/Feedback"
                class="flex items-center px-4 py-2 mb-4
                    <?= ($data['navbar'] === 'Feedback')
                ? 'text-blue-overlay8 border-r-4 border-blue-overlay font-medium'
                : 'text-gray-700 hover:bg-dark-overlay1 rounded-lg' ?>
                transition text-sm">
                <div>
                    <?= icon('starFill', 'w-6 h-6 mr-3') ?>
                </div>
                Data Feedback  
            </a>

            <?php if ($_SESSION['role'] === 'Superadmin'): ?>
            <!-- Supeer Admin -->
            <a href="/superAdmin"
                class="flex items-center px-4 py-2 mb-4
                    <?= ($data['navbar'] === 'superAdmin')
                ? 'text-blue-overlay8 border-r-4 border-blue-overlay font-medium'
                : 'text-gray-700 hover:bg-dark-overlay1 rounded-lg' ?>
                transition text-sm">
                <div>
                    <?= icon('shieldUser', 'w-6 h-6 mr-3') ?>
                </div>
                Data Admin
            </a>
            <?php endif; ?>

            <!-- Akun -->
            <a href="/Admin/Akun"
                class="flex items-center px-4 py-2 mb-4
                    <?= ($data['navbar'] === 'Akun')
                    ? 'text-blue-overlay8 border-r-4 border-blue-overlay font-medium'
                : 'text-gray-700 hover:bg-dark-overlay1 rounded-lg' ?>
                    transition text-sm">
                <div>
                    <?= icon('userAdmin', 'w-6 h-6 mr-3') ?>
                </div>
                Akun
            </a>

        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-dark-overlay2">
            <a href="#" onclick="konfirmasiLogout()" class="flex items-center px-4 py-2 mb- text-dark-overlay hover:bg-dark-overlay1 rounded-lg transition text-xs font-medium">
                <div>
                    <?= icon('logout', 'w-6 h-6 mr-3') ?>
                </div>
                Logout
            </a>
        </div>
    </aside>

    <?php include __DIR__ . '/../template/modal.php'; ?>
    <script src="/js/modal.js"></script>
    <script>
    function konfirmasiLogout() {
        Modal.confirm(
            'Logout',
            'Apakah anda yakin ingin logout?',
            function() {
                window.location.href = '/auth/handleLogout';
            },
            {
                icon: '/icon/logoutDashboard.svg',
                confirmText: 'Logout',
                confirmClass: 'w-full px-6 py-2 bg-red1 text-white rounded-lg font-semibold hover:bg-red-800 transition hover:cursor-pointer',
                cancelText: 'Batalkan'
            }
        );
    }
    </script>