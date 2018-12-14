<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    // Since the database column is an unsigned tinyint, values range between 0 and 255 (included)
    const Candidate = 0;
    const Expert = 1;
    const Admin = 2;
}
