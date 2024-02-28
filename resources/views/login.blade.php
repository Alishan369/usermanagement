<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('sweetalert2/dist/sweetalert2.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE styles -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f4f6f9;
        }

        .login-box {
            margin: 10% auto;
        }

        .login-logo a {
            color: #28a745;
            font-size: 32px;
            font-weight: bold;
        }

        .login-card-body {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-box-msg {
            font-size: 20px;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .custom-control-label::before,
        .custom-control-label::after {
            border-radius: 50%;
        }

        .create-account-link,
        .forgot-password-link {
            font-size: 14px;
            text-decoration: none;
            color: #28a745;
            cursor: pointer;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo text-center">
            <a href="#">user management</a>
        </div>
        <div class="card login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{ route('login.auth') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>

            <div class="mt-3">
                <a href="{{ url('registration') }}" class="create-account-link">Create Account</a> |
                <span class="forgot-password-link" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password</span>
            </div>

            @if (session()->has('error'))
                <script src="{{ asset('assets/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
                <script>
                    // Display error message using SweetAlert
                    $(document).ready(function() {
                        showSweetAlert();
                    });

                    function showSweetAlert() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ session('error') }}'
                        });
                    }
                </script>
            @endif
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add your forgot password form fields here -->
                    <p>Enter your email address to reset your password.</p>
                    <form id="forgotPasswordForm" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="str_forgot_email" placeholder="Your Email" required>
                        </div>
                        <button type="button" id="resetPasswordBtn" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Handle click on resetPasswordBtn
            $('#resetPasswordBtn').click(function() {
                // Perform AJAX request
                $.ajax({
                    url: "{{ url('forgot_password') }}",
                    method: 'POST',
                    data: $('#forgotPasswordForm').serialize(),
                    success: function(response) {
                        // Check response from the server
                        if (response.status == "success") {
                            // Reset form and show success message
                            $('#forgotPasswordForm')[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.msg
                            });
                        } else {
                            // Show error message if the request was not successful
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.msg
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
