<?php

namespace App\Enum;

use App\Traits\EnumParser;

enum TypeEnum:string
{
    use EnumParser;

    case WEB = "web";
    case Mobile = "mobile";
}
