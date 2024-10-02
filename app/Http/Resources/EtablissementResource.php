<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EtablissementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'nom_etablissement' => $this->nom_etablissement,
            'nom_dirigeant' => $this->nom_dirigeant,
            'email_etablissement' => $this->email_etablissement,
            'telephone' => $this->telephone,
            'adresse' => $this->adresse
        ];
    }
}
