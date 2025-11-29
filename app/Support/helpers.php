<?php

if (! function_exists('numerals_to_latin')) {
    /**
     * Convert Arabic-Indic and Extended Arabic-Indic numerals to Latin (0-9).
     * Keeps other characters unchanged.
     *
     * @param mixed $input
     * @return string
     */
    function numerals_to_latin($input)
    {
        $s = (string) $input;

        $map = [
            // Arabic-Indic digits (U+0660..U+0669)
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
            // Eastern Arabic-Indic / Persian digits (U+06F0..U+06F9)
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
        ];

        return str_replace(array_keys($map), array_values($map), $s);
    }
}
