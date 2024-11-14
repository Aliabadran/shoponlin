@extends('admin.layout.head')
@section('title') User @endsection

    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.layout.sidebar')

      <!-- partial:partials/_navbar.html -->
        <div class="container-fluid page-body-wrapper">
           <div class="main-panel">
                 <div class="panel-main">
              <div class="content-wrapper">
              <div class ="row">

              @include('admin.layout.header')
             @include('role-permission.nav-link')


    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Users
                            @can('create user')
                            <a href="{{ url('users/create') }}" class="btn btn-primary float-end">Add User</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $rolename)
                                                <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @can('update user')
                                        <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-success">Edit</a>
                                        @endcan

                                        @can('delete user')
                                        <form id="deleteForm-{{ $user->id }}" action="{{ url('users/'.$user->id.'/delete') }}" method="GET" style="display:inline;">
                                            @csrf
                                            <button type="button" class="btn btn-danger mx-2 deleteButton" data-id="{{ $user->id }}">Delete</button>
                                        </form>  @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

        </div>
      <!-- page-body-wrapper ends -->
    </div>
      </div>
    </div>
      </div>
   </div>
   @include('sweetalert::alert')
   @include('admin.layout.footer')

   <!-- Include SweetAlert JS script -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
       document.querySelectorAll('.deleteButton').forEach(button => {
           button.addEventListener('click', function(e) {
               e.preventDefault();

               const userId = this.getAttribute('data-id'); // Get the permission ID from the button's data attribute
               const deleteFormId = `deleteForm-${userId}`; // Construct the form ID dynamically

               // SweetAlert confirmation for delete action
               Swal.fire({
                   title: 'Are you sure?',
                   text: "This action cannot be undone!",
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, delete it!'
               }).then((result) => {
                   if (result.isConfirmed) {
                       document.getElementById(deleteFormId).submit(); // Submit the form if confirmed
                   }
               });
           });
       });
   </script>
