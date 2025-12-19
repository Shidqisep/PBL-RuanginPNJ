<?php 

function customExpiredDate($day, $month, $yearsToAdd = 4) {
    $year = date('Y') + $yearsToAdd;
    return sprintf('%04d-%02d-%02d 00:00:00', $year, $month, $day);
}

function countExpiredAt($email, $namaProdi) {
    $tahunMasuk = intval(date('Y')); // Default tahun sekarang jika gagal
    
    $atPos = strpos($email, '@');
    if ($atPos !== false && $atPos >= 2) {
        $username = substr($email, 0, $atPos); // ambil bagian sebelum '@'
        // ambil 2 digit terakhir dari username
        $duaDigitTahun = substr($username, -2);
        if (is_numeric($duaDigitTahun)) {
            $tahunMasuk = intval("20" . $duaDigitTahun);
        }
    }

    //cek berdasarkan jenjang di prodi
    $isD3 = false;
    if (stripos($namaProdi, 'D3') !== false) {
        $isD3 = true;
    }
    // D3 = 3 tahun, Selain itu (D4/S1) = 4 tahun
    $durasiTahun = $isD3 ? 3 : 4;

    //Hitung Tahun Lulus
    $tahunLulus = $tahunMasuk + $durasiTahun;

    //Susun Format Tanggal MySQL (YYYY-MM-DD HH:MM:SS)
    return "$tahunLulus-08-01 23:59:59";
}

function tanggal_indonesia($datetime) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
             'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $timestamp = strtotime($datetime);
    $day = date('j', $timestamp);
    $month = $bulan[(int)date('n', $timestamp)];
    $year = date('Y', $timestamp);

    return "$day $month $year";
}

function tanggal_indonesia_jam($datetime) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
             'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $timestamp = strtotime($datetime);
    $day = date('j', $timestamp);
    $month = $bulan[(int)date('n', $timestamp)];
    $year = date('Y', $timestamp);
    $time = date('H:i', $timestamp);

    return "$day $month $year, $time";
}

//ini buat ambil jamnya doang
function waktu_indonesia($datetime) {
    return date('H:i', strtotime($datetime));
}

//array lookup buat translate bulan
function monthTranslate($monthNumber) {
    $bulan = [
        1 => 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
             'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
    ];
    return $bulan[$monthNumber] ?? NULL;
}