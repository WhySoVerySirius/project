<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Casts\Attribute;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $fillable = [
        'id',
        'title',
        'description',
        'active',
        'uuid',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function getByUuid(string $uuid, ?array $visible = []): self
    {
        $news =  News::where('uuid', '=',  $uuid)->get()->first();
        if ($visible !== null) {
            foreach ($visible as $item) {
                $news->category->makeVisible($item);
            }
        }
        return $news;
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            set : fn ($value) => ucfirst($value)
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            set : fn ($value) => ucfirst($value)
        );
    }
}
