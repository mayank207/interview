@extends('layouts.app')
@section('title','All Jobs')
@section('css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection
@section('content')

<div class="bg-white shadow-lg col-md-12" style="padding:20px">

<div class="bg-white shadow-lg col-md-12" style="padding: 10px">
<form id="jobformsingle" class="mb-3">

<div class="row align-items-start">

        <div class="col-md-3">
            <div class="form-group">
                <label for="Title">Job Title</label>
                <input type="text" class="form-control" name="title" id="jobtitle" placeholder="Job Title" value="">
                <span class="text-danger error" data-error="title"></span>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="description">Job Description</label>
                <textarea placeholder="Type Description Here..." class="form-control" id="editjobdescription" name="jobdescription"></textarea>
                <span class="text-danger error" data-error="jobdescription"></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="technology">Technology</label>
                <select class="select2 form-control jobtechnology" name="technology[]" id="technology" multiple>
                </select>
                <span class="text-danger error" data-error="technology"></span>
            </div>
        </div>
        <input type="hidden" name="jobid" id="jobid">
            
        
</div>

        
        <div class="row float-right px-1 ml-1" >
            <button type="submit" class="btn btn-primary px-1 ml-1">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block"><i class="bx bx-plus"></i>&nbsp;&nbsp;Save </span>
            </button>
        </div>

</div>

</form>
</div>


<div class="row mb-3">
    <div class="col-md-12">
        <div class="float-right">
            <input type="text" name="searchjob" id="searchjob" class="form-control" placeholder="Search here">
        </div>
        @include('jobs.jobpagination')
        <button class="btn btn-danger mt-2" id="multipledelete" >Delete</button>
    </div>


  <div class="modal fade text-left" id="deletejobmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" > 
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
                    <form action="" method="post" id="jobdeletemodal">
                    <input type="hidden" name="" id="jobdeleteid">
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


</div>
</div>
@endsection

@section('js')

<script src="{{asset('js/select2.full.min.js')}}"></script>
<script src="{{asset('js/form-select2.min.js')}}"></script>
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

              $('#deletejobmodal').modal('show');
              idsArr.push($(this).attr('data-id'));

        }
    });

            $(document).on('submit','#jobdeletemodal',function(e){
            
          e.preventDefault();
           
              var strIds=idsArr.join(','); 
             $.ajax({
                    url: "{{route('deletemultiplejobs')}}",
                    type: "DELETE",
                    data:'ids='+strIds,
                    success: function(data){
                        toastr.success(data.success, 'Success Message');
                        $('.checkbox:checked').each(function(){
                            $(this).parents("tr").remove();
                        });
                        $('#deletejobmodal').modal('hide');
                        fetch_note(current_page);
                    }
                });
        });


        


    var current_page='1';
    function fetch_job(page='',query='')
    {
        $.ajax({
            url:"{{route('jobsearch')}}",
            method: 'post',
            data:{page:page,search:query},
            success:function(data)
            {
                $('#jobdata').html('');
                $('#jobdata').html(data);
            }
        });
    }

    // Pagination Job
    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        current_page=page;
        $('#hidden_page').val(page);
        $('li').removeClass('active');
        $(this).parent().addClass('active');
        fetch_job(page);
    });




        // Delete job
        $(document).on('click','#deletejob',function(){
            var jobid=$(this).attr('data-id');
            
            $('#jobdeleteid').val(jobid);
             $('#jobdeletemodal').attr('id','singledeletemodal');
            $('#deletejobmodal').modal('show');

            
           
        });

         $(document).on('submit','#singledeletemodal',function(e){
            e.preventDefault();
            var jobid=$('#jobdeleteid').val();
              
             $.ajax({
                    url: 'job/'+jobid,
                    type: "DELETE",
                    success: function(data){
                        toastr.success(data.success, 'Success Message');
                        
                        $('#deletejobmodal').modal('hide');
                        fetch_job(current_page);
                        $('#singledeletemodal').attr('id','jobdeletemodal');
                    }
                });
        });


    // Add Job
    $(document).on('submit','#jobformsingle',function(e){
        e.preventDefault();
        $('.error').html('');
        $.ajax({
            url: "{{ route('job.store')}}",
            method: 'post',
            data: $('#jobformsingle').serialize(),
            dataType: 'json',
            success: function(data){
                if(data.success){
                    $('#jobformsingle')[0].reset();
                    $('#technology').prop('selectedIndex',0);
                    toastr.success(data.success, 'Save Successfully ');
                    fetch_job();
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

    // Edit Job
    $(document).on('click','.editjob',function(){
        var jobid=$(this).attr('data-id');
        $.ajax({
            url:'job/'+jobid,
            method:'GET',
            success:function(data){
                if(data.success){
                    $('#jobformsingle').attr('id','updatejobform');
                    $('#jobid').val(data.success.id);
                    $('#jobtitle').val(data.success.title);
                    $('#editjobdescription').val(data.success.description);
                    var alltech=data.success.get_technology;
                    var tech='';
                    function checkExists(id)
                    {
                        var w=alltech.filter(function(item){
                        var itemData=item.tech?item.tech:'';
                        var textData=id;
                        return itemData.indexOf(textData) > -1;
                        });
                        if(w.length==1){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                    $.each(data.technology,function(key,value){
                        if(checkExists(value.tech))
                        {
                            tech+='<option value='+value.id+' selected>'+value.tech+'</option>';
                        }
                        else
                        {
                            tech+='<option value='+value.id+'>'+value.tech+'</option>';
                        }
                    });
                    $('.jobtechnology').append(tech);
                }
            }
        });
    });

    // Search Job
    $('#searchjob').on('keyup',function(){
        var query=$(this).val();
        fetch_job('',query);
    });

    // Update Job
    $(document).on('submit','#updatejobform',function(e){
        e.preventDefault();
        $('.error').html('');
        $.ajax({
            url:"{{route('updatejob')}}",
            method:'post',
            data:$('#updatejobform').serialize(),
            dataType: 'json',
            success:function(data){
                $('#updatejobform')[0].reset();
                toastr.success(data.success, 'Update Successfully');
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
</script>

@endsection
