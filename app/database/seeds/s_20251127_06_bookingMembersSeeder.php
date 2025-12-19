<?php

class s_20251127_06_bookingMembersSeeder extends Seeder {
    public function run() {
        $query = "INSERT INTO booking_members (id_booking, id_user, created_at, updated_at) VALUES
                -- 1. Done (User 6) --
                (1, 6, NOW(), NOW()), (1, 3, NOW(), NOW()), (1, 7, NOW(), NOW()),
                -- 2. Done (User 7) --
                (2, 7, NOW(), NOW()), (2, 4, NOW(), NOW()), (2, 5, NOW(), NOW()), (2, 6, NOW(), NOW()),
                -- 3. Done (User 8) --
                (3, 8, NOW(), NOW()), (3, 6, NOW(), NOW()), (3, 7, NOW(), NOW()), (3, 5, NOW(), NOW()),
                -- 4. Cancelled (User 6) --
                (4, 6, NOW(), NOW()), (4, 4, NOW(), NOW()), (4, 8, NOW(), NOW()), 
                -- 5. Pending (User 7) --
                (5, 7, NOW(), NOW()), (5, 3, NOW(), NOW()), (5, 5, NOW(), NOW()), (5, 12, NOW(), NOW()), (5, 13, NOW(), NOW()),
                -- 6. Pending (User 8) --
                (6, 8, NOW(), NOW()), (6, 10, NOW(), NOW()), (6, 11, NOW(), NOW()), (6, 12, NOW(), NOW()),
                -- 7. Cancelled --
                (7, 6, NOW(), NOW()), (7, 9, NOW(), NOW()),

                -- 8 s.d 15 (Bookingan Rutin User 6) --
                (8, 6, NOW(), NOW()), (8, 13, NOW(), NOW()), (8, 14, NOW(), NOW()), (8, 15, NOW(), NOW()),
                (9, 6, NOW(), NOW()), (9, 16, NOW(), NOW()), (9, 17, NOW(), NOW()), (9, 18, NOW(), NOW()),
                (10, 6, NOW(), NOW()), (10, 19, NOW(), NOW()), (10, 20, NOW(), NOW()),
                (11, 6, NOW(), NOW()), (11, 21, NOW(), NOW()), (11, 22, NOW(), NOW()),
                (12, 6, NOW(), NOW()), (12, 23, NOW(), NOW()), (12, 24, NOW(), NOW()), (12, 25, NOW(), NOW()),
                (13, 6, NOW(), NOW()), (13, 26, NOW(), NOW()),
                (14, 6, NOW(), NOW()), (14, 27, NOW(), NOW()),
                (15, 6, NOW(), NOW()), (15, 28, NOW(), NOW()),

                -- 16. Rejected/Cancelled (Rina) --
                (16, 19, NOW(), NOW()), (16, 20, NOW(), NOW()), (16, 21, NOW(), NOW()), (16, 22, NOW(), NOW()),
                -- 17. Cancelled (Bayu) --
                (17, 20, NOW(), NOW()), (17, 23, NOW(), NOW()), (17, 24, NOW(), NOW()), (17, 25, NOW(), NOW()), (17, 26, NOW(), NOW()), (17, 18, NOW(), NOW()),
                -- 18. Pending Bentrok (Dewi) --
                (18, 21, NOW(), NOW()), (18, 20, NOW(), NOW()), (18, 24, NOW(), NOW()), (18, 19, NOW(), NOW()),
                -- 19. Pending (Eko) --
                (19, 22, NOW(), NOW()), (19, 18, NOW(), NOW()), (19, 19, NOW(), NOW()), (19, 25, NOW(), NOW()), (19, 26, NOW(), NOW()), (19, 12, NOW(), NOW()), (19, 13, NOW(), NOW()),
                -- 20. Done (Gilang) --
                (20, 24, NOW(), NOW()), (20, 15, NOW(), NOW()), (20, 16, NOW(), NOW()), (20, 17, NOW(), NOW()),
                -- 21. Rejected/Cancelled (Fanny) --
                (21, 23, NOW(), NOW()), (21, 26, NOW(), NOW()), 
                -- 22. Cancelled (Tendik) --
                (22, 30, NOW(), NOW()), (22, 31, NOW(), NOW()), (22, 32, NOW(), NOW()),
                -- 23. Done (Tendik) --
                (23, 32, NOW(), NOW()), (23, 15, NOW(), NOW()), 
                -- 24. Pending (Tendik) --
                (24, 31, NOW(), NOW()), (24, 30, NOW(), NOW()),
                -- 25. Done (Sulthon) --
                (25, 12, NOW(), NOW()), (25, 11, NOW(), NOW()), (25, 13, NOW(), NOW()),
                -- 26. Done (Farhan) --
                (26, 16, NOW(), NOW()), (26, 14, NOW(), NOW()), (26, 15, NOW(), NOW()),
                -- 27. Rejected/Cancelled (Lebron) --
                (27, 10, NOW(), NOW()), (27, 11, NOW(), NOW()),

                -- === DATA MEMBER HISTORY (ID 28-47) === --
                
                -- 28 --
                (28, 6, NOW(), NOW()), (28, 7, NOW(), NOW()), (28, 8, NOW(), NOW()), (28, 9, NOW(), NOW()), (28, 10, NOW(), NOW()),
                -- 29 --
                (29, 7, NOW(), NOW()), (29, 12, NOW(), NOW()), (29, 13, NOW(), NOW()), (29, 14, NOW(), NOW()),
                -- 30 --
                (30, 8, NOW(), NOW()), (30, 6, NOW(), NOW()), (30, 25, NOW(), NOW()),
                -- 31 --
                (31, 12, NOW(), NOW()), (31, 13, NOW(), NOW()), (31, 14, NOW(), NOW()), (31, 15, NOW(), NOW()),
                -- 32 --
                (32, 13, NOW(), NOW()), (32, 18, NOW(), NOW()), (32, 19, NOW(), NOW()), (32, 20, NOW(), NOW()), (32, 21, NOW(), NOW()), (32, 22, NOW(), NOW()),
                -- 33 --
                (33, 15, NOW(), NOW()), (33, 16, NOW(), NOW()), (33, 17, NOW(), NOW()), (33, 26, NOW(), NOW()),
                -- 34 --
                (34, 18, NOW(), NOW()), (34, 19, NOW(), NOW()), (34, 20, NOW(), NOW()), (34, 21, NOW(), NOW()), (34, 22, NOW(), NOW()),
                -- 35 --
                (35, 27, NOW(), NOW()), (35, 28, NOW(), NOW()),
                -- 36 --
                (36, 6, NOW(), NOW()), (36, 7, NOW(), NOW()), (36, 8, NOW(), NOW()), (36, 9, NOW(), NOW()), (36, 10, NOW(), NOW()), (36, 11, NOW(), NOW()), (36, 12, NOW(), NOW()), (36, 13, NOW(), NOW()),
                -- 37 --
                (37, 10, NOW(), NOW()), (37, 20, NOW(), NOW()), (37, 25, NOW(), NOW()),

                -- 38 --
                (38, 30, NOW(), NOW()), (38, 31, NOW(), NOW()), (38, 32, NOW(), NOW()), (38, 4, NOW(), NOW()), (38, 5, NOW(), NOW()),
                -- 39 --
                (39, 32, NOW(), NOW()), (39, 15, NOW(), NOW()), (39, 16, NOW(), NOW()), (39, 17, NOW(), NOW()),
                -- 40 --
                (40, 6, NOW(), NOW()), (40, 7, NOW(), NOW()), (40, 8, NOW(), NOW()), (40, 9, NOW(), NOW()), (40, 10, NOW(), NOW()), (40, 11, NOW(), NOW()),
                -- 41 --
                (41, 9, NOW(), NOW()), (41, 10, NOW(), NOW()), (41, 11, NOW(), NOW()),
                -- 42 --
                (42, 14, NOW(), NOW()), (42, 15, NOW(), NOW()), (42, 16, NOW(), NOW()), (42, 17, NOW(), NOW()), (42, 18, NOW(), NOW()),
                -- 43 --
                (43, 21, NOW(), NOW()), (43, 22, NOW(), NOW()), (43, 23, NOW(), NOW()), (43, 24, NOW(), NOW()), (43, 25, NOW(), NOW()), (43, 26, NOW(), NOW()),
                -- 44 --
                (44, 28, NOW(), NOW()), (44, 29, NOW(), NOW()), (44, 27, NOW(), NOW()), (44, 30, NOW(), NOW()),
                -- 45 --
                (45, 23, NOW(), NOW()), (45, 24, NOW(), NOW()), (45, 25, NOW(), NOW()), (45, 26, NOW(), NOW()), (45, 12, NOW(), NOW()), (45, 13, NOW(), NOW()), (45, 14, NOW(), NOW()),
                -- 46 --
                (46, 16, NOW(), NOW()), (46, 6, NOW(), NOW()), (46, 7, NOW(), NOW()),
                -- 47 --
                (47, 6, NOW(), NOW()), (47, 30, NOW(), NOW()), (47, 31, NOW(), NOW()), (47, 32, NOW(), NOW()), (47, 4, NOW(), NOW());";

        $this->db->query($query);
        $this->db->execute();
    }
}