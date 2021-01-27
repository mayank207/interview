@extends('layouts.app')
@section('title','Profile Page')

@section('content')

<div class="row mt-2">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has($msg))
        <div id="toast-container" class="toast-container toast-top-right">
            <div class="toast toast-success" aria-live="polite" style="display: block;">
                <div class="toast-title">Success </div>
                <div class="toast-message"> {{ Session::get($msg) }}</div>
            </div>
        </div>
    @endif
@endforeach
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                            <div class="media">
                                <a href="javascript: void(0);">
                                    <img src="{{asset('image/profile')}}/{{Auth::user()->profile_pictures}}" class="rounded mr-75" alt="profile image" height="64" width="64">
                                </a>

                            </div>
                            <hr>
                            <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Name</label>
                                                <input type="text"  class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{Auth::user()->name}}" >
                                            @if($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif

                                        </div>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>E-mail</label>
                                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{Auth()->user()->email}}" >
                                            @if($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Profile</label>
                                                <div class="custom-file">
                                                    <input type="hidden" name="hiddenimage" value="{{Auth()->user()->profile_pictures}}">
                                                    <input type="file" class="custom-file-input @error('profile') is-invalid @enderror" name="profile" id="customFile" value="{{Auth()->user()->profile_pictures}}">
                                                    <label class="custom-file-label" for="customFile">Upload new photo</label>
                                                </div>
                                                @if($errors->has('profile'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('profile') }}</strong>
                                                </span>
                                            @endif
                                            <p class="text-muted ml-1 mt-50"><small>Allowed JPG, JPEG, GIF or PNG. Max
                                                size of
                                                10000kB</small></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                        <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                            changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>setTimeout(() => { $('.toast').hide(); }, 2000);</script>
@endsection
