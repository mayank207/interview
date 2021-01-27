@extends('layouts.app')
@section('title','Recruting Student')
@section('css')
    <link rel="stylesheet" href="{{asset('css/app-kanban.css')}}">
    <link rel="stylesheet" href="{{asset('css/jkanban.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <style type="text/css">
    input[type=number] {
    -moz-appearance: textfield;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
    </style>
@endsection
@section('content')

<div class="bg-white shadow-lg col-md-12" style="padding:10px"> 
<div id="show"></div>
<div id="contain"></div>
<div class="kanban-sidebar">
    <div class="card shadow-none quill-wrapper">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom px-2 py-1">
            <h3 class="card-title">Candidate Edit</h3>
            <button type="button" class="close close-icon">
                <i class="bx bx-x"></i>
            </button>
        </div>
        <!-- form start -->
        <form class="edit-kanban-item" id="edit-rectutingform" method="put" enctype="multipart/form-data">
            <div class="card-content">
                <div class="card-body">
                    <div class="container">
                        <div id="joberrors" class="text-center"></div>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="editname" class="form-control edit-kanban-item-title" placeholder="Name" id="editname">
                        <span class="text-danger error" data-error="editname"></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="editemail" placeholder="Email" class="form-control" disabled="">
                        <span class="text-danger error" data-error="editemail"></span>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="number" id="editphone" name="editphone" placeholder="Phone" class="form-control">
                        <span class="text-danger error" data-error="editphone"></span>
                    </div>
                    <div class="form-group">
                        <label>Created Date</label>
                        <input type="text" class="form-control edit-kanban-item-date" id="editdate" placeholder="21 August, 2019" disabled>

                    </div>
                        <div class="form-group">
                            <label>Document</label>
                            <div class="d-flex align-items-center">
                                <div class="m-0 mr-1" >
                                    <a href="#" target="_blank" id="attachment-link" class="btn btn-info text-white"><i class="bx bxs-folder-open"></i>   Show Document</a>
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <label>Technology</label>
                        <select class="select2 form-control" name="edittechnology[]" id="edittechnology" multiple>
                        </select>
                        <span class="text-danger error" data-error="edittechnology"></span>
                    </div>
                    <div class="form-group">
                        <label>Attachment</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="attachment" id="studentattachment">

                            <label class="custom-file-label" for="studentattachment">Attach Document</label>
                        </div>
                        <span class="text-danger error" data-error="attachment"></span>
                    </div>
                    <input type="hidden" name="studentid" id="studentid" value="">
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                @can('create-hr')
                <button type="button" class="btn btn-light-danger delete-kanban-item d-flex align-items-center mr-1" id="deletestudent" data-id="1">
                    <i class='bx bx-trash mr-50'></i>
                    <span>Delete</span>
                </button>
                 @endcan
                <button class="btn btn-primary glow update-kanban-item d-flex align-items-center" type="submit">
                    <i class='bx bx-send mr-50'></i>
                    <span>Save</span>
                </button>

            </div>

 


        </form>
        <!-- form start end-->
    </div>
</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>


<div class="modal fade text-left" id="std" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                        Are You Sure You Want To Delete It ?
                    </p>
                </div>
                <div class="modal-footer">
                    <form action="" method="post" id="deletemodal">
                        <input type="hidden" name="deletestudentid" id="deletestudentid">
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
<script src="{{asset('js/jkanban.min.js')}}"></script>
<script src="{{asset('js/select2.full.min.js')}}"></script>
<script src="{{asset('js/form-select2.min.js')}}"></script>

<script>
$(document).ready(function(){


    setTimeout(() => { $('.toast').hide(); }, 2000);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    fetchrecrut();

// Fetch all Recruitment Pipeline

    function fetchrecrut()
    {
        $('#contain').html('');

        $.ajax({
            url:"{{route('recrut.index')}}",
            method:"get",
            success:function(data){

                var allStudent=[],new_applicant=[],hr_round=[],technical=[],practical=[],offered=[],rejected=[],hold=[];
                var kanban_curr_el;
                $.each(data.success,function(key,value){
                var tech='';
                    $.each(value.get_technology,function(key,value){
                        tech+="<div class='badge' style='margin:2px;'>"+value.tech+"</div>";
                    });
                    if(value.state_id==1){
                        new_applicant.push({id:value.id,title:value.name,border:'primary',dueDate:tech });
                    }
                    if(value.state_id==2){
                        hr_round.push({id:value.id,title:value.name,border:'primary',dueDate:tech});
                    }
                    if(value.state_id==3){
                        technical.push({id:value.id,title:value.name,border:'primary',dueDate:tech});
                    }
                    if(value.state_id==4){
                        practical.push({id:value.id,title:value.name,border:'primary',dueDate:tech});
                    }
                    if(value.state_id==5){
                        offered.push({id:value.id,title:value.name,border:'primary',dueDate:tech});
                    }
                    if(value.state_id==6){
                        rejected.push({id:value.id,title:value.name,border:'primary',dueDate:tech});
                    }
                    if(value.state_id==7){
                        hold.push({id:value.id,title:value.name,border:'primary',dueDate:tech});
                    }
                });
                allStudent.push({id:"kanban-board-1",title:"New Applicant",item:new_applicant});
                allStudent.push({id:"kanban-board-2",title:"HR Round",item:hr_round});
                allStudent.push({id:"kanban-board-3",title:"Technical",item:technical});
                allStudent.push({id:"kanban-board-4",title:"Practical",item:practical});
                allStudent.push({id:"kanban-board-5",title:"Offered",item:offered});
                allStudent.push({id:"kanban-board-6",title:"Rejected",item:rejected});
                allStudent.push({id:"kanban-board-7",title:"Hold",item:hold});

                var kanban=new jKanban({
                    element:'#contain',
                    dropEl: function (el, target, source, sibling) {
                        var state_id=$(target).parent().attr('data-order');
                        var item_id=$(el).attr('data-eid');
                        updatestate(item_id,state_id);
                    },
                boards :allStudent,
                dragBoards : false,
                click: function(el) {
                    $(".kanban-overlay").addClass("show");
                    $(".kanban-sidebar").addClass("show");
                    $('#edittechnology').html('');

                    kanban_curr_el = el;
                    kanban_item_title = $(el).contents()[0].data;
                    kanban_curr_item_id = $(el).attr("data-eid");
                    $.ajax({
                        url:"recrut/"+kanban_curr_item_id,
                        method:"get",
                        success:function(data){
                            $('#editname').val(data.success.name);
                            $('#editemail').val(data.success.email);
                            $('#editphone').val(data.success.phone);
                             $('#editdate').val(data.success.created_at);
                            $('#editattachment').attr('src',"{{asset('attachment')}}/"+data.success.attachment);
                            $('#attachment-link').attr('href',"{{asset('attachment')}}/"+data.success.attachment);
                            $('#deletestudent').attr('data-id',data.success.id);
                            $('#studentid').val(data.success.id);
                            var tech='';
                             var alltech=data.success.get_technology;
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
                            $('#edittechnology').append(tech);
                        }
                    });
                }
            });

            // $('[data-id=kanban-board-1]').before("<h3>New Applicant</h3>");
            // $('[data-id=kanban-board-2]').before("<h3>HR Round</h3>");
            // $('[data-id=kanban-board-3]').before("<h3>Technical</h3>");
            // $('[data-id=kanban-board-4]').before("<h3>Practical</h3>");
            // $('[data-id=kanban-board-5]').before("<h3>New Applicant</h3>");
            // $('[data-id=kanban-board-6]').before("<h3>New Applicant</h3>");
            // $('[data-id=kanban-board-7]').before("<h3>Hold</h3>");

            // console.log(setTitle);
            var board_item_id, board_item_el;
            for (kanban_data in allStudent)
            {
                for (kanban_item in allStudent[kanban_data].item)
                {
                var board_item_details = allStudent[kanban_data].item[kanban_item];
                board_item_id = $(board_item_details).attr("id");
                (board_item_el = kanban.findElement(board_item_id)),
                    board_item_dueDate =" ";
                    if (typeof $(board_item_el).attr("data-dueDate") !== "undefined") {
                        board_item_dueDate =
                        '<div class="kanban-due-date d-flex flex-wrap ">' +
                        $(board_item_el).attr("data-dueDate") + '</div>';
                    }
                    if (typeof($(board_item_el).attr("data-dueDate")) !== "undefined")
                    {
                        $(board_item_el).append(
                        '<div class="kanban-footer d-flex justify-content-between mt-1">' +
                            '<div class="kanban-footer-left d-flex">' +
                            board_item_dueDate +
                            "</div>" +
                            '<div class="kanban-footer-right">' +
                            '<div class="kanban-users"><ul class="list-unstyled users-list m-0 d-flex align-items-center"></ul></div></div></div>');
                    }
                }
            }

            }
        });
    }


  $(".kanban-title-board").on("mouseenter", function() {
    $(this).attr("contenteditable", "false");
  });
  $(".kanban-sidebar .close-icon,.kanban-overlay"
  ).on("click", function() {
    $(".kanban-overlay").removeClass("show");
    $(".kanban-sidebar").removeClass("show");
  });
   if ($(".kanban-sidebar .edit-kanban-item .card-content").length > 0) {
    new PerfectScrollbar(".card-content", { wheelPropagation: false });
  }

    // Update State
    function updatestate(idString,state){


        $.ajax({
            url:"{{route('recrut.updatestate')}}",
            method:'POST',
            data:{ids:idString,state:state},
            success:function(){
            $('#show').html('');
                // $('#show').prepend('<div class="alert alert-primary">Menu Saved Successfully..!<div>')
                setTimeout(function(){
                    $('#show').html('');
                },3000);
            },
            error:function(data){
                console.log(data)
            }
        });
         $('#joberrors').html('');
    }

    // Open Sidebar and Set value
    $('#edit-rectutingform').submit(function(e){
        e.preventDefault();
        $("#show").html('');
                $('#joberrors').html('');

        var deleteid=$('#deletestudent').attr('data-id');
        $.ajax({
            url:"{{route('updatestudent')}}",
            method:'post',
            dataType:'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data:new FormData(this),
            success:function(data){
                 $.each(data.errors, function(key, value){
                    $('#joberrors').show();
                    $('#joberrors').append('<div class="bg-danger text-white py-1 mb-1">'+value+'</div>');
                    });
                if(data.success){
                    $('#show').append();

                    toastr.success(data.success, 'Success Message');

                    fetchrecrut();
                    $(".kanban-overlay").removeClass("show");
                    $(".kanban-sidebar").removeClass("show");
                    setTimeout(() => { $('.toast').hide(); }, 2000);

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




    // Delete Student
    $(document).on('click','#deletestudent',function(){
        var mydeleteid=$(this).attr('data-id');
            
            $('#std').modal('show');
            $('#deletestudentid').val(mydeleteid);


            

        });            

        $('#deletemodal').on('submit',function(e){
        e.preventDefault();
        var deleteid=$('#deletestudentid').val();
        
        // alert(deleteid);
            $.ajax({
                url:'recrut/'+deleteid,
                method:'delete',
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#show').append();
                        toastr.success(data.success, 'Success Message');
                        $('#std').modal('hide');
                        fetchrecrut();

                    }
                    if(data.danger)
                    {
                        $('#show').append();
                            toastr.success(data.danger, 'Wanning !!!');
                            $('#std').modal('hide');

                    }
                    $(".kanban-overlay").removeClass("show");
                    $(".kanban-sidebar").removeClass("show");

                }
            });
        
  
    });

    });
</script>
@endsection

