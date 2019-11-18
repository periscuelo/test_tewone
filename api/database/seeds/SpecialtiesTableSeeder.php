<?php

use Illuminate\Database\Seeder;
use App\Models\Specialties;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            ['specialty' => 'ALERGOLOGIA'],
            ['specialty' => 'ANGIOLOGIA'],
            ['specialty' => 'BUCO MAXILO'],
            ['specialty' => 'CARDIOLOGIA CLÍNICA'],
            ['specialty' => 'CARDIOLOGIA INFANTIL'],
            ['specialty' => 'CIRURGIA CABEÇA E PESCOÇO'],
            ['specialty' => 'CIRURGIA CARDÍACA'],
            ['specialty' => 'CIRURGIA DE CABEÇA/PESCOÇO'],
            ['specialty' => 'CIRURGIA DE TÓRAX'],
            ['specialty' => 'CIRURGIA GERAL'],
            ['specialty' => 'CIRURGIA PEDIÁTRICA'],
            ['specialty' => 'CIRURGIA PLÁSTICA'],
            ['specialty' => 'CIRURGIA TORÁCICA'],
            ['specialty' => 'CIRURGIA VASCULAR'],
            ['specialty' => 'CLÍNICA MÉDICA']
        ];
        foreach($specialties AS $specialty){
            Specialties::firstOrCreate($specialty);
        }
    }
}
