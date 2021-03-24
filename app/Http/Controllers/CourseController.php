<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Student;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Video;

class CourseController extends Controller
{
    protected $course;
    protected $student;
    protected $video;

    public function __construct(Student $student, Course $course, Video $video, CourseStudent $course_stud)
    {
        $this->course = $course;
        $this->student = $student;
        $this->video = $video;
        $this->course_stud = $course_stud;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = $this->course->all();
        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.create');
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
            'name'=>'required',
            'status'=>'required'
        ]);
        if($validator->fails()){
            return redirect('course/create')->withErrors($validator)->withInput();
        }
        $data = [
            'name'=>$input_array['name'],
            'uuid'=>(string) Str::orderedUuid(),
            'status'=>$input_array['status'],
            'description'=>$input_array['description']
        ];
        $course = $this->course->create($data);
        if(!!$course) {
            session()->flash('success','Course has Added');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/course');
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
        $course = $this->course->where('uuid',$uuid)->first();
        return view('course/create', compact('course'));
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
            'name'=>'required',
            'status'=>'required'
        ]);
        if($validator->fails())
        {
            return redirect('course/'.$uuid.'/edit')->withErrors($validator)->withInput();
        }
        $data = [
            'name'=>$input_array['name'],
            'status'=>$input_array['status'],
            'description'=>$input_array['description']
        ];
        $course = $this->course->where('uuid',$uuid)->update($data);
        if(!!$course) {
            session()->flash('success','Course has Updated');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/course');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $course = $this->course->where('uuid',$uuid)->first();
        if(!!$course){
            $course->delete();
            session()->flash('success','Course has Deleted');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/course');
    }

    public function playlist($uuid)
    {
        $playlist = $this->course->with('video')->where('uuid', $uuid)->first();
        return view('course/list',compact('playlist'));
    }

    public function playcreate()
    {
        return view('course/videocreate');
    }


    public function playedit($uuid, $id)
    {
        $video = $this->video->where('id',$id)->first();
        return view('course/videocreate',compact('video'));
    }
    public function playdelete($uuid, $id)
    {
        $video = $this->video->find($id);
        if(!!$video)
        {
            $video->delete();
            session()->flash('success','Video has Deleted');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/course/'.$uuid.'/playlist');
    }

    public function playstore(Request $request, $uuid)
    {
        $input_array = $request->all();
        $validator = Validator::make($input_array, [
            'title'=>'required',
            'youtube_link'=>'required',
            'status'=>'required'
        ]);
        if($validator->fails())
        {
            return redirect('course/'.$uuid.'/videocreate')->withErrors($validator)->withInput();
        }
        $course = $this->course->where('uuid',$uuid)->first();
        $data = [
            'title'=>$input_array['title'],
            'course_id'=>$course->id,
            'description'=>$input_array['description'],
            'youtube_link'=>$input_array['youtube_link'],
            'status'=>$input_array['status']
        ];
        $video = $this->video->create($data);
        if(!!$video) {
            session()->flash('success','Video has Added');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/course/'.$uuid.'/playlist');
    }

    public function playupdate(Request $request, $uuid, $id)
    {
        $input_array = $request->all();
        $validator = Validator::make($input_array,[
            'title'=>'required',
            'youtube_link'=>'required',
            'status'=>'required'
        ]);
        if($validator->fails())
        {
            return redirect('course/'.$uuid.'/'.$id.'/videoedit')->withErrors($validator)->withInput();
        }
        $data = [
            'title'=>$input_array['title'],
            'description'=>$input_array['description'],
            'youtube_link'=>$input_array['youtube_link'],
            'status'=>$input_array['status']
        ];
        $video = $this->video->where('id',$id)->update($data);
        if(!!$video)
        {
            session()->flash('success','Video has Updated');
        } else{
            session()->flash('error','Something goes wrong');
        }
        return redirect('/course/'.$uuid.'/playlist');
    }

    public function allCourse()
    {
        $courses = $this->course->where('status',1)->get();
        return view('course.allList',\compact('courses'));
    }

    public function courseEnrolled($uuid)
    {
        $videos = DB::table('courses')
            ->join('videos', 'videos.course_id', '=', 'courses.id')
            ->where('courses.uuid','=',$uuid)->where('videos.status','=','1')
            ->get();
        //$videos = $this->course->with('video')->where('uuid',$uuid)->first();
        $student_info = $this->student->where('email', Auth::user()->email)->first();
        $data = [
            'course_id'=>$videos[0]->id,// Course id
            'student_id'=>$student_info->id  //Student id
        ];
        $enrolled = $this->course_stud->where($data)->first();
        if(!$enrolled) {
            $coustud = $this->course_stud->create($data);
        }
        return view('course.playList',compact('videos','student_info'));
    }
}
