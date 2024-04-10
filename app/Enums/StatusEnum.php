<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case CANCELED = 'canceled';
    case RESOLVED = 'resolved';
    case ABANDONED  = 'abandoned';


    public function getReadableText(): string
    {
        return match ($this){
            self::PENDING => __('status.pending'),
            self::CANCELED => __('status.canceled'),
            self::RESOLVED => __('status.resolved'),
            self::ABANDONED => __('status.abandoned'),
        };
    }

    public function getValues(): array
    {
        return getEnumValues(self::class);
    }
}
