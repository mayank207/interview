<div class="table-responsive" id="notedata">
    <table class="table zero-configuration">
    <thead align="center">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Favourite</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody align="center">
        @foreach ($notes as $index=>$note)
        <tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="" id="customCheck{{$index}}" class="custom-control-input checkbox" data-id="{{$note->id}}">
                    <label class="custom-control-label" for="customCheck{{$index}}"></label>
                </div>
            </td>
            <td>{{$note->title}}</td>
            <td>{{$note->description}}</td>
            <td>
                <div class="checkbox">
                <input type="checkbox" class="checkbox-input" data-id="{{$note->id}}" id="checkbox{{$index}}" @if($note->favourite)checked @endif>
                    <label for="checkbox{{$index}}"></label>
                </div>
            </td>
            <td>{{$note->created_at}}</td>
            <td>

                <div class="d-flex justify-content-center">
                    <button type="button" data-id="{{$note->id}}" class="btn btn-primary mr-2 editnote" ><i class="bx bx-edit-alt"></i></button>
                    <button type="button" class="btn btn-danger" id="deletenote" data-id="{{$note->id}}"><i class="bx bx-trash" ></i></button>
                </div>


            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="row justify-content-between mx-2">
    <div>
      <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($notes)}} of {{count($notes)}} entries</div>
    </div>
    <div>
      <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        {!! $notes->links() !!}
      </div>
    </div>
  </div>
</div>