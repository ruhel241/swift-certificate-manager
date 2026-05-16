<?php

namespace SwiftCertificateManager\Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


/**
 * HelperFunction Class
 * @since 1.0.0
 */
class HelperFunction
{
     /**
     * Generate certificate code in format scYYMM0001
     */
    public function generateCertificateCode($prefix = '') {
        // Get current 2-digit year and 2-digit month
        $year = gmdate('y');  // 2-digit year (25 for 2025)
        $month = gmdate('m'); // 2-digit month (05 for May)
        $yearMonth = $year . $month;

        // Find the latest certificate for this month/year
        $lastCertificate = SwiftCertificateManagerQuery()->table('swiftcm_generates')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastCertificate) {
            // Extract the existing serial number
            $lastCode = $lastCertificate->certificate_code;
            // Extract the last 4 characters which should be the serial number
            $lastSerial = (int)substr($lastCode, -4);
            // Increment the serial
            $newSerial = $lastSerial + 1;
        } else {
            // No certificates yet for this month/year, start at 1
            $newSerial = 1;
        }

        // Format the serial number to have leading zeros
        $serialFormatted = str_pad($newSerial, 4, '0', STR_PAD_LEFT);

        // Generate the complete certificate code
        return $prefix . $yearMonth . $serialFormatted;
    }
}