<?php

namespace App\Enums;

enum UserStatusEnum: int
{
    case Active = 1;
    case Inactive = 2;


    public function label(): string
    {
        return match($this) {
            UserStatusEnum::Active => __('trans.active'),
            UserStatusEnum::Inactive => __('trans.inactive'),
        };
    }

    public function style()
    {
        return match($this) {
            UserStatusEnum::Active => 'success',
            UserStatusEnum::Inactive => 'danger',
        };
    }

    public static function labels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }
        return $labels;
    }

}
