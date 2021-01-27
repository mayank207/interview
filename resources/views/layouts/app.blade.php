<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="loading">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/vendors.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vertical-menu.min.css') }}" rel="stylesheet">
    <link href="{{asset('css/toastr.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

    @yield('css')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 2-columns  navbar-sticky footer-static menu-collapsed " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top bg-secondary">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            @include('layouts.header')
                        </ul>
                    </div>
                    <div class="mr-auto row">
                     @foreach ($not as $note)
                    <div class="shadow-lg bg-white px-1 mx-1">
                        <div class="text-center">
                            <span class="title"><b>{{$note->title}}</b></span>
                        </div>
                        <div class="text-center">
                             {{$note->description}}
                        </div>
                    </div>
                     @endforeach
                 </div>
                    
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <img class="round mr-1" src="{{asset('image/profile')}}/{{Auth::user()->profile_pictures}}" alt="avatar" height="40" width="40">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name">{{Auth::user()->name}} <i class="bx bx-caret-down"></i></span>
                                </div>
                                <span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{route('profile.show')}}"><i class="bx bx-user mr-50"></i> Edit Profile</a>
                                <a class="dropdown-item" href="{{route('password')}}"><i class="bx bx-lock mr-50"></i>Change Password</a>
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bx bx-power-off mr-50"></i> Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('home')}}">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">Techno</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
                <li class="{{ (request()->is('home*')) ? 'active':'' }} nav-item"><a href="{{route('home')}}"><i class="bx bxs-dashboard"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                </li>
                <li class="{{ (request()->is('job*')) ? 'active':'' }} nav-item"><a href="{{route('job.index')}}"><i class="bx bx-briefcase-alt"></i><span class="menu-title" data-i18n="Email">Jobs</span></a>
                </li>
                <li class="{{ (request()->is('notes*')) ? 'active':'' }} nav-item"><a href="{{route('notes.index')}}"><i class="bx bx-notepad"></i><span class="menu-title" data-i18n="Notes">Notes</span></a>
                </li>
                <li class="{{ (request()->is('recrut*')) ? 'active':'' }} nav-item"><a href="{{route('recrut.index')}}"><i class="bx bx-calendar"></i><span class="menu-title" data-i18n="Calendar">Recruting</span></a>
                </li>
                @can('create-hr')
                    <li class="{{ (request()->is('hr*')) ? 'active':'' }} nav-item"><a href="{{route('hr.index')}}"><i class="bx bx-user-plus"></i><span class="menu-title" data-i18n="Kanban">HR</span></a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->


    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="kanban-overlay"></div>
                <section id="kanban-wrapper">


                    {{-- Job Modal Start --}}
                    <div class="modal fade text-left" id="addjob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="myModalLabel1">Add Job</h3>
                                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                                <form id="jobform">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="title" id="title" placeholder="Job Title">
                                            <span class="text-danger error" data-error="title"></span>
                                        </div>
                                    <div class="form-group">
                                        <label>Description </label>
                                        <textarea placeholder="Type Here..." class="form-control" id="jobdescription" name="jobdescription"></textarea>
                                        <span class="text-danger error" data-error="jobdescription"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Technology</label>
                                        <select class="select2 form-control" name="technology[]" id="technology" multiple>
                                        </select>
                                        <span class="text-danger error" data-error="technology"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Save</span>
                                    </button>
                                </div>
                            </form>

                            </div>
                        </div>
                    </div>

{{-- Note Modal Start --}}
                    <div class="modal fade text-left" id="addnote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="myModalLabel1">Add Note</h3>
                                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                                <form id="noteform">
                                    <div class="container">
                                        <div id="noteerrors" class="text-center"></div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="notetitle" id="notetitle" placeholder="Title" class="form-control">
                                            <span class="text-danger error" data-error="notetitle"></span>
                                        </div>
                                    <div class="form-group">
                                        <label>Description: </label>
                                        <textarea placeholder="Type Here..." class="form-control" id="description" name="description"></textarea>
                                        <span class="text-danger error" data-error="description"></span>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" name="favouritenote" class="checkbox-input" id="checkbox1">
                                        <label for="checkbox1">Favourite</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Save</span>
                                    </button>
                                </div>
                            </form>

                            </div>
                        </div>
                    </div>

            {{-- Student Modal --}}
                    <div class="modal fade text-left" id="studentmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="myModalLabel1">Add Candidate</h3>
                                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                                <form enctype="multipart/form-data" method="post" id="studentform">

                                <div class="modal-body">
                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <label>Name</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                            <span class="text-danger error" data-error="name"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Email</label>
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                            <span class="text-danger error" data-error="email"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                                        <span class="text-danger error" data-error="phone"></span>
                                    </div>
                                    <div class="form-group d-flex my-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="freshercollpase" name="expereince" value="0" class="custom-control-input" data-toggle="collapse" data-parent="#freshercollpase" checked>
                                            <label class="custom-control-label" for="freshercollpase">Fresher</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="expereincecollpase" name="expereince" value="1" class="custom-control-input" data-toggle="collapse" data-parent="#expereincecollpase">
                                            <label class="custom-control-label" for="expereincecollpase">Expereince</label>
                                        </div>
                                    </div>
                                    <div class="row collapse my-2" id="expereincepanel">
                                        <div class="col-md-6">
                                            <label for="year">Year</label>
                                            <input type="number" name="year" id="year" class="form-control" value="0" placeholder="Year">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="month">Month</label>
                                            <input type="number" name="month" id="month" class="form-control" placeholder="Month">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Technology</label>
                                        <select class="select2 form-control" name="technology[]" id="student_technology" data-placeholder="Select Technology" multiple>
                                        </select>
                                        <span class="text-danger error" data-error="technology"></span>
                                    </div>
                                    <div class="form-group">
                                    <label>Attachment</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                        <label class="custom-file-label" for="attachment">Choose Attachment</label>
                                        <span class="text-danger error" data-error="attachment"></span>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label>State</label>
                                        <select name="state" class="custom-select" id="state">
                                            <option value="">Select Technology</option>
                                        </select>
                                        <span class="text-danger error" data-error="state"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Save</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>

                    @yield('content')

                </section>

            </div>
        </div>
    </div>



    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

     <!-- BEGIN: Footer-->
     <footer class="footer footer-static bg-primary text-white">
        <p class="clearfix mb-0"><span class="float-left d-inline-block">{{ now()->year }} &copy; Technostacks</span><span class="float-right d-sm-inline-block d-none">Developed By  :  <a class="text-uppercase text-white" href="#" target="_blank"><b>Technostacks</b></a></span>
        </p>
    </footer>
    <!-- END: Footer-->

    <script src="{{asset('js/vendors.min.js')}}"></script>
    <script src="{{asset('js/quill.min.js')}}"></script>
    <script src="{{asset('js/app-menu.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script src="{{asset('js/select2.full.min.js')}}"></script>
    <script src="{{asset('js/form-select2.min.js')}}"></script>
    <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     fetch_technology();
     fetch_state();

    // Fetch Technology
    function fetch_technology()
    {
        var all_tech='';
        $.ajax({
            url:'{{route("technology")}}',
            method:'get',
            success:function(data)
            {
                $.each(data.technology,function(key,value){
                    all_tech+='<option value="'+value.id+'">'+value.tech+'</option>';
                });
                $('#technology,#student_technology').append(all_tech);
            }
        });
    }
    // Fetch State
    function fetch_state()
    {
        var all_state='';
        $.ajax({
            url:'{{route("state")}}',
            method:'get',
            success:function(data)
            {
                $.each(data.state,function(key,value){
                    all_state+='<option value="'+value.id+'">'+value.status+'</option>';
                });
                $('#state,#filterstate').append(all_state);
            }
        });
    }

    // Add New Job
    $('#jobform').on('submit',function(e){
        $('#joberrors').html('');
        $('#success-message').html('');
        e.preventDefault();

        $.ajax({
            url: "{{ route('job.store')}}",
            method: 'post',
            data: $('#jobform').serialize(),
            success: function(data){

                if(data.success){
                    $('#addjob').modal('hide');
                    $('#jobform')[0].reset();
                     toastr.success(data.success, 'Success Message');
                }
            },
            error:function(error){
                    let errors = error.responseJSON.errors;
                    for(let key in errors)
                    {
                        let errorDiv = $(`[data-error="${key}"]`);
                        if(errorDiv.length )
                        {
                            errorDiv.text(errors[key][0]);
                        }
                    }
                }
        });
    });

    // Add New Note
    $('#noteform').on('submit',function(e){
        $('#noteerrors').html('');
        $('#success-message').html('');
        e.preventDefault();

        $.ajax({
            url: "{{ route('notes.store')}}",
            method: 'post',
            data: $('#noteform').serialize(),
            success: function(data){
                  if(data.messages)
                {
                    $('#noteerrors').append('<div class="bg-danger text-white py-1 mb-1">'+data.messages+'</div>');
                }
                $.each(data.errors, function(key, value){
                    $('#noteerrors').show();
                    $('#noteerrors').append('<div class="bg-danger text-white py-1 mb-1">'+value+'</div>');
                    });
                if(data.success){
                    $('#success-message').append("");
                    $('#addnote').modal('hide');
                    $('#noteform')[0].reset();
                    toastr.success(data.success, 'Success Message');

                }
                if(data.danger){
                    $('#success-message').append("");
                    toastr.success(data.danger, 'Warnning Message');
                }

            },
            error:function(error){
                    let errors = error.responseJSON.errors;
                    for(let key in errors)
                    {
                        let errorDiv = $(`[data-error="${key}"]`);
                        if(errorDiv.length )
                        {
                            errorDiv.text(errors[key][0]);
                        }
                    }
                }
        });
    });

    // Add New Student
    $('#studentform').on('submit',function(e){
        $('#recruterrors').html('');
        $('#success-message').html('');
        e.preventDefault();

        $.ajax({
            url: "{{route('recrut.store')}}",
            method: 'post',
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            data: new FormData(this),
            success: function(data){
                $.each(data.errors, function(key, value){
                    $('#recruterrors').show();
                    $('#recruterrors').append('<div class="bg-danger text-white py-1 mb-1">'+value+'</div>');
                    });
                if(data.success){
                    $('#success-message').append("");
                    $('#studentmodal').modal('hide');
                    $('#studentform')[0].reset();
                    toastr.success(data.success, 'Success Message');

                }
                if(data.danger){
                    $('#success-message').append("");
                    toastr.success(data.danger, 'danger Message');
                }


            },
            error:function(error){
                    let errors = error.responseJSON.errors;
                    for(let key in errors)
                    {
                        let errorDiv = $(`[data-error="${key}"]`);
                        if(errorDiv.length )
                        {
                            errorDiv.text(errors[key][0]);
                        }
                    }
                }
        });
    });


    setTimeout(() => { $('.toast').hide(); }, 2000);
    </script>
    @yield('js')
</body>
</html>
