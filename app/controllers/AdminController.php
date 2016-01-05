<?php

class AdminController extends BaseController {

    protected $layout = 'layouts.admin';

    public function index(){

        $this->layout->title = 'Admin';
        $this->layout->content = View::make('admin.index');
    }


    public function account(){
        $this->layout->title = 'Account';
        $this->layout->content = View::make('admin.account');
    }

    public function updateAccount(){

        $rules = array(
            'email' => 'required|email',
            'password' => 'min:8'
        );

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            return Redirect::to('/account')
                ->withErrors($validator);
        }

        $email = Input::get('email');

        $user = User::find(Auth::user()->id);
        $user->email = $email;

        if(Input::has('password')){
            $user->password = Hash::make(Input::get('password'));
        }
        $user->save();
        return Redirect::to('/account')
            ->with('message', array('type' => 'success', 'text' => 'Your account was updated!'));

    }


    public function newHoliday(){

        $holidays = Holiday::orderBy('date', 'DESC')->get();

        $page_data = array(
            'holidays' => $holidays
        );

        $this->layout->title = 'New Holiday';
        $this->layout->content = View::make('admin.new_holiday', $page_data);
    }


    public function createHoliday(){

        $holiday = new Holiday;
        $holiday->name = Input::get('name');
        $holiday->date = Input::get('date');
        $holiday->save();

        return Redirect::back()->with('message', array(
            'type' => 'success',
            'text' => 'Created Holiday!'
        ));

    }


    public function holiday($id){

        $holiday = Holiday::find($id);

        $page_data = array(
            'holiday' => $holiday
        );

        $this->layout->title = 'Update Holiday';
        $this->layout->content = View::make('admin.holiday', $page_data);
    }


    public function updateHoliday($id){

        $holiday = Holiday::find($id);
        $holiday->name = Input::get('name');
        $holiday->date = Input::get('date');
        $holiday->save();

        return Redirect::back()->with('message', array(
            'type' => 'success',
            'text' => 'Updated Holiday!'
        ));        

    }


    public function newClass(){

        $days = array(
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
        );

        $page_data = array(
            'days' => $days
        );

        $this->layout->title = 'Create New Class';
        $this->layout->content = View::make('admin.new_class', $page_data);

    }


    public function createClass(){

        $user_id = Auth::user()->id;

        $name = Input::get('name');
        $details = Input::get('details');

        $students = Input::get('students');
        $students = explode("\n", $students);
        
        $drop_absences_count = Input::get('drop_absences_count');

        $days = Input::get('days');
        $time_from = Input::get('time_from');
        $time_to = Input::get('time_to');



        $class_id = DB::table('classes')->insertGetId(array(
            'user_id' => $user_id,
            'name' => $name,
            'class_code' => str_random(10),
            'details' => $details,
            'drop_absences_count' => $drop_absences_count,
            'days' => json_encode($days),
            'time_from' => $time_from,
            'time_to' => $time_to
        ));
        
        
        foreach($students as $row){
            if(!empty($row)){

                $exploded_row = explode("\t", $row);
                
                $student_id = trim($exploded_row[0]);
                $student_name = trim($exploded_row[1]);

                $name_length = strlen($student_name);
                $delimiter_position = strpos($student_name, ',');

                $last_name = substr($student_name, 0, $delimiter_position);
                $middle_initial = substr($student_name, -2);
                $first_name = trim(substr($student_name, $delimiter_position + 1, -3)); 

                $gender = trim($exploded_row[2]);


                $student = Student::find($student_id);
                if(!$student){
                    $student = new Student;
                    $student->id = $student_id;
                    $student->last_name = $last_name;
                    $student->first_name = $first_name;
                    $student->middle_initial = $middle_initial;
                    $student->gender = $gender;
                    $student->save();
                }

                $student_class_id = $class_id . $student_id;
                $student_class = StudentClass::find($student_class_id);
                if(!$student_class){
                    $student_class = new StudentClass;
                    $student_class->id = $student_class_id;
                    $student_class->student_id = $student_id;
                    $student_class->class_id = $class_id;
                    $student_class->current_absence_count = 0; //default
                    $student_class->status = 'has_card';
                    $student_class->save();
                }
                
                
            }
        }
        
        return Redirect::back()->with('message', array('type' => 'success', 'text' => 'Class Created!'));

    }



    public function classes(){

        $user_id = Auth::user()->id;

        $classes = DB::table('classes')
            ->where('user_id', '=', $user_id)
            ->get();

        $page_data = array(
            'classes' => $classes
        );

        $this->layout->title = 'Classes';
        $this->layout->content = View::make('admin.classes', $page_data);

    }


    public function viewClass($class_id){

        $days = array(
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
        );

        $class = DB::table('classes')
            ->where('id', '=', $class_id)
            ->first();

        $students = DB::table('students')
            ->join('student_classes', 'students.id', '=', 'student_classes.student_id')
            ->select('students.id AS student_id', 'student_classes.id AS student_class_id', 'last_name', 'first_name', 'middle_initial', 'gender')
            ->where('student_classes.class_id', '=', $class_id)
            ->orderBy('gender', 'DESC')
            ->orderBy('last_name', 'ASC')
            ->get();

        $class_days = json_decode($class->days, true);

        $page_data = array(
            'days' => $days,
            'class' => $class,
            'class_days' => $class_days,
            'students' => $students
        );

        $this->layout->title = $class->name;
        $this->layout->content = View::make('admin.class', $page_data);
    }


    public function updateClass($id){

        $user_id = Auth::user()->id;

        $name = Input::get('name');
        $details = Input::get('details');

        $drop_absences_count = Input::get('drop_absences_count');

        $days = Input::get('days');
        $time_from = Input::get('time_from');
        $time_to = Input::get('time_to');


        DB::table('classes')
            ->where('user_id', '=', $user_id)
            ->where('id', '=', $id)
            ->update(array(
                'user_id' => $user_id,
                'name' => $name,
                'details' => $details,
                'drop_absences_count' => $drop_absences_count,
                'days' => json_encode($days),
                'time_from' => $time_from,
                'time_to' => $time_to
            ));
        
        return Redirect::back()->with('message', array('type' => 'success', 'text' => 'Class Updated!'));


    }


    public function removeStudent(){

        $id = Input::get('id');
        $class_student = StudentClass::find($id);
        $class_student->delete();

        return array('type' => 'ok');
    }


    public function attendance($class_id = null){

        $user_id = Auth::user()->id;

        $today = Carbon::now()->toDateString();

        if(is_null($class_id)){

            //determine the class based on the current date and time
            $now = Carbon::now();
            $current_time = $now->format('H:i:s');


            $days_of_week = array(
                'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
            );

            $day_of_week = $days_of_week[$now->dayOfWeek - 1];

            $results = DB::select( 
                DB::raw("SELECT * FROM classes WHERE user_id = :user_id AND (:current_time BETWEEN time_from AND time_to)"), 
                array(
                    'user_id' => $user_id,
                    'current_time' => $current_time
            ));


            $class = array();

            foreach($results as $row){
                $days = json_decode($row->days, true);
               
                if(in_array($day_of_week, $days) !== false){
                    $class = array(
                        'id' => $row->id,
                        'name' => $row->name,
                        'time_from' => $row->time_from,
                        'time_to' => $row->time_to,
                        'days' => $days,
                        'drop_absences_count' => $row->drop_absences_count
                    );
                }
            }
        }else{

            $class_result = DB::table('classes')
                ->where('id', '=', $class_id)
                ->first();

            if($class_result){

                $days = json_decode($class_result->days, true);

                $class = array(
                    'id' => $class_result->id,
                    'name' => $class_result->name,
                    'time_from' => $class_result->time_from,
                    'time_to' => $class_result->time_to,
                    'days' => $days,
                    'drop_absences_count' => $class_result->drop_absences_count
                );
            }

        }

        $students = array();

        if(!empty($class)){
           $students = DB::table('students')
                ->join('student_classes', 'students.id', '=', 'student_classes.student_id')
                ->select('students.id', 'last_name', 'first_name', 'middle_initial')
                ->where('student_classes.class_id', '=', $class['id'])
                ->orderBy('gender', 'DESC')
                ->orderBy('last_name', 'ASC')
                ->get(); 
        }else{
            return Redirect::to('/admin')
                ->with('message', array('type' => 'danger', 'text' => 'You don\'t have classes at this time'));
        }

        
        $page_data = array(
            'today' => $today,
            'class' => $class,
            'students' => $students
        );

        $this->layout->title = 'Attendance';
        $this->layout->content = View::make('admin.attendance', $page_data);

    }


    public function updateAttendance(){

        $date = Input::get('date');

        $class_id = Input::get('class_id');
        $students = Input::get('students');
        
        $drop_absences_count = DB::table('classes')
                ->where('id', '=', $class_id)
                ->pluck('drop_absences_count');

        if(!empty($students['excused'])){
            foreach($students['excused'] as $student_id){           
               
                $attendance = new StudentAttendance;
                $attendance->student_id = $student_id;
                $attendance->class_id = $class_id;
                $attendance->date = $date;
                $attendance->type = 'excused';
                $attendance->save();
            }
        }


        if(!empty($students['absent'])){
            foreach($students['absent'] as $student_id){

                $id = $class_id . $student_id;

                $attendance = new StudentAttendance;
                $attendance->student_id = $student_id;
                $attendance->class_id = $class_id;
                $attendance->date = $date;
                $attendance->type = 'absent';
                $attendance->save();

               
                $current_absence_count = DB::table('student_classes')
                    ->where('id', '=', $id)
                    ->pluck('current_absence_count');

                $current_absence_count += 1;

                if($current_absence_count == $drop_absences_count){
                    //update status to: to_drop
                    DB::table('student_classes')
                        ->where('id', '=', $id)
                        ->update(array(
                            'status' => 'to_drop'
                        ));
                }
                
                //increment current_absence_count
                DB::table('student_classes')
                    ->where('id', $id)
                    ->increment('current_absence_count');

            }
        }

        return array(
            'type' => 'success',
            'text' => 'Updated Attendance!'
        );
    
    }


    public function studentsToDrop($class_id){

        $class = DB::table('classes')
            ->where('id', '=', $class_id)
            ->pluck('name');

        $to_drop = DB::table('student_classes')
            ->join('students', 'student_classes.student_id', '=', 'students.id')
            ->select('student_classes.id AS id', 'students.id AS student_id', 'last_name', 'first_name', 'middle_initial')
            ->where('class_id', '=', $class_id)
            ->where('status', '=', 'to_drop')
            ->get();


        $page_data = array(
            'class' => $class,
            'to_drop' => $to_drop
        );

        $this->layout->title = 'Students to Drop';
        $this->layout->content = View::make('admin.to_drop', $page_data);
    }


    public function droppedStudents($class_id){

        $class = DB::table('classes')
            ->where('id', '=', $class_id)
            ->pluck('name');

        $dropped = DB::table('student_classes')
                ->join('students', 'student_classes.student_id', '=', 'students.id')
                ->select('student_classes.id AS id', 'students.id AS student_id', 'last_name', 'first_name', 'middle_initial')
                ->where('class_id', '=', $class_id)
                ->where('status', '=', 'dropped')
                ->get();


        $page_data = array(
            'class' => $class,
            'dropped' => $dropped
        );

        $this->layout->title = 'Students to Drop';
        $this->layout->content = View::make('admin.dropped', $page_data);
    }


    public function updateStudentStatus(){


        $id = Input::get('id');
        $status = Input::get('status');

        DB::table('student_classes')
            ->where('id', '=', $id)
            ->update(array(
                'status' => $status
            ));

        if($status === 'has_card'){
            //reset current_absence_count
            DB::table('student_classes')
                ->where('id', '=', $id)
                ->update(array(
                    'current_absence_count' => 0
                ));
        }

        return array(
            'type' => 'success',
            'text' => 'Updated Status!'
        );

    }


    public function absences($id){

        $class_id = substr($id, 0, 1);
        $student_id = substr($id, 1);

        $student = Student::find($student_id);

        $absences = StudentAttendance::where('student_id', '=', $student_id)
            ->where('class_id', '=', $class_id)
            ->orderBy('date', 'ASC')
            ->get();

        $class = DB::table('classes')->where('id', $class_id)->pluck('name');
  
        $page_data = array(
            'student' => $student,
            'absences' => $absences,
            'class' => $class
        );

        $this->layout->title = 'Absences';
        $this->layout->content = View::make('admin.absences', $page_data);

    }


    public function semesterSettings(){

        $sem = DB::table('semester_settings')
            ->where('id', 1)
            ->first();

        $page_data = array(
            'sem' => $sem
        );

        $this->layout->title = 'Semester Settings';
        $this->layout->content = View::make('admin.semester_settings', $page_data);

    }


    public function updateSemesterSettings(){

        DB::table('semester_settings')->update(Input::all());
        return Redirect::back()->with('message', array('type' => 'success', 'text' => 'Semester settings is updated!'));
    }


    public function logout(){

        Session::flush();
        Auth::logout();
        return Redirect::to("/login")
          ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));

    }

}
