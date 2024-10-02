<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory; 
    public $table = "etablissements";
    protected $primaryKey = "id";
    public $incrementing = true;
    protected $keyType = 'string';

    protected $fillable = ['nom_etablissement', 'nom_dirigeant', 'email_etablissement', 'telephone', 'adresse'];
}
