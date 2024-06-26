<?php

namespace App\Enum;

enum VentureStatusEnum: string
{
    case ONGOING = 'ongoing';

    case ABANDONED = 'abandoned';

    case COMPLETE = 'complete';

    case MILESTONE = 'milestone';
    case HOBBY = 'hobby';

    case RELEASE = 'release';

}
