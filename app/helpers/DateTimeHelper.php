<?php
class DateTimeHelper {

    public static function toHuman($datetime, $timezone = null){

        if(!is_null($timezone)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                ->setTimezone($timezone)
                ->diffForHumans();
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                        ->diffForHumans();

    }


    public static function toShortDate($datetime, $timezone = null){

        if(!is_null($timezone)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                ->setTimezone($timezone)
                ->toFormattedDateString();
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                        ->toFormattedDateString();

    }

    public static function toLongDate($datetime, $timezone = null){

        if(!is_null($timezone)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                ->setTimezone($timezone)
                ->format('F j, Y');
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                        ->format('F j, Y');

    }


    public static function term($date){

        $sem = DB::table('semester_settings')
            ->where('id', 1)
            ->first();

        $weeks_per_term = $sem->weeks_per_term;
        $prelim_start = 1;
        $prelim_end = $prelim_start + $weeks_per_term;
        $midterm_start = $prelim_end + 1;
        $midterm_end = $midterm_start + $weeks_per_term;
        $finals_start = $midterm_end + 1;
        $finals_end = $finals_start + $weeks_per_term;

        $current_date = Carbon::now();
        $absence_date = Carbon::parse($date);

        $term = 'prelims';
        $diff_in_weeks = $absence_date->diffInWeeks($current_date); 
        
        if($diff_in_weeks >= $prelim_start && $diff_in_weeks <= $prelim_end){
            $term = 'finals';
        }else if($diff_in_weeks >= $midterm_start && $diff_in_weeks <= $midterm_end){
            $term = 'midterms';
        }

        return $term;

    }


    public static function week($date){

        $sem = DB::table('semester_settings')
            ->where('id', 1)
            ->first();

        $current_date = Carbon::parse($date);
        $base_date = Carbon::parse($sem->start_date);
        $diff_in_weeks = $base_date->diffInWeeks($current_date);
        return $diff_in_weeks + 1; //week starts at 0 for the current week

    }

}