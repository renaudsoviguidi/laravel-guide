<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEtablissementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'nom_etablissement' => 'required|string',
            'nom_dirigeant' => 'required',
            'email_etablissement' => 'required|unique:etablissements,email_etablissement',
            'telephone' => ['required', 'phone:AUTO']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Erreurs de validation',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'telephone.phone' => 'Le numéro de téléphone est invalide.',
        ];
    }
}
