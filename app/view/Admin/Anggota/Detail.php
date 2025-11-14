    <main class="flex-1 p-8 overflow-y-auto bg-[#F3F5FA]">
        <nav class="mb-6 text-sm text-dark-overlay/60">
            <a href="/Admin/Anggota" class="text-gray-900 hover:text-[#1E68FB]">Data Anggota</a>
            <span class="mx-2">></span>
            <a href="/Admin/Anggota" class="text-gray-900 hover:text-[#1E68FB]">Daftar Anggota</a>
            <span class="mx-2">></span>
            <span class="text-dark-overlay/60 font-medium hover:cursor-pointer">Detail Anggota</span>
        </nav>

        <h2 class="text-xl font-bold text-[#171E29] mb-6">Detail Anggota</h2>


        <div class="bg-[#F3F5FA] rounded-2xl w-full">
            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="grid gap-4">
                    <div class="mb-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <div class="relative">
                            <input type="Text" id="Nama" name="Nama" placeholder="Nama Lengkap" readonly
                                class="w-full bg-white px-4 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                        <div class="relative">
                            <input type="Text" id="NIM" name="NIM" placeholder="NIM" readonly
                                class="w-full bg-white px-4 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <input type="Email" id="Email" name="Email" placeholder="Email" readonly
                                class="w-full bg-white px-4 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                        <div class="relative">
                            <input type="Text" id="Jurusan" name="Jurusan" placeholder="Jurusan" readonly
                                class="w-full bg-white px-4 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Daftar</label>
                        <div class="relative">
                            <input type="Date" id="TanggalDaftar" name="Tanggal Daftar" placeholder="Tanggal Daftar" readonly
                                class="w-full bg-white px-4 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Suspend</label>
                        <div class="relative">
                            <input type="Number" id="JumlahSuspend" name="Jumlah Suspend" placeholder="Jumlah Suspend" readonly
                                class="w-full bg-white px-4 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-12 mt-2">
                        <button class="px-4 py-2 bg-[#C90B0B] text-white rounded-lg font-medium hover:bg-red-800 transition hover:cursor-pointer">Hapus Anggota</button>
                        <button class="px-4 py-2 bg-[#C90B0B] text-white rounded-lg font-medium hover:bg-red-800 transition hover:cursor-pointer">Suspend</button>
                    </div>
                </div>
            </form>
        
    </div>
    </main>