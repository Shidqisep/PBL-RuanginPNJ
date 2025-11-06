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
}