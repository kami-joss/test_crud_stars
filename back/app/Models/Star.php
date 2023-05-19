<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    use HasFactory;

    // Column labels
    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_FIRSTNAME = 'firstname';
    const COLUMN_DESCRIPTION = 'description';

    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_FIRSTNAME,
        self::COLUMN_DESCRIPTION,
    ];
}
