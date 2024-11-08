@extends('layouts.app')

@push('custom_css')
    <style>
        .text-bold {
            font-weight: 800;
        }

        text-color {
            color: #0093c4;
        }

        /* Main image - left */
        .main-img img {
            width: 100%;
        }

        /* Preview images */
        .previews img {
            width: 100%;
            height: 140px;
        }

        .main-description .product-title {
            font-size: 2.5rem;
        }

        .new-price {
            font-size: 2rem;
        }

        .details-title {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 1.2rem;
            color: #757575;
        }

        .quantity input {
            border-radius: 0;
            height: 40px;

        }


        .custom-btn {
            text-transform: capitalize;
            background-color: #0093c4;
            color: white;
            width: 150px;
            height: 40px;
            border-radius: 0;
        }

        .custom-btn:hover {
            background-color: #0093c4 !important;
            font-size: 18px;
            color: white !important;
        }

        .similar-product img {
            height: 400px;
        }

        .similar-product {
            text-align: left;
        }

        .similar-product .title {
            margin: 17px 0px 4px 0px;
        }

        .similar-product .price {
            font-weight: bold;
        }


        /* Small devices (landscape phones, less than 768px) */
        @media (max-width: 767.98px) {

            /* Make preview images responsive  */
            .previews img {
                width: 100%;
                height: auto;
            }

        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Show Product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Show Product
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="main-img">
                                    <img class="img-fluid" src="{{ Storage::url($product->image) }}" alt="ProductS">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="main-description px-2">
                                    <div class="product-title text-bold my-3">
                                        {{ $product->name }}
                                    </div>

                                    <div class="price-area my-4">
                                        <p class="new-price text-bold mb-1">
                                            BDT {{ number_format($product->price, 2) }}
                                        </p>
                                    </div>


                                    <div class="buttons d-flex align-items-center gap-2 my-5">
                                        <div class="block">
                                            <a href="#" class="shadow btn custom-btn ">
                                                {{ $product->product_id }}
                                            </a>
                                        </div>

                                        <div class="align-middle quantity">
                                            Product Available: {{ $product->stock }}
                                        </div>
                                    </div>
                                </div>

                                <div class="product-details my-4">
                                    <p class="details-title text-color mb-1">Product Details</p>
                                    <p class="description">
                                        {!! $product->description !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
