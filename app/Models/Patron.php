<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_information',
    ];

    public function borrowingRecords()
    {
        return $this->hasMany(BorrowingRecord::class);
    }
}
