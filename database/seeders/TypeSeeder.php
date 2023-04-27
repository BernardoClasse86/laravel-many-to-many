<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project_types = ['Full Stack', 'Programming', 'Application', 'Game', 'Design', 'FrontEnd', 'BackEnd'];

        foreach ($project_types as $project_type) {

            $new_type = new Type();
            $new_type->name = $project_type;
            $new_type->slug = Str::slug($project_type);

            $new_type->save();
        }
    }
}
