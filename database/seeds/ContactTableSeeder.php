<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Contact;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'phone' => str_random(10),
        ]);

    }
}
