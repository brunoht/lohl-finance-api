<?php

namespace App\Helpers;

use Carbon\Carbon;
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
    public static function addMinutes(int $minutes, string $format, bool $formatted = true, string $timezone = "-03:00") : string|DateTime
    {
        $now = Carbon::now()->setTimezone($timezone);
        $date = $now->addMinutes($minutes);
        return $formatted ? $date->format($format) : $date;
    }

    /**
     * @param string $date
     * @param string|null $compareDate
     * @return int
     * @throws Exception
     */
    public static function diff(string $date, string $compareDate = null)
    {
        $date1 = DateTime::createFromFormat(Date::$MERCADOPAGO_DATE_FORMAT, $date);
        $date2 = DateTime::createFromFormat(Date::$MERCADOPAGO_DATE_FORMAT, $compareDate ?? Date::now(Date::$MERCADOPAGO_DATE_FORMAT));
        $diff = $date1->diff($date2);

        return $date1 >= $date2 ? $diff->i : -1*$diff->i;
    }

    /**
     * @param string $date
     * @param string $format
     * @return string
     * @throws Exception
     */
    public static function format(string $date, string $fromFormat, string $toFormat) : string
    {
        $date = DateTime::createFromFormat($fromFormat, $date);
        return $date->format($toFormat);
    }

    /**
     * @param string $date
     * @return string
     */
    public static function formatFromConsole(string $date) : string
    {
        $newDate = explode('/', $date);
        $newDate = $newDate[2] . '-' . $newDate[1] . '-' . $newDate[0];
        return $newDate;
    }

    /**
     * @param string $date
     * @return string
     */
    public static function formatToConsole(string $date) : string
    {
        $newDate = explode('-', $date);
        $newDate = $newDate[2] . '/' . $newDate[1] . '/' . $newDate[0];
        return $newDate;
    }
}
