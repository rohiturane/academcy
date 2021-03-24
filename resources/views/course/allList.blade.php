@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">All Courses</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/student/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Courses</li>
                </ol>
            </div>
        </div>
        <div class="row">
                <!-- Column -->
                
                    <?php if(!empty($courses[0])) { 
                        foreach($courses as $course) { 
                         //var_dump($course); exit;
                        ?>
                        <div class="col-lg-4 col-xlg-3 col-md-5">
                            <div class="card">
                                <div class="card-block">
                                    <center class="m-t-30"> 
                                        <h4 class="card-title m-t-10">Course Name: <?= $course->name ?></h4>
                                        <h6 class="card-subtitle"> <?= $course->description; ?></h6>
                                        <div class="row text-center justify-content-md-center">
                                        <div class="col-6"><a href="{{route('course.enrolled',['uuid'=>$course->uuid,'video'=>1])}}" class="btn btn-primary"><i class="mdi mdi-arrow-right"></i> <font class="font-medium">Enter</font></a></div>
                                        <!-- <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div> -->
                                    </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    <?php } } else { ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <h3>The Course has not yet created</h3>
                            </div>
                        </div>
                    </div>
                <?php } ?>
        </div>
    </div>
</div>
@endsection