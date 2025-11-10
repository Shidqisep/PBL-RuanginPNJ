<?php

class Email extends Controller {

    public function index(){
        $this->view('error/index');
    }

    public function kirim(){
        try {
            $emailTujuan = 'test@mailpit.local';
            $namaPenerima = 'user test';
            $subjek = 'Test email untuk noifikasi';
            $isiEmail = 'ini adalah email percobaan dari ruanginpnj';

            sendEmail($emailTujuan, $namaPenerima, $subjek, $isiEmail);
            echo "Email berhasil dikirim ke $emailTujuan";
        }catch (Exception $e){
           echo "Gagal mengirim email. Error: " . $e->getMessage();
        }



    }
}