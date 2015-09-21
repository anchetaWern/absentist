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
                    $student_class->save();
                }
                
                
            }
        }
        
        return Redirect::back()->with('message', array('type' => 'success', 'text' => 'Class Created!'));

    }



    public function logout(){

        Session::flush();
        Auth::logout();
        return Redirect::to("/login")
          ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));

    }

}
