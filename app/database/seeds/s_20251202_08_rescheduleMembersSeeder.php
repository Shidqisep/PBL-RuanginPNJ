<?php

class s_20251202_08_rescheduleMembersSeeder extends Seeder {
    public function run() {
        $query = "INSERT INTO reschedule_members (id_reschedule, id_user, created_at, updated_at) VALUES
                  (1, 4, NOW(), NOW()),
                  (1, 3, NOW(), NOW()),
                  (1, 12, NOW(), NOW()),
                  (2, 16, NOW(), NOW()),
                  (2, 14, NOW(), NOW());";

        $this->db->query($query);
        $this->db->execute();
    }
}