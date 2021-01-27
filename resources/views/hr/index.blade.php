@extends('layouts.app')
@section('title','Hr Details')
@section('css')

    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">

@endsection

@section('content')
<div class="bg-white shadow-lg col-md-12" style="padding:10px"> 
{{-- HR modal --}}
  <div class="modal fade text-left" id="addhrmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="hrmodallabel">Add HR</h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form action="{{route('hr.store')}}" method="post" id="addhrform">
                <div class="container">
                    <div id="joberrors" class="text-center"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="position-relative has-icon-left">
                            <input type="text" id="hrname" class="form-control" name="hrname" placeholder="Name">
                            <div class="form-control-position">
                                <i class="bx bx-user"></i>
                            </div>
                            <span class="text-danger error" data-error="hrname"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="position-relative has-icon-left">
                            <input type="text" id="hremail" class="form-control" name="hremail" placeholder="Email" data-error="hremail">
                            <div class="form-control-position">
                                <i class="bx bx-mail-send"></i>
                            </div>
                            <span class="text-danger error" data-error="hremail"></span>
                        </div>
                    </div>
                    <input type="hidden" name="hrid" id="hrid" value="">
                    <div class="form-group" id="hrpasswordedit">
                        <div class="position-relative has-icon-left">
                        <input type="password" id="hrpassword" class="form-control" name="hrpassword" placeholder="Password" data-error="hrpassword">
                            <div class="form-control-position">
                                <i class="bx bx-lock"></i>
                            </div>
                        </div>
                        <span class="text-danger error" data-error="hrpassword"></span>
                    </div>

                    <div class="form-group" id="passwordgroup">
                        <div class="position-relative has-icon-left">
                        <input type="password" id="confirm-password" class="form-control" name="confirm-password" placeholder="confirm password" data-error="confirm-password">
                            <div class="form-control-position">
                                <i class="bx bx-lock"></i>
                            </div>
                        </div>
                        <span class="text-danger error" data-error="confirm-password"></span>
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





<div class="float-right mt-3">
    <button href="{{route('hr.create')}}" class="btn btn-primary mb-1 shadow-lg" data-toggle="modal" data-target="#addhrmodal" id="addhrbutton" >
        <i class='bx bx-add-to-queue mr-50'></i>Add HR
    </button>
</div>

<div class="clearfix"></div>


<div class="row mb-3">
    <div class="col-md-12">
    <div class="bg-white shadow-lg col-md-12" style="padding:10px"> 
        <div class="float-right">
            <input type="text" name="searchhr" id="searchhr" class="form-control" placeholder="Search here">
        </div>
        @include('hr.hrpagination')
        <button class="btn btn-danger mt-2" id="multipledelete">Delete</button>
    </div>
    </div>
</div>
</div>

  <div class="modal fade text-left" id="deletehrmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" > 
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1">Confirmation</h3>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete ?
                    </p>
                </div>
                <div class="modal-footer">
                    <form action="" method="post" id="hrdeletemodal">
                        @csrf
                    <input type="hidden" name="" id="hrdeleteid">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-danger ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Delete</span>
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script>
        setTimeout(() => { $('.toast').hide(); }, 2000);


    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length==$('.checkbox').length){
            $('#check_all').prop('checked',true);
        }
        else{
            $('#check_all').prop('checked',false);
        }
    });

        var idsArr=[];
    $('#multipledelete').on('click',function(){
        $('.checkbox:checked').each(function(){
            idsArr.push($(this).attr('data-id'));
        });
        if(idsArr.length==0){
            alert('Select at least one');
        }
        else
        {
              $('#deletehrmodal').modal('show');
              var strIds=idsArr.push($(this).attr('data-id'));
        }
    });

    $(document).on('submit','#hrdeletemodal',function(e){
            
            e.preventDefault();
            
            var strIds=strIds;

              var strIds=idsArr.join(','); 

             $.ajax({
                    url: "{{route('deletemultiplehrs')}}",
                    type: "DELETE",
                    data:'ids='+strIds,
                    success: function(data){
                        toastr.success(data.success, 'Success Message');
                        $('.checkbox:checked').each(function(){
                            $(this).parents("tr").remove();
                        });
                        $('#deletehrmodal').modal('hide');
                        fetch_hr(current_page);
                    }
                });
        });





        var current_page='1';
        function fetch_hr(page='',query='')
        {
            $.ajax({
                url:"{{route('hrsearch')}}",
                method: 'post',
                data:{page:page,search:query},
                success:function(data)
                {
                    $('#hrdata').html('');
                    $('#hrdata').html(data);
                }
            });
        }

        // Pagination HR
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            current_page=page;
            $('#hidden_page').val(page);    
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_hr(page);
        });

        // Delete HR
        $(document).on('click','.deletehr',function(){
            var hrid=$(this).attr('data-id');
            
            $('#hrdeleteid').val(hrid);
             $('#hrdeletemodal').attr('id','singledeletemodal');
            $('#deletehrmodal').modal('show');
            
           
        });

        $(document).on('submit','#singledeletemodal',function(e){
            e.preventDefault();
            var hrid=$('#hrdeleteid').val();
             $.ajax({
                    url: 'hr/'+hrid,
                    type: "DELETE",
                    success: function(data){
                        toastr.success(data.success, 'Success Message');
                           $('#deletehrmodal').modal('hide');
                        fetch_hr(current_page);
                         $('#singledeletemodal').attr('id','hrdeletemodal');
                    }
                });
        });
         // Search Job
        $('#searchhr').on('keyup',function(){
            var query=$(this).val();
            fetch_hr('',query);
        });


        // Add HR
        $(document).on('submit','#addhrform',function(e){
            e.preventDefault();
            $('.error').html('');
            $.ajax({
                url: "{{ route('hr.store')}}",
                method: 'post',
                data: $('#addhrform').serialize(),
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    // if(data.success){
                        $('#addhrform')[0].reset();
                        toastr.success(data.success, 'Success Message');
                        $('#addhrmodal').modal('hide');
                        fetch_hr();
                    // }
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
      $('#addhrbutton').on('click',function(){
            $('#passwordgroup').show();
            $('#hrpasswordedit').show();
            $('#hrmodallabel').html('Add Hr');
            $('#hrid,#hrname,#hremail').val('');
             $('#updatehrform').attr('id','addhrform');

        });
        // Edit Job
    $(document).on('click','.edithr',function(){
         $('#hrid,#hrname,#hremail').val('');
            $('#addhrform').attr('id','updatehrform');
            $('#hrpasswordedit').hide();
            $('#hrmodallabel').html('Update Hr');
            $('#addhrmodal').modal('show');
            $('#passwordgroup').hide();
        var hrid=$(this).attr('data-id');
        $.ajax({
            url:'hr/'+hrid,
            method:'GET',
            success:function(data){
                if(data.success){
                    $('#hrid').val(data.success.id);
                    $('#hrname').val(data.success.name);
                    $('#hremail').val(data.success.email);
                }
            }
        });
    });

// update hr
    $(document).on('submit','#updatehrform',function(e){
            e.preventDefault();
            $('.error').html('');
            $.ajax({
                url: "{{ route('updatehr')}}",
                method: 'post',
                data: $('#updatehrform').serialize(),
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    // if(data.success){
                        $('#updatehrform')[0].reset();
                        toastr.success(data.success, 'Success Message');
                        $('#addhrmodal').modal('hide');
                        fetch_hr(current_page);
                        $('#updatehrform').attr('id','addhrform');
                    // }
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

    </script>
@endsection
