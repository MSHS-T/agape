<?php

namespace App\Utils;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Process;

class Version
{
    public static function get(): ?array
    {
        if (Process::run('git --version')->failed()) {
            return null;
        }

        $tagResult = Process::path(base_path())->run('git describe --tags --abbrev=0');
        $tag = null;
        if ($tagResult->successful() && filled($tagResult->output())) {
            $tag = trim($tagResult->output());
        }

        $hashResult = Process::path(base_path())->run('git log --pretty="%h" -n1 HEAD');
        $hash = trim($hashResult->output());
        $dateResult = Process::path(base_path())->run('git log -n1 --pretty=%ci HEAD');
        $date = Carbon::parse(trim($dateResult->output()));
        return [
            'tag'    => $tag,
            'date'   => $date,
            'hash'   => $hash,
            'string' => sprintf('%s (%s)', $tag ?? $hash, $date->format('d/m/y H:i')),
        ];
    }
}
