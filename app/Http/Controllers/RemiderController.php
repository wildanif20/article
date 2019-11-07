<?php

namespace App\Http\Controllers;

use Event;
use App\Events\RemiderEvent;
use App\User;
use Reminder;
use Sentinel;
use Illuminate\Http\Request;
use Session;

class RemiderController extends Controller
{
    public function create(){
        return view('remiders.create');
    }

    public function store(Request $request){
        $getuser = User::where('email', $request->email)->first();
        $user = Sentinel::findById($getuser->id);
        
        
        if($getuser){
            // dd(Reminder::create($user));
            ($remider = Reminder::exists($user)) || ($remider = Reminder::create($user));
            Event(new RemiderEvent($user, $remider));
            Session::flash('notice', 'Chech your email for instruction');
            dd('berhasil');
        } else {
            dd('gagal');
            Session::flash('error', 'Email not valid');
        }
        return view('remiders.create');
    }

    public function edit($id, $code){
        $user = Sentinel::findById($id);

        if(Reminder::exists($user, $code)){
            return view('remiders.edit', ['id' => $id, 'code' => $code]);
        } else {
            return redirect('/');
        }
    }

    public function update(ReminderRequest $request, $id, $code){
        $user = Sentinel::findById($id);
        $remider = Remider::exists($user, $code);

        if($remider){
            Session::flash('notice', 'You password success midified');
            Reminder::complete($user, $code, $request->password);
            return redirect('login');
        } else {
            Session::flash('error', 'Password must match.');
        }
    }
}
