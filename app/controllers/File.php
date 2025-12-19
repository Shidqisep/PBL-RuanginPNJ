<?php
class File extends Controller{

   public function showBukti($filename = '') {
        if (empty($filename)) {
            http_response_code(404);
            die('File tidak ditemukan');
        }

        $basePath = dirname($_SERVER['DOCUMENT_ROOT']) . '/storage/fotobukti/';
        $filePath = realpath($basePath . $filename);

        // Cek file valid dan dalam direktori yang diizinkan
        if ($filePath === false || strpos($filePath, $basePath) !== 0) {
            http_response_code(404);
            die('Akses ditolak atau file tidak ditemukan.');
        }

        if (!file_exists($filePath)) {
            http_response_code(404);
            die('File tidak ditemukan di server.');
        }

        // Tampilkan file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    }

    //ini buat ngambil foto
    public function showPhoto($filename = '', $basePath = '/storage/roomsImage') {
        if (empty($filename)) {
            http_response_code(404);
            die('File tidak ditemukan');
        }

        $basePath = dirname($_SERVER['DOCUMENT_ROOT']) . $basePath;
        $filePath = realpath($basePath . '/' . $filename);

        // Cek file valid dan dalam direktori yang diizinkan
        if ($filePath === false || strpos($filePath, $basePath) !== 0) {
            http_response_code(404);
            die('Akses ditolak atau file tidak ditemukan.');
        }

        if (!file_exists($filePath)) {
            http_response_code(404);
            die('File tidak ditemukan di server.');
        }

        $lastModified = filemtime($filePath);
        $etag = md5_file($filePath);
        $maxAge = 604800; // 7 hari dalam detik

        // Cek apakah browser sudah punya versi terbaru (Browser Validation)
        if ((isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified) ||
            (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag)) {
            header('HTTP/1.1 304 Not Modified');
            exit;
        }

        // Header untuk menginstruksikan browser menyimpan cache
        header("Cache-Control: public, max-age=$maxAge, must-revalidate");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s", $lastModified) . " GMT");
        header("Etag: $etag");
        header("Pragma: cache");
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + $maxAge) . " GMT");

        // Tampilkan file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        header('Content-Type: ' . $mimeType);   
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    }

    public function downloadDokumen($filename = '') {
        if (empty($filename)) {
            http_response_code(404);
            die('Nama file tidak valid.');
        }

        // 1. Tentukan folder penyimpanan DOKUMEN (sesuaikan path upload kamu)
        // Pastikan folder ini sejajar dengan 'fotobukti'
        $basePath = dirname($_SERVER['DOCUMENT_ROOT']) . '/storage/documents/'; 
        $filePath = realpath($basePath . $filename);

        // 2. SECURITY CHECK (Penting!)
        // Mencegah user akses file di luar folder dokumen (misal ../../config.php)
        if ($filePath === false || strpos($filePath, $basePath) !== 0) {
            http_response_code(403); // 403 Forbidden lebih tepat untuk akses ilegal
            die('Akses ditolak.');
        }

        if (!file_exists($filePath)) {
            http_response_code(404);
            die('File dokumen tidak ditemukan.');
        }

        // 3. Siapkan Header
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        // Ambil nama file bersih untuk didownload user
        $cleanName = basename($filePath);

        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        
        // PENTING: Header ini yang bikin browser memunculkan dialog "Save As" / Download
        // Kalau mau langsung buka di browser (misal PDF), ganti 'attachment' jadi 'inline'
        header('Content-Disposition: attachment; filename="' . $cleanName . '"');

        // Bersihkan output buffer biar file ga rusak
        if (ob_get_level()) ob_end_clean(); 
        readfile($filePath);
        exit;
    }
}