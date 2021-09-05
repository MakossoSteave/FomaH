<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChapitreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_etatChapitre()
    {
        $idChapitre=11170517;
        $response = $this->get('/etatChapitre/'.$idChapitre);
     
        $response->assertStatus(302);
    }
}
