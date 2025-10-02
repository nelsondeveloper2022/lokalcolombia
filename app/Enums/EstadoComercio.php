<?php

namespace App\Enums;

enum EstadoComercio: string
{
    case PENDIENTE = 'pendiente';
    case APROBADO = 'aprobado';
    case RECHAZADO = 'rechazado';
    case ELIMINADO = 'eliminado';

    public function label(): string
    {
        return match($this) {
            self::PENDIENTE => 'Pendiente',
            self::APROBADO => 'Aprobado',
            self::RECHAZADO => 'Rechazado',
            self::ELIMINADO => 'Eliminado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDIENTE => 'warning',
            self::APROBADO => 'success',
            self::RECHAZADO => 'danger',
            self::ELIMINADO => 'secondary',
        };
    }

    public static function getOptions(): array
    {
        return [
            self::PENDIENTE->value => self::PENDIENTE->label(),
            self::APROBADO->value => self::APROBADO->label(),
            self::RECHAZADO->value => self::RECHAZADO->label(),
            self::ELIMINADO->value => self::ELIMINADO->label(),
        ];
    }
}