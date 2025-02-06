    
    @foreach($catalogues as $catalogue)
    <div class="form-check">
        <label class="form-check-label">
            @if(isset($selected) && $catalogue->id == $selected)
            <input type="checkbox" checked name="parent_id" class="form-input-styled" value="{{$catalogue->id}}" data-fouc>
            @else
            <input type="checkbox" name="parent_id" class="form-input-styled" value="{{$catalogue->id}}" data-fouc>
            @endif
            {{$catalogue->name}}
        </label>
    </div>
    @endforeach