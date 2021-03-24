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
                        <h3 class="text-themecolor m-b-0 m-t-0">Video</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item"><a href="/course">Course</a></li>
                            <li class="breadcrumb-item">Playlist</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <a href="{{route('course.playlist',['uuid'=> request()->segment(2)])}}" class="btn waves-effect waves-light btn-danger pull-right ">Courses List</a>
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
                            @if(empty($video))
                                <form method="post" action="{{route('courseplay.store',['uuid'=>request()->segment(2)])}}" class="form-horizontal form-material">
                            @else
                            <form method="post" action="{{route('courseplay.update',['uuid'=>request()->segment(2),'id'=>$video->id])}}" class="form-horizontal form-material">
                            @method('put')
                            @endif
                                @csrf
                                    <div class="form-group">
                                        <label class="col-md-12">Title</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Title" name="title" value="<?php if(!empty($video->title)) { echo $video->title;}?>" required class="form-control form-control-line @error('title') is-invalid @enderror">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Video Link</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Video Link" name="youtube_link" value="<?php if(!empty($video->youtube_link)) { echo $video->youtube_link;}?>" required class="form-control form-control-line @error('youtube_link') is-invalid @enderror">
                                            @error('youtube_link')
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
                                                <option <?php if(!empty($video)) { if($video->status==1) { echo 'selected';} }?> value="1">Active</option>
                                                <option <?php if(!empty($video)) { if($video->status==0) { echo 'selected';} }?> value="0">InActive</option>
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
                                            <textarea rows="5" class="form-control form-control-line" name="description"><?php if(!empty($video)) { echo $video->description; }?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success"><?php if(!empty($video)) { echo 'Update'; } else { echo 'Save';}?></button>
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