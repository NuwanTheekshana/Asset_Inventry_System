<?php

namespace Tests\Unit;
use App\Models\User;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class peripheralsTest extends TestCase
{
    
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_pheripheral_store()
    {
        // Ignore all middleware, including authentication
        $this->withoutMiddleware();
    
        // Perform the POST request
        $response = $this->post('/add_peripherals_type', [
            'peri_type' => 'Keyboard'
        ]);
        
        $response->assertStatus($response->status(), 302);
    
        // Optionally check if the data was stored correctly
        $this->assertDatabaseHas('peripherals_type_tbls', [
            'peripheral_type' => 'Keyboard'
        ]);
    }
}
