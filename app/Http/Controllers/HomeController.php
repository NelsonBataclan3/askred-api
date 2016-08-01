<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Question;
use App\User;
use App\Department;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
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
        $q->answered_by = Auth::user()->id;
        $q->save();

        $request->session()->flash('success', 'Answer saved.');
        return redirect('/home');
    }

    public function users()
    {
        return view('users', ['users' => User::withTrashed()->paginate(10), 'departments' => Department::all()]);
    }

    public function saveUser(Request $request)
    {
        $this->validate($request, [
            'username'  =>  'required|unique:users,username|alpha_num',
            'password'  =>  'required|confirmed'
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'department'    =>  $request->department,
            'type'  =>  $request->type
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

    public function getDepartments()
    {
        return view('departments', ['departments' => Department::withTrashed()->orderBy('id', 'DESC')->paginate(10)]);
    }

    public function saveDepartment(Request $request)
    {
        Department::create([
            'name'  =>  $request->name
        ]);

        $request->session()->flash('success', 'Department saved.');
        return redirect('/departments');
    }

    public function deleteDepartment(Request $request, $id)
    {
        $dept = Department::findOrFail($id);
        $dept->delete();

        $request->session()->flash('success', 'Department deleted.');
        return redirect('/departments');
    }

    public function restoreDepartment(Request $request, $id)
    {
        $dept = Department::withTrashed()->findOrFail($id);
        $dept->restore();

        $request->session()->flash('success', 'Department restored.');
        return redirect('/departments');
    }

    public function changePassword(Request $request)
    {
        // Validate
        $this->validate($request, [
            'password'      =>      'confirmed'
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            // Change password
            Auth::user()->password = bcrypt($request->password);
            Auth::user()->save();
            $request->session()->flash('success', 'Password changed.');
            return Redirect::back();
        } else {
            $request->session()->flash('error', 'Invalid old password.');
            return Redirect::back();
        }
    }
}
