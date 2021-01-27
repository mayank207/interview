@extends('layouts.app')
@section('title','All Notes')
@section('css')

    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <style>
        .checkbox-input{cursor: pointer}
    </style>
@endsection
@section('content')


{{-- Notes modal --}}
<div class="modal fade text-left" id="addnotemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="notemodallabel">Add Note</h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form method="post" id="noteformsingle">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="position-relative has-icon-left">
                            <input type="text" name="notetitle" id="singlenotetitle" placeholder="Title" class="form-control">
                            <div class="form-control-position">
                                <i class="bx bxs-send"></i>
                            </div>
                            <span class="text-danger error" data-error="notetitle"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="position-relative has-icon-left">
                            <textarea placeholder="Type Here..." class="form-control" id="notedescription" name="description"></textarea>
                            <div class="form-control-position">
                                <i class="bx bxs-comment-detail"></i>
                            </div>
                            <span class="text-danger error" data-error="description"></span>
                        </div>
                    </div>
                    <input type="hidden" name="noteid" id="noteid">
                    <div class="checkbox">
                        <i class="bx bxs-star"></i>
                        <input type="checkbox" name="favouritenote" class="checkbox-input" id="favouritenote">
                        <label for="favouritenote">Favourite</label>
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

  <div class="modal fade text-left" id="deletenotemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" > 
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
                    <form action="" method="post" id="notedeletemodal">
                    @csrf
                    <input type="hidden" name="deletenot" id="deletenot">
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


<div class="float-right mt-3">
    <button class="btn btn-primary mb-1" data-toggle="modal" data-target="#addnotemodal" id="addnotebutton">
        <i class='bx bx-add-to-queue mr-50'></i>Add Notes
    </button>
</div>
<div class="clearfix"></div>



<div class="row mb-3">
    <div class="col-md-12">
        <div class="float-right">
            <input type="text" name="searchnote" id="searchnote" class="form-control" placeholder="Search here">
        </div>
        @include('notes.notepagination')
        <button class="btn btn-danger mt-2" id="multipledelete">Delete</button>
    </div>
</div>

@endsection


@section('js')

    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            setTimeout(() => { $('.toast').hide(); }, 2000);

            $('#errors').html('');



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
            $('#deletenotemodal').modal('show');
             idsArr.push($(this).attr('data-id'));

        }
    });

         $(document).on('submit','#notedeletemodal',function(e){
            
          e.preventDefault();
           
              var strIds=idsArr.join(','); 
             $.ajax({
                    url: "{{route('deletemultiplenotes')}}",
                    type: "DELETE",
                    data:'ids='+strIds,
                    success: function(data){
                        toastr.success(data.success, 'Success Message');
                        $('.checkbox:checked').each(function(){
                            $(this).parents("tr").remove();
                        });
                        $('#deletenotemodal').modal('hide');
                        fetch_note(current_page);
                    }
                });
        });



    var current_page='1';
    function fetch_note(page='',query='')
    {
        $.ajax({
            url:"{{route('notesearch')}}",
            method: 'post',
            data:{page:page,search:query},
            success:function(data)
            {
                $('#notedata').html('');
                $('#notedata').html(data);
            }
        });
    }

     // Pagination Note
     $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        current_page=page;
        $('#hidden_page').val(page);
        $('li').removeClass('active');
        $(this).parent().addClass('active');
        fetch_note(page);
    });

     // Delete Note


            $(document).on('click','#deletenote',function(){
            var noteid=$(this).attr('data-id');
            
            
            $('#deletenot').val(noteid);
            
           $('#notedeletemodal').attr('id','singledeletemodal');
        $('#deletenotemodal').modal('show');
        });

        $(document).on('submit','#singledeletemodal',function(e){
            e.preventDefault();
            var noteid=$('#deletenot').val();
             
             $.ajax({
                    url: 'notes/'+noteid,
                    type: "DELETE",
                    success: function(data){

                        toastr.success(data.success, 'Success Message');
                           $('#deletenotemodal').modal('hide');
                        fetch_note(current_page);
                         $('#singledeletemodal').attr('id','notedeletemodal');
                    }
                });
        });

    // Edit Note
    $(document).on('click','.editnote',function(){
        $('#notemodallabel').html('Update Note');
        $('#addnotemodal').modal('show');
        $('#singlenotetitle,#notedescription').val('');
        var noteid=$(this).attr('data-id');
        $.ajax({
            url:'notes/'+noteid,
            method:'GET',
            success:function(data){
                if(data.success){
                    $('#noteformsingle').attr('id','updatenoteform');
                    $('#noteid').val(data.success.id);
                    $('#singlenotetitle').val(data.success.title);
                    $('#notedescription').val(data.success.description);
                    if(data.success.favourite==1)
                    {
                        $('#favouritenote').prop('checked',true);
                    }
                    else{
                        $('#favouritenote').prop('checked',false);
                    }
                }
            }
        });
    });

    $('#addnotebutton').on('click',function(){
        $('#singlenotetitle,#notedescription').val('');
        $('.error').html('');
        $('#notemodallabel').html('Add Note');
        $('#favouritenote').prop('checked',false);
    });

    // Add Note
    $(document).on('submit','#noteformsingle',function(e){
        e.preventDefault();
        $('.error').html('');
        $.ajax({
            url: "{{ route('notes.store')}}",
            method: 'post',
            data: $('#noteformsingle').serialize(),
            dataType: 'json',
            success: function(data){
                console.log(data);
                if(data.danger){
                    toastr.success(data.danger, 'Danger Message');
                }
                if(data.success){
                    $('#noteformsingle')[0].reset();
                    toastr.success(data.success, 'Success Message');
                    $('#addnotemodal').modal('hide');
                    fetch_note();
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

    // Search Job
    $('#searchnote').on('keyup',function(){
        var query=$(this).val();
        fetch_note('',query);
    });

    // Update Job
    $(document).on('submit','#updatenoteform',function(e){
        e.preventDefault();
        $('.error').html('');
        $.ajax({
            url:"{{route('updatenote')}}",
            method:'post',
            data:$('#updatenoteform').serialize(),
            dataType: 'json',
            success:function(data){
                if(data.success)
                {
                    $('#updatenoteform')[0].reset();
                    toastr.success(data.success, 'Success Message');
                    $('#addnotemodal').modal('hide');
                    fetch_note(current_page);
                }
                if(data.danger)
                {
                    toastr.success(data.danger, 'Success Message');
                }

            },
            error:function(error)
            {
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

        });
    </script>
@endsection