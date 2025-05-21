<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StageStatusEnum extends Enum
{
    const Ongoing = 1;
    const Completed = 2;

    /**
     * @param int
     * @return string
     */
    public static function getLabel($key)
    {
        $labels = [
            self::Ongoing => "Ongoing",
            self::Completed => "Completed",
        ];

        return $labels[$key] ?? "Unknown";
    }
}