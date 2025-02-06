
    @foreach($categories as $category)
    <div class="form-check">
        <label class="form-check-label">
            @if(isset($selected) && in_array($category->id, $selected))
            <input type="checkbox" checked name="category_id[]" class="form-input-styled" value="{{$category->id}}" data-fouc>
            @else
            <input type="checkbox" name="category_id[]" class="form-input-styled" value="{{$category->id}}" data-fouc>
            @endif
            {{$category->name}}
        </label>
        @if($category->children()->count())
        <ul class="list list-unstyled mt-2">
            @foreach($category->children as $child)
            <li>
                <div class="form-check">
                    <label class="form-check-label">
                        @if (isset($selected) && in_array($child->id, $selected))
                        <input type="checkbox" checked name="category_id[]" class="form-input-styled" value="{{$child->id}}" data-fouc>
                        @else
                        <input type="checkbox" name="category_id[]" class="form-input-styled" value="{{$child->id}}" data-fouc>
                        @endif
                        {{$child->name}}
                    </label>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
    @endforeach