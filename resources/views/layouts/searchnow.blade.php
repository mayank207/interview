<div class="row">
    @foreach ($items as $index=>$item)
      <div class="col-md-6">
        <div class="form-group">
            @php
              $stringFormat = strtolower(str_replace(' ', '', $item));
            @endphp
            <label for="input<?=$stringFormat?>" class="control-label">{{$item}}</label>
            <input value="{{isset($oldVals) ? $oldVals[$index] : ''}}" type="text" class="form-control" name="<?=$stringFormat?>" id="input<?=$stringFormat?>" placeholder="{{$item}}">
        </div>
      </div>
    @endforeach
  </div>
