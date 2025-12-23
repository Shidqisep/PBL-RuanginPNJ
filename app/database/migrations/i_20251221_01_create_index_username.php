<?php

class i_20251221_01_create_index_username extends Migration{
    public function up()
    {
        $index = "CREATE INDEX idx_username ON users(username);";
        $this->db->query($index);
        $this->db->execute();
    }

    public function down()
    {
        $dropIndex = "DROP INDEX IF EXISTS idx_username;";
        $this->db->query($dropIndex);
        $this->db->execute();
    }
}