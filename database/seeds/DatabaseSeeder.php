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
         $this->call(UserRoleSeeding::class);
         $this->call(GameVersionSeeding::class);
         $this->call(ForumIconSeed::class);
         $this->call(UserTestDataSeeding::class);//TODO: hide for production
         $this->call(TestBannerSedding::class);//TODO: hide for production
         $this->call(ForumSectionIconsSeed::class);
         $this->call(DBRelocationDataSeed::class);

         $this->call(UserBirthdaysSeeder::class);//TODO: hide for production
    }
}
