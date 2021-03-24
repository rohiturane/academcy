<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;
use App\Models\CourseStudent;

class HomeController extends Controller
{
    protected $course_stud;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CourseStudent $course_stud)
    {
        $this->course_stud = $course_stud;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $enrolled = DB::select('SELECT COUNT(student_course.student_id) as total, CONCAT(MONTH(student_course.created_at), "-", YEAR(student_course.created_at)) as mon ,courses.name FROM `student_course`, courses WHERE student_course.course_id=courses.id GROUP BY CONCAT(MONTH(student_course.created_at),"-", YEAR(student_course.created_at)), courses.id');
        
        return view('home', compact('enrolled'));
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $data = $request->all();
    
        $user = User::find(auth()->user()->id);

        if(!\Hash::check($data['old_password'], $user->password)){
            session()->flash('error', 'The current password does not match with your credentials.');
            return back();

        }else{

        //    here you will write password update code
            $user->password = Hash::make($data['new_password']);
            $user->save();
            session()->flash('success','Password has Updated');
            return redirect('/change/password');
        }
    }
    public function changePassword()
    {
        return view('auth.changepassword');
    }
}
