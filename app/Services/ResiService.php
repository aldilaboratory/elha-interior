<?php

namespace App\Services;

class ResiService
{
    /**
     * Generate a dummy resi number
     *
     * @param string $courier
     * @return string
     */
    public static function generateResi($courier = 'JNE')
    {
        $prefix = strtoupper(substr($courier, 0, 3));
        $timestamp = time();
        $random = strtoupper(substr(md5(uniqid()), 0, 8));
        
        return $prefix . $timestamp . $random;
    }

    /**
     * Generate resi based on courier type
     *
     * @param string $courier
     * @return string
     */
    public static function generateResiByCourier($courier)
    {
        $courierMap = [
            'JNE' => 'JNE',
            'POS' => 'POS',
            'TIKI' => 'TIK',
            'J&T' => 'JNT',
            'SiCepat' => 'SIC',
            'AnterAja' => 'ANT',
            'Wahana' => 'WHA',
            'Ninja Express' => 'NIN',
            'Lion Parcel' => 'LIO',
            'Paxel' => 'PAX',
            'SAP Express' => 'SAP',
            'Jet Express' => 'JET',
            'REX Express' => 'REX',
            'First Logistics' => 'FIR',
            'ID Express' => 'IDX',
            'Sentral Cargo' => 'SEN',
            'Star Cargo' => 'STA',
            'Pandu Logistics' => 'PAN',
            'Dakota Cargo' => 'DAK',
            'Royal Express Indonesia' => 'ROY',
        ];

        $prefix = $courierMap[$courier] ?? 'EXP';
        $timestamp = time();
        $random = strtoupper(substr(md5(uniqid()), 0, 8));
        
        return $prefix . $timestamp . $random;
    }
}
