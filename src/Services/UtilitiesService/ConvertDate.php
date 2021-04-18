<?php

namespace App\Services\UtilitiesService;

class ConvertDate
{
    public function __construct()
    {
        setlocale(LC_ALL, 'fr_FR', 'fra');
        date_default_timezone_set("Europe/Paris");
        mb_internal_encoding("UTF-8");
    }


    /**
     * This function get a datetime and convert to date string or long date string fr_FR - Returns two format (02-01-2021 17:11:32) or (02-01-2021)
     *
     * @param datetime $date
     * @param boolean $hour
     * @return date | long date string fr
     */
    public function toDateTimeFr($date, $hour = true)
    {
        if ($hour == true) {
            return strftime('%d-%m-%Y %H:%M:%S', strtotime($date));
        } else {
            return strftime('%d-%m-%Y', strtotime($date));
        }
    }

    /**
     * This function get a datetime and convert to date string fr_FR - Returns two format (samedi 02 janvier 2021 à 17h11) or (samedi 02 janvier 2021)
     *
     * @param datetime $date
     * @param boolean $hour
     * @return date | date string fr
     */
    public function toStrDateTimeFr($date, $hour = true)
    {
        if ($hour !== false) {
            $strDateTimeFr = mb_convert_encoding('%A %d %B %Y à %Hh%M', 'ISO-8859-9', 'UTF-8');
        } else {
            $strDateTimeFr = mb_convert_encoding('%A %d %B %Y', 'ISO-8859-9', 'UTF-8');
        }
        return iconv("ISO-8859-9", "UTF-8", strftime($strDateTimeFr, strtotime($date)));
    }

}
