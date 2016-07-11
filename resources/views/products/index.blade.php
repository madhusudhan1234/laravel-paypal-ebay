@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3">
                    <div class="box">
                        <img src="{{ url('assets/images/'.$product->image) }}" alt="{{ $product->image }}" class="img-responsive">
                        <div class="infos">
                            <h4>{{ $product->name }}</h4>
                            <p>{{ $product->description }}</p>
                            <p>
                                <b class="pull-left"> $ {{ $product->price }}</b>
                                <a href=" {{ route('product.details',$product->id) }}">
                                    <button class="btn btn-success pull-right" style="padding:2px 3px;">
                                        Store To Ebay
                                    </button>
                                </a>
                                <a href="{{ route('product.order',$product->id) }}">
                                    <button class="btn btn-primary pull-right" style="padding:2px 3px;">
                                        Buy This
                                    </button>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection