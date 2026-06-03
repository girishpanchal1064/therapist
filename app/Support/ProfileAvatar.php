<?php

namespace App\Support;

class ProfileAvatar
{
    public const PLACEHOLDER_PATH = 'assets/img/avatars/1.png';

    public static function placeholderUrl(): string
    {
        return asset(self::PLACEHOLDER_PATH);
    }

    public static function url(?string $storagePath): string
    {
        return $storagePath
            ? asset('storage/' . $storagePath)
            : self::placeholderUrl();
    }
}
