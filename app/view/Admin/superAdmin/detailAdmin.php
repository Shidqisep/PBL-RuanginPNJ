<main class="flex-1 p-8 overflow-y-auto bg-background1">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm">
        <a href="/Admin/superAdmin" class="text-blue-overlay hover:text-blue-700">Data Admin</a>
            <span class="mx-2">
                <div class="text-dark-overlay6">
                    <?= icon('arrowRight', 'w-5 h-5') ?>
                </div>
            </span>
        <a href="/Admin/detailAdmin" class="text-dark-overlay6 hover:text-blue-700">Detail Admin</a>
    </nav>

    <!-- Header dengan Title dan Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-dark-overlay">Detail Admin iniloh</h2>
    </div>

    <div class="bg-background2 rounded-2xl w-full shadow-xl p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 justify-start items-start border border-dark-overlay7 p-4 rounded-md">
            <div class="border-dark-overlay7 py-4">  

                <p class="text-dark-overlay7 text-sm">Nama</p>
                <div class="max-w-3/6">
                    <h2 class="text-xl inline-block font-semibold pr-2 1y-1 text-dark-overlay rounded-lg mt-2">Lele</h2>
                </div>           
            </div>

            <div class="py-4">         
                <p class="text-dark-overlay7 text-sm">NIP</p>
                <div class="max-w-3/6">
                    <h2 class="text-lg inline-block pr-2 1y-1 text-dark-overlay rounded-lg mt-2">212312</h2>
                </div>           
            </div>

            <div class="py-4">         
                <p class="text-dark-overlay7 text-sm">Email</p>
                <div class="max-w-3/6">
                    <h2 class="text-lg inline-block pr-2 1y-1 text-dark-overlay rounded-lg mt-2">@stu,pnj.ac.id</h2>
                </div>           
            </div>

            <div class="py-4">
                <p class="text-dark-overlay7 text-sm">Status</p>

                <div class="relative inline-block mt-2">
                    <!-- Toggle button -->
                    <button id="statusToggle" type="button"
                        class="flex items-center gap-3 bg-white border border-dark-overlay5 rounded-lg py-2 px-3 shadow-sm hover:shadow-md transition focus:outline-none"
                        aria-haspopup="true" aria-expanded="false" onclick="toggleStatusDropdown()">
                        <span id="statusIcon" class="text-green1">
                            <?= icon('circleFill', 'w-4 h-4') ?>
                        </span>
                        <span id="statusLabel" class="text-sm font-semibold text-dark-overlay pl-1">Aktif</span>
                        <span class="ml-2 transform transition-transform duration-300" id="statusArrow">
                            <?= icon('arrowDown', 'w-4 h-4 text-dark-overlay6') ?>
                        </span>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="statusMenu" class="hidden absolute right-0 mt-2 w-40 bg-white border border-dark-overlay5 rounded-lg shadow-xl overflow-hidden z-30">
                        <button type="button" class="w-full text-left px-4 py-2 hover:bg-dark-overlay1 transition flex items-center gap-3"
                                onclick="selectStatus('Aktif')">
                            <span class="text-green1"><?= icon('circleFill', 'w-4 h-4') ?></span>
                            <span class="text-sm">Aktif</span>
                        </button>
                        <button type="button" class="w-full text-left px-4 py-2 hover:bg-dark-overlay1 transition flex items-center gap-3"
                                onclick="selectStatus('Nonaktif')">
                            <span class="text-red1"><?= icon('circleFill', 'w-4 h-4') ?></span>
                            <span class="text-sm">Nonaktif</span>
                        </button>
                        <button type="button" class="w-full text-left px-4 py-2 hover:bg-dark-overlay1 transition flex items-center gap-3"
                                onclick="selectStatus('Suspend')">
                            <span class="text-yellow-500"><?= icon('circleFill', 'w-4 h-4') ?></span>
                            <span class="text-sm">Suspend</span>
                        </button>
                    </div>

                    <input type="hidden" id="statusValue" name="status" value="Aktif">
                </div>
            </div>
        </div>


        <div class="flex flex-col sm:flex-row justify-between gap-8 mt-6">
                
            <button id="buttonNonAktif" class="flex-1 bg-red1 hover:bg-red-800 text-white font-semibold py-3 rounded-xl transition duration-150 shadow-md hover:cursor-pointer">
                Nonaktifkan
            </button>
            
            <button onclick="konfirmasiSuspend()" class="flex-1 bg-red1 hover:bg-red-800 text-white font-semibold py-3 rounded-xl transition duration-150 shadow-md hover:cursor-pointer">
                Suspend
            </button>
            
            <button id="buttonAktifkan" class="flex-1 bg-green1 hover:bg-green-600 text-white font-semibold py-3 rounded-xl transition duration-150 shadow-md hover:cursor-pointer">
                Aktifkan
            </button>
            
        </div>
    </div>
</main>

<script src="/js/modal.js" defer></script>
<script>

    const buttonAktifkan = document.getElementById('buttonAktifkan');
    const buttonNonAktif = document.getElementById('buttonNonAktif');
    if (buttonAktifkan) {
        buttonAktifkan.addEventListener('click', function () {document.getElementById('approveForm').submit();});
}


    function konfirmasiSuspend() {
        Modal.confirm(
            'Suspend Admin?',
            'Apakah yakin ingin suspend?',
            function() {
                document.getElementById('suspendForm').submit();
            },
            {
                icon: <?= json_encode(icon("suspend", "w-12 h-12 text-red1")) ?>,
                confirmText: 'Suspend',
                confirmClass: 'w-full px-6 py-2 bg-red1 text-white rounded-lg font-semibold hover:bg-red-800 transition hover:cursor-pointer',
                cancelText: 'Batalkan'
            }
        );
    }

    function konfirmasiNonAktif() {
        Modal.confirm(
            'Nonaktifkan Admin?',
            'Apakah yakin ingin Menonaktifkan Admin?',
            function() {
                document.getElementById('non-activateForm').submit();
            },
            {
                icon: <?= json_encode(icon("usersAdmin", "w-24 h-24 text-red1")) ?>,
                confirmText: 'NonAktifkan',
                confirmClass: 'w-full px-6 py-2 bg-red1 text-white rounded-lg font-semibold hover:bg-red-800 transition hover:cursor-pointer',
                cancelText: 'Batalkan'
            }
        );
    }

    if(buttonNonAktif) {
        buttonNonAktif.addEventListener('click', konfirmasiNonAktif);
    }

        // Status dropdown behavior
        function toggleStatusDropdown() {
            const menu = document.getElementById('statusMenu');
            const arrow = document.getElementById('statusArrow');
            const btn = document.getElementById('statusToggle');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                arrow.classList.add('rotate-180');
                if (btn) btn.setAttribute('aria-expanded','true');
            } else {
                menu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
                if (btn) btn.setAttribute('aria-expanded','false');
            }
        }

        function selectStatus(value) {
            const label = document.getElementById('statusLabel');
            const icon = document.getElementById('statusIcon');
            const hidden = document.getElementById('statusValue');
            const menu = document.getElementById('statusMenu');
            const arrow = document.getElementById('statusArrow');

            if (label) label.textContent = value;
            if (hidden) hidden.value = value;

            // update color class on icon/label
            if (icon) {
                icon.classList.remove('text-green1','text-red1','text-yellow-500');
                if (value === 'Aktif') icon.classList.add('text-green1');
                else if (value === 'Nonaktif') icon.classList.add('text-red1');
                else if (value === 'Suspend') icon.classList.add('text-yellow-500');
            }

            // close menu
            if (menu) menu.classList.add('hidden');
            if (arrow) arrow.classList.remove('rotate-180');
            const btn = document.getElementById('statusToggle');
            if (btn) btn.setAttribute('aria-expanded','false');
        }

        // Close status dropdown when clicking outside
        document.addEventListener('click', function(e){
            const container = e.target.closest && e.target.closest('div.relative');
            const menu = document.getElementById('statusMenu');
            const btn = document.getElementById('statusToggle');
            const arrow = document.getElementById('statusArrow');
            if (!menu || !btn) return;
            const isInside = e.target.closest && e.target.closest('#statusMenu, #statusToggle');
            if (!isInside) {
                menu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
                btn.setAttribute('aria-expanded','false');
            }
        });

</script>