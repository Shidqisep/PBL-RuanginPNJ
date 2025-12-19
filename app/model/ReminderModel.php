<?php

class ReminderModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //ambil id booking yang 10 menit lagi mulai dan belum dikirim reminder
    public function getUpcomingBookings($timeframeInMinutes = 10)
    {
        $query = "SELECT b.id_booking, b.start_time, b.end_time, u.username, u.email 
                  FROM bookings b
                  JOIN users u ON b.id_user = u.id_user
                  WHERE start_time BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL :timeframe MINUTE)
                  AND b.start_reminder = 0
                  AND b.status = 'pending'";

        $this->db->query($query);
        $this->db->bind('timeframe', $timeframeInMinutes);
        return $this->db->resultSet();
    }

    //ambil email dan username dari anggota bookingnya
    public function getBookingMembers($id_booking)
    {
        $query = "SELECT u.email, u.username 
                  FROM booking_members bm
                  JOIN users u ON bm.id_user = u.id_user
                  WHERE bm.id_booking = :id_booking";

        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        return $this->db->resultSet();
    }

    //update flagnya start_reminder jadi 1
    public function markStartReminderSent($id_booking)
    {
        $query = "UPDATE bookings 
                  SET start_reminder = 1 
                  WHERE id_booking = :id_booking";

        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
    }

    //ambil id_booking yang 10 menit lagi selesai dan belum dikirim reminder
    public function getEndingBookings($timeframeInMinutes = 10)
    {
        $query = "SELECT b.id_booking, b.start_time, b.end_time, u.username, u.email
                  FROM bookings b
                  JOIN users u ON b.id_user = u.id_user
                  WHERE end_time BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL :timeframe MINUTE)
                  AND end_reminder = 0
                  ";

        $this->db->query($query);
        $this->db->bind('timeframe', $timeframeInMinutes);
        return $this->db->resultSet();
    }

    public function markEndReminderSent($id_booking)
    {
        $query = "UPDATE bookings 
                  SET end_reminder = 1 
                  WHERE id_booking = :id_booking";

        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
    }

    public function getBookingLeader($id_booking)
    {
        $query = "SELECT u.email, u.username 
                  FROM bookings b
                  JOIN users u ON b.id_user = u.id_user
                  WHERE b.id_booking = :id_booking";

        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        return $this->db->singleSet();
    }   
}