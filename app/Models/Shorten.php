<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shorten extends Model
{
    use HasFactory;

    protected $table = "shorten";

    protected $fillable = [
        'url',
        'shortened_url',
        'website_title',
        'accesses'
    ];

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "url" => $this->url,
            "shortened_url" => env("APP_URL") . '/' . $this->shortened_url,
            "website_title" => $this->website_title,
            "accesses" => $this->accesses
        ];
    }
}
