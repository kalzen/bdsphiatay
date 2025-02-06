
    @foreach($attributes->chunk(2) as $chunk)
    <div class="row">
        @foreach($chunk as $attribute)
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label class="form-check-label w-100">
                    {{$attribute->name}}
                    @if(isset($record)&&$record->attributes()->where('attribute_product.attribute_id',$attribute->id)->first())
                    <textarea name="attribute[{{$attribute->id}}][value]" class="form-control">{{$record->attributes()->where('attribute_product.attribute_id',$attribute->id)->first()->pivot->value??''}}</textarea>
                    @else
                    <textarea name="attribute[{{$attribute->id}}][value]" class="form-control"></textarea>
                    @endif
                </label>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach