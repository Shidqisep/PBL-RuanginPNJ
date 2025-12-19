<?php


function uploadImage(array $fileData, $targetDir, $compressQuality = 75, $maxWidth = 1200) : string{
    //Pastikan folder storage/FotoBukti/ ada
    //$uploadPath = __DIR__ . '/../../public/' . $targetDir; // Path relatif dari folder helper
    $uploadPath = dirname($_SERVER['DOCUMENT_ROOT']) . '/' . trim($targetDir, '/') . '/';

    // 1. Cek error bawaan PHP
    if ($fileData['error'] !== UPLOAD_ERR_OK) {
        throw new \Exception("Error saat mengupload file. Kode: " . $fileData['error']);
    }

    //Validasi Ukuran (contoh: maks 2MB)
    // $maxSize = 2 * 1024 * 1024; // 2MB
    // if ($fileData['size'] > $maxSize) {
    //     throw new \Exception("Ukuran file terlalu besar. Maksimal 2MB.");
    // }

    //Validasi Tipe File cek sampai ke mime
    $allowedTypes = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
    ];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $fileData['tmp_name']);
    finfo_close($fileInfo);

    $extension = array_search($mimeType, $allowedTypes, true);
    if ($extension === false) {
        throw new \Exception("Tipe file tidak diizinkan. Harap upload JPG atau PNG.");
    }

    //Buat nama file unik
    $fileName = 'fotobukti-' . uniqid() . '.' . $extension;
    $targetFile = $uploadPath . $fileName;

    //Pindahkan file ke $targetFile
list($width, $height) = getimagesize($fileData['tmp_name']);
    
    // Hitung rasio resize
    // Jika lebar asli > maxWidth (misal 1200px), kita kecilkan
    if ($width > $maxWidth) {
        $ratio = $maxWidth / $width;
        $newWidth = $maxWidth;
        $newHeight = $height * $ratio;
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    // Buat canvas gambar baru (kosong)
    $imageResource = imagecreatetruecolor($newWidth, $newHeight);
    
    // Load gambar sumber berdasarkan tipe
    switch ($mimeType) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($fileData['tmp_name']);
            break;
        case 'image/png':
            $source = imagecreatefrompng($fileData['tmp_name']);
            
            // Khusus PNG: Pertahankan transparansi
            imagealphablending($imageResource, false);
            imagesavealpha($imageResource, true);
            break;
        default:
            throw new \Exception("Format gambar tidak didukung untuk kompresi.");
    }

    // Copy dan Resize gambar sumber ke canvas baru
    // imagecopyresampled memberikan hasil resize lebih halus daripada imagecopyresized
    imagecopyresampled($imageResource, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Simpan file ke server
    $result = false;
    if ($mimeType == 'image/jpeg') {
        // Parameter ke-3 adalah Quality (0 - 100). 75 adalah sweet spot.
        $result = imagejpeg($imageResource, $targetFile, $compressQuality);
    } elseif ($mimeType == 'image/png') {
        // Parameter ke-3 adalah Compression Level (0 - 9). 
        // PNG tidak punya "quality" lossy di PHP Native, jadi kita pakai level kompresi max (9).
        // (Note: PNG biasanya tetap lebih besar dari JPG)
        $result = imagepng($imageResource, $targetFile, 9);
    }

    if ($result) {
        return $fileName;
    } else {
        throw new \Exception("Gagal mengompresi dan menyimpan file.");
    }
}

function uploadDocument(array $fileData, $targetDir) : string {
        // Tentukan path penyimpanan
        // Sesuaikan path ini dengan struktur folder project Anda
        // Contoh: C:/xampp/htdocs/project_anda/public/uploads/dokumen/
        $uploadPath = dirname($_SERVER['DOCUMENT_ROOT']) . '/' . trim($targetDir, '/') . '/';

        // Pastikan folder tujuan ada, jika tidak buat baru
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // 1. Cek error bawaan PHP
        // var_dump($fileData['error']);
        // exit;
        if ($fileData['error'] !== UPLOAD_ERR_OK) {
            switch ($fileData['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    throw new \Exception("File terlalu besar (melebihi upload_max_filesize di php.ini).");
                case UPLOAD_ERR_FORM_SIZE:
                    throw new \Exception("File terlalu besar (melebihi batas form).");
                case UPLOAD_ERR_PARTIAL:
                    throw new \Exception("File hanya terupload sebagian.");
                case UPLOAD_ERR_NO_FILE:
                    throw new \Exception("Tidak ada file yang diupload.");
                default:
                    throw new \Exception("Error upload tidak diketahui. Kode: " . $fileData['error']);
            }
        }

        // 2. Validasi Ukuran (Contoh: Maks 5MB untuk dokumen)
        $maxSize = 10 * 1024 * 1024; // 5MB
        if ($fileData['size'] > $maxSize) {
            throw new \Exception("Ukuran file terlalu besar. Maksimal 5MB.");
        }

        // 3. Validasi Tipe File (MIME Type Check)
        // Daftar MIME types yang aman untuk dokumen
        $allowedMimes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // Tambahkan jika perlu excel:
            // 'xls'  => 'application/vnd.ms-excel',
            // 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            // Tambahkan jika perlu gambar juga:
            'jpg'  => 'image/jpeg',
            'png'  => 'image/png',
        ];

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $fileData['tmp_name']);
        finfo_close($fileInfo);

        // Cari ekstensi berdasarkan mime type yang ditemukan
        $extension = array_search($mimeType, $allowedMimes, true);

        if ($extension === false) {
            throw new \Exception("Format file tidak didukung ($mimeType). Harap upload PDF atau Word.");
        }

        // 4. Buat nama file unik
        // Menggunakan 'dokumen-' sebagai prefix
        $fileName = 'dokumen-' . uniqid() . '.' . $extension;
        $targetFile = $uploadPath . $fileName;

        // 5. Pindahkan file
        if (move_uploaded_file($fileData['tmp_name'], $targetFile)) {
            return $fileName; // Success
        } else {
            throw new \Exception("Gagal memindahkan file ke folder tujuan.");
        }
    }

//yang ini kurang aman bisa di inject script
function uploadCover(){
    $namaFile = $_FILES['cover']['name'];
    $error = $_FILES['cover']['error'];
    $tmpName = $_FILES['cover']['tmp_name'];

    // Cek apakah tidak ada file yang diupload
    if ($error === 4) {
        return false; // atau bisa return false jika ingin wajib upload
    }

    // Cek ekstensi file
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiValid)){
        echo "<script>alert('File yang anda upload bukan gambar!!!')
        document.location.href='index.php';
        </script>;";
        return false;
    }
    // Generate nama file baru agar unik
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($tmpName, '../public/asset/' . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }   
    }