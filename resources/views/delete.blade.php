<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')

@if (!session('admin'))
    <div class="alert alert-danger">
        {{ __('You are not logged in !') }}

    </div>

@endif;

<div class="alert alert-success">

    {{ __('You deleted the product') }}

</div>

<meta http-equiv="refresh" content="3; url=/products" />

@include ('footer')
