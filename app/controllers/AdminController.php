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


    public function logout(){

        Session::flush();
        Auth::logout();
        return Redirect::to("/login")
          ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));

    }

}
