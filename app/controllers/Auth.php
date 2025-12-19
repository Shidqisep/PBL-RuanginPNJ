<?php


class Auth extends Controller {

    public function __construct()
    {
        $this->preventCache();
    }

    public function index(){
        //biar ga bisa back

        // if(isset($_SESSION['user'])){
        //     header('location: /dashboard');
        //     exit;
        // }

        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];

            switch ($role) {
                case 'Superadmin':
                    header('location: /admin');
                    break;
                case 'Admin':
                    header('location: /admin');
                    break;
                default:
                    header('location: /dashboard');
                    break;
            }
        }
        unset($_SESSION['regisRole']);
        $this->view('Auth/login');
    }

    // public function registerForm(){
    //     $this->view('Auth/register/index');
    //     $this->view('Layout/Footer');
    // }

    public function registerForms(){

        if (isset($_POST['backToRole'])) {
            unset($_SESSION['regisRole']);
            unset($_SESSION['input']);
        }

        if (isset($_POST['role'])) {
            $data['role'] =  $_POST['role'];
        }

        $forms = $_POST['role'] ?? null;
        switch ($forms) {
            case "3":
                $data['dataProdi'] = getProdi();
                $this->view('Auth/register/registerMahasiswa', $data);

                break;
            case "4":
                $this->view('Auth/register/registerDosen', $data);

                break;
            case "5":
                $this->view('Auth/register/registerTendik', $data);

                break;
            default:
                $this->view('Auth/register/index');
            
                break;
            }
    }

    // public function 

    // public function registerMahasiswa(){
    //     $this->view('Auth/register/registerMahasiswa');
    //     $this->view('Layout/Footer');
    // }

    // public function registerDosen(){
    //     $this->view('Auth/register/registerDosen');
    //     $this->view('Layout/Footer');
    // }

    // public function registerTendik(){
    //     $this->view('Auth/register/registerTendik');
    //     $this->view('Layout/Footer');
    // }

    //belum bisa jangan dipake
    public function handleRegister(){
        try {

             //Cek apakah token dikirim dari form
            // if (!isset($_POST['cf-turnstile-response'])) {
            //     throw new Exception('Mohon selesaikan verifikasi keamanan (CAPTCHA).');
            // }

            // // Persiapkan data untuk verifikasi ke Cloudflare
            // $turnstileResponse = $_POST['cf-turnstile-response'];
            // $remoteIp = $_SERVER['REMOTE_ADDR'];
            // $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
            
            // $data = [
            //     'secret' => TURNSTILE_SECRET_KEY,
            //     'response' => $turnstileResponse,
            //     'remoteip' => $remoteIp
            // ];

            // // Kirim request verifikasi menggunakan cURL
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // curl_close($ch);    

            // // Cek hasil verifikasi
            // $result = json_decode($response);
            
            // if (!$result || !$result->success) {
            //     throw new Exception('Verifikasi keamanan gagal. Silakan coba lagi.');
            // }

            $_SESSION['input'] = $_POST;
            // var_dump($_SESSION['input']);
            // die();

            if ($_POST['password'] != $_POST['confirmPassword']) {
                throw new Exception('Password tidak sama');
            }

            if (!validatePassword($_POST['password'])) {
                throw new Exception('Password minimal 6 huruf dan 1 angka');
            }

            if (!validateNIM($_POST['nomor_induk'])) {
                throw new Exception('NIM hanya boleh berisi angka');
            }

            $role = $_POST['role'] ?? null;
            if (!$role) {
                throw new Exception('Role tidak ditemukan, silakan ulangi proses registrasi.');
            }

            if ($_POST['role'] === '3') {
            // Validasi email hanya untuk mahasiswa
                if (!validateEmail($_POST['email'])) {
                    throw new Exception('Email tidak valid');
                }

                $expiredDate = countExpiredAt($_POST['email'], $_POST['prodi']);

                // Upload bukti hanya untuk mahasiswa
                if (isset($_FILES['buktiKubaca']) && $_FILES['buktiKubaca']['error'] === 0) {

                    $buktiKubaca = uploadImage($_FILES['buktiKubaca'], 'storage/FotoBukti/');
                    if (!$buktiKubaca) {
                        throw new Exception('Error mengupload File');
                    }
                } else {
                    throw new Exception('Mohon upload file bukti');
                }
            } else {
                if (!validateEmailPHP($_POST['email'])) {
                    throw new Exception('email tidak valid');
                }
            }
            $data = [
                'id_role' => $_POST['role'],
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                'nomor_induk' => $_POST['nomor_induk'],
                'email' => $_POST['email'],
                'jurusan_unit' => $_POST['jurusan_unit'],
                'prodi' => $_POST['prodi'] ?? NULL,
                'status' => 'pending',
                'kubaca_photo' => $buktiKubaca ?? NULL,
                'profile_photo' => 'DefaultProfilePicture.jpg',
                'suspend_count' => 0,
                'email_verified' => true,
                'expired_at' => $expiredDate ?? NULL,
                'now' => date('Y-m-d H:i:s')
            ];

           $existingUser = $this->model('UserModel')->findUserByEmailorNomor_Induk($data['email'], $data['nomor_induk']);

            if ($existingUser) {
                // 2. Jika user ada, CEK STATUSNYA
                if ($existingUser['status'] === 'rejected') {
                    
                    // KASUS: User pernah daftar tapi ditolak.
                    
                    // Tambahkan ID user lama ke array data agar model tahu siapa yang diupdate
                    $data['id_user'] = $existingUser['id_user']; 

                    // Panggil fungsi update khusus
                    $result = $this->model('UserModel')->resubmitRejectedUser($data);
                    
                    if ($result <= 0) {
                         throw new Exception('Gagal memperbarui data pendaftaran.');
                    }
                } else {
                    // KASUS: User ada dan statusnya 'pending', 'active', atau 'banned'
                    // SOLUSI: Lempar error seperti biasa
                    throw new Exception('Email atau NIM sudah terdaftar dan sedang diproses/aktif!');
                }

            } else {
                // 3. Jika user BELUM ada, buat baru (INSERT)
                $result = $this->model('UserModel')->createUser($data);
                
                if ($result <= 0) {
                    throw new Exception('Something Went Wrong');
                }
            }
            
            unset($_SESSION['input']);
            header('Location: /auth/pending');
            exit;

        } catch (\Exception $e ) {
            Flasher::setModalInfo( 'Gagal Registrasi',$e->getMessage(), 'error');
            header('Location: /auth/registerForms');
            exit;
        }
    }

    public function handleLogin(){
        try{

            // //Cek apakah token dikirim dari form
            // if (!isset($_POST['cf-turnstile-response'])) {
            //     throw new Exception('Mohon selesaikan verifikasi keamanan (CAPTCHA).');
            // }

            // // Persiapkan data untuk verifikasi ke Cloudflare
            // $turnstileResponse = $_POST['cf-turnstile-response'];
            // $remoteIp = $_SERVER['REMOTE_ADDR'];
            // $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
            
            // $data = [
            //     'secret' => TURNSTILE_SECRET_KEY,
            //     'response' => $turnstileResponse,
            //     'remoteip' => $remoteIp
            // ];

            // // Kirim request verifikasi menggunakan cURL
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // curl_close($ch);    

            // // Cek hasil verifikasi
            // $result = json_decode($response);
            
            // if (!$result || !$result->success) {
            //     throw new Exception('Verifikasi keamanan gagal. Silakan coba lagi.');
            // }

            $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
            ];
        $user = $this->model('UserModel')->findUserAndRoleByEmail($data['email']);

        if (!$user) {
            throw new Exception('Email Salah');
        }

        if (!password_verify($data['password'], $user['password'])) {
            throw new Exception('Password Salah');
        }

        if ($user['status'] === 'suspended') {
            throw new Exception('Akun anda tersuspend! hubungi admin');
        }

        if ($user['status'] !== 'active') {
            throw new Exception('Akun anda belum Aktif!');
        }

        if ($user['suspend_count'] >= 3){
            throw new Exception('Akun anda sedang di suspend, silahkan hubungi admin!');
        }

        if ($user['expired_at'] !== null) {
            $now = new DateTime();
            $expired = new DateTime($user['expired_at']);

            if ($now > $expired) {
                throw new Exception('Akun anda sudah expired, silahkan hubungi admin');
            }
        }

        $_SESSION['user'] = [
            'user_id' => $user['id_user'],
            'username' => $user['username'],
            'email' => $user['email'],
            'jurusan_unit' => $user['jurusan_unit'],
            'prodi' => $user['prodi'],
            'profile_photo' => $user['profile_photo'],
            'nomor_induk' => $user['nomor_induk']
        ];
        $_SESSION['role'] = $user['role'];

        if (isset($_POST['remember'])) {
            $email = $user['email'];
            $expired_time = time() + 86400 * 7; // 7 hari dari sekarang
            
            // Buat Payload (Data yang mau disimpan)
            // Kita gabung email dan waktu expire
            $payload = $email . '|' . $expired_time;
            
            // Buat Tanda Tangan (Signature)
            // Menggunakan HMAC-SHA256. Ini inti keamanannya.
            $signature = hash_hmac('sha256', $payload, APP_KEY);
            
            $cookieValue = base64_encode($email) . ':' . $expired_time . ':' . $signature;
            
            setcookie('ruangin_login', $cookieValue, $expired_time, "/", "", false, true);
        }

        generateCsrf();

        Flasher::setFlash('Berhasil', 'login', 'success');
        if ($user['role'] === 'Admin') {
            header('location: /admin');
            exit;
        } else if ($user['role'] === 'Superadmin'){
            header('Location: /admin');
            exit;
        }
        else{
        header('location: /dashboard');
        exit();
        }
        exit;
        } catch(\Exception $e) {
            Flasher::setModalInfo($e->getMessage(), 'gagal login', 'error');;
            header('Location: /auth/formLogin');
            exit;
        }
    }

        public function forgetPassword(){

        if (isset($_POST['email'])) {
            $user = $this->model('userModel')->findUserByEmail($_POST['email']);

            if (!$user) {
            Flasher::setFlash('Email tidak terdaftar', 'Coba lagi', 'error');
            header('location: /auth/forgetPassword');
                exit;
            }

            $_SESSION['reset_email'] = $user['email'];
            $_SESSION['name'] = $user['username'];
            $_SESSION['otp'] = generateOTP();
            $_SESSION['otp_expire'] = time() + 600;

            try{
            sendEmail($_SESSION['reset_email'], $_SESSION['name'], 'Silahkan ini otp anda, jangan bagikan ke siapapun', $_SESSION['otp']);
            header('location: /auth/verifyPassword');
            exit;   
            } catch(Exception $e){
            Flasher::setFlash($e->getMessage(), 'Gagal mengirim email', 'danger');
            header('Location: /auth/forgetPassword');
            exit;
            }
        }
        $this->view('Auth/forgetPassword');
    }

        public function resendOTP() {
        // die("Method resendOTP terpanggil!");
        // 1. Cek apakah ada email di session (artinya user memang sedang dalam proses reset)
        if (!isset($_SESSION['reset_email'])) {
            Flasher::setModalInfo('Sesi berakhir', 'Silakan masukkan email kembali', 'danger');
            header('Location: /auth/forgetPassword');
            exit;
        }

        // 2. (Opsional) Cek cooldown agar tidak spam (misal: hanya boleh resend tiap 60 detik)
        if (isset($_SESSION['last_otp_resend']) && (time() - $_SESSION['last_otp_resend'] < 60)) {
            Flasher::setModalInfo('Tunggu sebentar', 'Harap tunggu 60 detik sebelum mengirim ulang', 'warning');
            header('Location: /auth/verifyPassword');
            exit;
        }

        // 3. Generate OTP baru
        $_SESSION['otp'] = generateOTP();
        $_SESSION['otp_expire'] = time() + 600; // 10 menit
        $_SESSION['last_otp_resend'] = time(); // Simpan waktu kirim terakhir

        // 4. Kirim ulang email
        try {
            sendEmail($_SESSION['reset_email'], $_SESSION['name'], 'Ini adalah kode OTP baru anda', $_SESSION['otp']);
            Flasher::setModalInfo('OTP Berhasil dikirim ulang', 'Silakan cek email anda', 'success');
            header('Location: /auth/verifyPassword');
            exit;
        } catch (Exception $e) {
            Flasher::setModalInfo($e->getMessage(), 'Gagal mengirim email', 'error');
            header('Location: /auth/verifyPassword');
            exit;
        }
    }

    // ini buat lupa password ya bukan password biasa
    public function verifyPassword(){
        if (!isset($_SESSION['reset_email'])) {
            header('location: /auth/forgetPassword');
            exit;
        }
        if (isset($_POST['otp-1'])) {
            $otp =
                ($_POST['otp-1'] ?? '') .
                ($_POST['otp-2'] ?? '') .
                ($_POST['otp-3'] ?? '') .
                ($_POST['otp-4'] ?? '') .
                ($_POST['otp-5'] ?? '') . 
                ($_POST['otp-6'] ?? '');;

                if (time() > $_SESSION['otp_expire']) {
                    Flasher::setFlash('Kode OTP sudah kedaluwarsa', 'Silakan minta ulang', 'danger');
                    unset($_SESSION['reset_email'], $_SESSION['otp'], $_SESSION['otp_expire']);
                    header('Location: /auth/forgetPassword');
                    exit;
                }

                $sessionOTP = $_SESSION['otp'];
                if ($otp !== $sessionOTP) {
                Flasher::setFlash('OTP salah', 'Coba lagi', 'danger');
                header('Location: /auth/verifyPassword');
                exit;
            }
                    
                $_SESSION['reset_verified'] = true;

                unset($_SESSION['otp'], $_SESSION['otp_expire']);
                header('location: /auth/resetPassword');
                exit;
        }

        $this->view('auth/verifyOTP');
    }

    public function resetPassword(){
       if (!isset($_SESSION['reset_verified'])) {
            Flasher::setFlash('Forbidden', 'Coba lagi', 'danger');
            header('location: /auth/verifyPassword');
            exit;
            }

        if (isset($_POST['passwordBaru'])) {
            if ($_POST['passwordBaru'] !== $_POST['password']) {
                Flasher::setFlash('Password tidak sama', 'Coba lagi', 'danger');
                header('location: /auth/resetPassword');
                exit;
            }

            $data = [
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'email' => $_SESSION['reset_email']
            ];
            $result = $this->model('userModel')->updatePassword($data);

            if ($result) {
            // hapus session reset
            unset($_SESSION['reset_email'], $_SESSION['reset_verified'], $_SESSION['otp']);
            Flasher::setFlash('Berhasil', 'Ubah password', 'success');
            header('location: /auth/');
            exit;
            }else {
                Flasher::setFlash('Gagal', "Ubah Password", "danger");
                header('location: /auth/resetPassword');
                exit;
            }
        }

        $this->view('auth/resetPassword');
    }

    public function handleLogout(){
        // setcookie('ruangin_login', '', time() - 3600);
        session_unset();
        session_destroy();
        setcookie('ruangin_login', '', time() - 3600, '/');
        header('location: /auth/');
        exit;
    }

    public function captchaImage(){
        // Pastikan token sudah ada di session (dibuat oleh formLogin/index)
        if (!isset($_SESSION['captcha_token'])) {
             // Buat gambar darurat jika token tidak ada
             $image = imagecreate(150, 50);
             $bgColor = imagecolorallocate($image, 255, 255, 255); // Putih
             $textColor = imagecolorallocate($image, 255, 0, 0); // Merah
             imagestring($image, 5, 10, 15, "ERROR", $textColor);
             header('Content-Type: image/png');
             imagepng($image);
             imagedestroy($image);
             exit;
        }

        $token = $_SESSION['captcha_token'];

        // 1. Buat kanvas gambar
        $image = imagecreate(150, 50); // Lebar 150, Tinggi 50

        // 2. Tentukan warna
        $bgColor = imagecolorallocate($image, 240, 240, 240); // Abu-abu muda
        $textColor = imagecolorallocate($image, 30, 30, 30); // Hitam/Abu tua
        $lineColor = imagecolorallocate($image, 200, 200, 200); // Garis acak

        // 3. (Opsional) Tambah garis-garis acak (noise)
        for ($i = 0; $i < 3; $i++) {
            imageline($image, 0, rand(0, 50), 150, rand(0, 50), $lineColor);
        }

        // 4. Tulis teks token ke gambar
        // (Kita pakai font bawaan PHP, angka 5 itu ukuran fontnya)
        imagestring($image, 5, 40, 15, $token, $textColor);

        // 5. Kirim gambar ke browser
        header('Content-Type: image/png');
        imagepng($image);

        // 6. Bersihkan memori
        imagedestroy($image);
        exit; // Penting, agar tidak ada output lain
    }

    public function pending(){
        $this->view('Auth/pending');
    }
}