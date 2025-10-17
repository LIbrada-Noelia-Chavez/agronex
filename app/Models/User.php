<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Atributos que deben ocultarse al serializar.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipos de datos para los atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     */
    public function hasRole(string $role): bool
    {
        return strtolower($this->role) === strtolower($role);
    }

    /**
     * Verifica si el usuario tiene alguno de los roles especificados.
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verifica si el usuario es capataz de cultivo.
     */
    public function isCapatazCultivo(): bool
    {
        return $this->hasRole('capataz_cultivo');
    }

    /**
     * Verifica si el usuario es capataz de ganado.
     */
    public function isCapatazGanado(): bool
    {
        return $this->hasRole('capataz_ganado');
    }

    /**
     * Verifica si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Scope para filtrar usuarios por rol.
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope para filtrar usuarios por múltiples roles.
     */
    public function scopeWhereRoleIn($query, array $roles)
    {
        return $query->whereIn('role', $roles);
    }

    /**
     * Devuelve los roles disponibles en la aplicación.
     */
    public static function getAvailableRoles(): array
    {
        return [
            'capataz_cultivo' => 'Capataz de Cultivo',
            'capataz_ganado'  => 'Capataz de Ganado',
            'admin'           => 'Administrador',
        ];
    }

    /**
     * Devuelve el nombre legible del rol del usuario.
     */
    public function getRoleNameAttribute(): string
    {
        $roles = self::getAvailableRoles();
        return $roles[$this->role] ?? ucfirst($this->role);
    }
}
