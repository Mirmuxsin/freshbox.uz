@extends('admin.layouts.master')

@section('page')
    View Categories
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            @include('admin.layouts.message')

            <div class="card">
                <div class="header">
                    <h4 class="title">Categories</h4>
                    <p class="category">List of all categories</p>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Sub - Category</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->subcategory }}</td>
                                <td>

                                    {{ Form::open(['route' => ['categories.destroy', $category->id], 'method'=>'DELETE']) }}
                                        {{ Form::button('<span class="fa fa-trash"></span>', ['type'=>'submit','class'=>'btn btn-danger btn-sm ti-trash','onclick'=>'return confirm("Are you sure you want to delete this?")'])  }}
                                        {{ link_to_route('categories.edit','', $category->id, ['class' => 'btn btn-info btn-sm ti-pencil']) }}
                                        {{ link_to_route('categories.show','', $category->id, ['class' => 'btn btn-primary btn-sm ti-list']) }}
                                    {{ Form::close() }}

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


    </div>


@endsection