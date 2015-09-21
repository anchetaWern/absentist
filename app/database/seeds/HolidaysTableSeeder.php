<?php
class HolidaysTableSeeder extends Seeder {

    public function run()
    {
        DB::table('holidays')->delete();

        DB::table('holidays')->insert(array(
            array(
                'name' => 'Christmas Day',
                'date' => '2015-12-25'
            ),
            array(
                'name' => "Ninoy Aquino Day",
                'date' => '2015-08-21'
            ),
            array(
                'name' => "National Heroes Day",
                'date' => '2015-08-31'
            ), 
            array(
                'name' => "Eid'l Adha",
                'date' => '2015-09-25'
            ),
            array(
                'name' => "Bonifacio Day",
                'date' => '2015-11-30'
            )
        ));
    }

}