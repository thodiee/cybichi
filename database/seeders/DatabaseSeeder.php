<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SiteSettingSeeder::class,
            ServiceCategorySeeder::class,
            ProductSeeder::class,
            ServicePackageSeeder::class,
            ClientSeeder::class,
            InvoiceAndAgreementSeeder::class,
        ]);
    }
}
