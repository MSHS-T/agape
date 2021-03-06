<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CallType extends Enum
{
    // Since the database column is an unsigned tinyint, values range between 0 and 255 (included)
    const Unknown = 0;
    const Region = 1;
    const Exploratoire = 2;
    const Workshop = 3;

    /**
     * Return the enum as an array, excluding zero value (Unknown type)
     *
     * @return array
     */
    public static function toArray(): array {
        $parent = parent::toArray();

        return array_filter($parent, function($value){
            return $value > 0;
        });
    }
}
