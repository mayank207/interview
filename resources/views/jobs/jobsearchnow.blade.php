<div class="row">

      <div class="col-md-6">
        <div class="form-group">
            @php
              $stringFormat =  strtolower(str_replace(' ', '', $items[0]));
            @endphp
            <label for="input<?=$stringFormat?>" class="control-label">{{$items[0]}}</label>
            <div>
              <input type="text" class="form-control" name="<?=$stringFormat?>" id="input<?=$stringFormat?>" placeholder="{{$items[0]}}" value="{{isset($oldVals[0]) ? $oldVals[0] : ''}}">
            </div>
        </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            @php
                $technologyFormat =  strtolower(str_replace(' ', '', $items[1]));
            @endphp
            <label for="input<?=$stringFormat?>" class="control-label">{{$items[1]}}</label>
            <div>
                <select name="<?=$technologyFormat?>[]" data-placeholder="Select Technology" id="" class="select2 form-control" multiple>
                    @foreach ($technology as $item)
                        <option value="{{$item->id}}" {{isset($oldVals[1]) ?  (collect($oldVals[1])->contains($item['id']))  ? 'selected' : '' : ''}}>{{$item->tech}}</option>
                    @endforeach
                </select>
            </div>
          </div>
      </div>

  </div>
