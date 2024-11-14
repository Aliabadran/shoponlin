@extends('admin.layout.head')
@section('title') Permissions @endsection
@notifyCss
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    @include('admin.layout.sidebar')

    <!-- SweetAlert for Alerts -->
    @include('sweetalert::alert')

    <!-- partial:partials/_navbar.html -->
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="panel-body">
                <div class="content-wrapper">
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
                                        <h4>Permissions
                                            @can('create permission')
                                            <a href="{{ url('permissions/create') }}" class="btn btn-primary float-end">Add Permission</a>
                                            @endcan
                                        </h4>
                                    </div>
                                    <div class="card-body">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th width="40%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($permissions as $permission)
                                                <tr>
                                                    <td>{{ $permission->id }}</td>
                                                    <td>{{ $permission->name }}</td>
                                                    <td>
                                                        @can('update permission')
                                                        <a href="{{ url('permissions/'.$permission->id.'/edit') }}" class="btn btn-success">Edit</a>
                                                        @endcan

                                                        @can('delete permission')
                                                        <!-- Delete action with SweetAlert confirmation -->
                                                        <form id="deleteForm-{{ $permission->id }}" action="{{ url('permissions/'.$permission->id.'/delete') }}" method="GET" style="display:inline;">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger mx-2 deleteButton" data-id="{{ $permission->id }}">Delete</button>
                                                        </form>

                                                        @endcan
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
    @include('notify::components.notify')
    @notifyJs
  
    @include('admin.layout.footer')
</div>

@include('sweetalert::alert')
<!-- Include SweetAlert JS script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const permissionId = this.getAttribute('data-id'); // Get the permission ID from the button's data attribute
            const deleteFormId = `deleteForm-${permissionId}`; // Construct the form ID dynamically

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
