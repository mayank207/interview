<div class="table-responsive" id="hrdata">
    <table class="table" style="width:100%">
        <thead align="center">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody align="center">
            @foreach ($hrs as $index=>$hr)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="" id="customCheck{{$index}}" class="custom-control-input checkbox" data-id="{{$hr->id}}">
                        <label class="custom-control-label" for="customCheck{{$index}}"></label>
                    </div>
                </td>
                <td>{{$hr->name}}</td>
                <td>{{$hr->email}}</td>
                <td>
                    <div class="d-flex justify-content-center">
                        <button type="button" data-id="{{$hr->id}}" class="btn btn-primary mr-2 edithr" ><i class="bx bx-edit-alt"></i></button>
                        <button type="button" class="btn btn-danger deletehr" data-id="{{$hr->id}}" data-toggle="modal" data-target="#deletehrmodal"><i class="bx bx-trash" ></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

 



    <div class="row justify-content-center align-items-center mx-2 ">
        <div>
            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($hrs)}} of {{count($hrs)}} entries</div>
        </div>
        <div class="ml-auto">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {!! $hrs->links() !!}
            </div>
        </div>
    </div>
</div>
