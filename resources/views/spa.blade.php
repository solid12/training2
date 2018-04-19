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
                                '<a class="add" data-id="' + product.id + '" >{{ __('Add to Cart') }}</a>',
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
                                '<a href="#edit" class="editbutton" data-id="' + product.id + '">{{ __('Edit Product') }}</a> | <a class="delete" data-id="' + product.id + '" >{{ __('Delete Product') }}</a>',
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
                                '<a class="remove" data-id="' + product.id + '" >{{ __('Remove Product') }}</a>',
                                '</ul>'
                            ].join('');
                        });

                        return html;
                    }

                    function checkLogin(callback) {
                        $.ajax({
                            url: '/check',
                            dataType: 'json',
                            success: function (data) {
                                if (parseInt(data)) {
                                    if (callback) {
                                        callback();
                                    }
                                } else {
                                    window.location.hash = '#login';
                                }
                            }
                        });
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
                                            var id = $(this).attr("data-id");
                                            $.ajax({
                                                type: "GET",
                                                url: "/cart",
                                                data: 'id=' + id,
                                                dataType: 'json',
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
                                checkLogin(function () {
                                    $('.edit').show();
                                });
                                break;

                            case '#add':
                                // Show the cart page
                                checkLogin(function () {
                                    $('.add').show();
                                });
                                break;

                            case '#products':
                                // Show the cart page
                                checkLogin(function () {
                                    $('.products').show();
                                    // Load the cart products from the server
                                    $.ajax('/products', {
                                        dataType: 'json',
                                        success: function (response) {
                                            // Render the products in the cart list
                                            $('.products .list').html(renderListproducts(response));
                                            $(".delete").click(function (e) {
                                                var id = $(this).attr("data-id");
                                                $.ajax({
                                                    type: "GET",
                                                    url: "/delete",
                                                    data: "id=" + id,
                                                    dataType: 'json',
                                                    success: function (data) {
                                                        window.onhashchange();
                                                        alert('{{__('Your product has been deleted !')}}');
                                                    }
                                                });
                                                return false;
                                            });

                                        }
                                    });

                                    $(document).on("click", ".editbutton", function (e) {
                                        var id = $(this).attr("data-id");
                                        $.ajax({
                                            type: "GET",
                                            url: "/product",
                                            data: "id=" + id,
                                            dataType: 'json',
                                            success: function (data) {
                                                window.location.hash = '#edit';
                                                var title = data.title;
                                                var description = data.description;
                                                var price = data.price;
                                                $('.js-title').val(title);
                                                $('.js-description').val(description);
                                                $('.js-price').val(price);
                                                $('.product').show();
                                            }

                                        });

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
                                            var id = $(this).attr("data-id");
                                            $.ajax({
                                                type: "GET",
                                                url: "/index",
                                                data: 'id=' + id,
                                                dataType: 'json',
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
                                $.ajax({
                                    method: 'POST',
                                    url: '/login',
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

                    $('.edit .js-formedit [type=submit]').click(function () {
                        $.ajax('/token', {
                            success: function (response) {
                                var idedit = $('.editbutton').attr("data-id");
                                var sel = $('.js-formedit')[0];
                                var formData = new FormData(sel);
                                formData.append('_token', response);
                                formData.append('submit', '1');
                                $.ajax({
                                    url: '/product?id=' + idedit,
                                    type: 'POST',
                                    data: formData,
                                    encType: 'multipart/form-data',
                                    cache: false,
                                    dataType: 'json',
                                    contentType: false,
                                    processData: false,
                                    success: function (result) {

                                        if (result.error === 1) {
                                            alert('{{__('Your image is too large !')}}');
                                        } else if (result.error === 2) {
                                            alert('{{__('Your image not has valid format !')}}');
                                        } else if (result.error === 3) {
                                            alert('{{__('Your image can`t be validated !')}}');
                                        } else if (result.error === 4) {
                                            alert('{{__('Title not is set !')}}');
                                        } else if (result.error === 5) {
                                            alert('{{__('Description not is set !')}}');
                                        } else if (result.error === 6) {
                                            alert('{{__('Price not is set !')}}');
                                        } else if (result.error === 8) {
                                            alert('{{__('Error update.')}}');
                                        } else {
                                            window.location.hash = '#products';
                                            window.onhashchange();
                                            alert('{{__('Your product has been updated !')}}');
                                        }
                                    },
                                    error: function (result) {
                                        console.log(result);
                                    }
                                });
                                return false;

                            }
                        });
                    });

                    $('.add input[type=submit]').click(function () {
                        $.ajax('/token', {
                            success: function (response) {

                                var sel = $('.js-form')[0];
                                var formData = new FormData(sel);
                                formData.append('_token', response);
                                formData.append('submit', '1');
                                $.ajax({
                                    url: '/product',
                                    type: 'POST',
                                    data: formData,
                                    cache: false,
                                    dataType: 'json',
                                    contentType: false,
                                    processData: false,
                                    success: function (result) {

                                        if (result.error === 1) {
                                            alert('{{__('Your image is too large !')}}');
                                        } else if (result.error === 2) {
                                            alert('{{__('Your image not has valid format !')}}');
                                        } else if (result.error === 3) {
                                            alert('{{__('Your image can`t be validated !')}}');
                                        } else if (result.error === 4) {
                                            alert('{{__('Title not is set !')}}');
                                        } else if (result.error === 5) {
                                            alert('{{__('Description not is set !')}}');
                                        } else if (result.error === 6) {
                                            alert('{{__('Price not is set !')}}');
                                        } else if (result.error === 7) {
                                            alert('{{__('Error upload. Please add image and after add product !')}}');
                                        } else {
                                            window.location.hash = '#products';
                                            $('.add .js-addtitle').val('');
                                            $('.add .js-adddescription').val('');
                                            $('.add .js-addprice').val('');
                                            alert('{{__('Your product has been added !')}}');
                                        }
                                    },
                                    error: function (result) {
                                        console.log(result);

                                    }
                                });
                                return false;

                            }
                        });
                    });

                    $('.cart [type=submit]').click(function () {
                        $.ajax('/token', {
                            success: function (response) {
                                $.ajax({
                                    method: 'POST',
                                    url: '/cart',
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
                        $.ajax({
                            type: "GET",
                            url: "/logout",
                            dataType: 'json',
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
        )
        ;
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
        <input type="submit" name="send" class="btn btn-success pull-right checkout"
               value="{{ __("Checkout") }}"> </input>
    </form>
    <!-- A link to go to the index by changing the hash -->
    <a href="#">{{__('Go to index')}}</a>
</div>

<div class="page products">
    <!-- The cart element where the products list is rendered -->
    <div class="list"></div>
    <br/>
    <a href="#add" class="addbutton">{{__('Add Product')}}</a><br/>
    <a class="logout">{{__('Logout')}}</a>
</div>

<div class="page edit">
    <!-- The cart element where the products list is rendered -->
    <form class="js-formedit" enctype="multipart/form-data">
        <label>{{__('Title Product')}}</label><br/>
        <input type="text" class="js-title" name="title" placeholder="{{__('Title Product')}}"
               autocomplete="off"/><br/>
        <label>{{__('Description Product')}}</label><br/>
        <input type="text" class="js-description" name="description" placeholder="{{__('Description Product')}}"
               autocomplete="off"/><br/>
        <label>{{__('Price Product')}}</label><br/>
        <input type="number" class="js-price" name="price" placeholder="{{__('Price Product')}}"
               autocomplete="off"/><br/>
        <label>{{__('Upload')}}</label><br/>
        <input type="file" class="fileToUpload" name="fileToUpload"><br/>
        <input type="submit" class="button" name="submit" value="{{__('Submit')}}">
    </form>

    <br/>
</div>

<div class="page add">
    <!-- The cart element where the products list is rendered -->
    <div class="product">
        <form class="js-form" enctype="multipart/form-data">
            <label>{{__('Title Product')}}</label><br/>
            <input type="text" class="js-addtitle" name="title" placeholder="{{__('Title Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Description Product')}}</label><br/>
            <input type="text" class="js-adddescription" name="description"
                   placeholder="{{__('Description Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Price Product')}}</label><br/>
            <input type="number" class="js-addprice" name="price" placeholder="{{__('Price Product')}}"
                   autocomplete="off"/><br/>
            <label>{{__('Upload')}}</label><br/>
            <input type="file" class="fileToUpload" name="fileToUpload"><br/>
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