<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewSubscriber extends Model
{
    use HasFactory;
    protected $table = "new_subscribers";
    protected $fillable = ['email'];
}
