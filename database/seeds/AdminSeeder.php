<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'=>'admin',
            'last_name'=>'istrador',
            'ci'=>'3836362',
            'celular'=>'12345678',
           // 'rol'=>'Administrador',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('123456'),
            'password_text'=>('123456'),
            'username'=>'admin_istrador',
            'oficina_id'=>'5'
        ]);
        $user=\App\User::find(1);
        $role=\App\Role::find(1);
        $user->attachRole($role);
    }
}
