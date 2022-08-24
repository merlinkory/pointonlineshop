<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    protected $validUserEmail = "devstylesoftware@gmail.com";
    protected $validPassword = "123";
    public function test_example()
    {
        $this->assertTrue(true);      
    }
    
    public function test_basic_request(){
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }
    
    public function test_go_to_lk_without_auth(){
        $response = $this->get('/lk');
       
        $response->assertRedirect('/login');
    }
    
    public  function test_user_authorize(){
        
        $this->post('/login', [
            'email'=> $this->validUserEmail,
            'password' => $this->validPassword
        ]);
        
        $response = $this->get('/lk');
        
        $response->assertStatus(200);
    }
    
    public function test_go_to_admin(){
        $this->post('/login', [
            'email'=> $this->validUserEmail,
            'password' => $this->validPassword
        ]);
        
        $response = $this->get('/admin');
        
        $response->assertStatus(200);
    }
}
