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
                        <h3 class="text-themecolor m-b-0 m-t-0">Courses</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Course</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <a href="{{route('course.index')}}" class="btn waves-effect waves-light btn-danger pull-right ">Courses Lis</a>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    
                    <!-- Column -->
                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            <div class="card-block">
                            @if(empty($course))
                                <form method="post" action="{{route('course.store')}}" class="form-horizontal form-material">
                            @else
                            <form method="post" action="{{route('course.update',['uuid'=>$course->uuid])}}" class="form-horizontal form-material">
                            @method('put')
                            @endif
                                @csrf
                                    <div class="form-group">
                                        <label class="col-md-12">Course Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Name" name="name" value="<?php if(!empty($course->name)) { echo $course->name;}?>" required class="form-control form-control-line @error('name') is-invalid @enderror">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Status</label>
                                        <div class="col-sm-12">
                                            <select name="status" class="form-control form-control-line @error('status') is-invalid @enderror" required>
                                                <option <?php if(!empty($course)) { if($course->status==1) { echo 'selected';} }?> value="1">Active</option>
                                                <option <?php if(!empty($course)) { if($course->status==0) { echo 'selected';} }?> value="0">InActive</option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Description</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" class="form-control form-control-line" name="description"><?php if(!empty($course)) { echo $course->description; }?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success"><?php if(!empty($course)) { echo 'Update'; } else { echo 'Save';}?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
@endsection
@section('script')
<script>
$(document).ready( function () {
    <?php
        if(Session::has('success')){
            echo 'Swal.fire("Success", "'.session('success').'","success");';
        }
        if(Session::has('error')) {
            echo "Swal.fire({ icon: 'error', title: 'Oops...', text: '".session('error')."'})";
        }
    
    ?>
});
</script>
@endsection