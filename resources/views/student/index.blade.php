@extends('layouts.app')
@section('content')
<?php 
$deviceLogged = [];
foreach($devices as $device)
{
    foreach($students as $student){
        if($student->email == $device->email) {
            if(array_key_exists($student->email, $deviceLogged)) {
                $deviceLogged[$device->email]=$deviceLogged[$device->email]+1;
            } else{
                $deviceLogged[$device->email]=1;
            }
        }
    }
} 
?>
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
                            <li class="breadcrumb-item active">Students</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <a href="{{route('student.create')}}" class="btn waves-effect waves-light btn-danger pull-right">Add New</a>
                    </div>
                </div>
                
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">Students</h4>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered display dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile No.</th>
                                                <th>Status</th>
                                                <th>Logged In Devices</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $key => $student)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$student->first_name.' '.$student->middle_name.' '.$student->last_name}}</td>
                                                <td>{{$student->email}}</td>
                                                <td>{{$student->mobile}}</td>
                                                <td>@if($student->status==1)<span class="badge badge-primary">Active</span>@elseif($student->status==2)<span class="badge badge-info">Completed</span>@else<span class="badge badge-danger">InActive</span>@endif</td>
                                                <td style="text-align:center;"><?php if(!empty($deviceLogged[$student->email])) { echo $deviceLogged[$student->email]; } else { echo 0;}?></td>
                                                <td><a href="{{route('student.edit',['uuid'=>$student->uuid])}}"><i class="mdi mdi-border-color mdi-24px"></i></a><a data-toggle='modal'href="#" data-target='#deleteModal' data-href="{{route('student.delete',['uuid'=>$student->uuid])}}"><i class="mdi mdi-delete mdi-24px"></i></a><a href="{{route('student.devices',['uuid'=>$student->uuid])}}"><i class="mdi mdi-cellphone-link mdi-24px"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="topModalLabel">Proceed with the request?</h4>
                <button type="button" class="close ml-auto" data-dismiss="modal"
                    aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h5>Confirmation to Delete? </h5>
                <p>Do you really want to Delete?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                    data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger text-white" onclick="event.preventDefault(); document.getElementById('deleteform').submit();">Delete</a>
                <form id="deleteform" method="POST" style="display: none;">
                    @method('delete')
                    {{ csrf_field() }}
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@section('script')
<script>
$(document).ready( function () {
    $('#zero_config').DataTable();
    <?php
        if(Session::has('success')){
            echo 'Swal.fire("Success", "'.session('success').'","success");';
        }
        if(Session::has('error')) {
            echo "Swal.fire({ icon: 'error', title: 'Oops...', text: '".session('error')."'})";
        }
    
    ?>
    $('#zero_config_length').find( "select" ).css('width','35%');
    $('#zero_config_wrapper').removeClass('container-fluid').css('width','98%');
} );
$('#deleteModal').on('show.bs.modal', function(e) {
    $(this).find('#deleteform').attr('action', $(e.relatedTarget).data('href'));

});
</script>
@endsection