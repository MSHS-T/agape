<?php

namespace App\Enums;

use App\ProjectCallType;
use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

final class UserRole extends Enum
{
    // Since the database column is an unsigned tinyint, values range between 0 and 255 (included)
    const Candidate = 0;
    const Expert = 1;
    const Admin = 2;
    const Manager = 3;

    /**
     * Return the enum as an array
     *
     * @return array
     */
    public static function toSelectArray(): array
    {
        $parent = parent::toArray();

        $resp = [];
        foreach ($parent as $label => $value) {
            $label = __('vocabulary.role.' . $label);
            $resp[] = (object) compact('value', 'label');
        }

        return $resp;
    }

    public static function toSelectArrayWithTypes(): array
    {
        $parent = parent::toArray();
        $types = ProjectCallType::all();
        $resp = [];
        foreach ($parent as $label => $value) {
            if ($value === self::Manager) {
                $originalValue = intval($value);
                foreach ($types as $type) {
                    $label = __('vocabulary.role.ManagerType', ['type' => $type->label_short]);
                    $value = $originalValue . '-' . $type->id;
                    $resp[] = (object) compact('value', 'label');
                }
            } else {
                $label = __('vocabulary.role.' . $label);
                $resp[] = (object) compact('value', 'label');
            }
        }

        return $resp;
    }

    public static function getTranslatedLabel(int $value): string
    {
        return __('vocabulary.role.' . self::getKey($value));
    }

    public static function getLabel($value): string
    {
        if (Str::startsWith($value, '3-')) {
            list($role, $type) = array_map('intval', explode('-', $value));
            $type = ProjectCallType::find($type);
            return __('vocabulary.role.ManagerType', ['type' => $type->label_short]);
        } else {
            return self::getTranslatedLabel(intval($value));
        }
    }

    public static function isValid($value): bool
    {
        if (Str::startsWith($value, '3-')) {
            list($role, $type) = array_map('intval', explode('-', $value));
            return ProjectCallType::find($type) !== null;
        } else {
            return in_array($value, self::getKeys());
        }
    }
}
