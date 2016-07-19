<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Question;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['questions' => Question::whereNull('answer')->orWhere('answer', '')->orderBy('id', 'DESC')->paginate(10)]);
    }

    public function answered()
    {
        return view('answered', ['questions' => Question::whereNotNull('answer')->orderBy('id', 'DESC')->paginate(10)]);
    }

    public function saveAnswer(Request $request)
    {
        // Validate
        $this->validate($request, [
            'id'        =>  'required|exists:questions,id',
            'answer'    =>  'required|string'
        ]);
        $q = Question::findOrFail($request->id);
        $q->answer = $request->answer;
        $q->save();

        $request->session()->flash('success', 'Answer saved.');
        return redirect('/home');
    }

    public function users()
    {
        return view('users', ['users' => User::withTrashed()->paginate(10)]);
    }

    public function saveUser(Request $request)
    {
        $this->validate($request, [
            'username'  =>  'required|unique:users,username',
            'password'  =>  'required|confirmed'
        ]);

        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        $request->session()->flash('success', 'User saved.');
        return redirect('/users');
    }

    public function deleteUser(Request $request, $id)
    {
        if ($id == Auth::user()->id) {
            $request->session()->flash('error', 'You can\'t delete your own account.');
            return redirect('/users');
        }
        $user = User::findOrFail($id);
        $user->delete();

        $request->session()->flash('success', 'User deleted.');
        return redirect('/users');
    }

    public function restoreUser(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        $request->session()->flash('success', 'User restored.');
        return redirect('/users');
    }
}
