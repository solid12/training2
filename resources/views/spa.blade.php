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
                        '<button class="add" id="' + product.id + '" >{{ __('Add to Cart') }}</button>',
                        '</ul>'
                    ].join('');
                });

                return html;
            }

            function renderListproducts(products) {
                html = '';

                $.each(products, function (key, product) {
                    html += [
                        '<ul>',
                        '<img src="' + product.image + '">',
                        '<li>' + product.title + '</li>',
                        '<li>' + product.description + '</li>',
                        '<li>' + product.price + '</li>',
                        '<a href="#edit"><button class="editbutton" id="' + product.id + '" >{{ __('Edit Product') }}</button></a> | <button class="delete" id="' + product.id + '" >{{ __('Delete Product') }}</button>',
                        '</ul>'
                    ].join('');
                });

                return html;
            }

            function renderListcart(products) {
                html = '';

                $.each(products, function (key, product) {
                    html += [
                        '<ul>',
                        '<img src="' + product.image + '">',
                        '<li>' + product.title + '</li>',
                        '<li>' + product.description + '</li>',
                        '<li>' + product.price + '</li>',
                        '<button class="remove" id="' + product.id + '" >{{ __('Remove Product') }}</button>',
                        '</ul>'
                    ].join('');
                });

                return html;
            }

            function logat1() {
                logat = 0;
                $.get('/check', function (data) {
                    if (data == 0) {
                        var logat = 0;
                    } else if (data == 1) {
                        var logat = 1;
                    }
                });
                return logat;
            }

            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();

                switch (window.location.hash) {
                    case '#cart':
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/cart', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderListcart(response));
                                $(".remove").click(function (e) {
                                    e.preventDefault();
                                    var id = $(this).attr("id");
                                    $.ajax({
                                        type: "GET",
                                        url: "/cart",
                                        data: 'id=' + id,
                                        cache: false,
                                        success: function (data) {
                                            window.onhashchange();
                                        }
                                    });
                                    return false;
                                });

                            }
                        });
                        break;

                    case '#edit':
                        // Show the cart page
                        $('.edit').show();

                        break;

                    case '#add':
                        // Show the cart page
                        $('.add').show();

                        break;

                    case '#products':
                        // Show the cart page
                        var logat = logat1();
                        console.log(logat);
                        $('.products').show();
                        // Load the cart products from the server
                        $.ajax('/products', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.products .list').html(renderListproducts(response));
                                $(".delete").click(function (e) {
                                    e.preventDefault();
                                    var id = $(this).attr("id");
                                    $.ajax({
                                        type: "GET",
                                        url: "/delete?id=" + id,
                                        cache: false,
                                        success: function (data) {
                                            window.onhashchange();
                                        }
                                    });
                                    return false;
                                });

                            }
                        });

                        $(document).on("click", ".editbutton", function (e) {
                            e.preventDefault();
                            var id = $(this).attr("id");
                            $.ajax( {
                                type: "GET",
                                url: "/product",
                                data: "id="+ id,
                                success: function (data) {
                                    window.location.hash = '#edit';
                                    var title = data.title;
                                    var description = data.description;
                                    var price = data.price;
                                    $('#title').val(title);
                                    $('#description').val(description);
                                    $('#price').val(price);
                                    $('.product').show();
                                }

                            });

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
                                $(".add").click(function (e) {
                                    e.preventDefault();
                                    var id = $(this).attr("id");
                                    $.ajax({
                                        type: "GET",
                                        url: "/index?id=" + id,
                                        data: 'id=' + id,
                                        cache: false,
                                        success: function (data) {
                                            window.onhashchange();
                                        }
                                    });
                                    return false;
                                });

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

                    $('.edit [type=submit]').click(function () {
                        $.ajax('/token', {
                            success: function (response) {
                                var idedit = $('.editbutton').attr("id");
                                $.ajax( {
                                    method: 'POST',
                                    url: '/product?id='+idedit,
                                    data: {
                                        _token: response,
                                        submit: 1,
                                        title: $('.edit [name=title]').val(),
                                        description: $('.edit [name=description]').val(),
                                        price: $('.edit [name=price]').val()
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.success) {
                                            window.location.hash = '#products';
                                        }
                                    }
                                });
                            }
                        });
                    });

                $('.cart [type=submit]').click(function () {
                    $.ajax('/token', {
                        success: function (response) {
                            $.ajax('/cart', {
                                method: 'POST',
                                data: {
                                    _token: response,
                                    send: 1,
                                    name: $('.cart [name=name]').val(),
                                    contact: $('.cart [name=contact]').val(),
                                    comment: $('.cart [name=comment]').val()
                                },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.success) {
                                        window.location.hash = '#';
                                    } else {
                                        alert(response.message);
                                    }
                                }
                            });
                        }
                    });
                });


                $(".logout").click(function (e) {
                    e.preventDefault();
                    $.ajax( {
                        type: "GET",
                        url: "/logout",
                        success: function (data) {
                            window.location.hash = '#login';
                        }
                    });
                    return false;
                });


                $('form').submit(function (e) {
                    e.preventDefault();
                });

                window.onhashchange();
            }
            );
    </script>
</head>
<body>
<!-- The index page -->
<div class="page index">
    <!-- The index element where the products list is rendered -->
    <div class="list"></div>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart">{{__('Go to cart')}}</a>
</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <div class="list"></div>
    <br/>

    <form enctype="multipart/form-data" style="padding: 120px 30px" name="cart">
        <input type="name" name="name" placeholder="{{ __("Name") }}" autocomplete="off" required="required"/>
        <input type="email" name="contact" placeholder="{{ __("Contact Details") }}" autocomplete="off"
               required="required"/>
        <textarea rows="4" cols="30" name="comment" placeholder="{{ __("Comments") }}"></textarea>
        <input type="submit" name="send" class="btn btn-success pull-right" value="{{ __("Checkout") }}"> </input>
    </form>
    <!-- A link to go to the index by changing the hash -->
    <a href="#">Go to index</a>
</div>

<div class="page products">
    <!-- The cart element where the products list is rendered -->
    <div class="list"></div>
    <br/>
    <a href="#add"><button class="add">{{__('Add Product')}}</button></a><br/>
    <button class="logout">{{__('Logout')}}</button>
</div>

<div class="page edit">
    <!-- The cart element where the products list is rendered -->
    <div class="product">
        <form enctype="multipart/form-data">
            {{ csrf_field() }}
            <label>{{__('Title Product')}}</label><br/>
            <input type="text" id="title" name="title" placeholder="{{__('Title Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Description Product')}}</label><br/>
            <input type="text" id="description" name="description" placeholder="{{__('Description Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Price Product')}}</label><br/>
            <input type="number" id="price" name="price" placeholder="{{__('Price Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Upload')}}</label><br/>
            <input type="file" name="fileToUpload" id="fileToUpload"><br/>
            <input type="submit" class="button" name="submit" value="{{__('Submit')}}">
        </form>

    </div>
    <br/>

</div>


<div class="page add">
    <!-- The cart element where the products list is rendered -->
    <div class="product">
        <form enctype="multipart/form-data">
            {{ csrf_field() }}
            <label>{{__('Title Product')}}</label><br/>
            <input type="text" id="title" name="title" placeholder="{{__('Title Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Description Product')}}</label><br/>
            <input type="text" id="description" name="description" placeholder="{{__('Description Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Price Product')}}</label><br/>
            <input type="number" id="price" name="price" placeholder="{{__('Price Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Upload')}}</label><br/>
            <input type="file" name="fileToUpload" id="fileToUpload"><br/>
            <input type="submit" class="button" name="submit" value="{{__('Submit')}}">
        </form>

    </div>
    <br/>

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
                                    <input id="user" type="text" class="form-control" name="user"
                                           placeholder="{{__('User')}}" value="" required autofocus>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">{{__('Password')}}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control"
                                           placeholder="{{__('Password')}}" name="password" required>

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