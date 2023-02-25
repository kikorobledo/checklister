<?php

namespace App\Models;

use App\Models\User;
use App\Models\Checklist;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Task extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = ['name', 'description', 'checklist_id', 'position', 'user_id', 'task_id', 'compleated_at', 'added_to_my_day_at', 'is_important', 'due_date', 'reminder_at'];

    protected $casts = [
        'due_date' => 'date',
        'reminder_at' => 'date'
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width('600');
    }

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
