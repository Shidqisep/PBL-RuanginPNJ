<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="/Admin/superAdmin" class="text-dark-overlay6 hover:text-blue-700">Data Admin</a>
    </nav>

    <!-- Header dengan Title dan Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-dark-overlay">Data Admin</h2>

        <div class="flex justify-between items-center gap-8">
            <a href="/Superadmin/tambahAdmin"
                class="flex items-center gap-2 px-3 py-1.5 bg-blue-overlay hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition duration-200">
                Tambah Admin
                <div>
                    <?= icon('plus', 'w-4 h-4') ?>
                </div>
            </a>
        </div>
    </div>

    <form action="" method="GET">
    <div class="pb-2">
        <div class="relative max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <div class="text-dark-overlay7">
                    <?= icon('search', 'w-5 h-5') ?>
                </div>
            </div>
         
            <input type="text" id="search-input" placeholder="Cari Nama atau Email" name="keyword" id="search-input"
                value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>"
                class="block w-full pl-10 pr-10 py-2 border border-dark-overlay4 rounded-lg 
                        bg-white text-dark-overlay7 placeholder-dark-overlay7 text-sm
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                        transition duration-150">
            <button type="button" id="clear-search" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-dark-overlay7 hover:text-dark-overlay hidden">
                <div class="text-dark-overlay7">
                    <?= icon('cross', 'w-4 h-4 hover:cursor-pointer') ?>
                </div>
            </button>
            
        </div>
    </div>
    </form>


    <div class="rounded-lg shadow-sm border border-dark-overlay4 overflow-hidden mt-4">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-overlay1 border-b border-dark-overlay4">
                        <th class="px-4 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">No</th>
                        <th class="px-12 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Nama</th>
                        <th class="px-12 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">NIP</th>
                        <th class="px-12 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Email</th>
                        <th class="px-12 py-4 text-left text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Status</th>
                        <th class="px-12 py-4 text-center text-xs font-semibold text-dark-overlay7 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-dark-overlay4">
                    <?php $i = 1 ?>
                    <?php foreach ($data['admins'] as $admin): ?>
                    <tr class="hover:bg-gray-50 bg-white transition-colors duration-150">
                        <td class="px-4 py-4 text-xs font-medium text-dark-overlay"><?= $i ?></td>
                        <td class="px-12 py-4 text-xs font-medium text-dark-overlay"><?= $admin['username'] ?></td>
                        <td class="px-12 py-4 text-xs font-medium text-dark-overlay"><?= $admin['nomor_induk'] ?></td>
                        <td class="px-12 py-4 text-xs font-medium text-dark-overlay"><?= $admin['email'] ?></td>
                        <td class="px-12 py-4 text-xs font-medium text-dark-overlay"><?= translateStatus($admin['status']) ?></td>
                        
                        <td class="px-4 py-4 text-center">
                            <a href="/SuperAdmin/detailAdmin/<?= $admin['id_user'] ?>"
                                class="items-center gap-2 px-6 py-2 bg-blue-overlay hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition duration-200">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    <?php $i++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $query = $_GET;
        unset($query['page']); // reset page biar aman
        $baseUrl = http_build_query($query); ?>
        <?php if ($total_page >= 1): ?>
            
        <div class="flex items-center justify-center px-6 py-4 border-gray-200 mx-8">
            
            <div class="flex items-center gap-2">
                
            <!-- Previous -->
                <?php if ($current_page > 1): ?>
                    <a href="?<?= $baseUrl ?>&page=<?= $current_page - 1 ?>" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <button disabled class="p-2 text-gray-300 cursor-not-allowed rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                <?php endif; ?>

                <?php 
                    // 1. Tentukan range halaman yang mau ditampilkan
                    $range = [];
                    $delta = 1; // Jumlah halaman yang muncul di kiri-kanan halaman aktif

                    for ($i = 1; $i <= $total_page; $i++) {
                        // Kondisi ambil halaman:
                        // 1. Halaman pertama atau terakhir
                        // 2. Halaman saat ini
                        // 3. Halaman di sekitar halaman saat ini (sesuai delta)
                        if ($i == 1 || $i == $total_page || ($i >= $current_page - $delta && $i <= $current_page + $delta)) {
                            $range[] = $i;
                        }
                    }

                    // 2. Sisipkan titik-titik (...) jika ada lompatan halaman
                    $pages_to_show = [];
                    $l = null; // last page number processed

                    foreach ($range as $i) {
                        if ($l) {
                            if ($i - $l === 2) {
                                // Jika selisih cuma 2 (misal 1 dan 3), tampilkan angka 2 (jangan titik-titik)
                                $pages_to_show[] = $l + 1; 
                            } elseif ($i - $l > 1) {
                                // Jika selisih jauh, tampilkan titik-titik
                                $pages_to_show[] = '...'; 
                            }
                        }
                        $pages_to_show[] = $i;
                        $l = $i;
                    }
                    ?>

                    <?php foreach ($pages_to_show as $p) : ?>

                        <?php if ($p === '...') : ?>
                            <span class="px-2 py-2 text-sm text-dark-overlay6">...</span>
                        
                        <?php elseif ($p == $current_page) : ?>
                            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-overlay rounded-lg">
                                <?= $p; ?>
                            </button>
                        
                        <?php else : ?>
                            <a href="?<?= $baseUrl; ?>&page=<?= $p; ?>" class="px-4 py-2 text-sm font-medium text-dark-overlay hover:bg-dark-overlay1 rounded-lg transition-colors duration-150 block">
                                <?= $p; ?>
                            </a>
                        <?php endif; ?>

                    <?php endforeach; ?>

                <!-- Next -->
                <?php if ($current_page < $total_page): ?>
                    <a href="?<?= $baseUrl ?>&page=<?= $current_page + 1 ?>" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <button disabled class="p-2 text-gray-300 cursor-not-allowed rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                <?php endif; ?>
            <?php endif; ?>

            </div>
                    <form action="" method="GET" class="flex items-center gap-2 ml-4">
                        <?php foreach($query as $key => $val): ?>
                        <?php if ($key === 'Status') continue; ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($val) ?>">
                        <?php endforeach; ?>

                        <span class="text-sm text-gray-600">Go to</span>
                        <input type="number" name="page" min="1" max="<?= $total_page ?>" value="<?= $current_page ?>"
                            class="w-16 px-3 py-2 text-center text-sm border border-gray-300 rounded-lg">

                        <span class="text-sm text-gray-600">Page</span>
                        <button type="submit" class="hidden"></button>
                    </form>
                </div>
            </div>
    </div>
</main>

<script src="/js/searchAdmin.js"></script>