<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.default';

	public function index(){

		$this->layout->title = 'Home';
		$this->layout->content = View::make('index');

	}

	public function register(){

		$this->layout->title = 'Sign Up';
		$this->layout->content = View::make('register');

	}


	public function doRegister(){

        $rules = array(
            'username' => 'required',
            'email' => 'email|required|unique:users'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()){
            return Redirect::to('/register')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }else{

            $username = Input::get('username');
            $email = Input::get('email');
            $password = Input::get('password');
            
            $user = new User;
            $user->username = $username;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            Session::forget('plan.id');

            Auth::loginUsingId($user->id);
            
            return Redirect::to('/admin');
        }

	}

	public function login(){

		$this->layout->title = 'Login';
		$this->layout->content = View::make('login');

	}

	public function doLogin(){

        $rules = array(
            'email' => 'email|required',
            'password' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){

            return Redirect::to('/login')
                ->withErrors($validator)
                ->withInput(Input::except('password'));

        }else{

            $user_data = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            if(Auth::attempt($user_data)){
               return Redirect::to('/admin');
            }else{
                return Redirect::to('/login')
                    ->with('message', array('type' => 'danger', 'text' => 'Incorrect email or password'));
            }

        }

	}


    public function registerCheck(){

        $username = Input::get('username');
        $email = Input::get('email');
        $password = Input::get('password');

        $rules = array(
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        );

        $validator = Validator::make(Input::all(), $rules);

        $errors = null;
        if($validator->fails()){
            $errors = array();
            $messages = $validator->messages();
            foreach($messages->all() as $mess){
                $errors[] = $mess;
            }

            return array(
                'errors' => $errors
            );
        }

        return 'success';
    }


}
