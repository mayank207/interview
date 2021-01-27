<button type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true"><i class="bx bx-plus"></i></button>
<div class="dropdown-menu" x-placement="left-start" >
    <button class="dropdown-item" data-toggle="modal" data-target="#addjob"><i class="bx bx-briefcase-alt mr-50"></i>  Add Job</button>
    <button class="dropdown-item" data-toggle="modal" data-target="#studentmodal"><i class="bx bx-calendar mr-50"></i> Add Recruting</button>
    <button class="dropdown-item" data-toggle="modal" data-target="#addnote"><i class="bx bx-notepad mr-50"></i> Add Note</button>
</div>




 {{-- Policy modal start --}}
 {{-- <div class="modal fade text-left show" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-modal="true" > --}}
    {{-- <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Policy</h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div> --}}

    {{-- @if($count==1) --}}
            {{-- @foreach($policy as $poli) --}}
{{--
        <form action="{{route('update.policy',$policy->id)}}" method="post" id="policyform" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
               <div class="form-group">
                   <label for="policy title">Title</label>
                    <input type="text" name="title" value="{{$policy->title}}" class="form-control" id="title">
               </div>
               @error('title')
                <div class="error">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="policydescription">Policy Description</label>
                    <textarea name="policy_description" id="policydescription" cols="30" rows="10" class="form-control">{{$policy->description}}</textarea>
                </div>
                @error('policydescription')
                <div class="error">{{ $message }}</div>
                @enderror

                <div class="form-group">

                    <a target="blank" href="uploads/{{$policy->document}}" class="btn btn-primary form-control"> <i class="bx bx-file font-medium-5">     Document</i></a>
                </div>
                <div class="custom-file">
            <input type="file" name="document" class="form-control">

           </div>

       <br>
                <div align="center">
                    <br>
                <input type="submit" class="btn btn-primary ml-1"  value="Update">
                  </div>
                </form>
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"></span>

                </button>
            </div>
        </form> --}}
{{--
    @else
        <form action="{{route('save.policy')}}" method="post" id="policyform" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
               <div class="form-group">
                   <label for="policy title">Title</label>
                    <input type="text" name="title" value=""class="form-control" id="title"></div>
                    @error('title')
                <div class="error">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="policydescription">Policy Description</label>
                    <textarea name="policy_description" id="policydescription" cols="30" rows="10" class="form-control"></textarea>
                </div>
                 @error('policy_description')
                <div class="error">{{ $message }}</div>
                @enderror

                <div class="custom-file"><input type="file" name="document" class="form-control"></div>
                @error('document')
                <div class="error">{{ $message }}</div>
                @enderror

       <br>
                    <div align="center">
                <input type="submit" class="btn btn-primary ml-1"  value="Save">
                    </div>
                </form>
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"></span>

                </button>
            </div>
        </form> --}}

    {{-- @endif --}}

        {{-- </div> --}}
