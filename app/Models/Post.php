<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = 
    [
        'user_id',
        'title',
        'content',
        'published_at',
        'status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public const TYPE_ACTIVE = 'active';
    public const TYPE_SCHEDULED = 'scheduled';
    public const TYPE_DRAFT = 'draft';

    public function user ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
