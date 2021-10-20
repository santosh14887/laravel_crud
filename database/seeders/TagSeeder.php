<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;
use App\Models\Tag;
class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->delete();
        Tag::create(['name' => 'Drama']);
        Tag::create(['name' => 'Cartoon']);
        Tag::create(['name' => 'Movie']);
        Tag::create(['name' => 'Kids']);
        Tag::create(['name' => 'Apple']);
    }
}
