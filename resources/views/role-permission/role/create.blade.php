

@extends('admin.layout.head')
@section('title') Create Role @endsection
@notifyCss
  <body>

        <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.layout.sidebar')

      <!-- partial:partials/_navbar.html -->
        <div class="container-fluid page-body-wrapper">
           <div class="main-panel">
           <div class="panel-body">
            <div class="content-wrapper">

              @include('admin.layout.header')

            @include('role-permission.nav-link')
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12">

                            @if ($errors->any())
                            <ul class="alert alert-warning">
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                            @endif
                            @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                            <div class="card">
                                <div class="card-header">
                                    <h4>Create Role
                                        <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('roles') }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="">Role Name</label>
                                            <input type="text" name="name" class="form-control" />
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('sweetalert::alert')
                @include('notify::components.notify')
@notifyJs

            @include('admin.layout.footer')
            </div>
            </div>
             </div>
            </div>


</body>
