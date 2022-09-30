<?php

declare(strict_types=1);

namespace App\Service;

class Slugify
{
    public function slugify(string $value): string
    {
        $slug = str_replace(" ", "-", $value);

        $specialCharInValue = preg_filter("/[A-Za-z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+(?:-[A-Za-z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+)*/", "", $value);
        if ($specialCharInValue) {
            foreach (str_split(trim($specialCharInValue)) as $char) {
                $slug = str_replace($char, "", $slug);
            }
        }
        $slug = str_replace("--", "-", $slug);
        return rtrim($slug, "-");
    }
}
