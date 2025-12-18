<?php
/**
 * Validator Utility Class
 * Provides server-side validation methods
 */

class Validator {
    /**
     * Validate email format
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate phone number (Malaysian format)
     */
    public static function validatePhone($phone) {
        // Remove spaces and dashes
        $phone = preg_replace('/[\s\-]/', '', $phone);
        
        // Check if it matches Malaysian phone format
        // Accepts: +60123456789, 60123456789, 0123456789
        return preg_match('/^(\+?6?01)[0-9]{8,9}$/', $phone) === 1;
    }

    /**
     * Sanitize string input
     */
    public static function sanitizeString($string) {
        return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate required field
     */
    public static function validateRequired($value) {
        return !empty(trim($value));
    }

    /**
     * Validate date format (YYYY-MM-DD)
     */
    public static function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * Validate time format (HH:MM)
     */
    public static function validateTime($time) {
        return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time) === 1;
    }

    /**
     * Validate string length
     */
    public static function validateLength($string, $min, $max) {
        $length = strlen($string);
        return $length >= $min && $length <= $max;
    }
}
?>
