<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Share extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'file_id',
        'directory_id',
        'slug',
        'is_public',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function file() {
        return $this->belongsTo(File::class);
    }

    public function directory() {
        return $this->belongsTo(Directory::class);
    }
}

