<?php

class v_20251218_01_create_view_v_ruangan_dashboard extends Migration{
    public function up()
    {
        $view = "CREATE OR REPLACE VIEW v_ruangan_dashboard AS
                 SELECT 
                    id_room, 
                    room_name, 
                    img_room, 
                    short_description, 
                    floor, 
                    max_capacity, 
                    min_capacity, 
                    status 
                 FROM rooms 
                 WHERE status = 'active';";
        $this->db->query($view);
        $this->db->execute();
    }

}