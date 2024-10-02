<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $table = "products";
    protected $primaryKey = "id";
    public $incrementing = true;
    protected $keyType = 'string';

    protected $fillable = ['nom', 'details', 'image', 'prix', 'category_id'];

    public function get_category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
