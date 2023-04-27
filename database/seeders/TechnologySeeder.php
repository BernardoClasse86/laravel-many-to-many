<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = ['Laravel', 'Blade', 'PHP', 'CSS', 'SASS', 'Bootstrap', 'Tailwind', 'Angular', 'React', 'JS', 'Vue', 'HTML'];

        foreach ($technologies as $technology_type) {

            $technology = new Technology();

            $technology->name = $technology_type;
            $technology->slug = Str::slug($technology_type);

            $technology->save();
        }
    }
}
