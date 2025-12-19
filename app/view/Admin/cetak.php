<?php
// --- 1. PREPARASI DATA DI VIEW ---
$isExcel = (isset($data['mode']) && $data['mode'] == 'excel');

// Helper sederhana untuk nama bulan
$listBulan = [
    '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', 
    '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', 
    '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];

// Pastikan bulan & tahun selalu array
$bulan = $data['selected_bulan'];
$tahun = $data['selected_tahun'];

if (!is_array($bulan)) {
    $bulan = $bulan !== '' ? explode(',', $bulan) : [];
}

if (!is_array($tahun)) {
    $tahun = $tahun !== '' ? explode(',', $tahun) : [];
}

// =======================
// 1. Jika bulan kosong -> tampilkan tahun saja
// =======================
if (empty($bulan)) {

    // Jika tahun banyak
    if (count($tahun) > 1) {
        $periodeLabel = "Tahun " . implode(', ', $tahun);
    } else {
        $periodeLabel = "Tahun " . $tahun[0];
    }

} else {

    // =======================
    // 2. Bulan ada → buat list nama bulan
    // =======================
    $namaBulan = [];

    foreach ($bulan as $b) {
        if (isset($listBulan[$b])) {
            $namaBulan[] = $listBulan[$b];
        }
    }

    $textBulan = implode(', ', $namaBulan);

    // =======================
    // 3. Tahun → join jika banyak
    // =======================
    if (count($tahun) > 1) {
        $textTahun = implode(', ', $tahun);
    } else {
        $textTahun = $tahun[0];
    }

    // =======================
    // 4. Gabungkan
    // =======================
    $periodeLabel = $textBulan . ' - Tahun ' . $textTahun;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        /* Reset dasar */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        /* Styling Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        /* Judul Laporan */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2, .header h3, .header h4 {
            margin: 5px 0;
        }

        /* Helper Warna Status */
        .status-success { color: green; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
        .status-rejected { color: red; font-weight: bold; }

        /* Aturan Print */
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
            .no-print {
                display: none;
            }
        }
        
        /* CSS Khusus Excel: Paksa border hitam */
        <?php if ($isExcel): ?>
            table, th, td { border: 1px solid black; }
        <?php endif; ?>
    </style>
</head>

<body <?php if (!$isExcel) echo 'onload="window.print()"'; ?>>

    <div class="header">
        <h2>LAPORAN DATA PEMINJAMAN RUANGAN</h2>
        <h3>Politeknik Negeri Jakarta</h3>
        
        <h4>Periode: <?= $periodeLabel; ?></h4>
        
        <p style="font-size: 10px;">Tanggal Cetak: <?= date('d-m-Y') ?></p>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Peminjam</th>
                <th>Ruangan</th>
                <th>Jam Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Tanggal Peminjaman</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['laporan'])) : ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data peminjaman pada periode ini.</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; ?>
                <?php foreach ($data['laporan'] as $row) : ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++; ?></td>
                        <td><?= $row['nama_penanggung_jawab']; ?></td>
                        <td><?= $row['nama_ruangan']; ?></td>
                        
                        <td style="mso-number-format:'\@'"><?= waktu_indonesia($row['start_time']) ?></td>
                        <td style="mso-number-format:'\@'"><?= waktu_indonesia($row['end_time']) ?></td>
                        
                        <td><?= tanggal_indonesia($row['start_time']) ?></td>
                        <td style="text-align: center;">
                            <?= translateStatus($row['status']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!$isExcel): ?>
        <div class="no-print" style="margin-top: 20px;">
            <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer;">Kembali</button>
        </div>
    <?php endif; ?>

</body>
</html>