<?php 

class History extends Controller{
    public function __construct()
        {
            parent::__construct();
            if (!isset($_SESSION['user'])) {
            // Jika 'user_id' tidak ada di session (artinya belum login)
            Flasher::setFlash('Anda harus login', 'untuk mengakses halaman ini.', 'danger');
            header('Location: /auth/formLogin'); // Redirect ke halaman login
            exit; //Hentikan eksekusi script
            }

            $user = $this->model('UserModel')->getSuspendCount($_SESSION['user']['user_id']);

            if ($user >= 3) {
                session_destroy();
                header("Location: /auth/handleLogout");
                exit;
            }
        }

    public function index(){

        $data['current_page'] = 1;
        $data['total_page'] = 1;

        $data['limit'] = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        // if ($page < 1) {
        //     $page = 1;
        // }
        $start = ($page > 1) ? ($page * $data['limit']) - $data['limit'] : 0;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $idUser = $_SESSION['user']['user_id'];
        $status = '';
        
        if (isset($_GET['Status'])) {
            if (is_array($_GET['Status'])) {
                $status = $_GET['Status']; 
            } else {
                $status = explode(',', $_GET['Status']);
            }
        }

        if ($search === '' && $status === '') {
            // tanpa pencarian
            $data['bookings'] = $this->model('BookingModel')->getAllBookingByUser($idUser, $data['limit'], $start);

            $total_data = $this->model('BookingModel')->countAllBookingByUser($idUser);
        } else {
            // dengan pencarian
            $data['bookings'] = $this->model('BookingModel')->filterBookingByUser($idUser, $data['limit'], $start, $search, $status);

            $total_data = $this->model('BookingModel')->countFilterBookingByUser($idUser, $search, $status);
        }

        

        $data['total_page'] = ceil($total_data / $data['limit']);
        $data['current_page'] = $page;
        unset($book); // best practice
        $data['judul'] = 'History';
        $data['navbar'] = 'History';
        $this->view('Layout/Header', $data);
        $this->view('anggota/History/index', $data); 
        $this->view('Layout/Footer');
    }

    public function submitFeedback(){
        try{
            if (empty($_POST['id_booking'])||empty($_POST['rating'])) {
                throw new Exception("Data tidak lengkap!", 1);
            }

            if (!$this->model('BookingModel')->isUserAssociatedWithBooking($_POST['id_booking'], $_SESSION['user']['user_id'])) {
                throw new Exception("Anda tidak memiliki akses ke booking ini!", 1);
            }

            $data = [
                'id_booking' => $_POST['id_booking'],
                'id_user' => $_SESSION['user']['user_id'],
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment'] ?? NULL
            ];

            $result = $this->model('FeedbackModel')->addFeedback($data);

            if($result <= 0 ){
                throw new Exception("Internal SQL ERROR");
            }

            Flasher::setModalInfo('Berhasil Mengirim FeedBack', 'Terima kasih yaa, Feedback kamu sangat berarti', 'success');
            header('Location: /History'); // Redirect ke halaman history
            exit; //Hentikan eksekusi script


        } catch (Exception $e){
            Flasher::setModalInfo('Gagal Mengirim FeedBack', $e->getMessage(), 'error');
            header('Location: /History'); // Redirect ke halaman history
            exit; //Hentikan eksekusi script
        }
    }

}