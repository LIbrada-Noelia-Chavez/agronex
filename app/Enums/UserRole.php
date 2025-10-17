<?php

namespace App\Enums;

class UserRole
{
    const CAPATAZ_CULTIVO = 'capataz_cultivo';
    const ADMIN = 'admin';
    // Agrega otros roles según necesites
    
    public static function all(): array
    {
        return [
            self::CAPATAZ_CULTIVO,
            self::ADMIN,
        ];
    }
}