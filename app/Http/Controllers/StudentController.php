<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\User;

class StudentController extends Controller
{
    protected $student;
    protected $user;

    public function __construct(Student $student, User $user)
    {
        $this->student = $student;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = $this->student->all();
        $devices = DB::table('devices')->join('users','users.id','=','devices.user_id')->get();
        return view('student.index',compact('students','devices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input_array = $request->all();
        
        $validator = Validator::make($input_array,[
            'first_name'=>'required',
            'middle_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'mobile'=>'required'
        ]);
        if($validator->fails()) {
            return redirect('student/create')->withErrors($validator)->withInput();
        }

        $data = [
            'first_name'=>$input_array['first_name'],
            'middle_name'=>$input_array['middle_name'],
            'last_name'=>$input_array['last_name'],
            'email'=>$input_array['email'],
            'mobile'=>$input_array['mobile'],
            'uuid'=>(string) Str::orderedUuid(),
            'status'=>$input_array['status'],
            'isLogged'=>(!empty($input_array['isLogged']) && $input_array['isLogged']=='on') ? 1:0,
        ];
        $student = $this->student->create($data);
        if(!!$student) {
            if( !empty($input_array['isLogged']) && $input_array['isLogged']=='on') {
                $user = $this->user->create([
                    'name'=> $input_array['first_name'].' '.$input_array['last_name'],
                    'email'=>$input_array['email'],
                    'password'=>Hash::make($input_array['password']),
                    'active'=>$input_array['status'],
                    'role'=>2
                ]);
            }
            session()->flash('success','Student has Added');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/student');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $student = $this->student->where('uuid',$uuid)->first();
        return view('student/create',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $input_array = $request->all();
        $validator = Validator::make($input_array,[
            'first_name'=>'required',
            'middle_name'=>'required',
            'last_name'=>'required',
            'mobile'=>'required'
        ]);
        if($validator->fails()) {
            return redirect('student/'.$uuid.'/create')->withErrors($validator)->withInput();
        }

        $data = [
            'first_name'=>$input_array['first_name'],
            'middle_name'=>$input_array['middle_name'],
            'last_name'=>$input_array['last_name'],
            'status'=>$input_array['status'],
            'mobile'=>$input_array['mobile']
        ];

        $student = $this->student->where('uuid',$uuid)->update($data);
        if($student) {
            $student = $this->student->where('uuid',$uuid)->first();
            $userdata = [
                'name'=> $input_array['first_name'].' '.$input_array['last_name'],
                'password'=>Hash::make($input_array['password']),
                'active'=>$input_array['status']
            ];
            $user = $this->user->where('email', $student->email)->update($userdata);
            if($user) {
                session()->flash('success','Student has Updated');
            } else{
                session()->flash('error','Something goes wrong');
            }
        } else {
            session()->flash('error','Something goes wrong');
        }
        return redirect('/student');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $student = $this->student->where('uuid',$uuid)->first();
        if($student){
            $user = $this->user->where('email',$student->email)->update(['active'=>'0']);
            $student->delete();
            session()->flash('success','Student has Deleted.');
        } else {
            session()->flash('error','Something goes wrong');
        }
        return redirect('/student');
    }

    public function alldevices($uuid)
    {
        $student = $this->student->where('uuid', $uuid)->first();
        $devices = DB::table('devices')->join('users','users.id','=','devices.user_id')->where('users.email',$student->email)->get();
        return view('student/devices',compact('devices'));
    }

    public function resetDevice($uuid)
    {
        $student = $this->student->where('uuid', $uuid)->first();
        $device = DB::table('devices')->join('users','users.id','=','devices.user_id')->where('users.email', $student->email)->delete();
        if($device) {
            session()->flash('success','Device has Reset');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/student/'.$uuid.'/devices');
    }

    public function dashboard()
    {
        return view('student.dashboard');
    }
    
    public function videoSeen($uuid, $id)
    {
        if($user = Auth::user())
        {
            $student = $this->student->where('email', $user->email)->first();
            $tata = empty($student->video_seen) ? [] : $student->video_seen;
            if(!in_array($id, $tata)) {
                array_push($tata, (int)$id);
                $student->video_seen = $tata;
                $student->save();
            }
            return response()->json(['success'=>true,'message'=>'Video seen completed.']);
        }
        return response()->json(['success'=>false,'message'=>'Something goes wrong']);
    }
}
