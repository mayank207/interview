@extends('layouts.app')
@section('title','Edit Note')
@section('css')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection

@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{route('notes.index')}}">Note</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <div class="card w-100">
        <div class="card-header">
            <h2 class="card-title">Edit Note</h2>
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
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form form-vertical" action="{{route('notes.update',$notes->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">Note Title</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="title" class="form-control  @error('title') is-invalid @enderror" name="title"
                                        value="{{$notes->title}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-user"></i>
                                        </div>
                                    </div>
                                    @error('title')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Note Description</label>
                                    <div class="position-relative has-icon-left">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{$notes->description}}</textarea>
                                        <div class="form-control-position">
                                            <i class="bx bx-mail-send"></i>
                                        </div>
                                    </div>
                                    @error('description')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                <a href="{{route('notes.index')}}" class="btn btn-light-secondary mr-1 mb-1">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('js/select2.full.min.js')}}"></script>
<script src="{{asset('js/form-select2.min.js')}}"></script>
<script>setTimeout(() => { $('.toast').hide(); }, 2000);</script>
@endsection
