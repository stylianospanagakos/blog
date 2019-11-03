<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $usersNumber = $this->command->askWithCompletion('How many users do you want to generate?', [], 10);

        factory(App\User::class, $usersNumber)->create();
    }
}
