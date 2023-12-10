<?php

namespace App\Enums;

use App\Enums\MetaProperties\Color;
use App\Enums\MetaProperties\Label;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use Filament\Support\Colors\Color as FilamentColor;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectCallStatus: string implements HasLabel, HasColor
{
    case PLANNED = 'planned';
    case APPLICATION = 'application';
    case WAITING_FOR_EVALUATION = 'waiting_for_evaluation';
    case EVALUATION = 'evaluation';
    case FINISHED = 'finished';
    case ARCHIVED = 'archived';

    public function getLabel(): ?string
    {
        return __('attributes.project_call_status.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PLANNED                => FilamentColor::Cyan,
            self::APPLICATION            => FilamentColor::Blue,
            self::WAITING_FOR_EVALUATION => FilamentColor::Yellow,
            self::EVALUATION             => FilamentColor::Orange,
            self::FINISHED               => FilamentColor::Green,
            self::ARCHIVED               => FilamentColor::Gray,
        };
    }
}
