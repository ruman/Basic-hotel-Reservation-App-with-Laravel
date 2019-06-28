<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Customers;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        DB::table('customers')->delete();

        $rows = array(
			['first_name' => 'John', 'last_name'=>'Alex', 'address'=>'', 'city'=>'Paris', 'country'=>"France", 'phone'=>'', 'fax'=>'', 'email'=>'johnalex@example.com'],
			['first_name' => 'Demo', 'last_name'=>'Alex', 'address'=>'', 'city'=>'Dhaka', 'country'=>"Bangladesh", 'phone'=>'8803383383', 'fax'=>'', 'email'=>'alextester@example.com'],
			['first_name' => 'Demo', 'last_name'=>'Tester', 'address'=>'', 'city'=>'Darussalam', 'country'=>"Brunei", 'phone'=>'8803383383', 'fax'=>'', 'email'=>'btester@example.com'],
			['first_name' => 'Alex', 'last_name'=>'Hyder', 'address'=>'', 'city'=>'Dhaka', 'country'=>"Bangladesh", 'phone'=>'8803383383', 'fax'=>'', 'email'=>'ahayder@example.com'],
			['first_name' => 'Chad', 'last_name'=>'Flex', 'address'=>'', 'city'=>'Chad', 'country'=>"Ghana", 'phone'=>'0566sd83', 'fax'=>'', 'email'=>'chad@example.com'],
			['first_name' => 'Cree', 'last_name'=>'Flacon', 'address'=>'', 'city'=>'Alabama', 'country'=>"United States", 'phone'=>'3450332323', 'fax'=>'', 'email'=>'creeflacon@example.com'],
			['first_name' => 'Chop', 'last_name'=>'Sey', 'address'=>'', 'city'=>'New York', 'country'=>"United States", 'phone'=>'3450332323', 'fax'=>'', 'email'=>'chopsey@example.com'],
			['first_name' => 'Vermo', 'last_name'=>'Das', 'address'=>'', 'city'=>'Aslow', 'country'=>"Norway", 'phone'=>'3450332323', 'fax'=>'', 'email'=>'vermodas@example.com'],
		    ['first_name'=> 'Frew', 'last_name'=> 'Alex', 'address'=> '', 'city'=>'NY', 'country'=> 'United States', 'phone'=>'8829992', 'fax'=>'', 'email'=> 'fewalex@gmail.com'],
		    ['first_name'=> 'Domanic', 'last_name'=> 'Deo', 'address'=> '', 'city'=>'NY', 'country'=> 'United States', 'phone'=>'4646456', 'fax'=>'', 'email'=> 'domanicdeo@gmail.com'],
		);

		foreach ($rows as $row) {
			Customers::create($row);
		}
		Model::reguard();
    }
}
