<?php

if (!function_exists('nowIST')) {
    /**
     * Get current time in IST
     */
    function nowIST()
    {
        return \Carbon\Carbon::now('Asia/Kolkata');
    }
}

if (!function_exists('parseIST')) {
    /**
     * Parse a date/time string and convert to IST
     */
    function parseIST($datetime)
    {
        return \Carbon\Carbon::parse($datetime)->setTimezone('Asia/Kolkata');
    }
}
