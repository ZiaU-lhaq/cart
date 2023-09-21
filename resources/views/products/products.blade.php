@extends('layout')

@section('content')
<?php $cart = session()->get('cart', []);?>

<div class="row">
    @foreach($products as $product)
        <div class="col-xs-18 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="{{ $product->image }}" alt="">
                <div class="caption">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->description }}</p>
                    <p><strong>Price: </strong> {{ $product->price }}$</p>
                    <p><strong>quantity: </strong> {{ $product->quantity }}</p>
                    @if ($product->quantity < 1 || ( isset($cart[$product->id])&&$cart[$product->id]['quantity'] >= $product->quantity))
                        <p class="btn-holder"><a class="btn btn-danger btn-block text-center" role="button">Out of stock</a> </p>
                    @else
                        <p class="btn-holder"><a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
