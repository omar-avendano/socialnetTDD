<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test    */
    public function guest_users_can_not_create_statuses(){

        $this->withoutExceptionHandling();//Deshabilitar manejo de excepciones
        $response=$this->post(route('statuses.store'),['body'=>'Mi primer status']);

        //dd($response->content());
        $response->assertRedirect('login');//Probar que nos redirija a login

    }

    /** @test    */
    public function an_authenticated_user_can_create_statuses()
    {
        $this->withoutExceptionHandling();
        //1.Given => Teniendo un usuario autenticado
        $user=factory(User::class)->create();
        $this->actingAs($user);
        //2.When => Cuando hace post request a status
        $response=$this->post(route('statuses.store'),['body'=>'Mi primer status']);

        //$response->assertSuccessful();//Si queremos probar que retorne un estado de 200 a 300
        //$response->assertRedirect('/');//Si queremos probar que nos redirija a una url
        $response->assertJson([
            'body'=>'Mi primer status'
        ]);


        //3.Then => entonces vemos un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses',[
            'user_id'=>$user->id,
            'body'=>'Mi primer status'
        ]);
    }
}
