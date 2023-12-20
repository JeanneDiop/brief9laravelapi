<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCandidatureRequest;
use App\Http\Requests\RefuserCandidatureRequest;
use App\Http\Requests\AccepterCandidatureRequest;


class CandidatureController extends Controller
{

  public function index()
  {
    try {
      return response()->json([
        'status_code' => 200,
        'status_message' => ' toutes les candidatures ont été recupéré',
        'data' => Candidature::all(),
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }


  
  public function listeraccepter(Candidature $candidatures)
  {
    try {
      // $candidatures = Candidature::find($id);
      $candidatures = Candidature::where('statut', 'accepter')->get();
      return response()->json([
        'status_code' => 200,
        'status_message' => ' toutes les candidatures acceptées ont été recupérées',
        'data' => $candidatures,
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

  public function listerrefuser(Candidature $candidatures)
  {
    try {
      $candidatures=Candidature::where('statut', 'refuser')->get();
      return response()->json([
        'status_code' => 200,
        'status_message' => ' toutes les candidatures refusées ont été recupérées',
        'data' => $candidatures
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
    public function store(CreateCandidatureRequest $request)
    {
      try {
        $candidature= new Candidature();
        $candidature->user_id=$request->user_id;
        $candidature->formation_id=$request->formation_id;
        $candidature->statut = $request->statut;
        $candidature->save();
  
        return response()->json([
          'status_code' => 200,
          'status_message' => 'candidature a été ajoutée',
          'data' => $candidature
        ]);
      } catch (Exception $e) {
        return response()->json($e);
      }
    }
  public function update(AccepterCandidatureRequest $request,$id)
  {
    try{
      $candidature = Candidature::findOrFail($id);
      $candidature->user_id=$request->user_id;
      $candidature->formation_id=$request->formation_id;
      $candidature->update(['statut' => 'accepter']);

      return response()->json([
        'status_code' => 200,
        'status_message' => 'candidature a été modifiée',
        'data' => $candidature

      ]);

    }catch (Exception $e){
      return response()->json($e);
    }
  }

  public function refuser(RefuserCandidatureRequest $request,$id)
  {
    try{
      $candidature = Candidature::findOrFail($id);
      $candidature->user_id=$request->user_id;
      $candidature->formation_id=$request->formation_id;
      $candidature->update(['statut' => 'refuser']);

      return response()->json([
        'status_code' => 200,
        'status_message' => 'candidature a été modifiée',
        'data' => $candidature

      ]);

    }catch (Exception $e){
      return response()->json($e);
    }
  }
}
