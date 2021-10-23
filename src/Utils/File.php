<?php

namespace Atakankorkmaz\Utils;

class File
{
    public static function getExtension(string $path): string
    {
        $explodedName = explode('.', $path);
        return end($explodedName);
    }
}
