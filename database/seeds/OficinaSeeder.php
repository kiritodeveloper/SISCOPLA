<?php

use Illuminate\Database\Seeder;

class OficinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Oficina::create([
            'name'=>'Vicerrectorado',
            'type'=>'Unidad Mayor',
            'oficina_id'=>'0'
        ]);
        \App\Oficina::create([
            'name'=>'Unidad Administrativa',
            'type'=>'Unidad Dependiente',
            'oficina_id'=>'1'
        ]);
        \App\Oficina::create([
            'name'=>'FACULTAD DE INGENIERIA',
            'type'=>'Facultad',
            'oficina_id'=>'0'
        ]);
        \App\Oficina::create([
            'name'=>'CARRERA DE SISTEMAS',
            'type'=>'Carrera',
            'oficina_id'=>'3'
        ]);
        \App\Oficina::create([
            'name'=>'Data Center',
            'type'=>'Unidad Dependiente',
            'oficina_id'=>'1'
        ]);
    }
}
