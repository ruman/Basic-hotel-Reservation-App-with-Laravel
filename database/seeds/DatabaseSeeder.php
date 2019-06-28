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
        $this->call(UsersTableSeeder::class);
        $this->call(HotelsSeeder::class);
        $this->call(RoomTypesSeeder::class);
        $this->call(RoomCapacitySeeder::class);
        $this->call(RoomPricesSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(RoomsSeeder::class);
        $this->call(HotelDataSeeder::class);
        $this->call(ReservationSeeder::class);
    }
}
