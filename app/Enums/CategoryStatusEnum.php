<?php

namespace App\Enums;

enum CategoryStatusEnum: int
{
    case active = 1;
    case inactive = 2;


    public function label(): string
    {
        return match($this) {
            CategoryStatusEnum::active => __('trans.active'),
            CategoryStatusEnum::inactive => __('trans.inactive'),
        };
    }

    public function style()
    {
        return match($this) {
            CategoryStatusEnum::active => 'success',
            CategoryStatusEnum::inactive => 'danger',
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
