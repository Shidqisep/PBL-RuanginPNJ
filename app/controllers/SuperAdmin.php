<?php

class SuperAdmin extends Controller{

    public function __construct()
    {
         if (!isset($_SESSION['user'])){

            header('Location: /auth/formLogin');
            Flasher::setModalInfo('kamu belum login', 'silahkan login dulu', 'error');
            exit;
        }

        if ($_SESSION['role'] !== 'Superadmin'){ 
            Flasher::setModalInfo('Akses ditolak', 'anda bukan admin', 'error');
            header('Location: /dashboard');
            exit;
        }
    }

    public function index(){

        $keyword = $_GET['keyword'] ?? null;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $data['limit'] = 5;
        $total_data = $this->model('AdminModel')->countAdmin($keyword);
        
        // Hitung START (Offset) sesuai rumus kamu
        $start = ($page > 1) ? ($page * $data['limit']) - $data['limit'] : 0;
        $data['total_page'] = ceil($total_data / $data['limit']);
        $data['current_page'] = $page;

        $data['admins'] = $this->model('AdminModel')->getAllAdmin($data['limit'], $start, $keyword);
        $data['judul'] = 'Data Admin';
        $data['navbar'] = 'superAdmin';
        $this->view('layout/sidebar', $data);
        $this->view('admin/superAdmin/index', $data);
    }

    public function detailAdmin($id_user = null){

        if ($id_user === null) {
            Flasher::setModalInfo('Terjadi kesalahan', 'ID Admin tidak ditemukan.', 'error');
            header('Location: /superadmin');
            exit;
        }
        $data['admin'] = $this->model('AdminModel')->getAdminById($id_user);

        $data['judul'] = 'Detail Data Admin';
        $data['navbar'] = 'superAdmin';
        $this->view('layout/sidebar', $data);
        $this->view('admin/superAdmin/ubahAdmin', $data);
    }

    public function tambahAdmin(){
        $data['judul'] = 'Tambah Data Admin';
        $data['navbar'] = 'superAdmin';
        $this->view('layout/sidebar', $data);
        $this->view('admin/superAdmin/tambahAdmin', $data);
    }

    public function ubahAdmin(){
        $data['judul'] = 'Ubah Data Admin';
        $data['navbar'] = 'superAdmin';
        $this->view('layout/sidebar', $data);
        $this->view('admin/superAdmin/ubahAdmin', $data);
    }

    public function handleTambahAdmin(){

        try{

            if (
                empty($_POST['username']) ||
                empty($_POST['email']) ||
                empty($_POST['nomor_induk']) ||
                empty($_POST['password'])
            ) {
                throw new Exception('Semua field harus diisi.');
            }

            //cek apakah ada nip yang sama
            $existingUser = $this->model('UserModel')->findUserByEmailOrNomor_Induk($_POST['email'], $_POST['nomor_induk']);

            if ($existingUser) {
                throw new Exception('Email atau Nomor Induk sudah terdaftar.');
            }

            if (!validateEmailPHP($_POST['email'])) {
                throw new Exception('Format email tidak valid.');
            }


            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'nomor_induk' => $_POST['nomor_induk'],
                'password' => $_POST['password'],
                'id_role' => 2,
                'status' => 'active' // Default status
            ];

            if($this->model('AdminModel')->createAdmin($data) > 0 ){
                Flasher::setModalInfo('Berhasil', 'ditambahkan', 'success');
                header('Location: /superAdmin');
                exit;
            } else {
                throw new Exception('Gagal menambahkan admin baru.');
            }

        } catch (Exception $e){
            Flasher::setModalInfo('Terjadi kesalahan', $e->getMessage(), 'error');
            header('Location: /superAdmin/tambahAdmin');
            exit;
        }
    }

    public function handleUbahAdmin(){
        try {

            if (
                empty($_POST['username']) ||
                empty($_POST['email']) ||
                empty($_POST['nomor_induk']) ||
                empty($_POST['status'])
            ) {
                throw new \Exception('Semua field harus diisi.');
            }

            if (!validateEmailPHP($_POST['email'])) {
                throw new \Exception('Format email tidak valid.');
            }

            $data = [
                'id_user' => $_POST['id_user'],
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'nomor_induk' => $_POST['nomor_induk'],
                'status' => $_POST['status'],
                'id_role' => 2 // Pastikan id_role tetap 2 untuk Admin
            ];

            if($this->model('AdminModel')->updateAdmin($data) > 0 ){
                Flasher::setModalInfo('Berhasil', 'Data berhasil diubah', 'success');
                header('Location: /superAdmin');
                exit;
            } else {
                throw new \Exception('Gagal mengubah admin, tidak ada perubahan data.');
            }
            
        } catch (\Throwable $e) {
            Flasher::setModalInfo('Terjadi kesalahan', $e->getMessage(), 'error');
            header('Location: /superAdmin');
            exit;
        }
    }

    public function hapusAdmin(){

        try {
            if (empty($_POST['id_user'])) {
                throw new Exception('ID Admin tidak ditemukan.');
            }

            if($this->model('AdminModel')->deleteAdmin($_POST['id_user']) > 0 ){
                    Flasher::setModalInfo('Berhasil', 'Admin berhasil dihapus', 'success');
                    header('Location: /superAdmin');
                    exit;
            } else {
                    throw new \Exception('Gagal mengubah admin, tidak ada perubahan data.');
                }

        }catch(Exception $e){
            Flasher::setModalInfo('Gagal Menghapus', $e->getMessage(), 'error');
            header('location: /superadmin');
            exit();
        }
    }
}