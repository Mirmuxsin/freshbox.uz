<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    {{ Form::label('name', 'Category Name') }}
    {{ Form::text('name',$category->name,['class'=>'form-control border-input','placeholder'=>'Mobile phones']) }}
    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
    {{ Form::label('subcategory', 'Sub Category') }}

    @php
    if($category->subcategory){
        $main = [$category->subcategory];
    }else $main = ["NULL"];
    
        foreach ($categories as $category2){
            if($category2->subcategory == "NULL"){
                $main['Main Categories'] = $category2->where('subcategory', 'NULL')->pluck('name','name')->toArray();
            }else{
                $ctg = $category2->subcategory;
                $results = DB::table('categories')->where('name', $ctg)->get();
                foreach($results as $result){
                    $main['Sub Categories'][$result->name] = $category2->where('subcategory', $ctg)->pluck('name', 'name')->toArray();
                }
                
            }
        }
    @endphp
    {{ Form::select('subcategory', $main, null, ['class'=>'form-control border-input']
        ) }}
    <span class="text-danger">{{ $errors->has('category') ? $errors->first('category') : '' }}</span>
</div>