<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')

@if (!session('admin'))
    <div class="alert alert-danger">
        {{ __('You are not logged in !') }}
        {{ die() }}
    </div>

@endif;

@foreach($products as $product)

    <ul>
        <img src="{{ $images ? $images[0] : '' }}">
        <li>{{$product->title }}</li>
        <li>{{$product->description }}</li>
        <li>{{$product->price }}</li>
        <a href="/product?id={{$product->id}}">{{ __('Edit Product') }}</a><br/>
        <a href="/delete?id={{$product->id}}">{{ __('Delete Product') }}</a>
    </ul>
@endforeach

<a href="/product">{{__('Add Product')}}</a><br/>
<a href="/logout">{{__('Logout')}}</a>

@include ('footer')
