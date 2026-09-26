<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int $id
 * @property string $name
 * @property string $avatar
 * @property string $email
 * @property string $role
 * @property boolean $status
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Application> $applications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContactType> $contactTypes
 * @property-read int|null $applications_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User Filters(Request $request)
 * @mixin \Eloquent
 */
#[Fillable(['name', 'email', 'password', 'role', 'status', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isUser(): bool
    {
        return $this->role == 'user';
    }

    public function roleLabel(): string
    {
        switch ($this->role) {
            case 'admin':
                return 'Администратор';
            case 'user':
                return 'Пользователь';
            default:
                return 'Оно';
        }
    }

    public function scopeFilters(Builder $builder, Request $request): Builder
    {
        return $builder
            ->when(!is_null($request->status) && in_array($request->status, [0, 1]), function (Builder $builder) use ($request) {
                $builder->where('status', $request->status);
            })
            ->when($request->search, function (Builder $builder) use ($request) {
                $builder->where('name', 'like', '%' . $request->search . '%');
            });
    }

    public function contactTypes(): BelongsToMany
    {
        return $this->belongsToMany(ContactType::class)->withPivot('subject');
    }

    public function getAvatarAttribute(): ?string
    {
        if (isset($this->attributes['avatar']) && $this->attributes['avatar']) {
            return url('storage/avatars/' . $this->attributes['avatar']);
        }
        return null;
    }

    public function removeAvatar(): bool
    {
        if (!$this->avatar) {
            return false;
        }
        $filePath = 'storage/avatars/' . $this->attributes['avatar'];

        if (File::exists($filePath)) {
            File::delete($filePath);
            $this->avatar = null;
            $this->save();
        }
        return true;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
