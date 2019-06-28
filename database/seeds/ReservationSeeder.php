<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Bookings;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('bookings')->delete();

        $bookings = array(
			['hotel_id' => '1', 'room_id'=> '1', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>1],
			['hotel_id' => '2', 'room_id'=> '1', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>2],
			['hotel_id' => '2', 'room_id'=> '2', 'check_in'=> '2019-06-27', 'check_out'=> '2019-06-28', 'customer_id'=>3],
			['hotel_id' => '2', 'room_id'=> '2', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>4],
			['hotel_id' => '1', 'room_id'=> '3', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>5],
			['hotel_id' => '1', 'room_id'=> '4', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>6],
			['hotel_id' => '1', 'room_id'=> '5', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>7],
			['hotel_id' => '1', 'room_id'=> '6', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>8],
			['hotel_id' => '1', 'room_id'=> '7', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>9],
			['hotel_id' => '1', 'room_id'=> '8', 'check_in'=> '2019-06-24', 'check_out'=> '2019-06-25', 'customer_id'=>10],
			
		);

		foreach ($bookings as $reservation) {
			Bookings::create($reservation);
		}
		Model::reguard();
    }
}
