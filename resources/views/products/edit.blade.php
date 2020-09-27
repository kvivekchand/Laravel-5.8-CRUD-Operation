@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">Edit Product</div>
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
                  
                    <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="user_id" value="{{Auth::id()}}"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                <input type="text" name="name" class="form-control" value="{{$product->name}}" placeholder="Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    <input type="text" name="description" class="form-control" value="{{$product->description}}" placeholder="Description">
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
                                            @if ($category->id == $product->category_id)
                                                <option value="{{$category->id}}" selected>{{$category->category_name}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endif
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
                                        @foreach ($subcategories as $subcategory)
                                            @if ($subcategory->id == $product->sub_category_id)
                                                <option value="{{$subcategory->id}}" selected>{{$subcategory->sub_category_name}}</option>
                                            @else
                                                <option value="{{$subcategory->id}}">{{$subcategory->sub_category_name}}</option>
                                            @endif
                                        @endforeach                                      
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
                                    @if ($product->photo)
                                        <img src="{{asset('/storage/products/' . $product->photo)}}" alt="" style="width: 165px;height: 130px;">
                                    @else 
                                        <img src="{{asset('img/default.png')}}" alt="" style="width: 165px;height: 130px;">
                                    @endif
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
