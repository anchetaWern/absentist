<?php
class SemesterSettingsTableSeeder extends Seeder {

	public function run(){

		DB::table('semester_settings')->truncate();
		
		$start_date = Carbon::now()->toDateString();
		$end_date = Carbon::now()->toDateString();
		$weeks_per_sem = 18;

		DB::table('semester_settings')->insert(array(
			'start_date' => $start_date, 
			'end_date' => $end_date,
			'weeks_per_term' => $weeks_per_sem 
		));
	}

}