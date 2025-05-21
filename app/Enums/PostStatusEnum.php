<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PostStatusEnum extends Enum
{
    const Draft = 0;
    const Publish = 1;

    /**
     * @param int
     * @return string
     */
    public static function getLabel($key)
    {
        switch ($key) {
            case self::Publish:
                return "Publish";
            case self::Draft:
                return "Draft";
            default:
                return "";
        }
    }
}