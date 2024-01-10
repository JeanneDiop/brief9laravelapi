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
use openApi\Annotations as OA;
/**
 
*@OA\Info(title="endpointFormation", version="0.1")*/
class FormationController extends Controller
{
  /**
 * @OA\Get(
 *     path="/api/formations",
 *     tags={"Formations"},
 *     summary="Obtenir toutes les formations",
 *     description="Récupère la liste de toutes les formations.",
 *     @OA\Response(
 *         response=200,
 *         description="Liste de toutes les formations",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Formation")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */

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
  /**
 * @OA\Post(
 *     path="/api/formations",
 *     tags={"Formations"},
 *     summary="Ajouter une nouvelle formation",
 *     description="Crée une nouvelle formation avec les informations fournies.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", description="Nom de la formation"),
 *             @OA\Property(property="details", type="string", description="Détails de la formation"),
 *             @OA\Property(property="duree", type="integer", description="Durée de la formation"),
 *             @OA\Property(property="user_id", type="integer", description="ID de l'utilisateur associé à la formation"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Formation ajoutée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer"),
 *             @OA\Property(property="status_message", type="string"),
 *             @OA\Property(property="data", ref="#/components/schemas/Formation"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */

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

  /**
 * @OA\Put(
 *     path="/api/formations/{id}",
 *     tags={"Formations"},
 *     summary="Modifier une formation",
 *     description="Modifie une formation avec les informations fournies.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la formation à mettre à jour",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", description="Nom de la formation"),
 *             @OA\Property(property="details", type="string", description="Détails de la formation"),
 *             @OA\Property(property="duree", type="integer", description="Durée de la formation"),
 *             @OA\Property(property="user_id", type="integer", description="ID de l'utilisateur associé à la formation"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Formation modifiée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer"),
 *             @OA\Property(property="status_message", type="string"),
 *             @OA\Property(property="data", ref="#/components/schemas/Formation"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Formation non trouvée",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */
  public function update(EditFormationRequest $request, $id)
  {
   
    try {
      if(auth()->check() && auth()->user()->role_id === 1){
        $user_id=auth()->user()->id;
      }
      
      $formation = Formation::find($id);
      
        //  $formation->user_id= $user_id ;
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
/**
 * @OA\Delete(
 *     path="/api/formations/{id}",
 *     tags={"Formations"},
 *     summary="Supprimer une formation",
 *     description="Supprime une formation en fonction de l'ID fourni.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la formation à supprimer",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Formation supprimée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer"),
 *             @OA\Property(property="status_message", type="string"),
 *             @OA\Property(property="data", ref="#/components/schemas/Formation"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Formation non trouvée",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */
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
