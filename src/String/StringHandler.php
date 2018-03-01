<?php

namespace Atrapalo\PHPTools\String;

/**
 * Class StringHandler
 * @package Atrapalo\PHPTools\String
 */
class StringHandler
{
    /**
     * @param string $text
     * @return string
     */
    public static function removeAccentsByString(string $text): string
    {
        $charactersWithAccents = self::mbStringToArray(
            "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿºªç",
            "UTF-8"
        );

        $charactersWithoutAccents = self::mbStringToArray(
            "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyyoac",
            "UTF-8"
        );

        return str_replace($charactersWithAccents, $charactersWithoutAccents, $text);
    }

    /**
     * @param string $text
     * @param string $encoding
     * @return array
     */
    private static function mbStringToArray(string $text, string $encoding): array
    {
        $result = [];
        $length = mb_strlen($text);

        while ($length) {
            $result[] = mb_substr($text, 0, 1, $encoding);
            $text = mb_substr($text, 1, $length, $encoding);
            $length = mb_strlen($text);
        }

        return $result;
    }

    /**
     * @param string $url
     * @return string
     */
    public static function sanitizeUrl(string $url): string
    {
        $encoding = mb_detect_encoding($url);
        $url = mb_convert_case($url, MB_CASE_LOWER, $encoding);

        $needle = [
            'a%9A','Ã³', 'ý', 'Ã', 'Õ', 'ã', 'õ', '`', "'", '&amp;',
            'ñ', 'ç', '-', ' ', 'à', 'è', 'ì','ò', 'ù', 'á',
            'é', 'í', 'ó', 'ú', '/', '´', '"', 'Á', 'É', 'Í',
            'Ó', 'Ú', 'ä', 'ë', 'ï', 'ö','ü', 'â', 'ê', 'î',
            'ô', 'û', '', '$', '&', '!', '¡', '?', '¿',
            '=', '(', ')', '%', '+',',', '.', ';', '@', ':',
            '%', '*','º','ª','å','ø', '#', 'ß', 'æ', 'î', ',,'
        ];

        $haystack =  ['u', 'o', 'y', 'a', 'o', 'a', 'o', '-', '-', 'i',
            'n', 'c', '-', '-', 'a', 'e', 'i', 'o', 'u','a',
            'e', 'i', 'o', 'u', '-', '-', '', 'a', 'e', 'i',
            'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e','i',
            'o', 'u', 'euro', 'dollar', 'i', '', '', '', '',
            '', '-', '-', '', '', '-', '-', '-','a', '-',
            '-', '-','','','a','o', '-', 'ss', 'ae', 'i', '-'
        ];

        $url = urlencode(str_ireplace($needle, $haystack, strtolower($url)));
        $url = str_replace(['-+', '---', '--'], '-', $url);

        return $url;
    }

    /**
     * @param string $text
     * @return string
     */
    public static function sanitizeString(string $text): string
    {
        return self::removeSpecialChars(self::removeAccentsByString($text));
    }

    /**
     * @param string $text
     * @return string
     */
    public static function removeSpecialChars(string $text): string
    {
        $text = preg_replace('/[^A-Za-z0-9]/', ' ', $text);

        return self::removeExtraSpaces($text);
    }

    /**
     * @param string $text
     * @return string
     */
    public static function removeExtraSpaces(string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}
