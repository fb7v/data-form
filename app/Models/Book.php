<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['id', 'title', 'author', 'genre', 'price', 'publish_date', 'description'];
    public $incrementing = false;
    protected $primaryKey = 'id';
}
