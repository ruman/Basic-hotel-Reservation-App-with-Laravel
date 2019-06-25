<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Customers;

class CustomerManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	Model::unguard();

        DB::table('customers')->delete();

        $customers = [
		    ['first_name'=> 'John', 'last_name'=> 'Alex', 'address'=> '', 'city'=>'NY', 'country'=> 'United States', 'phone'=>'8829992', 'fax'=>'', 'email'=> 'johnalex@gmail.com'],
		    ['first_name'=> 'Domanic', 'last_name'=> 'Deo', 'address'=> '', 'city'=>'NY', 'country'=> 'United States', 'phone'=>'4646456', 'fax'=>'', 'email'=> 'domanicdeo@gmail.com'],
		];

		foreach ($customers as $customer) {
			Customers::create($customer);
		}
		Model::reguard();
    }
}
