<?php

use Illuminate\Database\Seeder;

class PermissionSeerder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Permission::create([
            'name'=>'admin-role',
            'display_name'=>'Roles',
            'description'=>'Todos Los permisos a direccion'
        ]);
        \DB::select('INSERT INTO permission_role(permission_id, role_id) VALUES (1,1)');
        App\Permission::create([
            'name'=>'admin-direccion',
            'display_name'=>'Unidades de Direcion',
            'description'=>'Todos Los permisos a direccion'
        ]);
        \DB::select('INSERT INTO permission_role(permission_id, role_id) VALUES (2,1)');
        App\Permission::create([
            'name'=>'admin-facultades',
            'display_name'=>'Facultades-carreras',
            'description'=>'Todos Los permisos a facultades y carreras'
        ]);
        \DB::select('INSERT INTO permission_role(permission_id, role_id) VALUES (3,1)');
        App\Permission::create([
            'name'=>'admin-users',
            'display_name'=>'Administracion de usuarios',
            'description'=>'Todos Los a administracion de permisos'
        ]);
        \DB::select('INSERT INTO permission_role(permission_id, role_id) VALUES (4,1)');
        App\Permission::create([
            'name'=>'planillas',
            'display_name'=>'Planillas',
            'description'=>'Todos los permisos al Envio  de Planillas'
        ]);
        App\Permission::create([
            'name'=>'documentos',
            'display_name'=>'Documentos Extras',
            'description'=>'Todos Los permisos a documentos extras'
        ]);
        App\Permission::create([
            'name'=>'mensajeria',
            'display_name'=>'Mensajeria',
            'description'=>'Permisos a mensajeria'
        ]);
        App\Permission::create([
            'name'=>'ayuda',
            'display_name'=>'Ayuda',
            'description'=>'Permiso a permisos de ayuda'
        ]);
        App\Permission::create([
            'name'=>'revision',
            'display_name'=>'Permisos a Unidades de Direcion',
            'description'=>'Todos Los permisos a direccion'
        ]);
    }
}
