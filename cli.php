<?php
// shidqi migration gaming
require_once 'app/core/Database.php';
require_once 'app/core/Migration.php';
require_once 'app/core/Seeder.php';

// Cek argumen terminal (contoh: php cli.php migrate)
$command = $argv[1] ?? null;

require_once __DIR__ . '/vendor/autoload.php';
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

if ($command === 'migrate') {
    runMigrations();
} elseif ($command === 'migrate:fresh') {
    // INI PERINTAH BARUNYA
    echo "!!! PERINGATAN: Database akan dikosongkan !!!\n";
    dropAllTables(); // Hapus semua tabel
    echo "--------------------------------------\n";
    echo "Memulai migrasi ulang...\n";
    runMigrations(); // Jalankan migrasi dari nol
} elseif ($command === 'seed') {
    runSeeders();
} elseif ($command == 'bookings:autocancel') {
    runAutoCancel();
} elseif($command == 'bookings:autocomplete'){
    runAutoComplete();
}elseif($command == 'reminders:start'){
    startReminder();
} elseif($command == 'reminders:end'){
    endReminder();
} else {
    echo "Perintah tidak dikenal. Gunakan: \n";
    echo "php cli.php migrate \n";
    echo "php cli.php migrate:fresh  (Reset total database) \n"; 
    echo "php cli.php seed \n";
    echo "php cli.php bookings:autocancel (Membatalkan booking telat 10 menit) \n";
    echo "php cli.php bookings:autocomplete (Menyelesaikan booking yang sudah lewat) \n";
    echo 'php cli.php reminders:start (Kirim reminder booking yang akan mulai) \n';
    echo 'php cli.php reminders:end (Kirim reminder booking yang akan berakhir) \n';
}

function runMigrations() {
    $db = new Database();
    
    //tabel pelacak migrasi
    $query = "CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $db->query($query);
    $db->execute();

    //Ambil daftar migrasi yang sudah pernah jalan
    $db->query("SELECT migration FROM migrations");
    $existing = $db->resultSet();
    $executedMigrations = array_column($existing, 'migration');

    //Scan folder migrasi
    $files = scandir(__DIR__ . '/app/database/migrations');
    $files = array_filter($files, function($file) {
        return pathinfo($file, PATHINFO_EXTENSION) === 'php';
    });

    $count = 0;
    foreach ($files as $file) {
        if (in_array($file, $executedMigrations)) {
            continue; // Skip jika sudah pernah jalan
        }

        require_once __DIR__ . '/app/database/migrations/' . $file;
        
        //nama file migrasi ataupun seeder harus dengan format m_yyyymmdd_namatabel
        $className = pathinfo($file, PATHINFO_FILENAME);
        $className = convertToClassName($file);

        if (class_exists($className)) {
            echo "Migrating: $file ... ";
            $migration = new $className();
            $migration->up();
            
            // Catat ke database
            $db->query("INSERT INTO migrations (migration) VALUES (:mig)");
            $db->bind(':mig', $file);
            $db->execute();
            
            echo "DONE.\n";
            $count++;
        } else {
            echo "Error: Class '$className' tidak ditemukan di $file \n";
        }
    }

    if ($count == 0) {
        echo "Tidak ada migrasi baru.\n";
    }
}

function runSeeders() {
    // Scan folder seeder
    $files = scandir(__DIR__ . '/app/database/seeds');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;

        require_once __DIR__ . '/app/database/seeds/' . $file;
        $className = pathinfo($file, PATHINFO_FILENAME);

        if (class_exists($className)) {
            echo "Seeding: $className ... ";
            $seeder = new $className();
            $seeder->run();
            echo "DONE.\n";
        }
    }
}

// Helper untuk mengambil nama file 
function convertToClassName($filename) {
    // Hanya mengambil nama file tanpa ekstensi .php
    return pathinfo($filename, PATHINFO_FILENAME);
}

function dropAllTables() {
    $db = new Database();
    
    echo "Sedang menghapus semua tabel...\n";

    //Matikan Foreign Key Check biar tidak error constraint
    $db->query("SET FOREIGN_KEY_CHECKS = 0");
    $db->execute();

    //Ambil semua nama tabel di database
    $db->query("SHOW TABLES");
    $tables = $db->resultSet(); 

    foreach ($tables as $t) {
        // Trik mengambil value pertama dari array/object tanpa tahu nama key-nya
        // Biasanya key-nya 'Tables_in_nama_db'
        $tableName = array_values((array)$t)[0];

        $db->query("DROP TABLE IF EXISTS $tableName");
        $db->execute();
        echo "   -> DROPPED: $tableName\n";
    }

    $db->query("SET FOREIGN_KEY_CHECKS = 1");
    $db->execute();
    
    echo "Database bersih.\n";
}

function runAutoCancel() {
    // Kita perlu load modelnya manual karena ini CLI (bukan lewat index.php/Controller)
    require_once 'app/model/BookingModel.php';
    require_once 'app/model/UserModel.php';
    require_once 'app/model/RescheduleModel.php';


    $bookingModel = new BookingModel();
    $userModel = new UserModel();
    $rescheduleModel = new RescheduleModel();
    echo "Mengecek booking yang telat lebih dari 10 menit...\n";

    $lateBookings = $bookingModel->getLateBookings();
    
    if (empty($lateBookings)) {
        echo "Tidak ada booking yang perlu dibatalkan saat ini.\n";
        return;
    }
    
    $count = 0;
    foreach ($lateBookings as $booking) {
        $idBooking = $booking['id_booking'];
        $ketuaId = $booking['id_user'];
        
        echo "---------------------------------------------------\n";
        echo "Memproses Booking ID: $idBooking\n";

        // --- PROSES KUMPULKAN USER (KETUA + ANGGOTA) ---
        $usersToSuspend = [$ketuaId]; // Masukkan ketua

        // Ambil anggota dari tabel booking_members (Query 2)
        $members = $bookingModel->getBookingMembers($idBooking);
        foreach ($members as $m) {
            $usersToSuspend[] = $m['id_user'];
        }
        
        // // Hapus duplikat user (jika ketua masuk sebagai anggota juga)
        // $usersToSuspend = array_unique($usersToSuspend);

        // --- PROSES SUSPEND (Looping Query per User) ---
        foreach ($usersToSuspend as $uid) {
            // langsung suspend user
            // $userModel->nonActivateUser($uid); 
            
            //tambah count suspend
            $userModel->addSuspendCount($uid);

            echo "-> User ID $uid telah disuspend.\n";
        }

        // --- PROSES CANCEL BOOKING (Query Update Booking) ---
        $bookingModel->cancelBookingSystem($idBooking);
        
        // --- PROSES CANCEL RESCHEDULE (Query Update Reschedule - jika ada) ---
        $rescheduleModel->cancelRelatedReschedule($idBooking);

        echo "-> Status Booking & Reschedule diupdate ke cancelled.\n";
        $count++;
    }
    
    echo "---------------------------------------------------\n";
    echo "Selesai. Total $count booking dibatalkan & anggotanya disuspend.\n";
}

function runAutoComplete() {
    require_once 'app/model/BookingModel.php';
    
    $bookingModel = new BookingModel();
    echo "Mengecek booking yang sudah selesai (lewat end_time)...\n";
    
    $affected = $bookingModel->autoCompleteFinishedBookings();
    
    if ($affected > 0) {
        echo "Berhasil menandai $affected booking sebagai 'done'.\n";
    } else {
        echo "Tidak ada booking yang perlu diselesaikan saat ini.\n";
    }
}

function startReminder(){
    require_once 'app/model/ReminderModel.php';
    require_once 'app/helper/sendEmail.php';
    
    $reminderModel = new ReminderModel();
    echo "Mengecek booking yang akan dimulai dalam 10 menit...\n";
    
    $bookings = $reminderModel->getUpcomingBookings(10);

    if (empty($bookings)) {
        echo "Tidak ada booking yang akan dimulai sebentar lagi.\n";
        return;
    }
    
    foreach($bookings as $booking){
        $members = $reminderModel->getBookingMembers($booking['id_booking']);
        $sentEmails = [];

        // 1. KIRIM KE KETUA (Datanya sudah ada di $booking, tidak perlu query lagi)
        if (!empty($booking['email'])) {
            $to = $booking['email'];
            $username = $booking['username'];
            
            $subject = "Reminder: Peminjaman Ruangan Anda Akan Dimulai";
            $message = "Halo " . $username . ",\n\n".
                       "Booking ruangan yang Anda ajukan akan dimulai pada " . $booking['start_time'] . ".\n".
                       "Mohon pastikan ruangan digunakan sesuai jadwal.\n\n".
                       "Terima kasih.";
            
            try {
                sendEmail($to, $username, $subject, $message);
                echo "Reminder (Ketua) dikirim ke: " . $to . "\n";
                $sentEmails[] = $to; 
            } catch (Exception $e) {
                echo "Gagal kirim ke Ketua ($to): " . $e->getMessage() . "\n";
            }
        }

        //kirim email ke masing-masing anggota
        foreach($members as $member){
            $to = $member['email'];
            $subject = "Reminder: Peminjaman Ruangan Akan Dimulai";
            $message = "Halo " . $member['username'] . ",\n\n".
                       "Ini adalah pengingat bahwa booking ruangan tim Anda akan dimulai pada " . $booking['start_time'] . ".\n".
                       "Silakan bersiap-siap.\n\n".
                       "Terima kasih.";
            try {
            sendEmail($to, $member['username'], $subject, $message);
            echo "Reminder dikirim ke: " . $to . "\n";
            } catch (Exception $e) {
                echo "Gagal kirim ke Anggota ($to): " . $e->getMessage() . "\n";
            }
        }
        
        //update flag start_reminder jadi 1
        $reminderModel->markStartReminderSent($booking['id_booking']);
    }
}

function endReminder(){
    require_once 'app/model/ReminderModel.php';
    require_once 'app/helper/sendEmail.php';
    
    $reminderModel = new ReminderModel();
    echo "Mengecek booking yang akan berakhir dalam 10 menit...\n";
    
    $bookings = $reminderModel->getEndingBookings(10);

    if (empty($bookings)) {
        echo "Tidak ada booking yang akan selesai sebentar lagi.\n";
        return;
    }
    
    foreach($bookings as $booking){
        $members = $reminderModel->getBookingMembers($booking['id_booking']);

        if (!empty($booking['email'])) {
            $to = $booking['email'];
            $username = $booking['username'];
            
            $subject = "Reminder: Booking Room Anda Akan Berakhir";
            $message = "Halo " . $username . ",\n\n".
                       "Booking ruangan yang Anda ajukan akan berakhir pada " . $booking['end_time'] . ".\n".
                       "Mohon persiapkan diri untuk meninggalkan ruangan tersebut tepat waktu.\n\n".
                       "Terima kasih.";
            
            try {
                sendEmail($to, $username, $subject, $message);
                echo "Reminder (Ketua) dikirim ke: " . $to . "\n";
            } catch (Exception $e) {
                echo "Gagal kirim ke Ketua ($to): " . $e->getMessage() . "\n";
            };
        }
        
        //kirim email ke masing-masing anggota
        foreach($members as $member){
            $to = $member['email'];
            $subject = "Reminder: Booking Room Akan Berakhir";
            $message = "Halo " . $member['username'] . ",\n\n".
                       "Ini adalah pengingat bahwa booking ruangan Anda akan berakhir pada " . $booking['end_time'] . ".\n".
                       "Silakan persiapkan diri untuk meninggalkan ruangan tersebut tepat waktu.\n\n".
                       "Terima kasih.";
    
            try {
                sendEmail($to, $member['username'], $subject, $message);
                echo "Reminder dikirim ke: " . $to . "\n";
            } catch (Exception $e) {
                echo "Gagal kirim ke Anggota ($to): " . $e->getMessage() . "\n";
            };
        }
        
        //update flag end_reminder jadi 1
        $reminderModel->markEndReminderSent($booking['id_booking']);
    }
}

