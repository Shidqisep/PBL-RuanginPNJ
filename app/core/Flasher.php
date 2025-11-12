<?php
class Flasher{

    public static function setFlash($pesan, $aksi, $tipe){
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi' => $aksi,
            'tipe' => $tipe
        ];
    }

    public static function flash(){
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        
        // Tentukan warna berdasarkan tipe
        $color = match($flash['tipe']) {
            'success' => 'bg-green-500 text-white',
            'danger' => 'bg-red-500 text-white',
            'warning' => 'bg-yellow-400 text-gray-900',
            'info' => 'bg-blue-500 text-white',
            default => 'bg-gray-500 text-white'
        };
    
        echo '
        <div id="flash-message" 
            class="fixed top-5 right-5 px-4 py-3 rounded-lg'.$color.' flex items-center gap-2 z-50">
            <span class="text-lg">⚡</span>
            <span>'.htmlspecialchars($flash['pesan']).' '.htmlspecialchars($flash['aksi']).'</span>
            <button class="ml-3 font-bold" onclick="this.parentElement.remove()">×</button>
        </div>';
        
        unset($_SESSION['flash']);
        }
    }
}