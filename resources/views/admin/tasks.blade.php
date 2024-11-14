@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@notifyCss
@section('title') Tasks @endsection

<body>

    <div class="container-scroller">
        @include('admin.layout.sidebar')
        <div class="container-fluid page-body-wrapper">

            <div class="panel-body">
             <div class="content-wrapper">

               @include('admin.layout.header')

               <div class="scrollable-container">
                    <div class="wide-content">
                        <div style="width: 1000px;" style="color: rgb(29, 73, 218)"> <!-- Example wide content -->

                            <div class="col-md-12">
                                @if ($errors->any())
                                <ul class="alert alert-warning">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                @endif

                                <!-- SweetAlert for success notifications -->
                                @if (session('success'))
                                    <script>
                                        Swal.fire({
                                            title: 'Success!',
                                            text: '{{ session('success') }}',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                @endif

                                <div class="container">
                                    <h1>Task List</h1>

                                    <form action="{{ route('admin.tasks.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="title" class="form-control" placeholder="New Task" required>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="description" class="form-control" placeholder="Description (optional)"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Task</button>
                                    </form>

                                    <h3 class="mt-4">Current Tasks</h3>
                                    <ul class="list-group">
                                        @foreach ($tasks as $task)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $task->title }}</span>
                                                <p>{{ $task->description }}</p>
                                                <div>
                                                    <form action="{{ route('admin.tasks.update', $task) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                                    </form>

                                                    <!-- Delete task with SweetAlert confirmation -->
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $task->id }})">Delete</button>
                                                    <form id="delete-form-{{ $task->id }}" action="{{ route('admin.tasks.destroy', $task) }}" method="POST" style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <x-notify::notify />
    @notifyJs
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert confirmation for task deletion
        function confirmDelete(taskId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this task?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + taskId).submit();
                }
            });
        }
    </script>
</body>
