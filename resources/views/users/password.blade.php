@extends('layouts.app')
@section('title','Change Password')

@section('content')


<div class="row mt-3">
    <div class="col-md-12">

    <form action="{{route('UpdatePassword',Auth::user()->id)}}" method="post" >
        @csrf
        <div class="form-group">
            <label for="">Password</label>
            <input type="Password" name="Password" value="" placeholder="Enter New Password"class="form-control @error('Password') is-invalid @enderror" name="password" required autocomplete="new-password">
            <small><b>At Least 8 Characters ,Uper & Lower Case , Numberic , At Least One special character </b></small>
            @error('Password')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Confirm Password</label>
            <input type="Password" name="Confirm-Password" value="" placeholder="Confirm Password" class="form-control @error('Confirm-Password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('Confirm-Password')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <input type="submit" name="submit" class="btn btn-primary" value="Update">


    </form>
</div>
</div>



@endsection
