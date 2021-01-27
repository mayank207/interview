@extends('layouts.app')
@section('title','Add Note')
@section('css')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection

@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{route('notes.index')}}">Note</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
    <div class="card w-100">
        <div class="card-header">
            <h2 class="card-title">Add Note</h2>
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
                <form class="form form-vertical" action="{{route('notes.store')}}" method="post">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="notetitle">Note Title</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="notetitle" class="form-control @error('notetitle') is-invalid @enderror" name="notetitle" placeholder="Note Title" value="{{old('notetitle')}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-note"></i>
                                        </div>
                                    </div>
                                    @error('notetitle')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="notedescription">Note Description</label>
                                    <div class="position-relative has-icon-left">
                                    <textarea id="notedescription" class="form-control @error('notedescription') is-invalid @enderror" name="notedescription" placeholder="Note Description">{{old('notedescription')}}</textarea>
                                        <div class="form-control-position">
                                            <i class="bx bx-spreadsheet"></i>
                                        </div>
                                    </div>
                                    @error('notedescription')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="favourite" id="favourite">
                                        <label class="custom-control-label" for="favourite">Favourite</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
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
