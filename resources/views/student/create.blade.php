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
                        <h3 class="text-themecolor m-b-0 m-t-0">Students</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Student</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <a href="{{route('student.index')}}" class="btn waves-effect waves-light btn-danger pull-right">Student List</a>
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
                            @if(empty($student))
                                <form method="post" action="{{route('student.store')}}" class="form-horizontal form-material">
                            @else
                            <form method="post" action="{{route('student.update',['uuid'=>$student->uuid])}}" class="form-horizontal form-material">
                            @method('put')
                            @endif
                                @csrf
                                    <div class="form-group">
                                        <label class="col-md-12">First Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="First Name" name="first_name" value="<?php if(!empty($student->first_name)) { echo $student->first_name;}?>" required class="form-control form-control-line @error('first_name') is-invalid @enderror">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Middle Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Middle Name" name="middle_name" value="<?php if(!empty($student->middle_name)) { echo $student->middle_name;}?>" required class="form-control form-control-line @error('middle_name') is-invalid @enderror">
                                            @error('middle_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Last Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Last Name" name="last_name" value="<?php if(!empty($student->last_name)) { echo $student->last_name;}?>" required class="form-control form-control-line @error('last_name') is-invalid @enderror">
                                            @error('last_name')
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
                                                <option <?php if(!empty($student)) { if($student->status==1) { echo 'selected';} }?> value="1">Active</option>
                                                <option <?php if(!empty($student)) { if($student->status==0) { echo 'selected';} }?> value="0">InActive</option>
                                                <option <?php if(!empty($student)) { if($student->status==2) { echo 'selected';} }?> value="2">Completed</option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" placeholder="Email" name="email" id="email" value="<?php if(!empty($student->email)) { echo $student->email;}?>" <?php if(!empty($student->email)) { echo "disabled";}?> required class="form-control form-control-line @error('email') is-invalid @enderror">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Mobile</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Mobile" name="mobile" maxlength="10" value="<?php if(!empty($student->mobile)) { echo $student->mobile;}?>" required class="form-control form-control-line @error('mobile') is-invalid @enderror">
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="isLogged" id="isLogged" <?php if(!empty($student)) { if($student->isLogged) { echo 'checked'; } }?>>

                                                <label class="form-check-label" for="isLogged">
                                                    {{ __('Student Login') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="loginEmail" <?php  if(!empty($student)) { if($student->isLogged) { echo 'style="display:block;"'; } else { echo 'style="display:none;"'; }   } else { echo 'style="display:none;"'; }   ?>>
                                        <label class="col-md-12">UserName</label>
                                        <div class="col-md-12">
                                            <input type="email" disabled id="username" value="<?php if(!empty($student->email)) { echo $student->email;}?>" class="form-control form-control-line ">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group" id="loginPassword" <?php if(!empty($student)) { if($student->isLogged) { echo 'style="display:block;"'; } else { echo 'style="display:none;"'; }  } else { echo 'style="display:none;"'; }    ?>>
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" placeholder="*********" name="password" autocomplete="off" id="pwd" class="form-control form-control-line">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success"><?php if(!empty($student)) { echo 'Update'; } else { echo 'Save';}?></button>
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
$('#isLogged').change(function() {
    if($(this).prop('checked')) {
        var email = $('#email').val();
        $('#loginEmail').css('display','block');
        $('#loginPassword').css('display','block');
        $('#username').val(email);
        $('#pwd').attr('required');
    } else{
        $('#username').val('');
        $('#loginEmail').css('display','none');
        $('#loginPassword').css('display','none');
    }
});
</script>
@endsection