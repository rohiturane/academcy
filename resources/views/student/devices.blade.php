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
                        <h3 class="text-themecolor m-b-0 m-t-0">Devices</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item "><a href="/student">Student</a></li>
                            <li class="breadcrumb-item">List of Devices</li>
                        </ol>
                    </div>
                    @if(!empty($devices[0])) 
                    <!-- <div class="col-md-7 col-4 align-self-center">
                        <a href="{{route('student.deviceReset',['uuid'=>request()->segment(2)])}}" class="btn waves-effect waves-light btn-danger pull-right ">Reset Device</a>
                    </div> -->
                    @endif
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
                    
                        <?php if(!empty($devices[0])) { 
                            foreach($devices as $device) { 
                            $specification = getBrowser($device->user_agent);
                            $device = deviceDetect($device->user_agent);
                            // var_dump($device); exit;
                            ?>
                            <div class="col-lg-4 col-xlg-3 col-md-5">
                                <div class="card">
                                    <div class="card-block">
                                        <center class="m-t-30"> <img src="{{ asset('assets/images/'.$device)}}" class="img-responsive" width="150" />
                                            <h4 class="card-title m-t-10">Device Used: <?= $specification['platform']; ?></h4>
                                            <h6 class="card-subtitle">Browser Used: <?= $specification['name'].' '.$specification['version']?></h6>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        <?php } } else { ?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <h3>The student has not yet login from any device</h3>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        </div>
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
} );
</script>
@endsection