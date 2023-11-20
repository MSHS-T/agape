<?php

namespace App\Utils;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MimeType
{

    public static function getList()
    {
        return Cache::get('mime_list', function () {
            $s = array();
            $content = Storage::disk('local')->get('mime.types');
            foreach (@explode("\n", $content) as $row)
                if (
                    filled($row)
                    && !Str::startsWith($row, '#')
                    && preg_match_all('#([^\s]+)#', $row, $out)
                    && isset($out[1])
                    && ($c = count($out[1])) > 1
                ) {
                    for ($i = 1; $i < $c; $i++) {
                        $s[$out[1][$i]] = $out[1][0];
                    }
                }
            ksort($s);
            return $s;
        });
    }

    public static function getByExtension(string $extension): ?string
    {
        $sanitizedExtension = Str::lower(trim($extension));
        if (Str::startsWith($sanitizedExtension, '.')) {
            $sanitizedExtension = Str::after($sanitizedExtension, '.');
        }
        return self::getList()[$sanitizedExtension] ?? null;
    }

    public static function getByExtensionList(string $extensionList): array
    {
        $extensionList = explode(',', $extensionList);
        $mimeList = [];
        foreach ($extensionList as $extension) {
            $mimeList[] = self::getByExtension($extension);
        }

        return $mimeList;
    }
}
