<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use openApi\Annotations as OA;

/**
 
*@OA\Info(title="endpointCandidature", version="0.1")*/
class AuthController extends Controller
{
      /**
     * @OA\SecurityScheme(
     *     type="apiKey",
     *     in="header",
     *     securityScheme="bearerAuth",
     *     name="Authorization",
     * )
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentification"},
 *     summary="Connexion utilisateur",
 *     description="Connecte un utilisateur en utilisant les informations d'identification fournies.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", format="email", description="Adresse e-mail de l'utilisateur"),
 *             @OA\Property(property="password", type="string", description="Mot de passe de l'utilisateur"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur connecté avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", ref="#/components/schemas/User"),
 *             @OA\Property(property="authorization", type="object",
 *                 @OA\Property(property="token", type="string", description="Jeton d'authentification (Bearer token)"),
 *                 @OA\Property(property="type", type="string", description="Type de jeton (bearer)"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="object"),
 *         ),
 *     ),
 * )
 */

    public function login(Request $request)
    {
        
        $validator=Validator::make($request->all() ,([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]));
       
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()]);
         }
        
           
        
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
       
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"Authentification"},
 *     summary="Inscription utilisateur",
 *     description="Enregistre un nouvel utilisateur avec les informations fournies.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", description="Nom de l'utilisateur"),
 *             @OA\Property(property="email", type="string", format="email", description="Adresse e-mail de l'utilisateur"),
 *             @OA\Property(property="password", type="string", description="Mot de passe de l'utilisateur"),
 *             @OA\Property(property="telephone", type="string", pattern="^\+221(77|78|76|70)\d{7}$", description="Numéro de téléphone de l'utilisateur (format: +221XXXXXXXXX)"),
 *             @OA\Property(property="adresse", type="string", description="Adresse de l'utilisateur"),
 *             @OA\Property(property="role_id", type="integer", description="ID du rôle de l'utilisateur"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur enregistré avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="user", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="object"),
 *         ),
 *     ),
 * )
 */
    public function register(Request $request)
    {
        // dd($request);
        $validator=Validator::make($request->all() ,([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'telephone' => ['required', 'regex:/^\+221(77|78|76|70)\d{7}$/','unique:users'],
            'adresse' => 'required|string|max:255',
            'role_id' => 'required'
        ]));
 if($validator->fails()){
    return response()->json(["error"=>$validator->errors()]);
 }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' =>$request->telephone,
            'adresse' =>  $request->adresse,
            'role_id' => $request->role_id
        ]);
    

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    /**
 * @OA\Post(
 *     path="/api/refresh",
 *     tags={"Authentification"},
 *     summary="Actualiser le jeton d'authentification",
 *     description="Actualise le jeton d'authentification de l'utilisateur actuellement connecté.",
 *     security={{ "bearerAuth"={} }},
 *     @OA\Response(
 *         response=200,
 *         description="Jeton d'authentification actualisé avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", ref="#/components/schemas/User"),
 *             @OA\Property(property="authorisation", type="object",
 *                 @OA\Property(property="token", type="string", description="Nouveau jeton d'authentification (Bearer token)"),
 *                 @OA\Property(property="type", type="string", description="Type de jeton (bearer)"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string"),
 *         ),
 *     ),
 * )
 */

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
