<?php

namespace Database\Seeders;

use App\Models\Skyll;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkyllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('skylls')->insert([
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Tratar calos e calosidades nos pés.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Tratar unhas encravadas e inflamações.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Tratar micoses nos pés e unhas.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Realizar ortoplastia para correção de deformidades.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Realizar ortonixia para correção de unhas deformadas.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Avaliar e tratar a postura através dos pés.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Tratar verrugas plantares.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Promover higiene e cuidados diários dos pés.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Realizar massoterapia nos pés.',
            ],
            [
                'occupation_id' => 996,
                'type' => 'vaga',
                'description' => 'Prevenir lesões nos pés de atletas e diabéticos.',
            ],
        ]);
    }
}
