<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number', 'book_title', 'type_of_material', 'author', 
        'publisher', 'publication_city', 'publication_year', 
        'requester_name', 'faculty', 'email', 'status', 'notes'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $today = now()->format('Ymd');
            
            $lastRequest = static::whereDate('created_at', now()->toDateString())
                                 ->orderBy('id', 'desc')
                                 ->first();
            
            if ($lastRequest && $lastRequest->request_number) {
                $lastSequence = intval(substr($lastRequest->request_number, -3));
                $newSequence = $lastSequence + 1;
            } else {
                $newSequence = 1;
            }

            $model->request_number = 'REQ-' . $today . '-' . str_pad($newSequence, 3, '0', STR_PAD_LEFT);
        });
    }
}