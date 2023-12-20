<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCandidatureRequest;
use App\Http\Requests\RefuserCandidatureRequest;
use App\Http\Requests\AccepterCandidatureRequest;
use openApi\Annotations as OA;
/**
 
*@OA\Info(title="endpointCandidature", version="0.1")*/

class CandidatureController extends Controller
{
  /**
 * @OA\Get(
 *     path="/api/candidatures",
 *     tags={"Candidatures"},
 *     summary="Obtenir toutes les candidatures",
 *     description="Récupère toutes les candidatures.",
 *     @OA\Response(
 *         response=200,
 *         description="Liste de toutes les candidatures",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Candidature")
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
        'status_message' => ' toutes les candidatures ont été recupéré',
        'data' => Candidature::all(),
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

/**
 * @OA\Get(
 *     path="/api/candidatures/acceptees",
 *     tags={"Candidatures"},
 *     summary="Lister toutes les candidatures acceptées",
 *     description="Récupère la liste de toutes les candidatures acceptées.",
 *     @OA\Response(
 *         response=200,
 *         description="Liste de toutes les candidatures acceptées",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Candidature")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */
  
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

  /**
 * @OA\Get(
 *     path="/api/candidatures/refusees",
 *     tags={"Candidatures"},
 *     summary="Lister toutes les candidatures refusées",
 *     description="Récupère la liste de toutes les candidatures refusées.",
 *     @OA\Response(
 *         response=200,
 *         description="Liste de toutes les candidatures refusées",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Candidature")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */

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

  /**
 * @OA\Post(
 *     path="/api/candidatures",
 *     tags={"Candidatures"},
 *     summary="Ajouter une nouvelle candidature",
 *     description="Crée une nouvelle candidature avec les informations fournies.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", description="ID de l'utilisateur"),
 *             @OA\Property(property="formation_id", type="integer", description="ID de la formation"),
 *             @OA\Property(property="statut", type="string", description="Statut de la candidature (attente, accepter, refuser)"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Candidature ajoutée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer"),
 *             @OA\Property(property="status_message", type="string"),
 *             @OA\Property(property="data", ref="#/components/schemas/Candidature"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */
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

    /**
 * @OA\Put(
 *     path="/api/candidatures/{id}",
 *     tags={"Candidatures"},
 *     summary="Modifier le statut d'une candidature pour l'accepter",
 *     description="Modifie le statut d'une candidature pour l'accepter avec les informations fournies.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la candidature à mettre à jour",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", description="ID de l'utilisateur"),
 *             @OA\Property(property="formation_id", type="integer", description="ID de la formation"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Candidature modifiée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer"),
 *             @OA\Property(property="status_message", type="string"),
 *             @OA\Property(property="data", ref="#/components/schemas/Candidature"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Candidature non trouvée",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */
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
  /**
 * @OA\Put(
 *     path="/api/candidatures/{id}/refuser",
 *     tags={"Candidatures"},
 *     summary="Modifier le statut d'une candidature pour la refuser",
 *     description="Modifie le statut d'une candidature pour la refuser avec les informations fournies.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la candidature à mettre à jour",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", description="ID de l'utilisateur"),
 *             @OA\Property(property="formation_id", type="integer", description="ID de la formation"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Candidature modifiée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer"),
 *             @OA\Property(property="status_message", type="string"),
 *             @OA\Property(property="data", ref="#/components/schemas/Candidature"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Candidature non trouvée",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *     )
 * )
 */

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
