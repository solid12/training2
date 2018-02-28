<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include ('header')

<div class="alert alert-success">

    {{ __('You deleted the product') }}

</div>

<meta http-equiv="refresh" content="3; url=/products" />

@include ('footer')
