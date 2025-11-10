<?php
require __DIR__.'/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// use Dotenv\Dotenv;

// $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
// $dotenv->load();


/**
 * Fungsi untuk mengirim email
 *
 * @param string $toEmail Alamat email tujuan
 * @param string $toName Nama penerima
 * @param string $subject Judul email
 * @param string $body Isi email (bisa HTML atau teks)
 * @return bool True jika sukses, false jika gagal
 * @throws Exception Jika terjadi error PHPMailer
 */
function sendEmail($toEmail, $toName, $subject, $body) {
    
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->Port = (int)$_ENV['SMTP_PORT'];

        if (isset($_ENV['SMTP_AUTH']) && $_ENV['SMTP_AUTH'] === 'true') {
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            if (isset($_ENV['SMTP_SECURE']) && $_ENV['SMTP_SECURE'] === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
        } else {
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;
        }
        $fromEmail = !empty($_ENV['SMTP_USER']) ? $_ENV['SMTP_USER'] : 'no-reply@ruanginpnj.com';
        $mail->setFrom($fromEmail, 'Ruangin PNJ');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(false); // Asumsikan email adalah teks biasa
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Versi teks biasa

        $mail->send();
        return true;

    } catch (Exception $e) {
        // Sebaiknya di-log errornya, bukan di-echo
        error_log("Email Error: " . $mail->ErrorInfo);
        throw $e; // Lempar lagi errornya agar controller bisa tangkap
    }
}