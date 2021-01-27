@extends('layouts.app')
@section('title','Add Job')
@section('css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection

@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{route('job.index')}}">Job</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
    <div class="card w-100">
        <div class="card-header">
            <h2 class="card-title">Add Job</h2>
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
                <form class="form form-vertical" action="{{route('job.store')}}" method="post">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="hrname">Job Title</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="jobtitle" class="form-control @error('jobtitle') is-invalid @enderror" name="jobtitle" placeholder="Job Title" value="{{old('jobtitle')}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-message-alt-dots"></i>
                                        </div>
                                    </div>
                                    @error('jobtitle')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="jobdescription">Job Description</label>
                                    <div class="position-relative has-icon-left">
                                    <textarea id="jobdescription" class="form-control @error('jobdescription') is-invalid @enderror" name="jobdescription" placeholder="Job Description">{{old('jobdescription')}}</textarea>
                                        <div class="form-control-position">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                    @error('jobdescription')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="jobdescription">Job Technology</label>

                                        <select id="jobtechnology" class="select2 form-control @error('jobtechnology') is-invalid @enderror" name="jobtechnology[]" data-placeholder="Select a Technology" multiple>
                                        @forelse ($technology as $item)
                                            <option value="{{$item->id}}" {{ (collect(old('jobtechnology'))->contains($item['id']))  ? 'selected' : '' }}>{{$item->tech}}</option>
                                        @empty
                                            <option value="">No Technology Found</option>
                                        @endforelse
                                    </select>

                                    @error('jobtechnology')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
