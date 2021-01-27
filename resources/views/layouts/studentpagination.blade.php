<div class="table-responsive" id="studentdata">
<table class="table" style="width:100%">
    <thead align="center">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:1%">Name</th>
            <th style="width:1%">Email</th>
            <th style="width:1%">Expereince</th>
            <th style="width:1%">Phone</th>
            <th style="width:1%">Date</th>
        </tr>
    </thead>
    <tbody align="center">
    @forelse ($students as $index=>$item)
    <tr>
        <td>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="" id="customCheck{{$index}}" class="custom-control-input checkbox" data-id="{{$item->id}}">
                <label class="custom-control-label" for="customCheck{{$index}}"></label>
            </div>
        </td>
        <td>{{$item->name}}</td>
        <td>{{$item->email}}</td>
        <td>@if($item->fresher==0) {{$item->expereince_year}} Year {{$item->expereince_month}} Month @else  Trainee  @endif </td>
        <td>{{$item->phone}}</td>
        <td>{{$item->created_at}}</td>
    </tr>
    @empty
    <tr>
        <td colspan="5"><h2 class="text-center">No data found</h2></td>
    </tr>
    @endforelse
    </tbody>

</table>

<div class="row justify-content-center align-items-center mx-2 ">
    <div>
        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($students)}} of {{count($students)}} entries</div>
    </div>
    <div class="ml-auto">
        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {!! $students->links() !!}
        </div>
    </div>
</div>
</div>


