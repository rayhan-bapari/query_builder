@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Products</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All Products
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search by Product ID or Description"
                                                value="{{ request('search') }}">
                                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Sorting
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('products.index', ['sort' => null, 'direction' => null]) }}">
                                                    Default
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('products.index', ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                    Sort by name
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('products.index', ['sort' => 'price', 'direction' => request('sort') === 'price' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                                    Sort by price
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add New Product
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Product ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Image</th>
                                        <th style="width: 250px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->product_id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->stock ?? 'N/A' }}</td>
                                            <td>
                                                @if ($product->image)
                                                    <img src="{{ Storage::url($product->image) }}"
                                                        alt="{{ $product->name }}" class="img-thumbnail"
                                                        style="max-width: 100px;">
                                                @else
                                                    <span class="badge bg-secondary">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('products.show', $product) }}"
                                                        class="btn btn-sm btn-info d-inline-flex align-items-center"
                                                        title="View">
                                                        <i class="bi bi-eye me-1"></i>
                                                        View
                                                    </a>
                                                    <a href="{{ route('products.edit', $product) }}"
                                                        class="btn btn-sm btn-warning d-inline-flex align-items-center"
                                                        title="Edit">
                                                        <i class="bi bi-pencil me-1"></i>
                                                        Edit
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('products.destroy', $product->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger d-inline-flex align-items-center"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                                            <i class="bi bi-trash me-1"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($products->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No products found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($products->hasPages())
                            <div class="card-footer">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
