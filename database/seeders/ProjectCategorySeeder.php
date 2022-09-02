<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectCategory::create([
            'name' => 'Umum'
        ]);
        ProjectCategory::create([
            'name' => 'Pendidikan'
        ]);
        ProjectCategory::create([
            'name' => 'Dakwah'
        ]);
        ProjectCategory::create([
            'name' => 'Sosial'
        ]);
        ProjectCategory::create([
            'name' => 'Kesehatan'
        ]);
    }
}
