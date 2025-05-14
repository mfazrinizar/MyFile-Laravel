<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class File extends Model
{
    use HasFactory, HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'directory_id',
        'name',
        'path',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function directory()
    {
        return $this->belongsTo(Directory::class);
    }

    public function share()
    {
        return $this->hasOne(Share::class);
    }
}
