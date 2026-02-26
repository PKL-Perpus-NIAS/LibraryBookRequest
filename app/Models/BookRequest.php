<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_title', 'type_of_material', 'author', 'publisher', 
        'publication_city', 'publication_year', 'requester_name', 
        'faculty', 'email', 'status'
    ];
}