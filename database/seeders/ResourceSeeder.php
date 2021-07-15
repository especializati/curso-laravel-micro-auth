<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Resource::create(['name' => 'Categorias']);
        $category->permissions()->create(['name' => 'visualizar_categorias']);
        $category->permissions()->create(['name' => 'visualizar_categoria']);
        $category->permissions()->create(['name' => 'deletar_categoria']);
        $category->permissions()->create(['name' => 'editar_categoria']);

        $company = Resource::create(['name' => 'Empresas']);
        $company->permissions()->create(['name' => 'visualizar_empresas']);
        $company->permissions()->create(['name' => 'visualizar_empresa']);
        $company->permissions()->create(['name' => 'deletar_empresa']);
        $company->permissions()->create(['name' => 'editar_empresa']);

        $admin = Resource::create(['name' => 'Admins']);
        $admin->permissions()->create(['name' => 'users']);
        $admin->permissions()->create(['name' => 'add_permissions_user']);
        $admin->permissions()->create(['name' => 'deletar_permissao_usuario']);
    }
}
