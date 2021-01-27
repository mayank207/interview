@extends('layouts.app')
@section('title','Dashboard')
@section('css')
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('css/pickadate.css')}}">
<style type="text/css">
input[type=number] {
  -moz-appearance: textfield;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
@media (max-width:768px){
    #notes {
        flex-direction: column;
    }
}
</style>
@endsection
@section('content')
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




    {{-- Display 3 Cards --}}
<div class="bg-white shadow-lg col-md-12" style="padding: 15px">                  
                            

    <div class="row">
                <div class="col-xl-4 col-md-4 col-sm-4">
                    <div class="card text-center shadow-lg" >
                        <div class="card-content">
                            <div class="card-body">
                                <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                    <i class="bx bxs-group font-medium-5"></i>
                                </div>
                                <p class="text-muted mb-0 line-ellipsis">Total</p>
                                <h2 class="mb-0">{{$total_student}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
               
             <div class="col-xl-4 col-md-4 col-sm-4 ">
              
                    <div class="card text-center shadow-lg">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                    <i class="bx bx-briefcase font-medium-5"></i>
                                </div>
                                <p class="text-muted mb-0 line-ellipsis">Job Description</p>
                                <h2 class="mb-0">{{$total_job}}</h2>
                            </div>
                        </div>
                    </div>
                </div>

               
                 
                <div class="col-xl-4 col-md-4 col-sm-4">

                    <div class="card text-center" data-toggle="modal" data-target="#policy" id="policy-card">
                        <div class="card-content shadow-lg">
                            <div class="card-body">
                                <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                    <i class="bx bx-file font-medium-5"></i>
                                </div>
                                
                                <p class="text-muted mb-0 line-ellipsis">Policy</p>
                                
                                <h2 class="mb-0">{{1}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


{{-- Policy modal --}}
<div class="modal fade text-left show" id="policy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-modal="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Policy</h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
        <form id="policyform" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
               <div class="form-group">
                   <label for="policy title">Title</label>
                    <input type="text" name="title" value="" class="form-control" id="policytitle">
                </div>
                <div class="error" data-error="title"></div>

                <div class="form-group">
                    <label for="policydescription">Policy Description</label>
                    <textarea name="policy_description" id="policydescription" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="error" data-error="policy_description"></div>

                <div class="custom-file">
                    <input type="file" name="document" id="document" class="form-control">
                </div>
                <div class="error" data-error="document"></div>
                <input type="hidden" name="documentname" id="documentname">
                <input type="hidden" name="policyid" id="policyid" value="">
                <a href="#" target="_blank"  class="btn btn-block" id="showdocument">Show Document</a>
                <input type="submit" class="btn btn-primary btn-block" value="Save">
                </form>
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"></span>

                </button>
            </div>
        </form>


        </div>
    </div>
</div>


    {{-- Display Student With Filter --}}
    <div class="bg-white shadow-lg col-md-12" style="padding:10px"> 
        <div class="row my-2">
            @include('layouts.studentsearch')
        </div>
        <div style="padding-right:50px" align="right" >
        <button class="btn btn-danger mt-2 " id="multipledelete">Delete</button>
        </div>
    <div id="filterdate" class="collapse">
        <div class="d-flex">
            <fieldset class="form-group position-relative has-icon-left">
                <input type="text" name="startdate" class="form-control pickadate" placeholder="Select Start Date">
                <div class="form-control-position">
                    <i class='bx bx-calendar'></i>
                </div>
            </fieldset>
            <fieldset class="form-group position-relative has-icon-left">
                <input type="text" name="enddate" class="form-control pickadate" placeholder="Select End Date">
                <div class="form-control-position">
                    <i class='bx bx-calendar'></i>
                </div>
            </fieldset>
        </div>
    </div>
    @include('layouts.studentpagination')
    </div>
    

   <div class="modal fade text-left" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" > 
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
                    <form action="" method="post" id="multideletemodal">
                    
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

@endsection
@section('js')

<script src="{{asset('js/picker.js')}}"></script>
<script src="{{asset('js/picker.date.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>


<script>
    var current_page='1';
$('.pickadate').pickadate({format: 'yyyy-mm-dd'});

$('#expereincecollpase').on('click', function (e) {
    e.stopPropagation();
    if(this.id == 'expereincecollpase'){
        $('#expereincepanel').collapse('show');
    }
});
$('#freshercollpase').on('click',function(e){
    e.stopPropagation();
    if(this.id=='freshercollpase')
    {
        $('#expereincepanel').collapse('hide');
    }
});
$('#customdate').on('change',function(){
    if($(this).val()==0){
        $('#filterdate').collapse('show');
    }
    else{
        $('#filterdate').collapse('hide');
    }
});

function fetchstudent(page='',technology='',expereince='',state='',date='')
{
    $.ajax({
        url:"{{route('studentsearch')}}",
        method: 'post',
        data:{page:page,technology:technology,expereince:expereince,state:state,date:date},
        success:function(data)
        {
            $('#studentdata').html('');
            $('#studentdata').html(data);
        }
    });
}

    $('.tech,#expereincesearch,#filterstate,#customdate').on('change',function(){
        var technology=$('.tech').val();
        var expereince=$('#expereincesearch').val();
        var state=$('#filterstate').val();
        var date=$('#customdate').val();
        fetchstudent('',technology,expereince,state,date);
    });


    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        current_page=page;
        $('li').removeClass('active');
        $(this).parent().addClass('active');
        fetchstudent(page);
    });

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
           
               
                $('#deletemodal').modal('show');
           
        }
    });
         
        

        $('#multideletemodal').on('submit',function(e){
            e.preventDefault();
            
              var strIds=idsArr.join(','); 
             $.ajax({
                    url: "{{route('deletemultiplestudents')}}",
                    type: "DELETE",
                    data:'ids='+strIds,
                    success: function(data){
                        toastr.success(data.success, 'Success Message');
                        $('.checkbox:checked').each(function(){
                            $(this).parents("tr").remove();
                        });
                        $('#deletemodal').modal('hide');
                        fetchstudent(current_page);
                    }
                });
        });


fetchPolicy();
    // fetch Policy
    function fetchPolicy()
    {
        $.ajax({
        url:'{{route("ajaxfetch")}}',
        method:'GET',
        success:function(data){
            console.log(data);
            var status=$.isEmptyObject(data.success);
            if(status)
            {
            console.log("save");
            $('button').attr('id','save');
            }
            else
            {
            $('button').attr('id','update');
            $('#policytitle').val(data.success[0].title);
            $('#policydescription').val(data.success[0].description);
            $('#policyid').val(data.success[0].id);
            $('#showdocument').attr('href','{{asset("document")}}/'+data.success[0].document);
            $('#documentname').val(data.success[0].document);
            }
        },
        error:function(data){
            console.log(data);
        }
        });
    }

    $('#policyform').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "ajaxupdate",
            data: formData,
            cache:false,
            dataType:'JSON',
            contentType: false,
            processData: false,
            success: (data) => {
                fetchPolicy();
                toastr.success(data.success, 'Success Message');
                console.log(data);
            },
            error: function(data){
                console.log(data);
            }
        });
    });

</script>

@endsection

