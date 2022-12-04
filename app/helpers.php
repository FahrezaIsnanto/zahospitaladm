<?php

if (!function_exists('convertDateToSQL')) {
    function convertDateToSQL($dateDMY)
    {
        $date = substr($dateDMY, 0, 2);
        $month = substr($dateDMY, 3, 2);
        $year = substr($dateDMY, 6, 4);
        return  $year . '-' . $month . '-' . $date;
    }
}

if (!function_exists('convertSQLtoDate')) {
    function convertSQLtoDate($dateYMD)
    {
        $date = substr($dateYMD, 8, 2);
        $month = substr($dateYMD, 5, 2);
        $year = substr($dateYMD, 0, 4);
        return $date . '-' . $month . '-' . $year;
    }
}
