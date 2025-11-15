<?php 

class RuanganModel {

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getRuanganForDashboard(){
        $this->db->query("SELECT id_ruangan, nama_ruangan, img_ruangan, deskripsi_singkat, lantai, jumlah_maksimal, jumlah_minimal, status FROM ruangan");
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getRuanganById($id_ruangan){
        $this->db->query("SELECT * FROM ruangan WHERE id_ruangan = :id_ruangan");
        $this->db->bind(':id_ruangan', $id_ruangan);
        $this->db->execute();
        return $this->db->singleSet();
    }
}