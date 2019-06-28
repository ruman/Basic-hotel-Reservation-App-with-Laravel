<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Rooms;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('rooms')->delete();

        $rooms = array(
			['name' => 'Economy', 'room_type_id'=> 1, 'room_capacity_id'=> 1],
			['name' => 'E Economy', 'room_type_id'=> 1, 'room_capacity_id'=> 2],
			['name' => 'S Economy', 'room_type_id'=> 1, 'room_capacity_id'=> 3],
			['name' => 'Coulple', 'room_type_id'=> 2, 'room_capacity_id'=> 2],
			['name' => 'Coulple S', 'room_type_id'=> 2, 'room_capacity_id'=> 2],
			['name' => 'Coulple Sep', 'room_type_id'=> 2, 'room_capacity_id'=> 2],
			['name' => 'Delux Couple', 'room_type_id'=> 3, 'room_capacity_id'=> 3],
			['name' => 'Delux Couple S', 'room_type_id'=> 4, 'room_capacity_id'=> 3],
			['name' => 'Delux S', 'room_type_id'=> 5, 'room_capacity_id'=> 4],
			['name' => 'Executive', 'room_type_id'=> 8, 'room_capacity_id'=> 8],
			
		);

		foreach ($rooms as $room) {
			Rooms::create($room);
		}
		Model::reguard();
    }
}
