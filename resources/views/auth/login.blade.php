@extends('layouts.layout-login')

@section('content')
<section id="auth-login" class="row flexbox-container">
    <div class="col-xl-8 col-11">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center mb-2">Welcome Back</h4>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="{{route('login')}}" method="POST">
                                    @csrf
                                    <div class="form-group mb-50">
                                        <label class="text-bold-600" for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="Email address" name="email" value="{{old('email')}}" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password" name="password" autofocus>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary glow w-100 position-relative">Login<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <div class="card-content">
                        <img class="img-fluid" src="{{asset('image/login.png')}}" alt="branding logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
