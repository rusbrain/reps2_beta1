<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CountriesSeed::class);
         $this->call(ReplayMapsSeeding::class);
         $this->call(ReplayTypesSeeding::class);
         $this->call(ForumSectionSeeding::class);
<<<<<<< HEAD
         $this->call(UserRoleSeeding::class);
=======
>>>>>>> feature/front_home_page
         $this->call(UserTestDataSeeding::class);
    }
}
