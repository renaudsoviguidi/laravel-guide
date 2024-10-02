<?php

namespace App\Repositories;

use App\Interfaces\EtablissementRepositoryInterface;
use App\Models\Etablissement;

class EtablissementRepository implements EtablissementRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return Etablissement::all();
    }

    public function getById($id){
       return Etablissement::findOrFail($id);
    }

    public function store(array $data){
       return Etablissement::create($data);
    }

    public function update(array $data,$id){
       return Etablissement::whereId($id)->update($data);
    }
    
    public function delete($id){
       Etablissement::destroy($id);
    }
}
