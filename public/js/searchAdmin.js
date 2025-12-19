document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-search');

    // Cek apakah elemen ditemukan (untuk menghindari error)
    if (searchInput && clearBtn) {

        // Fungsi: Cek apakah tombol silang harus muncul?
        function checkVisibility() {
            if (searchInput.value && searchInput.value.trim() !== '') {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        // 1. Jalankan SAAT HALAMAN DIMUAT (Penting agar tombol muncul jika ada value PHP)
        checkVisibility();

        // 2. Jalankan SAAT MENGETIK
        searchInput.addEventListener('input', checkVisibility);

        // 3. Jalankan SAAT KLIK CLEAR
        clearBtn.addEventListener('click', () => {
            // Hapus tulisan
            searchInput.value = '';
            
            // Sembunyikan tombol
            clearBtn.classList.add('hidden');
            
            // Balikin kursor ke input
            searchInput.focus();

            // PENTING: Karena kamu pakai <form>, kita harus reload halaman 
            // agar data tabel kembali normal (tidak terfilter).
            // Kalau baris bawah ini dihapus, tulisan hilang tapi data tabel tetap data hasil search.
            window.location.href = window.location.pathname;
        });
    } else {
        console.error("Elemen search-input atau clear-search tidak ditemukan. Cek ID di HTML.");
    }
});