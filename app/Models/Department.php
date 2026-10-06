<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'code',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function directors(): HasMany
    {
        return $this->hasMany(User::class)->where('role', UserRole::DIRECTOR->value);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class)->where('role', UserRole::EMPLOYEE->value);
    }

    public function portals(): HasMany
    {
        return $this->hasMany(Portal::class);
    }

    public function targetedPortals(): BelongsToMany
    {
        return $this->belongsToMany(Portal::class, 'portal_department')
            ->withTimestamps();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('short_name', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
        });
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
