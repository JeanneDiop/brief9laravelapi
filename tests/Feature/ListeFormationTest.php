<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListeFormationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
  
    
        {
             //envoie la requete  HTTP get avec l'URI(/api/candidature/lister) 
            $response = $this->get('/api/formation/lister');
            //qu'il me recupere le contenu de la réponse HTTP dans la variable $responseContent
            $responseContent = $response->getContent();
            //convertit le JSON en un tableau associatif.
            var_dump(json_decode($responseContent, true));
            $response->assertStatus(200);
        }

    
}
