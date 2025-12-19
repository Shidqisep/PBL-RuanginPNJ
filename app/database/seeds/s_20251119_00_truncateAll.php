<?php

class s_20251119_00_truncateAll extends Seeder{

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->execute();

        $tables = [
            'users',
            'roles',
            'announcement',
            'rooms',
            'bookings',
            'booking_members',
            'reschedule',
            'reschedule_members',
            'feedback'
        ];

        foreach ($tables as $table) {
            $this->db->query("TRUNCATE TABLE $table");
            $this->db->execute();
            echo "    -> Cleared: $table \n";
        }

        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        $this->db->execute();
    }
}