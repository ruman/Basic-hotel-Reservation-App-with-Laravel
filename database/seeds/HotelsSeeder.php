<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Hotels;

class HotelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('hotels')->delete();

        $hotels = array(
			['name' => 'Hotel 1', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],

			['name' => 'Hotel 2', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 3', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 4', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 5', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 6', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 7', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 8', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 9', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
			['name' => 'Hotel 10', 'address'=> '', 'city'=> 'New York', 'state'=> 'NY', 'country'=>'United States','zipcode'=>'2011','phone'=>'','email'=>'','image'=>''],
			
		);

		foreach ($hotels as $hotel) {
			Hotels::create($hotel);
		}
		Model::reguard();
    }
}
