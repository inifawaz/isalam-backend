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
            'category' => 'Umum'
        ]);
        ProjectCategory::create([
            'category' => 'Pendidikan'
        ]);
        ProjectCategory::create([
            'category' => 'Dakwah'
        ]);
        ProjectCategory::create([
            'category' => 'Sosial'
        ]);
        ProjectCategory::create([
            'category' => 'Kesehatan'
        ]);
    }
}
