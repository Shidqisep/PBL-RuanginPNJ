// public/js/filter.js

// === 1. LOGIKA UTAMA DROPDOWN (TOGGLE) ===

/**
 * Mengubah visibilitas dropdown (menu opsi).
 * @param {string} dropdownId - ID unik dari elemen dropdown menu (misalnya: 'jenis_anggota_menu').
 */
function toggleDropdown(dropdownId) {
    const dropdownMenu = document.getElementById(dropdownId);
    if (!dropdownMenu) return;

    // find container and toggle button arrow
    const container = dropdownMenu.closest('.filter-dropdown-container');
    const toggleBtn = container ? container.querySelector('.filter-dropdown-toggle') : null;
    const arrow = container ? container.querySelector('.filter-dropdown-arrow') : null;

    // If hidden -> open with animation; else close with animation
    if (dropdownMenu.classList.contains('hidden')) {
        // Close other menus with animation
        document.querySelectorAll('.filter-dropdown-menu').forEach(menu => {
            if (menu.id !== dropdownId && !menu.classList.contains('hidden')) {
                const otherContainer = menu.closest('.filter-dropdown-container');
                const otherArrow = otherContainer ? otherContainer.querySelector('.filter-dropdown-arrow') : null;
                closeDropdown(menu, otherArrow);
            }
        });
        openDropdown(dropdownMenu, arrow);
        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
    } else {
        closeDropdown(dropdownMenu, arrow);
        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
    }
}

function openDropdown(menu, arrow) {
    menu.classList.remove('hidden');
    menu.style.overflow = 'hidden';
    menu.style.transition = 'max-height 260ms ease, opacity 200ms ease';
    menu.style.maxHeight = '0px';
    menu.style.opacity = '0';
    // force reflow
    // eslint-disable-next-line no-unused-expressions
    menu.offsetHeight;
    menu.style.maxHeight = menu.scrollHeight + 'px';
    menu.style.opacity = '1';
    if (arrow) arrow.classList.add('rotate-180');

    const cleanup = () => {
        menu.style.maxHeight = '';
        menu.style.opacity = '';
        menu.removeEventListener('transitionend', cleanup);
    };
    menu.addEventListener('transitionend', cleanup);
}

function closeDropdown(menu, arrow) {
    menu.style.maxHeight = menu.scrollHeight + 'px';
    // force reflow
    // eslint-disable-next-line no-unused-expressions
    menu.offsetHeight;
    menu.style.maxHeight = '0px';
    menu.style.opacity = '0';
    if (arrow) arrow.classList.remove('rotate-180');

    const onEnd = () => {
        menu.classList.add('hidden');
        menu.style.maxHeight = '';
        menu.style.opacity = '';
        menu.removeEventListener('transitionend', onEnd);
    };
    menu.addEventListener('transitionend', onEnd);
}

// === 2. LOGIKA STATE (CHECKBOX DAN HIDDEN INPUT) ===

/**
 * Logika untuk toggle checkbox, update hidden input, dan update label tombol.
 * @param {string} filterName - Nama filter (ID dari hidden input, e.g., 'jenis_anggota').
 * @param {string} value - Nilai yang dipilih/dihapus (e.g., 'Mahasiswa').
 * @param {string} labelId - ID dari elemen span label tombol (e.g., 'jenis_anggota_label').
 * @param {string} defaultLabel - Label default (e.g., 'Jenis Anggota').
 */
function toggleFilter(filterName, value, labelId, defaultLabel) {
    const hiddenInput = document.getElementById(filterName);
    const labelElement = document.getElementById(labelId);
    if (!hiddenInput || !labelElement) return;

    let values = hiddenInput.value.split(',').filter(v => v !== '');
    const index = values.indexOf(value);

    // Toggle nilai dalam array
    if (index > -1) {
        values.splice(index, 1); // Hapus (Uncheck)
    } else {
        values.push(value);      // Tambahkan (Check)
    }

    // Update hidden input
    hiddenInput.value = values.join(',');

    // Update label tombol
    updateButtonLabel(labelElement, values, defaultLabel);
    
    // PENTING: Panggil fungsi AJAX/Submit Form rekan Anda di sini
    // applyFilters(); 
    // from backend: no ajax no fetch fak yu
}

/**
 * Memperbarui teks pada tombol dropdown berdasarkan nilai yang dipilih.
 */
function updateButtonLabel(labelElement, values, defaultLabel) {
    const count = values.length;
    if (count > 0) {
        labelElement.textContent = `${count} Filter Aktif`;
    } else {
        labelElement.textContent = defaultLabel;
    }
}

function applyFilters() {
    const params = new URLSearchParams(window.location.search);

    const currentTab = params.get('tab');
    params.set('page', 1);

    const filterNames = ['status', 'jurusan', 'jenis', 'Status', 'Jurusan', 'Jenis', 'tab', 'Tahun', 'Bulan', 'Ruangan', 'ruangan', 'bulan', 'tahun', 'Prodi', 'Role'];

    // ambil semua hidden input filter
    document.querySelectorAll('input[type="hidden"]').forEach(input => {
            if (filterNames.includes(input.name)) {
                params.delete(input.name);
                // Hanya set jika ada isinya
                if (input.value.trim() !== '') {
                    params.set(input.name, input.value);
                }
            }
        });

    const searchInput = document.getElementById('search-input'); 
    if (searchInput) {
        params.delete('search'); // Hapus parameter search lama
        if (searchInput.value.trim() !== '') {
            params.set('search', searchInput.value.trim()); // Masukkan nilai baru
        }
    }

    // return;


    const newUrl = window.location.origin + window.location.pathname + '?' + params.toString();
    window.location.href = newUrl
}


// === 3. LOGIKA UNTUK MENJAGA STATE SETELAH REFRESH (OPSIONAL TAPI BAIK) ===
document.addEventListener('DOMContentLoaded', () => {
    // Cari semua hidden input yang merupakan filter dan inisialisasi label
    document.querySelectorAll('.filter-dropdown-container').forEach(container => {
        const filterName = container.getAttribute('data-filter-id');
        const defaultLabel = container.getAttribute('data-default-label');
        
        const hiddenInput = document.getElementById(filterName);
        const labelElement = document.getElementById(filterName + '_label');
        
        if (hiddenInput && labelElement) {
             const currentValues = hiddenInput.value.split(',').filter(v => v !== '');
             updateButtonLabel(labelElement, currentValues, defaultLabel);
             
             // Pastikan checkbox yang sesuai tercentang saat DOM dimuat
             currentValues.forEach(val => {
                const checkboxId = filterName + '_' + val.toLowerCase().replace(/[^a-z0-9]/g, '_');
                const checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.checked = true;
                }
             });
        }
        // Set initial aria-expanded and arrow rotation based on visibility
        const menu = container.querySelector('.filter-dropdown-menu');
        const btn = container.querySelector('.filter-dropdown-toggle');
        const arrow = container.querySelector('.filter-dropdown-arrow');
        if (btn) btn.setAttribute('aria-expanded', menu && !menu.classList.contains('hidden') ? 'true' : 'false');
        if (arrow) {
            if (menu && !menu.classList.contains('hidden')) arrow.classList.add('rotate-180');
            else arrow.classList.remove('rotate-180');
        }
    });

    // Event listener untuk menutup dropdown saat klik di luar (gunakan animasi)
    document.addEventListener('click', (event) => {
        let isDropdown = event.target.closest('.filter-dropdown-container');
        if (!isDropdown) {
            document.querySelectorAll('.filter-dropdown-menu').forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    const otherContainer = menu.closest('.filter-dropdown-container');
                    const otherArrow = otherContainer ? otherContainer.querySelector('.filter-dropdown-arrow') : null;
                    closeDropdown(menu, otherArrow);
                    const btn = otherContainer ? otherContainer.querySelector('.filter-dropdown-toggle') : null;
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });

    // === 4. FILTER ACTION BUTTON TOGGLE ICON (Check <-> Cross) ===
    (function() {
        const btn = document.getElementById('filter-action-btn');
        const iconContainer = document.getElementById('filter-action-icon');
        const textContainer = document.getElementById('filter-action-text');
        
        const form = document.getElementById('filterForm');

        if (!btn || !iconContainer) return;

        function filtersActiveFromURL() {
            const params = new URLSearchParams(window.location.search);
            for (const [k, v] of params) {
                if (v !== '' && k !== 'page' && k !== 'tab') return true;
            }
            return false;
        }

        function update() {
            const active = filtersActiveFromURL();
            const checkHTML = iconContainer.dataset.check || '';
            const crossHTML = iconContainer.dataset.cross || '';

            const textCheck = textContainer ? (textContainer.dataset.textCheck || 'Terapkan') : '';
            const textCross = textContainer ? (textContainer.dataset.textCross || 'Reset') : '';


            if (active) {
                // 🔴 MODE RESET
                if (crossHTML) iconContainer.innerHTML = crossHTML;
                if (textContainer) textContainer.textContent = textCross;

                btn.onclick = function(e) {
                    const url = new URL(window.location.href);
                    e.preventDefault();

                    // hapus semua filter kecuali search tertentu kalau mau
                    const filtersToDelete = ['page', 'jenis', 'Jenis', 'status', 'Status', 'jurusan', 'Jurusan', 'url', 'search', 'ruangan', 'bulan', 'tahun', 'Prodi', 'Role'];

                    //Loop array di atas dan hapus dari URL
                    filtersToDelete.forEach(p => url.searchParams.delete(p));
                    // reset URL tanpa query
                    window.location.href = url.toString();
                };
                btn.classList.remove('text-dark-overlay5');
                btn.classList.add('text-red1');
            } else {
                // show check and make button apply/submit filters
                if (checkHTML) iconContainer.innerHTML = checkHTML;
                if (textContainer) textContainer.textContent = textCheck;
                btn.onclick = function() {
                    applyFilters();
                };
                btn.classList.remove('text-red1');
                btn.classList.add('text-dark-overlay5');
            }
        }

        // Initial update and also watch for history changes (back/forward)
        update();
        window.addEventListener('popstate', update);
    })();
});

function exportData(baseUrl, mode) {
    // Ambil parameter URL saat ini dari browser
    const currentParams = new URLSearchParams(window.location.search);

    // Bersihkan parameter yang tidak perlu
    currentParams.delete('page'); 
    currentParams.delete('tab'); 
    
    // TAMBAHKAN MODE (Excel / Print)
    // Jika mode diisi, kita tambahkan ke parameter URL
    if (mode) {
        currentParams.set('mode', mode);
    }

    // Gabungkan Base URL dengan parameter
    const finalUrl = `${baseUrl}?${currentParams.toString()}`;

    // Buka di tab baru
    window.open(finalUrl, '_blank');
}