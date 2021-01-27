 <div class="bg-white shadow-lg col-md-12" style="padding:10px"> 
<div class="table-responsive" id="jobdata">
    <table class="table" style="width:100%">
        <thead align="center">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Technology</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody align="center">
            @forelse ($jobs as $index=>$job)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="" id="customCheck{{$index}}" class="custom-control-input checkbox" data-id="{{$job->id}}">
                        <label class="custom-control-label" for="customCheck{{$index}}"></label>
                    </div>
                </td>
                <td>{{$job->title}}</td>
                <td>{{$job->description}}</td>
                <td>
                    @forelse ($job->getTechnology as $tech)
                    <div class="badge badge-pill badge-primary mr-1 mb-1">{{$tech->tech}}</div>
                    @empty
                        No Found
                    @endforelse
                </td>
                <td>{{$job->created_at}}</td>
                <td>
                    <div class="d-flex justify-content-center">
                        <button type="button" data-id="{{$job->id}}" class="btn btn-primary mr-2 editjob" ><i class="bx bx-edit-alt"></i></button>
                        <button type="button" class="btn btn-danger" id="deletejob"   data-id="{{$job->id}}"><i class="bx bx-trash" ></i></button>

                    </div>





                </td>
            </tr>
            @empty
            <tr>
                <h3>No Found</h3>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="row justify-content-center align-items-center mx-2 ">
        <div>
            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($jobs)}} of {{count($jobs)}} entries</div>
        </div>
        <div class="ml-auto">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {!! $jobs->links() !!}
            </div>
        </div>
    </div>
</div>

</div>

