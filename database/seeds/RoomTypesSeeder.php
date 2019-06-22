<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\RoomTypes;

class RoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        DB::table('room_types')->delete();

        $roomtypes = array(
			['name' => 'Economy'],
			['name' => 'Standard'],
			['name' => 'Single'],
			['name' => 'Dubble'],
			['name' => 'Tripple'],
			['name' => 'Droom'],
			['name' => 'Delux'],
			['name' => 'Super Delux'],
			['name' => 'Laxury'],
			['name' => 'Duplex'],
		);

		foreach ($roomtypes as $type) {
			RoomTypes::create($type);
		}
		Model::reguard();
    }
}
