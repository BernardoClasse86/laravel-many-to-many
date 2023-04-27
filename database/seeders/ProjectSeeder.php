<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $project_type_ids = Type::all()->pluck('id')->all();
        $project_technology_ids = Technology::all()->pluck('id')->all();

        for ($i = 0; $i < 20; $i++) {

            $project = new Project();

            $project->title = $faker->unique()->sentence($faker->numberBetween(1, 4));
            $project->client_name = $faker->optional()->name();
            $project->description = $faker->optional()->paragraph($faker->numberBetween(4, 6), true);
            $project->project_url = $faker->url();
            $project->project_date = $faker->dateTimeBetween('-1 year', 'now');
            $project->slug = Str::slug($project->title, '-');
            $project->type_id = $faker->optional()->randomElement($project_type_ids);

            $project->save();

            $project->technologies()->attach($faker->randomElements($project_technology_ids, rand(0, 4)));
        }
    }
}
