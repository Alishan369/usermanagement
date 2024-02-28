@extends('admin/layout')
@section('page_title', 'users')
@section('container')
    <h1 class="mb10">Users</h1>
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            loadUserData();
        });

        function loadUserData() {
            $('#datatable').DataTable({
                "responsive": true,
                "ajax": "{{ route('admin.users.get_users') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'number'
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button type="button" onclick="changeStatus(' + row.id + ', ' + (
                                    row.status == 1 ? 0 : 1) + ')" class="btn btn-sm btn-' + (row
                                    .status == 1 ? 'success' : 'secondary') + '">' + (row
                                    .status == 1 ? 'Active' : 'Deactivate') + '</button>' +
                                '<button type="button" onclick="deleteUser(' + row.id +
                                ')" class="btn btn-sm btn-danger">Delete</button>' +
                                '</div>';
                        }
                    }
                ]
            });
        }

        function changeStatus(userId, newStatus) {
            $.ajax({
                url: "{{ url('admin/user/status') }}/" + newStatus + "/" + userId,
                type: "GET",
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    $('#datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            });
        }

        function deleteUser(userId) {
            $.ajax({
                url: "{{ url('admin/user/delete') }}/" + userId,
                type: "GET",
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    $('#datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            });
        }
    </script>
@endsection
