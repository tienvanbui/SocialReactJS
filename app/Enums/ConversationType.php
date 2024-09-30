<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PUBLIC()
 * @method static static PRIVATE()
 */
final class ConversationType extends Enum
{
    public const PUBLIC = 0;
    public const PRIVATE = 1;
}
