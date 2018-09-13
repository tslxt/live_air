<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Student = 1;
    const Teacher = 2;
    const Administrator = 3;
    const SuperAdministrator = 4;
}
