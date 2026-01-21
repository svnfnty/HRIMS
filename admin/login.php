<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | HRIMS</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
    <style>
        html, body {
            height: 100%;
            background-image: url('https://static.vecteezy.com/system/resources/previews/021/997/893/original/abstract-background-with-blue-gradient-color-free-vector.jpg'); /* Add your image here */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-card h3 {
            margin-bottom: 30px;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .form-control {
            border-radius: 50px;
            padding: 12px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #4e73df;
            border-radius: 50px;
            padding: 12px;
            border: none;
            width: 100%;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #3a57d8;
        }
        .pop_msg {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success {
            background-color: #28a745;
            color: white;
        }
        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
        .forgot-password {
            color: #4e73df;
            text-decoration: none;
            font-size: 14px;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <h3 class="text-dark">Human Resource Integrated Management System (HRIMS)</h3>
            <form id="login-form">
                <div class="pop_msg"></div>
                <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" required autofocus>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <div class="mt-3">
                    <a href="#" class="forgot-password">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function(){
            $('#login-form').submit(function(e){
                e.preventDefault();
                $('.pop_msg').remove();
                var _this = $(this);
                var _el = $('<div>').addClass('pop_msg');
                _this.find('button').attr('disabled', true);
                _this.find('button[type="submit"]').text('Logging in...');

                $.ajax({
                    url: './../Actions.php?a=login',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    error: function(err) {
                        console.log(err);
                        _el.addClass('alert alert-danger').text("An error occurred.");
                        _this.prepend(_el);
                        _el.show('slow');
                        _this.find('button').attr('disabled', false);
                        _this.find('button[type="submit"]').text('Login');
                    },
                    success: function(resp) {
                        if (resp.status === 'success') {
                            _el.addClass('alert alert-success').text(resp.msg);
                            setTimeout(function() {
                                location.replace('./');
                            }, 2000);
                        } else {
                            _el.addClass('alert alert-danger').text(resp.msg);
                        }
                        _el.hide().prependTo(_this).show('slow');
                        _this.find('button').attr('disabled', false);
                        _this.find('button[type="submit"]').text('Login');
                    }
                });
            });
        });
    </script>

</body>
</html>
