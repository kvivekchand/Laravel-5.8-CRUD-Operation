@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">Add New Product</div>
                        <div class="col-lg-4">
                            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <input type="hidden" name="user_id" value="{{Auth::id()}}"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    <input type="text" name="description" class="form-control" placeholder="Description">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Category:</strong>
                                    <select class="form-control" name="category_id">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Sub Category:</strong>
                                    <select class="form-control" name="sub_category_id">
                                        <option value="">Select</option>                                       
                                    </select>
                                    @error('sub_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Image/Photo:</strong>
                                    <input type="file" name="photo" class="form-control">
                                    @error('photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button style=" margin-top: 18px;margin-left: 118px;"type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                                               
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('select[name=category_id]').change(function(){

            $.ajax({
                type: "get",
                url: "{{ route('products.create') }}",
                data: {category_id : $(this).val()},
                success: function(data) {
                   $('select[name=sub_category_id]').html('');
                    $.each(JSON.parse(JSON.stringify(data)), function( key, value ) {
                        $('select[name=sub_category_id]').append(new Option(value['sub_category_name'], value['id']));
                    });                
                }
            });

            });
    });
</script>
@endsection
