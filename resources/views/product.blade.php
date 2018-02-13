<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Product Page') }}</title>

    <!-- Fonts -->

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->

</head>
<body>

@if (!session('admin'))
    <div class="alert alert-danger">
        {{ __('You are not logged in !') }}
        {{ die() }}
    </div>

@endif;

@if($msg):
<b style="color: white">{{$msg}}</b>
@endif

<div id="login">
    <form method="post" name="login" action="" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label>{{__('Title Product')}}</label><br/>
        <input type="text" name="title" placeholder="{{__('Title Product')}}" value="<?= $title ?>"
               autocomplete="off"/><br/>
        <label>{{__('Description Product')}}</label><br/>
        <input type="text" name="description" placeholder="{{__('Description Product')}}" value="<?= $description ?>"
               autocomplete="off"/><br/>
        <label>{{__('Price Product')}}</label><br/>
        <input type="number" name="price" placeholder="{{__('Price Product')}}" value="<?= $price ?>"
               autocomplete="off"/><br/>
        <label>{{__('Upload')}}</label><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/>
        <input type="submit" class="button" name="submit" value="{{__('Submit')}}">
    </form>
</div>


</body>
</html>