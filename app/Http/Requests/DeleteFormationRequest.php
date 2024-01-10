<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteFormationRequest extends FormRequest
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
        'nom' => 'required|max:255',
        'details' => 'required|max:255',
        'duree' => 'required|integer|min:1|max:12',
        'user_id'=>'required'
       
    ];
}
public function failedValidation(Validator $validator)
{
    throw new HttpResponseException(response()->json([
        'success'=>false,
        'error'=>true,
        'message'=>'Erreur de validation',
        'errorsList'=>$validator->errors()

    ]));
}
public function messages(){
    return[
        'nom.required'=>'un nom doit etre fourni',
        'detail.required'=>' detail doit etre fourni',
        'duree.required'=>'duree doit etre fourni'

    ];
}
}
