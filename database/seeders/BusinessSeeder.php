<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $businessId = $faker->uuid;

            DB::table('business')->insert([
                'id' => $businessId,
                'alias' => $faker->word,
                'name' => $faker->company,
                'image_url' => $faker->imageUrl(),
                'is_closed' => $faker->boolean,
                'url' => $faker->url,
                'review_count' => $faker->numberBetween(0, 100),
                'rating' => $faker->randomFloat(1, 0, 5),
                'price' => $faker->randomElement(['$', '$$', '$$$']),
                'phone' => $faker->phoneNumber,
                'display_phone' => $faker->phoneNumber,
                'distance' => $faker->randomFloat(3, 0, 100),
            ]);

            DB::table('categories')->insert([
                'business_id' => $businessId,
                'alias' => $faker->word,
                'title' => $faker->word,
            ]);

            DB::table('locations')->insert([
                'business_id' => $businessId,
                'address1' => $faker->streetAddress,
                'address2' => $faker->secondaryAddress,
                'address3' => $faker->buildingNumber,
                'city' => $faker->city,
                'zip_code' => $faker->postcode,
                'country' => $faker->country,
                'state' => $faker->state,
            ]);

            DB::table('coordinates')->insert([
                'business_id' => $businessId,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
            ]);

            $transactionTypes = ['pickup', 'delivery'];
            $transactionType = $faker->randomElement($transactionTypes);

            DB::table('transactions')->insert([
                'business_id' => $businessId,
                'transaction_type' => $transactionType,
            ]);
        }
    }
}
