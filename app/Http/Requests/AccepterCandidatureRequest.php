<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccepterCandidatureRequest extends FormRequest
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
            'user_id' => 'required',
           'formation_id'=> 'required',
           'statut'=>['required','in:en attente,accepter,refuser']
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
            'user_id.required'=>'user_id doit etre fourni',
            'formation_id.required'=>'formation_id doit etre fourni',
            'statut.in.required' => 'Le champ :attribute doit être une valeur d\'énumération valide.'

        ];
    }   
}
