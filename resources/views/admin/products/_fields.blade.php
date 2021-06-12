<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    {{ Form::label('name', 'Product Name') }}
    {{ Form::text('name',$product->name,['class'=>'form-control border-input','placeholder'=>'Macbook pro']) }}
    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    {{ Form::label('price', 'Price') }}
    {{ Form::number('price',$product->price,['class'=>'form-control border-input','placeholder'=>'$2500']) }}
    <span class="text-danger">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
    {{ Form::label('category', 'Category') }}

    @php
    if($product->category){
        $main = [$product->category];
    }else $main = [];
    
        foreach ($categories as $key=>$category){
            if($category->subcategory == "NULL"){
                $main['Main Categories'] = $category->where('subcategory', 'NULL')->pluck('name','name')->toArray();
            }else{
                $ctg = $category->subcategory;
                $results = DB::table('categories')->where('name', $ctg)->get();
                foreach($results as $result){
                    $main['Sub Categories'][$result->name] = $category->where('subcategory', $ctg)->pluck('name', 'name')->toArray();
                }
                
            }
        }
    @endphp
    {{ Form::select('category', $main, null, ['class'=>'form-control border-input']
        ) }}
    <span class="text-danger">{{ $errors->has('category') ? $errors->first('category') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    {{ Form::label('description', 'Description') }}
    {{ Form::textarea('description',$product->description,['class'=>'form-control border-input','placeholder'=>'Description']) }}
    <span class="text-danger">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    {{ Form::label('file','File') }}
    {{ Form::file('image', ['class'=>'form-control border-input', 'id' => 'image']) }}
    <div id="thumb-output"></div>
    <span class="text-danger">{{ $errors->has('image') ? $errors->first('description') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('text1') ? 'has-error' : '' }}">
    {{ Form::label('text1', 'Image text 1') }}
    {{ Form::text('text1',$product->text1,['class'=>'form-control border-input','placeholder'=>'Adidas Air Jordan']) }}
    <span class="text-danger">{{ $errors->has('text1') ? $errors->first('text1') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    {{ Form::label('text2', 'Image text 2') }}
    {{ Form::text('text2',$product->text2,['class'=>'form-control border-input','placeholder'=>'размер от 40  до 45']) }}
    <span class="text-danger">{{ $errors->has('text2') ? $errors->first('text2') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    {{ Form::label('text3', 'Image text 3') }}
    {{ Form::text('text3',$product->text3,['class'=>'form-control border-input','placeholder'=>'цена 345.000 сум']) }}
    <span class="text-danger">{{ $errors->has('text3') ? $errors->first('text3') : '' }}</span>
</div>