<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Ruangan</title>
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
            vertical-align: middle;
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
        .header h2, .header h3 {
            margin: 5px 0;
        }

        /* Styling Status Ruangan */
        .status-active { color: green; font-weight: bold; }
        .status-non-active { color: red; font-weight: bold; }
        .status-maintenance { color: orange; font-weight: bold; }

        /* Helper untuk Rating Bintang (Opsional text only) */
        .rating-score {
            font-weight: bold;
            color: #d35400;
        }

        /* Aturan Print: Kertas Landscape A4 */
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
            /* Hilangkan tombol cetak saat diprint */
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>LAPORAN ANGGOTA PERPUSTAKAAN</h2>
        <h3>Politeknik Negeri Jakarta</h3>
        <p>Tanggal Cetak: <?= date('d-m-Y') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama</th>
                <th width="15%">Peran</th>
                <th width="15%">Nomor Induk</th>
                <th width="15%">Jurusan</th>
                <th width="15%">Prodi</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            if (!empty($data['laporan'])) :
                foreach ($data['laporan'] as $row) : 
            ?>
                <tr>
                    <td style="text-align: center;"><?= $no++; ?></td>
                    <td>
                        <strong><?= $row['username']; ?></strong>
                    </td>
                    <td style="text-align: center;">
                        <?= $row['role_name'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $row['nomor_induk'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $row['jurusan_unit']; ?>
                    </td>
                    <td style="text-align: center;">
                        <span class="rating-score">
                            <?= htmlspecialchars($row['prodi'] ?? '-')?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <span> <?= translateStatus($row['status']) ?></span>
                    </td>
                </tr>
            <?php 
                endforeach; 
            else :
            ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data ruangan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px;">
        <button  onclick="window.location.href='/admin'" style="padding: 10px 20px; cursor: pointer;">Kembali</button>
    </div>

</body>
</html>