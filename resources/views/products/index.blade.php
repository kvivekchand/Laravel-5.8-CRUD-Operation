@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            Products
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                        </div>
                    </div>  
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                   
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                
                                    @if ($product->photo)
                                        <td><img src="{{asset('/storage/products/' . $product->photo)}}" alt="" style="width: 86px;height: 50px;"></td>
                                    @else 
                                        <td><img src="{{asset('img/default.png')}}" alt="" style="width: 86px;height: 50px;"></td>
                                    @endif
                                <td>{{ $product->category->category_name }}</td>
                                <td>{{ $product->subcategory->sub_category_name }}</td>
                                <td>
                                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    
                                        <a class="btn btn-sm btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                        
                                        <a class="btn btn-sm btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    
                                        @csrf
                                        @method('DELETE')
                        
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                  
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
