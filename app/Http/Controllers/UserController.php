<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use PHPUnit\Framework\MockObject\Rule\Parameters;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function inithome(){
        if (auth()->user()->type == 1){
            return redirect()->route('teacher.home')->with("login", "Welcome, " . auth()->user()->firstname);
        }
        else if (auth()->user()->type == 2){
            return redirect()->route('student.home')->with("login", "Welcome, " . auth()->user()->firstname);
        }
        else{
            return redirect('/');
        }
    }

    public function register(){
        if (View::exists('user.signuser')){
            return view('user.signuser');
        }
        else{
            return abort(404);
        }
    }

    public function login(){
        if (View::exists('user.signuser')){
            return view('user.signuser');
        }
        else{
            return abort(404);
        }
    }


    public function process(Request $request){
        $validated = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required',
        ]);

        if (!auth()->attempt($validated)){
            return redirect('/login')->withErrors(['login' => 'Invalid credentials.']);
        }

        $request->session()->regenerate();

        if (auth()->user()->type == 1){
            return redirect()->route('teacher.home')->with("login", "Welcome, " . auth()->user()->firstname);
        }
        else if (auth()->user()->type == 2){
            return redirect()->route('student.home')->with("login", "Welcome, " . auth()->user()->firstname);
        }
        else{
            return redirect('/');
        }
    }

    public function store(Request $request){
        $request->merge(['reference_id' => $this->generateUID()]);
        $request->merge(['verification_token' => Str::random(60)]);
        $validated = $request->validate([
            "reference_id" => [Rule::unique('users', 'reference_id')],
            "firstname" => ['required', 'min:1'],
            "middlename" => ['required', 'min:1'],
            "lastname" => ['required', 'min:1'],
            "verification_token" => ['required'],
            "email" => ['required', 'email', Rule::unique('users','email')],
            "password" => 'required|confirmed|min:8',
            "type" => 'required',
        ]);
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);
        event(new Registered($user));

        // //Mail
        // $data = [
        //     'subject' => 'THRIVE Email Verification',
        //     'body' => 'link'
        // ];

        // Mail::to($user->email)->send(new MailNotify($data));
        // auth()->login($user);
        return redirect(route('login'))->with('message', 'Successfully registered! Please login with your account to start.');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully logged out');
    }

    // Private functions
    private function generateUID(){
        $timestamp = time();
        $randomNum = mt_rand(100000, 999999);
        $uid = substr($timestamp . $randomNum, -6);
        return (string)$uid;
    }


    public function account(){
        if (View::exists('user.account')){
            $user = User::find(auth()->user()->id);
            return view('user.account', ['user' => $user]);
        }
        else{
            return abort(404);
        }
    }

    public function updatename(Request $request){
        $user = User::find(auth()->user()->id);
        $user->firstname = $request['firstname'];
        $user->middlename = $request['middlename'];
        $user->lastname = $request['lastname'];
        $user->save();

        return back()->with('success', 'Successfully updated account information.');
    }

    public function updatepassword(Request $request){
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|min:8|confirmed',
        ]);
        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->oldpassword, $user->password)) {
            return back()->withErrors(['oldpassword' => 'The old password is incorrect.']);
        }
        $user->password = Hash::make($request->newpassword);
        $user->save();

        return back()->with('success', 'Successfully updated password.');
    }
}
