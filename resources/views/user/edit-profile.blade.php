@extends('user.layout')
@section('page_title', 'Edit Profile')
@section('container')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Edit Profile
                </div>
                <div class="card-body">
                    <div id="alert-container"></div>
                    
                    <form id="updateProfileForm" action="{{ route('profile.update') }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="number">Number</label>
                            <input type="number" name="number" id="number" class="form-control" value="{{ $user->number }}" required>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="updateProfile()">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateProfile() {
            // Get form data
            var formData = new FormData(document.getElementById('updateProfileForm'));

            axios.post('{{ route('profile.update') }}', formData)
                .then(function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated',
                        text: response.data.msg,
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the profile.',
                    });
                });
        }
    </script>
@endsection
