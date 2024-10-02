<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table = "categories";
    protected $primaryKey = "id";
    public $incrementing = true;
    protected $keyType = 'string';

    protected $fillable = ['libelle', 'description'];
}
