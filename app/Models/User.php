<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'remember_token',
        'phone', 'address', 'city', 'state', 'country',
        'website', 'facebook', 'twitter', 'instagram', 'youtube', 'linkedin', 'github',
        'description', 'profile_image', 'college_id', 'role_id', 'status'
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

    // ---- Relationships ----

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class , 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedProjects()
    {
        return $this->belongsToMany(Project::class , 'project_likes', 'user_id', 'project_id')
            ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class , 'followers', 'follower_id', 'user_id')
            ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class , 'followers', 'user_id', 'follower_id')
            ->withTimestamps();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class , 'team_members', 'user_id', 'team_id');
    }

    /**
     * Get all projects associated with the user.
     * Includes projects they created directly AND projects associated with teams they belong to.
     */
    public function allProjects()
    {
        $teamIds = $this->teams()->pluck('teams.id');

        return Project::where(function ($query) use ($teamIds) {
            $query->where('created_by', $this->id)
                ->orWhereHas('teams', function ($q) use ($teamIds) {
                $q->whereIn('teams.id', $teamIds);
            }
            );
        });
    }

    /**
     * Get ranked list of top contributors.
     */
    public static function getTopContributors($limit = null)
    {
        $query = self::with(['college.university'])
            ->withCount(['projects' => function($query) {
                $query->where('status', true);
            }]);

        $contributors = $query->get()
            ->map(function($user) {
                $userProjects = Project::where('created_by', $user->id)->get();
                $user->total_likes = $userProjects->sum(function($p) { return $p->likes()->count(); });
                $user->total_views = $userProjects->sum('views');
                $user->total_downloads = $userProjects->sum('downloads');
                
                $user->rank_score = ($user->projects_count * 10) + ($user->total_likes * 2) + (int)($user->total_views / 10) + ($user->total_downloads * 5);
                
                return $user;
            })
            ->filter(function($user) {
                return $user->projects_count > 0;
            })
            ->sortByDesc('rank_score')
            ->values();

        if ($limit) {
            return $contributors->take($limit);
        }

        return $contributors;
    }
}
