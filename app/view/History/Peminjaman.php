<?php $tab = $_GET['tab'] ?? 'booking'; ?>

<main class="container mx-auto px-11 py-8 min-h-screen">
    <nav class="text-sm text-blue-600 mb-4">
        <a href="/History" class="hover:underline">History</a> > <span class="text-gray-800">Bookingan</span>
    </nav>

    <h1 class="text-3xl font-bold text-center mb-16">Bookingan Anda</h1>

    <div class="flex justify-center mb-6 flex-col">
        <div class="overflow-hidden w-full">
            <div class="flex border-b max-w-11/12 mx-auto border border-dark-overlay/70 rounded-t-xl overflow-hidden">
                <a href="?tab=booking" 
                class="flex-1 text-center py-3 font-medium transition <?= ($_GET['tab'] ?? 'booking') === 'booking' ? 'bg-[#1E68FB] text-white rounded-tl-xl' : 'bg-gray-100 text-dark-overlay/70 hover:bg-gray-200' ?>">
                    Booking
                </a>
                <a href="?tab=reschedule" 
                class="flex-1 text-center py-3 transition <?= ($_GET['tab'] ?? 'booking') === 'reschedule' ? 'bg-[#1E68FB] text-white rounded-tr-xl' : 'bg-gray-100 text-dark-overlay/70 hover:bg-gray-200' ?>">
                    Reschedule
                </a>
            </div>

                <?php if ($tab === 'booking'): ?>
                <!-- Booking Details -->
                <div class="w-full mx-auto bg-white rounded-xl shadow-sm p-6">
                    <div class="">
                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Nama Ruangan</p>
                            <h2 class="text-3xl font-semibold">Ruang Lentera Edukasi</h2>
                            <p class="text-gray-600 text-sm">Ruang bersih, tenang, dilengkapi wifi, cocok untuk belajar, rapat, dan aktivitas produktif.</p>
                        </div>
                        <div class="border-t border-dark-overlay/70 py-4">         
                            <p class="text-gray-900 text-sm">Tanggal Peminjaman</p>
                            <div class="max-w-1/6">
                                <h2 class="text-sm inline-block font-semibold px-2 1y-1 bg-black text-white rounded-lg mt-2">8 November 2025</h2>
                            </div>           
                        </div>
                        <div class="border-t border-dark-overlay/70 py-4">         
                            <p class="text-gray-900 text-sm">Jam Peminjaman</p>
                            <div class="max-w-1/6">
                                <h2 class="text-sm inline-block font-semibold px-2 1y-1 bg-black text-white rounded-lg mt-2">09:00 - 12:00</h2>
                            </div>           
                        </div>
                        <div class="border-t border-dark-overlay/70 py-4">
                            <p class="text-gray-900 text-sm">Jumlah Orang</p>
                            <h2 class="text-lg font-semibold">6 Orang</h2>     
                        </div>
                        <div class="border-t border-dark-overlay/70 py-4">         
                            <p class="text-gray-900 text-sm">Status</p>
                            <div class="max-w-1/6">
                                <h2 class="text-sm inline-block font-semibold py-2 px-5 bg-[#8D9198] text-white rounded-lg mt-2">Menunggu</h2>
                            </div>           
                        </div>
                        <div class="flex space-x-4 border-t border-dark-overlay/70 py-4">
                            <button class="bg-[#1E68FB] text-white px-6 py-2 rounded-sm text-sm hover:bg-blue-700 hover:cursor-pointer">
                                Reschedule
                            </button>
                            <button class="bg-[#C90B0B] text-white px-6 py-2 rounded-sm text-sm hover:bg-red-700 hover:cursor-pointer">
                                Cancel Booking
                            </button>
                        </div>
                    </div>
                </div>



                <?php else: ?>
                <!-- Tabel Reschedule -->
                <!-- <div class="p-8 text-center text-gray-500">
                    <p class="mb-2">Belum ada jadwal reschedule</p>
                    <button class="bg-[#1E68FB] text-white px-4 py-2 rounded-lg text-sm">+ Ajukan Reschedule</button>
                </div> -->

                <div id="desktop-table" class="md:block hidden overflow-x-auto bg-white rounded-t-xl">
                    <table class="w-full text-sm border-separate border-spacing-0 border border-[#8E97A6] rounded-t-xl">
                        <thead class="bg-[rgba(30,104,251,0.10)] rounded-t-xl">
                            <tr>
                                <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70 rounded-tl-xl">No.</th>
                                <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70">Tanggal</th>
                                <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70">Ruangan</th>
                                <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70">Jam</th>
                                <th class="px-4 py-3 text-center font-semibold text-dark-overlay/70 rounded-tr-xl">Status</th>
                            </tr>
                        </thead>
                        <tbody id="" class="divide-y divide-gray-500">

                            <!-- **************************************************
                            INI Data pERTAMA
                            ******************************************************* -->
                            <tr class="hover:bg-gray-50 transition border-b border-gray-300">
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">1</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">8 November 2025</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">Ruang Lentera Edukasi</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">09:00 - 12:00</td>
                                <td class="px-4 py-3 text-center justify-center flex border-b border-[#8E97A6]">
                                    <div
                                            class="flex bg-[#1E68FB] items-center justify-center text-white px-5 py-2 rounded-sm text-xs font-medium shadow-md min-w-1/2">
                                        <span>Pending</span>
                                    </div>
                                </td>
                            </tr>


                            <!-- **************************************************
                            INI Data KEDUA
                            ******************************************************* -->
                            <tr class="hover:bg-gray-50 transition border-b border-gray-300">
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">1</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">8 November 2025</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">Ruang Lentera Edukasi</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">09:00 - 12:00</td>
                                <td class="px-4 py-3 text-center justify-center flex border-b border-[#8E97A6]">
                                    <div
                                            class="flex bg-[#28CD41] items-center justify-center text-white px-5 py-2 rounded-sm text-xs font-medium shadow-md min-w-1/2">
                                        <span>Disetujui</span>
                                    </div>
                                </td>
                            </tr>


                            <!-- **************************************************
                            INI Data pERTAMA
                            ******************************************************* -->
                            <tr class="hover:bg-gray-50 transition border-b border-gray-300">
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">1</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">8 November 2025</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">Ruang Lentera Edukasi</td>
                                <td class="px-4 py-3 text-center text-sm border-b border-[#8E97A6]">09:00 - 12:00</td>
                                <td class="px-4 py-3 text-center justify-center flex border-b border-[#8E97A6]">
                                    <div
                                            class="flex bg-[#C90B0B] items-center justify-center text-white px-5 py-2 rounded-sm text-xs font-medium shadow-md min-w-1/2">
                                        <span>Ditolak</span>
                                    </div>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            

            
        </div>

        <div class="flex justify-center items-center gap-2 py-4 text-sm text-gray-600">
            <button class="px-2">&lt;</button>
            <button class="px-2 bg-blue-100 text-blue-600 rounded">1</button>
            <button class="px-2">2</button>
            <button class="px-2">3</button>
            <span>...</span>
            <button class="px-2">8</button>
            <button class="px-2">&gt;</button>
            <span class="ml-4">Go to</span>
            <input type="text" class="w-10 mx-1 text-center border rounded" value="1">
            <span>Page</span>
        </div>
    </div>
</main>