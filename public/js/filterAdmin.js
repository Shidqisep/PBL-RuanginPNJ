// public/js/filter.js

// === 1. LOGIKA UTAMA DROPDOWN (TOGGLE) - [TETAP SAMA] ===
function toggleDropdown(dropdownId) {
    const dropdownMenu = document.getElementById(dropdownId);
    if (!dropdownMenu) return;

    const container = dropdownMenu.closest('.filter-dropdown-container');
    const toggleBtn = container ? container.querySelector('.filter-dropdown-toggle') : null;
    const arrow = container ? container.querySelector('.filter-dropdown-arrow') : null;

    if (dropdownMenu.classList.contains('hidden')) {
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

// === 2. LOGIKA STATE (CHECKBOX DAN HIDDEN INPUT) - [TETAP SAMA] ===
function toggleFilter(filterName, value, labelId, defaultLabel) {
    const hiddenInput = document.getElementById(filterName);
    const labelElement = document.getElementById(labelId);
    if (!hiddenInput || !labelElement) return;

    let values = hiddenInput.value.split(',').filter(v => v !== '');
    const index = values.indexOf(value);

    if (index > -1) {
        values.splice(index, 1); // Hapus
    } else {
        values.push(value);      // Tambah
    }

    hiddenInput.value = values.join(',');
    updateButtonLabel(labelElement, values, defaultLabel);
}

function updateButtonLabel(labelElement, values, defaultLabel) {
    const count = values.length;
    if (count > 0) {
        labelElement.textContent = `${count} Filter Aktif`;
    } else {
        labelElement.textContent = defaultLabel;
    }
}

// === 3. LOGIKA APPLY FILTER (DIGANTI JADI SCOPED) ===
// Dulu: applyFilters() -> Global
// Sekarang: applyScopedFilters() -> Spesifik per container
function applyScopedFilters(scopeContainer, scopeKeys) {
    const params = new URLSearchParams(window.location.search);

    // Reset Page ke 1 setiap kali filter diterapkan
    params.set('page', 1);

    // Hapus parameter lama HANYA yang menjadi tanggung jawab scope ini
    // (Misal: Hapus 'Jurusan' tapi jangan hapus 'Tahun' peminjaman)
    if (scopeKeys && scopeKeys.length > 0) {
        scopeKeys.forEach(key => params.delete(key));
    }

    // Ambil input HANYA yang ada di dalam scopeContainer (Form/Div pembungkus)
    const inputs = scopeContainer.querySelectorAll('input[type="hidden"], input[type="text"]');

    inputs.forEach(input => {
        if (input.name) {
            const val = input.value.trim();
            if (val !== '') {
                params.set(input.name, val);
            }
        }
    });

    const newUrl = window.location.origin + window.location.pathname + '?' + params.toString();
    window.location.href = newUrl;
}

// === 4. EVENT LISTENER & TOMBOL ACTION ===
document.addEventListener('DOMContentLoaded', () => {
    
    // A. Inisialisasi Label & Checkbox saat Load (Agar tetap tercentang setelah refresh) - [TETAP SAMA]
    document.querySelectorAll('.filter-dropdown-container').forEach(container => {
        const filterName = container.getAttribute('data-filter-id');
        const defaultLabel = container.getAttribute('data-default-label');
        
        const hiddenInput = document.getElementById(filterName);
        const labelElement = document.getElementById(filterName + '_label');
        
        if (hiddenInput && labelElement) {
             const currentValues = hiddenInput.value.split(',').filter(v => v !== '');
             updateButtonLabel(labelElement, currentValues, defaultLabel);
             
             currentValues.forEach(val => {
                // Sanitasi ID agar sesuai dengan format ID di HTML
                const safeVal = val.toLowerCase().replace(/[^a-z0-9]/g, '_');
                const checkboxId = filterName + '_' + safeVal;
                const checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.checked = true;
                }
             });
        }
    });

    // B. Klik di luar menutup dropdown (animasi)
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

    // C. LOGIKA TOMBOL FILTER (CHECK <-> CROSS) - [DIPERBARUI JADI MULTIPLE & SCOPED]
    (function() {
        const buttons = document.querySelectorAll('.filter-action-btn');
        if (buttons.length === 0) return;

        function updateSingleButton(btn) {
            const iconContainer = btn.querySelector('.filter-action-icon');
            const textContainer = btn.querySelector('.filter-action-text');
            
            // 1. Cari Parent Container terdekat (Kandang Scope)
            // Pastikan di HTML ada <div class="filter-scope"> atau <form>
            const scopeContainer = btn.closest('.filter-scope') || btn.closest('form');
            
            if (!scopeContainer) {
                // Fallback jika lupa kasih container, anggap body (global)
                // console.warn("Filter button tidak punya parent .filter-scope atau form");
            }

            // 2. Ambil daftar filter dari atribut data-filter-list tombol
            const rawList = btn.getAttribute('data-filter-list') || '';
            const scopeFilters = rawList.split(',').map(s => s.trim()).filter(s => s !== '');

            // Cek apakah URL saat ini mengandung filter milik scope ini
            function isScopeActive() {
                const params = new URLSearchParams(window.location.search);
                return scopeFilters.some(key => params.has(key) && params.get(key) !== '');
            }

            const active = isScopeActive();
            
            // Ambil atribut visual
            const checkHTML = iconContainer ? (iconContainer.getAttribute('data-check') || '') : '';
            const crossHTML = iconContainer ? (iconContainer.getAttribute('data-cross') || '') : '';
            const textCheck = textContainer ? (textContainer.getAttribute('data-text-check') || 'Terapkan') : '';
            const textCross = textContainer ? (textContainer.getAttribute('data-text-cross') || 'Reset') : '';

            if (active) {
                // MODE RESET (Merah)
                if (iconContainer) iconContainer.innerHTML = crossHTML;
                if (textContainer) textContainer.textContent = textCross;
                btn.classList.add('text-red1');
                
                btn.onclick = function(e) {
                    e.preventDefault();
                    // Hapus param URL khusus scope ini + page
                    const url = new URL(window.location.href);
                    [...scopeFilters, 'page'].forEach(p => url.searchParams.delete(p));
                    window.location.href = url.toString();
                };
            } else {
                // MODE TERAPKAN (Default)
                if (iconContainer) iconContainer.innerHTML = checkHTML;
                if (textContainer) textContainer.textContent = textCheck;
                btn.classList.remove('text-red1');

                btn.onclick = function(e) {
                    e.preventDefault();
                    // Panggil fungsi apply yang BARU dengan parameter container
                    // Jika scopeContainer null (tidak ketemu), gunakan document
                    applyScopedFilters(scopeContainer || document, scopeFilters);
                };
            }
        }

        function updateAll() { buttons.forEach(updateSingleButton); }
        
        // Jalankan saat load dan saat user tekan Back/Forward browser
        updateAll();
        window.addEventListener('popstate', updateAll);
    })();
});

// === 5. EXPORT DATA (OPSIONAL) - [TETAP SAMA] ===
function exportData(baseUrl, mode) {
    const currentParams = new URLSearchParams(window.location.search);
    currentParams.delete('page'); 
    currentParams.delete('tab'); 
    
    if (mode) {
        currentParams.set('mode', mode);
    }

    const finalUrl = `${baseUrl}?${currentParams.toString()}`;
    window.open(finalUrl, '_blank');
}