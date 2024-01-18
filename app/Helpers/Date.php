<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;
use Exception;

class Date
{
    public static string $MERCADOPAGO_DATE_FORMAT = "Y-m-d\TH:i:s.vP";

    /**
     * @param string $format
     * @param bool $formatted
     * @return string|DateTime
     * @throws Exception
     */
    public static function now(string $format, bool $formatted = true) : string|DateTime
    {
        $dateTimezone = new DateTimeZone("America/Sao_Paulo");
        $date = new DateTime("now", $dateTimezone);
        return $formatted ? $date->format($format) : $date;
    }

    /**
     * @param int $minutes
     * @param string $format
     * @param bool $formatted
     * @return string|DateTime
     * @throws Exception
     */
    public static function addMinutes(int $minutes, string $format, bool $formatted = true) : string|DateTime
    {
        $dateTimezone = new DateTimeZone("America/Sao_Paulo");
        $date = new DateTime("now", $dateTimezone);
        $date->modify("+{$minutes} minutes");
        return $formatted ? $date->format($format) : $date;
    }

    public static function diff(string $date, string $compareDate = null)
    {
        $date1 = DateTime::createFromFormat(Date::$MERCADOPAGO_DATE_FORMAT, $date);
        $date2 = DateTime::createFromFormat(Date::$MERCADOPAGO_DATE_FORMAT, $compareDate ?? Date::now(Date::$MERCADOPAGO_DATE_FORMAT));
        $diff = $date1->diff($date2);

        return $date1 >= $date2 ? $diff->i : -1*$diff->i;
    }
}
