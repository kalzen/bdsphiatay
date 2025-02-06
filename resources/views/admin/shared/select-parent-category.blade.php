    
    @foreach($categories as $category)
    <div class="form-check">
        <label class="form-check-label">
            @if(isset($selected) && $category->id == $selected)
            <input type="checkbox" checked name="parent_id" class="form-input-styled" value="{{$category->id}}" data-fouc>
            @else
            <input type="checkbox" name="parent_id" class="form-input-styled" value="{{$category->id}}" data-fouc>
            @endif
            {{$category->name}}
        </label>
    </div>
    @endforeach