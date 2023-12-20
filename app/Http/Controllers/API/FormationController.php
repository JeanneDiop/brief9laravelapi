<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Role;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditFormationRequest;
use App\Http\Requests\CreateFormationRequest;
use App\Models\User;

class FormationController extends Controller
{

   public function index()
  {
    try {
      return response()->json([
        'status_code' => 200,
        'status_message' => ' toutes les formations ont été recupéré',
        'data' => Formation::all(),
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

  public function store(CreateFormationRequest $request)
  {
    try {
      $formation = new Formation();
      $formation->nom = $request->nom;
      $formation->details = $request->details;
      $formation->duree = $request->duree;
      $formation->user_id=$request->user_id;
      $formation->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'formation a été ajouté',
        'data' => $formation
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

  public function update(EditFormationRequest $request, $id)
  {
   
    try {

      $formation = Formation::find($id);

        $formation->nom = $request->nom;
        $formation->details = $request->details;
        $formation->duree = $request->duree;
        $formation->user_id=$request->user_id;
        $formation->save();
        return response()->json([
          'status_code' => 200,
          'status_message' => 'formation a été modifié',
          'data' => $formation
        ]);
      // } else {
      //   return response()->json([
      //     'status_message' => 'Vous ne pouvez modifier ce compte'
      //   ]);
      // }
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

  public function delete($id)
  {

    try {
      $formation = Formation::find($id);
      $formation->delete();
        return response()->json([
          'status_code' => 200,
          'status_message' => 'formation a été supprimé',
          'data' => $formation
        ]);
      // }else{
      //   return response()->json([
      //     'status_message' => 'Vous ne pouvez supprimer ce compte'
      //   ]);
      // }
      
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
}
