<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListeCandidatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
   

    public function test_example(): void

    {
        // Récupère un utilisateur existant avec le rôle administrateur (remplacez par votre propre logique de récupération d'utilisateur)
        $admin_simplon = User::where('role_id', 1)->first();
    
        // Vérifie si un utilisateur administrateur existe dans la base de données
        $this->assertNotNull($admin_simplon, 'Aucun admin trouvé dans la base de données.');
    
        // Authentifie l'utilisateur administrateur
        $this->actingAs($admin_simplon);
        //envoie la requete  HTTP get avec l'URI(/api/candidature/lister) 
        $response = $this->get('/api/candidature/lister');
    
        //qu'il me recupere le contenu de la réponse HTTP dans la variable $responseContent
        $responseContent = $response->getContent();
        //convertit le JSON en un tableau associatif.
        var_dump(json_decode($responseContent, true));
    
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');//verifie le nom de l'en-tete (le type de contenu attendu par exemple le fichier json) et la valeur attendu
    }
    
}
