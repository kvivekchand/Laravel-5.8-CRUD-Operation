@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">Product Details</div>
                        <div class="col-lg-4">
                            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $product->name }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Description:</strong>
                                {{ $product->description }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Category:</strong>
                                {{ $category->category_name }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Sub Category:</strong>
                                {{ $subCategory->sub_category_name }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Photo:</strong>
                                @if ($product->photo)
                                    <img src="{{asset('/storage/products/' . $product->photo)}}" alt="" style="width: 178px;height: 113px;">
                                @else 
                                    <img src="{{asset('img/default.png')}}" alt="" style="width: 178px;height: 113px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
