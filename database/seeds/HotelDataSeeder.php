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
		    ['hotel_id'=> 1, 'room_id'=> 1, 'price_id'=>1, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 2, 'room_id'=> 2, 'price_id'=>2, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 3, 'room_id'=> 1, 'price_id'=>3, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 4, 'room_id'=> 2, 'price_id'=>4, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 4, 'room_id'=> 5, 'price_id'=>5, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 4, 'room_id'=> 6, 'price_id'=>3, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 4, 'room_id'=> 7, 'price_id'=>4, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 4, 'room_id'=> 8, 'price_id'=>5, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 5, 'room_id'=> 9, 'price_id'=>7, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 6, 'room_id'=> 1, 'price_id'=>8, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		    ['hotel_id'=> 5, 'room_id'=> 1, 'price_id'=>9, 'price_description'=>'', 'date_start'=>'2019-06-23 00:00:00', 'date_end'=> '2019-06-30 00:00:00'],
		];

		foreach ($hote_data as $data) {
			HotelData::create($data);
		}
		Model::reguard();
    }
}
