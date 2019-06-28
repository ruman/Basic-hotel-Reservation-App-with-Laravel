<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\RoomCapacity;

class RoomCapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        DB::table('room_capacities')->delete();

        $rows = array(
			['name' => 'Single Bed'],
			['name' => '2 Single Bed'],
			['name' => '1 Double Bed'],
			['name' => '1 Double 1 Single Bed'],
			['name' => '2 Double Bed'],
			['name' => '1 King and 1 Single Bed'],
			['name' => '1 King 1 Double Bed'],
			['name' => '1 King 1 Queen bed'],
			['name' => '1 Room Appartment with South faced Balcony'],
			['name' => 'Duplex'],
		);

		foreach ($rows as $row) {
			RoomCapacity::create($row);
		}
		Model::reguard();
    }
}
