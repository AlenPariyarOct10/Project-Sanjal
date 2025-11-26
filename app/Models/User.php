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
        'id', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'phone', 'address', 'city', 'state', 'country', 'website', 'facebook', 'twitter', 'instagram', 'youtube', 'linkedin', 'github', 'description', 'profile_image', 'college_id', 'role_id'
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function likedProjects()
    {
        return $this->belongsToMany(Project::class, 'project_likes', 'user_id', 'project_id')
            ->withTimestamps();
    }


    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')
            ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')
            ->withTimestamps();
    }
}
