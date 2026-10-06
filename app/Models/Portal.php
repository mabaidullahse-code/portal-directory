<?php

namespace App\Models;

use App\Enums\PortalStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Portal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'url',
        'purpose',
        'description',
        'status',
        'opening_date',
        'closing_date',
        'icon',
        'category_id',
        'user_id',
        'department_id',
        'contact_person',
        'contact_email',
        'contact_phone',
        'tags',
        'version',
        'remarks',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'status' => PortalStatus::class,
            'opening_date' => 'date',
            'closing_date' => 'date',
            'tags' => 'array',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Portal $portal) {
            if (empty($portal->slug)) {
                $baseSlug = Str::slug($portal->title);
                $portal->slug = $baseSlug . '-' . Str::random(5);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function targetDepartments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'portal_department')
            ->withTimestamps();
    }

    public function targetUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'portal_user')
            ->withTimestamps();
    }

    /**
     * Compute display status taking schedule into account without mutating underlying DB status.
     */
    public function getComputedStatusAttribute(): PortalStatus
    {
        if ($this->status !== PortalStatus::ACTIVE) {
            return PortalStatus::INACTIVE;
        }

        $today = Carbon::today();

        if ($this->opening_date && $this->opening_date->isAfter($today)) {
            return PortalStatus::SCHEDULED;
        }

        if ($this->closing_date && $this->closing_date->isBefore($today)) {
            return PortalStatus::EXPIRED;
        }

        return PortalStatus::ACTIVE;
    }

    public function getSafeUrlAttribute(): string
    {
        $url = trim($this->url);
        if (!preg_match('~^https?://~i', $url)) {
            return 'https://' . $url;
        }
        return $url;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', PortalStatus::ACTIVE->value);
    }

    public function scopeByDepartment(Builder $query, int $departmentId): Builder
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('purpose', 'like', "%{$term}%")
              ->orWhere('url', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhereHas('user', function (Builder $userQuery) use ($term) {
                  $userQuery->where('name', 'like', "%{$term}%");
              })
              ->orWhereHas('department', function (Builder $deptQuery) use ($term) {
                  $deptQuery->where('name', 'like', "%{$term}%")
                            ->orWhere('short_name', 'like', "%{$term}%");
              })
              ->orWhereHas('category', function (Builder $catQuery) use ($term) {
                  $catQuery->where('name', 'like', "%{$term}%");
              });
        });
    }
}
