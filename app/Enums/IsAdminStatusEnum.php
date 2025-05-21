<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class IsAdminStatusEnum extends Enum
{
    const Subscriber = 0;
    const Admin = 1;

    const Client = 2;

    /**
     * @param int
     * @return string
     */
    public static function getLabel($key)
    {
        switch ($key) {
            case self::Subscriber:
                return "Subscriber";
            case self::Admin:
                return "Admin";
            case self::Client:
                return "Client";
            default:
                return "";
        }
    }
}