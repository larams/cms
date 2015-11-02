<?php

namespace Talandis\Larams;

class Utils
{

    public static function toAscii($str, $replace = array(), $delimiter = '-')
    {

        $translit = array(
                    "А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
                    "Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i",
                    "Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n",
                    "О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t",
                    "У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch",
                    "Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"",
                    "Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b",
                    "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo",
                    "ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k",
                    "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p",
                    "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f",
                    "х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch",
                    "ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu",
                    "я"=>"ya",'ą' => 'a', 'č' => 'c','ę' => 'e','ė' => 'e','š' => 's','ų' => 'u','ū' => 'u','ž' => 'z',
                    'Ą' => 'a','Č' => 'c','Ę' => 'e','Ė' => 'e','Į' => 'i','Š' => 's','Ų' => 'u','Ū' => 'u','Ž' => 'z'
                );

        $str = strtr( $str, $translit );

        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

}