@extends('admin.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@notifyCss
@section('title') Advertisements @endsection

<div class="container-scroller">
    @include('admin.layout.sidebar')
    @include('sweetalert::alert')
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="panel-body">
                <div class="content-wrapper">
                    @include('admin.layout.header')
                    <div class="scrollable-container">
                        <div class="wide-content">
                            <div style="min-width: 900px; color: rgb(29, 73, 218)">
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
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    <div class="card mt-3">
                                        <div class="container">
                                            <div class="card-header">
                                                <h1>Manage Advertisements</h1>
                                                <a href="{{ route('ads.create') }}" class="btn btn-primary">Create New Ad</a>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Photo</th>
                                                                <th>Title</th>
                                                                <th>Category</th>
                                                                <th>Description</th>
                                                                <th>Product</th>
                                                                <th>Active</th>
                                                                <th width="40%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($ads as $ad)
                                                            <tr>
                                                                <td>{{ $ad->id }}</td>
                                                                <td>
                                                                    @if ($ad->image_path)
                                                                        <img src="{{ asset('storage/' . $ad->image_path) }}" alt="Photo" width="100">
                                                                    @endif
                                                                </td>
                                                                <td>{{ $ad->title }}</td>
                                                                <td>
                                                                    @foreach($ad->categories as $category)
                                                                        {{ $category->name }}
                                                                    @endforeach
                                                                </td>
                                                                <td>{{ $ad->description }}</td>
                                                                <td>
                                                                    @foreach($ad->products as $product)
                                                                        <p>Product: {{ $product->name }}</p>
                                                                    @endforeach
                                                                </td>
                                                                <td>{{ $ad->is_active ? 'Yes' : 'No' }}</td>
                                                                <td>
                                                                    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-info">Edit</a>
                                                                    <button type="button" class="btn btn-danger mx-2" onclick="confirmDelete({{ $ad->id }})">Delete</button>
                                                                    <form id="delete-form-{{ $ad->id }}" action="{{ route('ads.destroy', $ad->id) }}" method="POST" style="display:none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div> <!-- End table-responsive -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('admin.layout.footer')

<style>
.scrollable-container {
    overflow-x: auto; /* Enables horizontal scrolling */
    white-space: nowrap; /* Prevents content from wrapping to a new line */
}

.wide-content {
    display: inline-block; /* Keeps content in a single line for horizontal scrolling */
    min-width: 80%; /* Ensures the content takes full width */
}
</style>
<x-notify::notify />
        @notifyJs
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(adId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + adId).submit();
            }
        });
    }
</script>
