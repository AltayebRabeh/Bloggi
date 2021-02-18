<?php

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $posts = [];
        $categories = collect(Category::all()->modelKeys());
        $users = collect(User::where('id', '>', 2)->get()->modelKeys());

        for ($i=0; $i < 1000; $i++) { 
            $days = [
                '01', '02', '03', '04', '05', '06', '07', '08', '09', 
                '10', '11', '12', '13', '14', '15', '16', '17', '18', 
                '19', '20', '21', '22', '23', '24', '25', '26', '27',
                '28'
            ];

            $months = ['01', '02', '03', '04', '05', '06', '07', '08'];

            $post_date = '2020-' . Arr::random($months) . "-" . Arr::random($days) . " 01:01:01";
            $post_title = $faker->sentence(mt_rand(3, 6));

            $posts[] = [
                'title' => $post_title,
                'slug' => Str::slug($post_title),
                'description' => $faker->paragraph(),
                'status' => rand(0, 1),
                'comment_able' => rand(0, 1),
                'user_id' => $users->random(),
                'category_id' => $categories->random(),
                'created_at' => $post_date,
                'updated_at' => $post_date,
            ];
        }

        $chunks = array_chunk($posts, 500);

        foreach ($chunks as $chunk) {
            Post::insert($chunk);
        }
    }
}
