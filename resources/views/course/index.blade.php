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
                        <a href="{{route('course.create')}}" class="btn waves-effect waves-light btn-danger pull-right ">Add New</a>
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
                                <h4 class="card-title">Courses</h4>
                                
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered display dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($courses as $key => $course)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$course->name}}</td>
                                                <td>@if($course->status==1)<span class="badge badge-primary">Active</span>@else<span class="badge badge-danger">InActive</span>@endif</td>
                                                <td><a href="{{route('course.edit',['uuid'=>$course->uuid])}}"><i class="mdi mdi-border-color mdi-24px"></i></a><a data-toggle='modal'href="#" data-target='#deleteModal' data-href="{{route('course.delete',['uuid'=>$course->uuid])}}"><i class="mdi mdi-delete mdi-24px"></i></a><a href="{{ route('course.playlist',['uuid'=>$course->uuid]) }}"><i class="mdi mdi-format-list-bulleted mdi-24px"></i></a></td>
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
<!-- Top modal content -->
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