@extends('errors.default')
@section('content')
    <div class="error-box">
        <div class="error-body text-center">
            <h1>405</h1>
            <h3 class="text-uppercase">Method Not Allowed!</h3>
            <p class="text-muted m-t-30 m-b-30">Something went wrong Go to Home</p>
            <a href="/" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
    </div>
@endsection