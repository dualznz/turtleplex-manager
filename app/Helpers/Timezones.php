<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTimeZone;

class Timezones
{

    public static $timezones = [
        'Pacific/Midway' => 'American Samoa',
        'Pacific/Apia' => 'Apia, Samoa',
        'Pacific/Honolulu' => 'Hawaii',
        'Pacific/Kiritimati' => 'Kiritimati',
        'Pacific/Marquesas' => 'Marquesas Islands',
        'America/Los_Angeles' => 'Pacific Time (US &amp; Canada)',
        'America/Anchorage' => 'Alaska',
        'America/Santa_Isabel' => 'Baja California',
        'America/Tijuana' => 'Tijuana',
        'America/Denver' => 'Mountain Time (US &amp; Canada)',
        'America/Chihuahua' => 'Chihuahua, La Paz, Mazatlan',
        'America/Phoenix' => 'Arizona',
        'America/Chicago' => 'Central Time (US &amp; Canada)',
        'America/Belize' => 'Saskatchewan, Central America',
        'America/Mexico_City' => 'Guadalajara, Mexico City, Monterrey',
        'Pacific/Easter' => 'Easter Island',
        'America/New_York' => 'Eastern Time (US &amp; Canada)',
        'America/Havana' => 'Cuba',
        'America/Bogota' => 'Bogota, Lima, Quito',
        'America/Caracas' => 'Caracas',
        'America/Halifax' => 'Atlantic Time (Canada)',
        'America/Goose_Bay' => 'Atlantic Time (Goose Bay)',
        'America/Asuncion' => 'Asuncion',
        'America/Santiago' => 'Santiago',
        'America/Cuiaba' => 'Cuiaba',
        'America/La_Paz' => 'Georgetown, La Paz, Manaus, San Juan',
        'America/St_Johns' => 'Newfoundland',
        'America/Argentina/Buenos_Aires' => 'Buenos Aires',
        'America/Argentina/San_Luis' => 'San Luis',
        'America/Argentina/Mendoza' => 'Argentina, Cayenne, Fortaleza',
        'Atlantic/Stanley' => 'Falkland Islands',
        'America/Godthab' => 'Greenland',
        'America/Montevideo' => 'Montevideo',
        'America/Sao_Paulo' => 'Brasilia',
        'America/Miquelon' => 'Saint Pierre and Miquelon',
        'America/Noronha' => 'Mid-Atlantic',
        'Atlantic/Cape_Verde' => 'Cape Verde Is.',
        'Atlantic/Azores' => 'Azores',
        'UTC' => 'UTC',
        'GMT' => 'Dublin, Edinburgh, Lisbon, London',
        'Africa/Casablanca' => 'Casablanca',
        'Atlantic/Reykjavik' => 'Monrovia, Reykjavik',
        'Africa/Algiers' => 'West Central Africa',
        'Europe/Amsterdam' => 'Central European Time',
        'Africa/Windhoek' => 'Windhoek',
        'Africa/Tunis' => 'Tunis',
        'Europe/Athens' => 'Eastern European Time',
        'Africa/Johannesburg' => 'South Africa Standard Time',
        'Europe/Kaliningrad' => 'Kaliningrad',
        'Asia/Amman' => 'Amman',
        'Asia/Beirut' => 'Beirut',
        'Africa/Cairo' => 'Cairo',
        'Asia/Jerusalem' => 'Jerusalem',
        'Asia/Gaza' => 'Gaza',
        'Asia/Damascus' => 'Syria',
        'Europe/Moscow' => 'Moscow, St. Petersburg, Volgograd',
        'Europe/Minsk' => 'Minsk',
        'Africa/Nairobi' => 'Nairobi, Baghdad, Kuwait, Qatar, Riyadh',
        'Asia/Tehran' => 'Tehran',
        'Asia/Dubai' => 'Abu Dhabi, Muscat, Tbilisi',
        'Asia/Yerevan' => 'Yerevan',
        'Asia/Baku' => 'Baku',
        'Indian/Mauritius' => 'Mauritius',
        'Asia/Kabul' => 'Kabul',
        'Asia/Yekaterinburg' => 'Ekaterinburg',
        'Asia/Tashkent' => 'Tashkent, Karachi',
        'Asia/Kolkata' => 'Chennai, Kolkata, Mumbai, New Delhi',
        'Asia/Kathmandu' => 'Kathmandu',
        'Asia/Novosibirsk' => 'Novosibirsk',
        'Asia/Dhaka' => 'Astana, Dhaka',
        'Asia/Almaty' => 'Almaty, Bishkek, Qyzylorda',
        'Asia/Rangoon' => 'Yangon (Rangoon)',
        'Asia/Krasnoyarsk' => 'Krasnoyarsk',
        'Asia/Bangkok' => 'Bangkok, Hanoi, Jakarta',
        'Asia/Irkutsk' => 'Irkutsk',
        'Asia/Hong_Kong' => 'Beijing, Chongqing, Hong Kong, Urumqi',
        'Asia/Singapore' => 'Kuala Lumpur, Singapore',
        'Australia/Perth' => 'Perth',
        'Asia/Yakutsk' => 'Yakutsk',
        'Asia/Tokyo' => 'Osaka, Sapporo, Tokyo',
        'Asia/Seoul' => 'Seoul',
        'Australia/Adelaide' => 'Adelaide',
        'Australia/Darwin' => 'Darwin',
        'Asia/Vladivostok' => 'Vladivostok',
        'Asia/Magadan' => 'Magadan',
        'Australia/Brisbane' => 'Brisbane, Guam',
        'Australia/Sydney' => 'Sydney, Melbourne, Hobart',
        'Pacific/Noumea' => 'Solomon Is., New Caledonia',
        'Pacific/Norfolk' => 'Norfolk Island',
        'Asia/Anadyr' => 'Anadyr, Kamchatka',
        'Pacific/Auckland' => 'Auckland, Wellington',
        'Pacific/Fiji' => 'Fiji',
        'Pacific/Chatham' => 'Chatham Islands',
        'Pacific/Tongatapu' => 'Nuku\'alofa'
    ];

    public static $time_format = [
        'Y-m-d H:i:s T'     => '2016-03-10 17:16:18 NZST (Y-m-d H:i:s T)',
        'F j, Y, g:i a'     => 'March 10, 2016, 5:16 pm (F j, Y, g:i a)',
        'D M j G:i:s T Y'   => 'Sat Mar 10 17:16:18 NZST 2016 (D M j G:i:s T Y)',
        'g:i a, F j'        => '5:16 pm, March 10 (g:i a, F j)',
        'g:i a, d/m/y'      => '5:16 pm, 10/03/16 (g:i a, d/m/y)',
        'g:i a, m/d/y'      => '5:16 pm, 03/10/16 (g:i a, m/d/y)',
        'F jS - h:i:s A T'  => 'March 10th - 05:16:18 PM NZST'
    ];

    public static function getDate($time, $tzId = 'UTC', $format = 'Y-m-d H:i:s T')
    {
        if (is_null($time)) {
            return null;
        }
        if ($time == '0000-00-00 00:00:00') {
            return 'Never';
        }
        return Carbon::createFromTimestamp($time, $tzId)->format($format);
    }

    public static function getFormatted($tzId)
    {
        $offsetFormatted = Carbon::now(new DateTimeZone($tzId))->format('P');
        return 'UTC' . $offsetFormatted;
    }

    public static function selectTimezones()
    {
        $list = [];
        foreach (self::$timezones as $key => $value) {
            $temp = [
                'name'      => $value,
                'value'     => $key,
                'offset'    => self::getFormatted($key)
            ];
            array_push($list, $temp);
        }
        return $list;
    }

    public static function selectTimeFormat()
    {
        $list = [];
        foreach (self::$time_format as $key => $value) {
            $temp = [
                'name'  => $value,
                'value' => $key
            ];
            array_push($list, $temp);
        }
        return $list;
    }
}
