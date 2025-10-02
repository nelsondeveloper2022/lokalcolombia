<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MarketCategoria;
use App\Models\MarketTipoComercioServicio;
use App\Models\MarketComercioServicio;

class PuenteLokalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador (verificar que no exista)
        if (!User::where('email', 'admin@puentelokal.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@puentelokal.com',
                'password' => Hash::make('admin123'),
                'rol' => 'admin'
            ]);
        }

        // Crear categorías de ejemplo (solo si no existen)
        $categorias = [
            ['nombre' => 'Restaurantes', 'descripcion' => 'Lugares para comer y disfrutar'],
            ['nombre' => 'Tiendas', 'descripcion' => 'Comercio al por menor'],
            ['nombre' => 'Servicios', 'descripcion' => 'Servicios profesionales'],
            ['nombre' => 'Entretenimiento', 'descripcion' => 'Diversión y entretenimiento'],
            ['nombre' => 'Salud', 'descripcion' => 'Servicios de salud y bienestar'],
        ];

        foreach ($categorias as $categoria) {
            MarketCategoria::firstOrCreate(['nombre' => $categoria['nombre']], $categoria);
        }

        // Crear tipos de comercio/servicio (solo si no existen)
        $tipos = [
            ['nombre' => 'Comercio', 'descripcion' => 'Negocios de venta de productos'],
            ['nombre' => 'Servicio', 'descripcion' => 'Negocios de prestación de servicios'],
            ['nombre' => 'Mixto', 'descripcion' => 'Comercio y servicios combinados'],
        ];

        foreach ($tipos as $tipo) {
            MarketTipoComercioServicio::firstOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }

        // Crear algunos comercios/servicios de ejemplo (solo si no existen)
        $comercios = [
            [
                'titulo' => 'Restaurante El Sabor Local',
                'descripcionCorta' => 'Comida típica colombiana con el mejor sabor casero',
                'idMarketCategoria' => 1,
                'idMarketTipoComercioServicio' => 1,
                'slug' => 'restaurante-el-sabor-local',
                'estado' => 'activo'
            ],
            [
                'titulo' => 'Tienda La Esquina',
                'descripcionCorta' => 'Todo lo que necesitas en el barrio',
                'idMarketCategoria' => 2,
                'idMarketTipoComercioServicio' => 1,
                'slug' => 'tienda-la-esquina',
                'estado' => 'activo'
            ],
            [
                'titulo' => 'Peluquería Estilo y Belleza',
                'descripcionCorta' => 'Los mejores cortes y peinados',
                'idMarketCategoria' => 3,
                'idMarketTipoComercioServicio' => 2,
                'slug' => 'peluqueria-estilo-y-belleza',
                'estado' => 'activo'
            ]
        ];

        foreach ($comercios as $comercio) {
            MarketComercioServicio::firstOrCreate(['titulo' => $comercio['titulo']], $comercio);
        }

        echo "Datos iniciales creados exitosamente!\n";
        echo "Usuario admin: admin@puentelokal.com\n";
        echo "Contraseña: admin123\n";
    }
}
