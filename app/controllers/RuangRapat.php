<?php 

class RuangRapat extends Controller{

    public function index(){
        $data['judul'] = 'Form Ruang Rapat';
        $this->view('Ruang_Rapat/index', $data);
        $this->view('Layout/Footer');
    }
}