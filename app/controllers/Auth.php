<?php

use App\services\AuthServices;

class Auth extends Controller {

    public function registerForm(){
        $this->view('Auth/register');
        $this->view('Layout/Footer');
    }

    public function index(){
        $this->view('Auth/login');
        $this->view('Layout/Footer');
    }

    public function formLogin(){
    $this->view('Auth/login');
    $this->view('Layout/Footer');
    }

    public function handleRegister(){
        try {

            if ($_POST['password'] != $_POST['confirmPassword']) {
                throw new Exception('Password tidak sama');
            }

            if (isset($_FILES['buktiKubaca'])) {
                $buktiKubaca = uploadImage($_FILES['buktiKubaca'], 'storage/FotoBukti/');
            } else {
                throw new Exception('Mohon upload files');
            }


            $data = [
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                'nomor_induk' => $_POST['nomor_induk'],
                'email' => $_POST['email'],
                'jurusan' => $_POST['jurusan'],
                'fotobukti' => $buktiKubaca,
                'suspend_count' => 0,
                'now' => date('Y-m-d H:i:s')
            ];

            if ($this->model('UserModel')->findUserByEmailorNomor_Induk($data['email'], $data['nomor_induk'])) {
                throw new Exception('Email atau NIM sudah terdaftar!');
            }
            

            $result = $this->model('UserModel')->createUser($data);
            if ($result <= 0) {
                throw new Exception('Something Went Wrong');
            }

            header('Location: /auth/pending');
            exit;

        } catch (\Exception $e ) {
            $error = $e->getMessage();
            Flasher::setFlash($error, 'Gagal Registrasi', 'danger');
            header('Location: /auth/registerForm');
            exit;
        }
    }

    public function handleLogin(){
        try{
            $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
            ];
        $user = $this->model('UserModel')->findUserByEmail($data['email']);

        if (!$user) {
            throw new Exception('Email Salah');
        }

        if (!password_verify($data['password'], $user['password'])) {
            throw new Exception('Password Salah');
        }

        if ($user['status'] !== 'active') {
            throw new Exception('Akun anda belum AKtif!');
        }

        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['email'] = $user['email'];


        Flasher::setFlash('Berhasil', 'login', 'success');
        if ($user['role'] === 'admin') {
            header('location: /admin');
            exit;
        }else{
        header('location: /dashboard');
        }
        exit;
        } catch(\Exception $e) {
             Flasher::setFlash($e->getMessage(), 'Gagal login', 'danger');
            header('Location: /auth/formLogin');
            exit;
        }
    }

    public function handleLogout(){
        session_unset();
        session_destroy();
        header('location: /auth/formLogin');
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

    public function forgetPassword(){

    }

    public function pending(){
        $this->view('Auth/pending');
        $this->view('Layout/Footer');
    }
}