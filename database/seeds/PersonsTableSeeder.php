<?php

use Illuminate\Database\Seeder;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persons')->insert([
            'first_name' => 'Michael',
            'last_name' => 'Jackson',
            'email' => 'kingofpop@gmail.com',
            'phone' => '0123456789',
            'status' => 'MCF',
            'is_workshop' => false
        ]);
        DB::table('persons')->insert([
            'first_name' => 'Freddy',
            'last_name' => 'Mercury',
            'email' => 'bohemianrhapsody@gmail.com',
            'phone' => '0123456789',
            'status' => 'PR',
            'is_workshop' => false
        ]);
        DB::table('persons')->insert([
            'first_name' => 'Johnny',
            'last_name' => 'Hallyday',
            'email' => 'lepatron@gmail.com',
            'phone' => '0123456789',
            'status' => 'CD',
            'is_workshop' => true
        ]);
        DB::table('persons')->insert([
            'first_name' => 'Claude',
            'last_name' => 'Nougaro',
            'email' => 'ohtoulouse@gmail.com',
            'phone' => '0123456789',
            'status' => 'DR',
            'is_workshop' => false
        ]);
        DB::table('persons')->insert([
            'first_name' => 'Francis',
            'last_name' => 'Cabrel',
            'email' => 'petitemarie@gmail.com',
            'phone' => '0123456789',
            'status' => 'Unknown',
            'is_workshop' => true
        ]);
        DB::table('persons')->insert([
            'first_name' => 'Patrick',
            'last_name' => 'Bruel',
            'email' => 'casserlavoix@gmail.com',
            'phone' => '0123456789',
            'status' => 'Other',
            'is_workshop' => true
        ]);
        DB::table('persons')->insert([
            'first_name' => 'Serge',
            'last_name' => 'Gainsbourg',
            'email' => 'gainsbarre@gmail.com',
            'phone' => '0123456789',
            'status' => 'Status',
            'is_workshop' => false
        ]);
    }
}
