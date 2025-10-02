<?php

namespace Tests\Feature;

use App\Mail\WelcomeBusinessRegistration;
use App\Models\MarketCategoria;
use App\Models\MarketComercioServicio;
use App\Models\MarketTipoComercioServicio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BusinessRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear datos de prueba
        $this->categoria = MarketCategoria::create([
            'nombre' => 'Restaurantes',
            'slug' => 'restaurantes',
            'icono' => 'fas fa-utensils',
            'estado' => 1
        ]);

        $this->tipoComercio = MarketTipoComercioServicio::create([
            'nombre' => 'Comida Rápida',
            'slug' => 'comida-rapida',
            'icono' => 'fas fa-hamburger',
            'estado' => 1
        ]);
    }

    public function test_can_view_registration_form()
    {
        $response = $this->get('/register');
        
        $response->assertStatus(200);
        $response->assertSee('Registra tu Negocio');
        $response->assertSee('Información Personal');
        $response->assertSee('Información del Negocio');
    }

    public function test_can_register_business_with_valid_data()
    {
        Mail::fake();

        $userData = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'categoria' => $this->categoria->idMarketCategoria,
            'tipo_comercio' => $this->tipoComercio->idMarketTipoComercioServicio,
            'nombre_comercio' => 'Restaurante El Buen Sabor',
            'descripcion_corta' => 'Deliciosa comida casera'
        ];

        $response = $this->post('/register', $userData);

        // Verificar redirección
        $response->assertRedirect('/dashboard');

        // Verificar que el usuario fue creado
        $this->assertDatabaseHas('users', [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com'
        ]);

        // Verificar que el comercio fue creado
        $this->assertDatabaseHas('tMarketComerciosServicios', [
            'titulo' => 'Restaurante El Buen Sabor',
            'descripcionCorta' => 'Deliciosa comida casera',
            'idMarketCategoria' => $this->categoria->idMarketCategoria,
            'idMarketTipoComercioServicio' => $this->tipoComercio->idMarketTipoComercioServicio
        ]);

        // Verificar la relación entre usuario y comercio
        $user = User::where('email', 'juan@example.com')->first();
        $comercio = MarketComercioServicio::where('titulo', 'Restaurante El Buen Sabor')->first();
        
        $this->assertEquals($comercio->idMarketComerciosServicios, $user->market_commerce_service_id);

        // Verificar que se envió el email
        Mail::assertSent(WelcomeBusinessRegistration::class, function ($mail) use ($user) {
            return $mail->user->email === $user->email;
        });
    }

    public function test_registration_requires_all_fields()
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
            'categoria',
            'tipo_comercio',
            'nombre_comercio'
        ]);
    }

    public function test_email_must_be_unique()
    {
        // Crear un usuario existente
        User::create([
            'name' => 'Usuario Existente',
            'email' => 'existente@example.com',
            'password' => bcrypt('password')
        ]);

        $userData = [
            'name' => 'Juan Pérez',
            'email' => 'existente@example.com', // Email duplicado
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'categoria' => $this->categoria->idMarketCategoria,
            'tipo_comercio' => $this->tipoComercio->idMarketTipoComercioServicio,
            'nombre_comercio' => 'Mi Negocio'
        ];

        $response = $this->post('/register', $userData);
        
        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_is_authenticated_after_registration()
    {
        Mail::fake();

        $userData = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'categoria' => $this->categoria->idMarketCategoria,
            'tipo_comercio' => $this->tipoComercio->idMarketTipoComercioServicio,
            'nombre_comercio' => 'Mi Negocio'
        ];

        $response = $this->post('/register', $userData);

        $this->assertAuthenticated();
        
        $user = auth()->user();
        $this->assertEquals('Juan Pérez', $user->name);
        $this->assertEquals('juan@example.com', $user->email);
    }
}
