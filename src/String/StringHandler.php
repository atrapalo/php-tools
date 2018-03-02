<?php

namespace Atrapalo\PHPTools\String;

/**
 * Class StringHandler
 * @package Atrapalo\PHPTools\String
 */
class StringHandler
{
    /**
     * @return StringHandler
     */
    public static function getInstance()
    {
        return new self();
    }

    /**
     * @param string $text
     * @return string
     */
    public function removeAccents(string $text): string
    {
        $charactersWithAccents = $this->mbStringToArray(
            "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿºªç",
            "UTF-8"
        );

        $charactersWithoutAccents = $this->mbStringToArray(
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
    private function mbStringToArray(string $text, string $encoding): array
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
    public function sanitizeUrl(string $url): string
    {
        $encoding = mb_detect_encoding($url);
        $url = mb_convert_case($url, MB_CASE_LOWER, $encoding);

        $needle = [
            'a%9A','Ã³', 'ý', 'Ã', 'Õ', 'ã', 'õ', '`', "'", '&amp;',
            'ñ', 'ç', '-', ' ', 'à', 'è', 'ì','ò', 'ù', 'á',
            'é', 'í', 'ó', 'ú', '/', '´', '"', 'Á', 'É', 'Í',
            'Ó', 'Ú', 'ä', 'ë', 'ï', 'ö','ü', 'â', 'ê', 'î',
            'ô', 'û', '', '€', '$', '&', '!', '¡', '?', '¿',
            '=', '(', ')', '%', '+',',', '.', ';', '@', ':',
            '%', '*','º','ª','å','ø', '#', 'ß', 'æ', 'î', ',,'
        ];

        $haystack =  ['u', 'o', 'y', 'a', 'o', 'a', 'o', '-', '-', 'i',
            'n', 'c', '-', '-', 'a', 'e', 'i', 'o', 'u','a',
            'e', 'i', 'o', 'u', '-', '-', '', 'a', 'e', 'i',
            'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e','i',
            'o', 'u', 'euro', 'euro', 'dollar', 'i', '', '', '', '',
            '', '-', '-', '', '', '-', '-', '-','a', '-',
            '-', '-','','','a','o', '-', 'ss', 'ae', 'i', '-'
        ];

        $url = urlencode(str_ireplace($needle, $haystack, strtolower($url)));
        $url = trim(preg_replace('/-+/', '-', $url), '-');

        return $url;
    }

    /**
     * @param string $text
     * @return string
     */
    public function sanitizeString(string $text): string
    {
        return $this->removeSpecialChars($this->removeAccents($text));
    }

    /**
     * @param string $text
     * @return string
     */
    public function removeSpecialChars(string $text): string
    {
        $text = preg_replace('/[^A-Za-z0-9]/', ' ', $text);

        return $this->removeExtraSpaces($text);
    }

    /**
     * @param string $text
     * @return string
     */
    public function removeExtraSpaces(string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}
