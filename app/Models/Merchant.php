<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    protected $appends = ['notes_count'];

    public function getNotesCountAttribute()
    {
        return $this->notes()->count();
    }
}