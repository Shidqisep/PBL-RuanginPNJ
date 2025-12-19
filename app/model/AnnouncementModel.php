<?php


class AnnouncementModel {
    private $table = 'announcement';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // ini dipake di editTataTertib admin
    public function getAnnouncement($id_announcement){
        $this->db->query("SELECT * FROM announcement WHERE id_announcement = :id_announcement" );
        $this->db->bind('id_announcement', $id_announcement);
        return $this->db->singleSet();
    }

    public function updateAnnouncement($id_announcement, $content){
        $this->db->query("UPDATE " . $this->table . " SET announcement_content = :content WHERE id_announcement = :id_announcement");
        $this->db->bind('content', $content);
        $this->db->bind('id_announcement', $id_announcement);
        $this->db->execute();
        return $this->db->rowCount();
    }
}