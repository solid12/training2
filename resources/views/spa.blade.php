<html>
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


    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
        $(document).ready(function () {

            /**
             * A function that takes a products array and renders it's html
             *
             * The products array must be in the form of
             * [{
            *     "title": "Product 1 title",
            *     "description": "Product 1 desc",
            *     "price": 1
            * },{
            *     "title": "Product 2 title",
            *     "description": "Product 2 desc",
            *     "price": 2
            * }]
             */
            function renderList(products) {
                html = '';

                $.each(products, function (key, product) {
                    html += [
                        '<ul>',
                            '<img src="' + product.image + '">',
                            '<li>' + product.title + '</li>',
                            '<li>' + product.description + '</li>',
                            '<li>' + product.price + '</li>',
                            '<a href="/index?id=' + product.id + '">{{ __('Add to Cart') }}</a>',
                        '</ul>'
                    ].join('');
                });

                return html;
            }

            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();

                switch(window.location.hash) {
                    case '#cart':
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/cart', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderList(response));
                            }
                        });
                        break;
                    case '#login':
                        // Show the cart page
                        $('.login').show();
                        break;
                    default:
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response));
                            }
                        });
                        break;
                }
            }

            $('.login [type=submit]').click(function () {
                $.ajax('/token', {
                    success: function (response) {
                        $.ajax('/login', {
                            method: 'POST',
                            data: {
                                _token: response,
                                submit: 1,
                                user: $('.login [name=user]').val(),
                                password: $('.login [name=password]').val()
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    window.location.hash = '#products';
                                } else {
                                    alert(response.message);
                                }
                            }
                        });
                    }
                });
            });

            $('form').submit(function (e) {
                e.preventDefault();
            });

            window.onhashchange();
        });
    </script>
</head>
<body>
<!-- The index page -->
<div class="page index">
    <!-- The index element where the products list is rendered -->
    <div class="list"></div>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart">Go to cart</a>
</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <div class="list"></div>

    <!-- A link to go to the index by changing the hash -->
    <a href="#">Go to index</a>
</div>

<!-- The login page -->
<div class="page login">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{__('Login')}}</div>

                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="user" class="col-md-4 control-label">{{__('Username')}}</label>

                                <div class="col-md-12">
                                    <input id="user" type="text" class="form-control" name="user" placeholder="{{__('User')}}" value="" required autofocus>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">{{__('Password')}}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" placeholder="{{__('Password')}}" name="password" required>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <input type="submit" name="submit" value="{{__('Submit')}}">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>