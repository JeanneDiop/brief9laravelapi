<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


class EmailCandidatTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
   
     public function testEmailUnique()

     {
        // Créez un utilisateur avec un email 'jeanne@gmail.com'
        User::create([
            'email' => 'jeanne@gmail.com',
        ]);

        // Créez un tableau de données avec le même email
        $data = [
            'email' => 'jeanne@gmail.com',
        ];

        // Essayez de créer un nouveau candidat avec le même email
        $candidat = new User($data);

        // Assurez-vous que la sauvegarde échoue en raison de la validation de l'email unique
        $this->assertFalse($candidat->save());

        // Assurez-vous qu'il y a une erreur associée à l'email
        $this->assertNotNull($candidat->errors()->get('email'));
    }
 
}