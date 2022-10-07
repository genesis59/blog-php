<?php

declare(strict_types=1);

namespace App\Service;

class Slugify
{
    public function slugify(string $value): string
    {

        $slug = strtolower(strtr($value, [
            "á" => "a","à" => "a","â" => "a","ä" => "a",
            "ã" => "a","å" => "a","ç" => "c","é" => "e",
            "è" => "e","ê" => "e","ë" => "e","í" => "i",
            "ì" => "i","î" => "i","ï" => "i","ñ" => "n",
            "ó" => "o","ò" => "o","ô" => "o","ö" => "o",
            "õ" => "o","ú" => "u","ù" => "u","û" => "u",
            "ü" => "u","ý" => "y","ÿ" => "y","æ" => "ae",
            "œ" => "oe"," " => "_"]));

        $specialCharInValue = preg_filter("/[A-Za-z0-9]+(?:-[A-Za-z0-9]+)*/", "", $value);
        if ($specialCharInValue) {
            foreach (str_split(trim($specialCharInValue)) as $char) {
                $slug = str_replace($char, "_", $slug);
            }
        }
        return $slug;
    }
}
