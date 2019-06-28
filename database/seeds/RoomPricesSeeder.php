<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\RoomPrices;

class RoomPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        DB::table('room_prices')->delete();

        $rows = array(
			['name' => 'Price 1', 'rate'=>'19'],
			['name' => 'Price 2', 'rate'=>'22'],
			['name' => 'Price 3', 'rate'=>'89'],
			['name' => 'Price 4', 'rate'=>'67'],
			['name' => 'Price 5', 'rate'=>'140'],
			['name' => 'Price 6', 'rate'=>'130'],
			['name' => 'Price 7', 'rate'=>'29'],
			['name' => 'Price 8', 'rate'=>'33'],
			['name' => 'Price 9', 'rate'=>'203'],
			['name' => 'Price 10', 'rate'=>'230'],
		);

		foreach ($rows as $row) {
			RoomPrices::create($row);
		}
		Model::reguard();
    }
}
