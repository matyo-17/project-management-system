<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        "created_at", "updated_at", "deleted_at",
    ];

    /**
     * Get the attributes that should be cast.
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

    public function role(): BelongsTo {
        return $this->belongsTo(Roles::class, "role_id", "id");
    }

    public function projects(): BelongsToMany {
        return $this->belongsToMany(
            Projects::class, ProjectUsers::class,
            "user_id", "project_id"
        );
    }

    public function has_permission(string $key): bool {
        return $this->role->permissions->contains("name", $key);
    }

    public function is_admin(bool $super=false): bool {
        $is_admin = $this->role->admin === 1;
        if (!$super) {
            return $is_admin;
        } else {
            return $is_admin && ($this->role->name === "super");
        }
    }

    public static function normal_users() {
        return self::whereHas('role', function ($q) {
            $q->where('admin', 0);
        })->get();
    }
}
