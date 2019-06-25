<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\HotelData;

class HotelDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('hotel_data')->delete();

		$hote_data = [
		    ['hotel_id'=> 11, 'room_id'=> 1, 'price_id'=>1, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 11, 'room_id'=> 2, 'price_id'=>2, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 12, 'room_id'=> 1, 'price_id'=>1, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 12, 'room_id'=> 2, 'price_id'=>1, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		];

		foreach ($hote_data as $data) {
			HotelData::create($data);
		}
		Model::reguard();
    }
}
