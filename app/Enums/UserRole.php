<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    // Since the database column is an unsigned tinyint, values range between 0 and 255 (included)
    const Candidate = 0;
    const Expert = 1;
    const Admin = 2;

    /**
     * Return the enum as an array
     *
     * @return array
     */
    public static function toSelectArray(): array {
        $parent = parent::toArray();

        $resp = [];
        foreach($parent as $label => $value){
            $label = __('vocabulary.role.'.$label);
            $resp[] = (object) compact('value', 'label');
        }

        return $resp;
    }

    public static function getTranslatedLabel(int $value): string
    {
        return __('vocabulary.role.'.self::getKey($value));
    }
}
