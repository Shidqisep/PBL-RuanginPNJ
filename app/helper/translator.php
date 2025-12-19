<?php

function translateStatus($status): string
{
    $lookup = [
        'active'   => 'Aktif',
        'ongoing'  => 'Berlangsung',
        'done'     => 'Selesai',
        'rejected' => 'Ditolak',
        'cancelled' => 'Dibatalkan',
        'expired'  => 'Kadaluarsa',
        'pending'  => 'Menunggu',
        'approved' => 'Disetujui',
        'declined' => 'Ditolak'
    ];

    return $lookup[$status] ?? 'Status tidak dikenal';
}

function translateStatusUser($status): string
{
    $lookup = [
        'active'   => 'Aktif',
        'rejected' => 'Ditolak',
        'cancelled' => 'Dibatalkan',
        'expired'  => 'Kadaluarsa',
        'suspended' => 'Suspended',
        'pending'  => 'Belum Aktif',
        'non-active' => 'Tidak Aktif'
    ];

    return $lookup[$status] ?? 'Status tidak dikenal';
}

function translateStatusRoom($status): string
{
    $lookup = [
        'active'   => 'Tersedia',
        'non-active' => 'Tidak Tersedia',
        'spesial' => 'Admin Only'
    ];

    return $lookup[$status] ?? 'Status tidak dikenal';
}

function getStyleStatus($status): string {

   $map = [
        'pending'  => 'bg-blue-600 text-[#1E68FB]',
        'active'   => 'bg-[#38C55C]',
        'ongoing'  => 'bg-yellow-500 text-white1 ',
        'done'     => 'bg-[#38C55C]',
        'cancelled' => 'bg-[#C90B0B]',
        'rejected' => 'bg-[#C90B0B]', //opacity 30%
        'approved' => 'bg-[#38C55C]',
        'declined' => 'bg-[#C90B0B]'
    ];

    return $map[$status] ?? 'bg-gray-400';
}

function getStyleStatusRoom($status): string {

   $map = [
        'active'   => 'bg-[#38C55C]',
        'non-active'  => 'bg-red-overlay3',
        'spesial'     => 'bg-[#38C55C]'
    ];

    return $map[$status] ?? 'bg-gray-400';
}

function getStyleStatusDetail($status): string {

   $map = [
        'pending'  => 'bg-blue-600/30 text-[#1E68FB]',
        'active'   => 'bg-green-overlay4',
        'non-active' => 'bg-red-overlay3',
        'ongoing'  => 'bg-yellow-500/30 text-yellow-600 ',
        'done'     => 'bg-green-overlay4',
        'cancelled' => 'bg-[#C90B0B]/30',
        'rejected' => 'bg-[#C90B0B]/30', //opacity 30%
        'approved' => 'bg-[#38C55C]/30',
        'declined' => 'bg-[#C90B0B]/30'
    ];

    return $map[$status] ?? 'bg-gray-400';
}

function getStyleStatustext($status): string {

   $map = [
        'pending'  => 'text-[#1E68FB]',
        'active'   => 'text-green1',
        'non-active' => 'text-red1',
        'ongoing'  => 'text-yellow-600 ',
        'done'     => 'text-green1',
        'cancelled' => 'text-[#C90B0B]',
        'rejected' => 'text-[#C90B0B]',
        'approved' => 'text-[#38C55C]',
        'declined' => 'text-[#C90B0B]',
        'non-active' => 'text-red1',
    ];

    return $map[$status] ?? 'bg-gray-400';
}

function getStyleRole($role): string {

   $map = [
        'Mahasiswa'  => 'bg-[#1E68FB]/30 text-[#1E68FB]',
        'Dosen'   => 'bg-[#FB1E6B]/30  text-[#FB1E6B]',
        'Tendik'  => 'bg-[#CF570D]/30  text-[#CF570D]',
    ];

    return $map[$role] ?? 'bg-gray-400';
}