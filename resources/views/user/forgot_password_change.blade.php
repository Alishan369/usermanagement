<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('sweetalert2/dist/sweetalert2.min.css') }}">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Change Password</h4>
                        <form id="frmUpdatePassword">
                            <div class="form-group">
                                <label for="password">Password<span>*</span></label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your new password" required>
                                <div id="password_error" class="text-danger"></div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block" id="btnUpdatePassword">Update
                                Password</button>
                            @csrf
                        </form>
                        <div id="thank_you_msg" class="text-success mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
  <script src="{{ asset('assets/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#btnUpdatePassword').click(function () {
                // Perform AJAX request
                $.ajax({
                    url: "{{ url('forgot_password_change_process') }}",
                    method: 'POST',
                    data: $('#frmUpdatePassword').serialize(),
                    success: function (response) {

                        if (response.status === "success") {
                            $('#frmUpdatePassword')[0].reset();
                            $('#thank_you_msg').html(response.message);
                            $('.text-danger').html('');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.msg
                            });
                            setTimeout(function () {
                            location.reload();
                        }, 1000);
                        } else {
                            displayErrors(response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                });
            });

            function displayErrors(errors) {
                $('.text-danger').html('');
                $.each(errors, function (key, value) {
                    $('#' + key + '_error').html(value[0]);
                });
            }
        });
    </script>
</body>

</html>
