<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'department_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Role constants
    const ROLE_ADMIN = 0;
    const ROLE_LEVEL1 = 1; // Ban ISO
    const ROLE_LEVEL2 = 2; // Cơ quan - Phân xưởng
    const ROLE_LEVEL3 = 3; // Người sử dụng

    /**
     * Get role name
     */
    public function getRoleName()
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_LEVEL1 => 'Ban ISO',
            self::ROLE_LEVEL2 => 'Cơ quan - Phân xưởng',
            self::ROLE_LEVEL3 => 'Người sử dụng',
            default => 'Unknown',
        };
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }



    /**
     * Department relationship
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
