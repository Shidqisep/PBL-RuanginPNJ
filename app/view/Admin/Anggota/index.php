    <?php
    // Hanya untuk logika tab (tidak pakai database)
    $tab = $_GET['tab'] ?? 'semua';
    $tab = strtolower($tab); // normalisasi
    $valid_tabs = ['semua', 'approval'];
    if (!in_array($tab, $valid_tabs)) {
        $tab = 'semua';
    }

    function isActive($current, $check) {
        return $current === $check;
    }
    ?>

    
    <main class="flex-1 p-8 overflow-y-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-dark-overlay/60">
        <a href="/Admin/Anggota" class="text-gray-900 hover:text-[#1E68FB]">Data Anggota</a>
        <span class="mx-2">></span>
        <span class="font-medium">Daftar Anggota</span>
    </nav>

    <h2 class="text-xl font-bold text-[#171E29] mb-6">Daftar Anggota</h2>

    <!-- Tombol Tab + Search -->
    <div class="flex justify-between mb-6">
        <div class="flex justify-between items-center space-x-4">
            <a href="?tab=semua"
                class="px-4 py-2 rounded-full font-medium text-sm transition duration-200
                        <?= isActive($tab, 'semua') 
                            ? 'bg-[rgba(30,104,251,0.90)] text-white hover:bg-blue-600' 
                            : 'bg-white text-[#171E29] border border-gray-300 hover:bg-gray-100' ?>">
                Semua
            </a>
            <a href="?tab=approval"
                class="px-4 py-2 rounded-full font-medium text-sm transition duration-200
                        <?= isActive($tab, 'approval') 
                            ? 'bg-[rgba(30,104,251,0.90)] text-white hover:bg-blue-600' 
                            : 'bg-white text-[#171E29] border border-gray-300 hover:bg-gray-100' ?>">
                Approval
            </a>
        </div>

        <!-- Search -->
        <div class="relative max-w-sm w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" id="search-input" placeholder="Cari Anggota"
                   class="block w-full pl-10 pr-10 py-2.5 border border-[rgba(23,30,41,0.50)] rounded-lg 
                          bg-white text-gray-900 placeholder-gray-500 
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                          transition duration-150 ease-in-out text-sm">
            <button type="button" id="clear-search" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- TABEL – SEMUA DATA DARI HTML -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm">
        <table class="w-full text-sm border border-[#8E97A6] rounded-xl">
            <thead class="bg-[rgba(30,104,251,0.10)]">
                <tr>
                    <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70 rounded-tl-xl">No.</th>
                    <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70">Nama</th>
                    <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70">NIM</th>
                    <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70">Jurusan</th>
                    <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70">Tanggal Daftar</th>
                    <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70 rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">

                <?php if ($tab === 'semua'): ?>
                    <!-- ========== TAB SEMUA – DATA HTML ========== -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm">1</td>
                        <td class="px-4 py-3 text-center text-sm">Naqib Zuhair Al-Hudri</td>
                        <td class="px-4 py-3 text-center text-sm">2407411042</td>
                        <td class="px-4 py-3 text-center text-sm">Teknik Informatika & Komputer</td>
                        <td class="px-4 py-3 text-center text-sm">5 November 2025</td>
                        <td class="px-4 py-3 text-center">
                            <a href="/Admin/detailAnggota?tab=semua"
                               class="inline-flex items-center justify-center px-5 py-2 rounded-sm text-xs font-semibold
                                      bg-[linear-gradient(0deg,rgba(30,104,251,0.03)_0%,rgba(30,104,251,0.03)_100%),#FAFAFA]
                                      border border-[rgba(23,30,41,0.50)] shadow-md hover:bg-gray-100 transition">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm">1</td>
                        <td class="px-4 py-3 text-center text-sm">Naqib Zuhair Al-Hudri</td>
                        <td class="px-4 py-3 text-center text-sm">2407411042</td>
                        <td class="px-4 py-3 text-center text-sm">Teknik Informatika & Komputer</td>
                        <td class="px-4 py-3 text-center text-sm">5 November 2025</td>
                        <td class="px-4 py-3 text-center">
                            <a href="/Admin/detailAnggota?tab=semua"
                               class="inline-flex items-center justify-center px-5 py-2 rounded-sm text-xs font-semibold
                                      bg-[linear-gradient(0deg,rgba(30,104,251,0.03)_0%,rgba(30,104,251,0.03)_100%),#FAFAFA]
                                      border border-[rgba(23,30,41,0.50)] shadow-md hover:bg-gray-100 transition">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm">1</td>
                        <td class="px-4 py-3 text-center text-sm">Naqib Zuhair Al-Hudri</td>
                        <td class="px-4 py-3 text-center text-sm">2407411042</td>
                        <td class="px-4 py-3 text-center text-sm">Teknik Informatika & Komputer</td>
                        <td class="px-4 py-3 text-center text-sm">5 November 2025</td>
                        <td class="px-4 py-3 text-center">
                            <a href="/Admin/detailAnggota?tab=semua"
                               class="inline-flex items-center justify-center px-5 py-2 rounded-sm text-xs font-semibold
                                      bg-[linear-gradient(0deg,rgba(30,104,251,0.03)_0%,rgba(30,104,251,0.03)_100%),#FAFAFA]
                                      border border-[rgba(23,30,41,0.50)] shadow-md hover:bg-gray-100 transition">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>

                <?php else: ?>
                    <!-- ========== TAB APPROVAL – DATA HTML ========== -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm">1</td>
                        <td class="px-4 py-3 text-center text-sm">Naqib Zuhair Al-Hudri</td>
                        <td class="px-4 py-3 text-center text-sm">2407411042</td>
                        <td class="px-4 py-3 text-center text-sm">Teknik Informatika & Komputer</td>
                        <td class="px-4 py-3 text-center text-sm">5 November 2025</td>
                        <td class="px-4 py-3 text-center">
                            <a href="/Admin/Selesaikan"
                               class="inline-flex items-center justify-center px-5 py-2 rounded-sm text-xs font-semibold
                                      bg-[linear-gradient(0deg,rgba(30,104,251,0.03)_0%,rgba(30,104,251,0.03)_100%),#FAFAFA]
                                      border border-[rgba(23,30,41,0.50)] shadow-md hover:bg-gray-100 transition">
                                Selesaikan
                            </a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm">1</td>
                        <td class="px-4 py-3 text-center text-sm">Naqib Zuhair Al-Hudri</td>
                        <td class="px-4 py-3 text-center text-sm">2407411042</td>
                        <td class="px-4 py-3 text-center text-sm">Teknik Informatika & Komputer</td>
                        <td class="px-4 py-3 text-center text-sm">5 November 2025</td>
                        <td class="px-4 py-3 text-center">
                            <a href="/Admin/Selesaikan"
                               class="inline-flex items-center justify-center px-5 py-2 rounded-sm text-xs font-semibold
                                      bg-[linear-gradient(0deg,rgba(30,104,251,0.03)_0%,rgba(30,104,251,0.03)_100%),#FAFAFA]
                                      border border-[rgba(23,30,41,0.50)] shadow-md hover:bg-gray-100 transition">
                                Selesaikan
                            </a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm">1</td>
                        <td class="px-4 py-3 text-center text-sm">Naqib Zuhair Al-Hudri</td>
                        <td class="px-4 py-3 text-center text-sm">2407411042</td>
                        <td class="px-4 py-3 text-center text-sm">Teknik Informatika & Komputer</td>
                        <td class="px-4 py-3 text-center text-sm">5 November 2025</td>
                        <td class="px-4 py-3 text-center">
                            <a href="/Admin/Selesaikan"
                               class="inline-flex items-center justify-center px-5 py-2 rounded-sm text-xs font-semibold
                                      bg-[linear-gradient(0deg,rgba(30,104,251,0.03)_0%,rgba(30,104,251,0.03)_100%),#FAFAFA]
                                      border border-[rgba(23,30,41,0.50)] shadow-md hover:bg-gray-100 transition">
                                Selesaikan
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center gap-2 py-6 text-sm text-gray-600">
        <a href="?tab=<?= $tab ?>&page=1" class="px-3 py-1 border rounded hover:bg-gray-100">&lt;</a>
        <a href="?tab=<?= $tab ?>&page=1" class="px-3 py-1 bg-blue-100 text-blue-600 rounded font-medium">1</a>
        <a href="?tab=<?= $tab ?>&page=2" class="px-3 py-1 border rounded hover:bg-gray-100">2</a>
        <a href="?tab=<?= $tab ?>&page=3" class="px-3 py-1 border rounded hover:bg-gray-100">3</a>
        <span>...</span>
        <a href="?tab=<?= $tab ?>&page=8" class="px-3 py-1 border rounded hover:bg-gray-100">8</a>
        <a href="?tab=<?= $tab ?>&page=8" class="px-3 py-1 border rounded hover:bg-gray-100">&gt;</a>
        <span class="ml-4">Go to</span>
        <input type="text" class="w-12 mx-1 text-center border rounded" value="1">
        <span>Page</span>
    </div>
</main>

</body>
</html>


<script>
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-search');

    searchInput.addEventListener('input', () => {
        clearBtn.classList.toggle('hidden', searchInput.value === '');
    });

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        searchInput.focus();
        clearBtn.classList.add('hidden');
    });
</script>