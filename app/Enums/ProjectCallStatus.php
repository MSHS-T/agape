<?php

namespace App\Enums;

use App\Enums\MetaProperties\Color;
use App\Enums\MetaProperties\Label;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use Filament\Support\Colors\Color as FilamentColor;

/**
 * @method string label()
 * @method FilamentColor color()
 */
#[Meta(Label::class, Color::class)]
enum ProjectCallStatus: int
{
    use Metadata;

    #[Label('attributes.project_call_status.planned')]
    #[Color(FilamentColor::Cyan)]
    case PLANNED = 0;

    #[Label('attributes.project_call_status.application')]
    #[Color(FilamentColor::Blue)]
    case APPLICATION = 1;

    #[Label('attributes.project_call_status.waiting_for_evaluation')]
    #[Color(FilamentColor::Yellow)]
    case WAITING_FOR_EVALUATION = 2;

    #[Label('attributes.project_call_status.evaluation')]
    #[Color(FilamentColor::Orange)]
    case EVALUATION = 3;

    #[Label('attributes.project_call_status.waiting_for_decision')]
    #[Color(FilamentColor::Red)]
    case WAITING_FOR_DECISION = 4;

    #[Label('attributes.project_call_status.finished')]
    #[Color(FilamentColor::Green)]
    case FINISHED = 5;

    #[Label('attributes.project_call_status.archived')]
    #[Color(FilamentColor::Gray)]
    case ARCHIVED = 6;
}
