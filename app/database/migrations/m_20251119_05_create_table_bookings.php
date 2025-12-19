<?php

class m_20251119_05_create_table_bookings extends Migration{

    public function up()
    {
        $query = "CREATE TABLE IF NOT EXISTS bookings (
                id_booking INT AUTO_INCREMENT PRIMARY KEY,
                id_room INT,
                id_user INT,
                external_email VARCHAR(255) NULL,
                total_person INT NULL,
                institution_name VARCHAR(255) NULL,
                purpose VARCHAR(255) NULL,
                booking_letter VARCHAR(255) NULL,
                start_time DATETIME,
                end_time DATETIME,
                booking_code VARCHAR(10),
                status ENUM('pending','ongoing','done', 'cancelled') DEFAULT 'pending',
                reject_reason VARCHAR(255) NULL,
                cancel_by ENUM('user','system','admin') NULL,
                start_reminder BOOLEAN DEFAULT 0,
                end_reminder BOOLEAN DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_bookings_room FOREIGN KEY (id_room)
                    REFERENCES rooms(id_room)
                    ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT fk_bookings_user FOREIGN KEY (id_user)
                    REFERENCES users(id_user)
                    ON DELETE RESTRICT ON UPDATE CASCADE
            );";

        $this->db->query($query);
        $this->db->execute();
    }
}