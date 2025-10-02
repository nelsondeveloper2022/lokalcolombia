<?php

namespace App\Console\Commands;

use App\Models\MarketCategoria;
use App\Models\MarketTipoComercioServicio;
use Illuminate\Console\Command;

class CreateSampleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:create-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear datos de prueba para categorías y tipos de comercio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando datos de prueba...');

        // Crear categorías
        $categorias = [
            ['nombre' => 'Restaurantes', 'slug' => 'restaurantes', 'icono' => 'fas fa-utensils'],
            ['nombre' => 'Tiendas', 'slug' => 'tiendas', 'icono' => 'fas fa-store'],
            ['nombre' => 'Servicios', 'slug' => 'servicios', 'icono' => 'fas fa-wrench'],
            ['nombre' => 'Salud', 'slug' => 'salud', 'icono' => 'fas fa-heartbeat'],
            ['nombre' => 'Educación', 'slug' => 'educacion', 'icono' => 'fas fa-graduation-cap'],
            ['nombre' => 'Entretenimiento', 'slug' => 'entretenimiento', 'icono' => 'fas fa-gamepad'],
        ];

        foreach ($categorias as $categoria) {
            MarketCategoria::firstOrCreate(
                ['nombre' => $categoria['nombre']],
                array_merge($categoria, ['estado' => 1])
            );
        }

        $this->info('✓ Categorías creadas');

        // Crear tipos de comercio/servicio
        $tipos = [
            ['nombre' => 'Comida Rápida', 'slug' => 'comida-rapida', 'icono' => 'fas fa-hamburger'],
            ['nombre' => 'Restaurante', 'slug' => 'restaurante', 'icono' => 'fas fa-utensils'],
            ['nombre' => 'Cafetería', 'slug' => 'cafeteria', 'icono' => 'fas fa-coffee'],
            ['nombre' => 'Panadería', 'slug' => 'panaderia', 'icono' => 'fas fa-bread-slice'],
            ['nombre' => 'Tienda de Ropa', 'slug' => 'tienda-ropa', 'icono' => 'fas fa-tshirt'],
            ['nombre' => 'Supermercado', 'slug' => 'supermercado', 'icono' => 'fas fa-shopping-cart'],
            ['nombre' => 'Farmacia', 'slug' => 'farmacia', 'icono' => 'fas fa-pills'],
            ['nombre' => 'Ferretería', 'slug' => 'ferreteria', 'icono' => 'fas fa-hammer'],
            ['nombre' => 'Peluquería', 'slug' => 'peluqueria', 'icono' => 'fas fa-cut'],
            ['nombre' => 'Salón de Belleza', 'slug' => 'salon-belleza', 'icono' => 'fas fa-spa'],
            ['nombre' => 'Mecánico', 'slug' => 'mecanico', 'icono' => 'fas fa-wrench'],
            ['nombre' => 'Electricista', 'slug' => 'electricista', 'icono' => 'fas fa-bolt'],
            ['nombre' => 'Plomero', 'slug' => 'plomero', 'icono' => 'fas fa-faucet'],
            ['nombre' => 'Dentista', 'slug' => 'dentista', 'icono' => 'fas fa-tooth'],
            ['nombre' => 'Médico General', 'slug' => 'medico-general', 'icono' => 'fas fa-stethoscope'],
            ['nombre' => 'Veterinario', 'slug' => 'veterinario', 'icono' => 'fas fa-paw'],
            ['nombre' => 'Academia', 'slug' => 'academia', 'icono' => 'fas fa-book'],
            ['nombre' => 'Gimnasio', 'slug' => 'gimnasio', 'icono' => 'fas fa-dumbbell'],
            ['nombre' => 'Cine', 'slug' => 'cine', 'icono' => 'fas fa-film'],
            ['nombre' => 'Bar', 'slug' => 'bar', 'icono' => 'fas fa-cocktail'],
        ];

        foreach ($tipos as $tipo) {
            MarketTipoComercioServicio::firstOrCreate(
                ['nombre' => $tipo['nombre']],
                array_merge($tipo, ['estado' => 1])
            );
        }

        $this->info('✓ Tipos de comercio/servicio creados');

        $categorias_count = MarketCategoria::where('estado', 1)->count();
        $tipos_count = MarketTipoComercioServicio::where('estado', 1)->count();

        $this->info("✅ Datos de prueba creados exitosamente:");
        $this->info("   • {$categorias_count} categorías disponibles");
        $this->info("   • {$tipos_count} tipos de comercio/servicio disponibles");
        $this->info("");
        $this->info("Ahora puedes probar el formulario de registro en: http://127.0.0.1:8001/register");
    }
}
