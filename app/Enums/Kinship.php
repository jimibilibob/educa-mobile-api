<?php

namespace App\Enums;

use App\Enums\Traits\HasArrayValues;

enum Kinship: string
{
    use HasArrayValues;

    case PARENTS = 'Padre/Madre';
    case TUTOR = 'Tutor';
    case GRANDPARENTS = 'Abuelo(a)';
    case UNCLES = 'Tio(a)';
    case OTHERS = 'Otro';
}
