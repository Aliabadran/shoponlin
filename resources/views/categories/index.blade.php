
@extends('admin.layout.head')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @notifyCss
@section('title')Categories @endsection
<body>
 <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
     @include('admin.layout.sidebar')
     @include('sweetalert::alert')
      <!-- partial:partials/_navbar.html -->
    <div class="container-fluid page-body-wrapper">
       <div class="main-panel">
         <div class="panel-body">
            <div class="content-wrapper">

              @include('admin.layout.header')
              @include('sweetalert::alert')


                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-md-12">


                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <br>
                                <br>
                                @can('view categories')

                                <form action="{{ route('categories.search') }}" method="GET">
                                    <input type="text" name="query" placeholder="Search categories..." value="{{ isset($query) ? $query :' ' }}" required>
                                    <button type="submit"class="btn btn-success" >Search</button>
                                </form>
                                @endcan
                                <a href="{{ url('categories') }}" class="btn btn-danger float-end">   Back</a>

                                <br>

                                      <div class="card mt-3">
                                      <div class="card-header" >
                                       <h4 >
                                        <p class="h1" >Categories</p>

                                         <br>
                                         <br>
                                         @can('create categories')
                                         <a href="{{ url('categories/create') }}"  margin-right="auto "class="btn btn-primary float-end me-md-2">Create New Category</a>
                                         @endcan
                                        </h4>
                                        </div>



                                          <!-- Search Results -->
                                       <ul>
                                    @if($categories->isEmpty())
                                            <li>No categories found.</li>
                                     @else

                                      <div class="card-body">

                                         <table class="table table-bordered table-striped">
                                            <thead>
                                               <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Photo</th>
                                                    <th width="40%">Action</th>
                                                  </tr>
                                             </thead>
                                            <tbody>

                                                    @foreach ($categories as $category)
                                                    <tr>
                                                        <td>{{ $category->id }}</td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{{ $category->description }}</td>
                                                        <td>
                                                            @if ($category->photo)
                                                            <img src="{{ asset('storage/' . $category->photo) }}" alt="Photo" width="100">
                                                        @endif
                                                        </td>
                                                        <td>
                                                          @can('view categories')
                                                            <a href="{{ route('categories.show', $category->id  ) }}" class="btn btn-success" >View</a>
                                                            @endcan
                                                           
                                                            <a href="{{ route('category.products', $category->id  ) }}" class="btn btn-warning" >Product</a>
                                                         
                                                            @can('edit categories')
                                                            <a href="{{ route('categories.edit', $category->id) }}"class="btn btn-info">Edit</a>
                                                            @endcan
                                                            @can('delete categories')
                                                            <form id="deleteForm-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger deleteCategoryBtn" data-id="{{ $category->id }}">Delete</button>
                                                            </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                 </tbody>
                                             </table>

                                     </div>
                                     @endif
                                     </ul>
                                </div>

       </div>
    </div>
 </div>

 @include('notify::components.notify')
    @notifyJs

    <script src="{{ asset('vendor/mckenziearts/notify/js/notify.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.deleteCategoryBtn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission

            const categoryId = this.getAttribute('data-id');
            const formId = `deleteForm-${categoryId}`;

            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>
   @include('admin.layout.footer')
 </body>
