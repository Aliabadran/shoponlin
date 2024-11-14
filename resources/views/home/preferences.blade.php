@notifyCss
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Select Your Preferences</h2>
                </div>
                @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
                <div class="card-body">
                    <form action="{{ route('preferences.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="preferences[]" value="{{ $category->name }}"
                                               id="category-{{ $category->id }}" {{ in_array($category->name, $userPreferences) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
<br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3">
                                Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
@include('notify::components.notify')
@notifyJs

<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    .card-header {
        padding: 20px;
        background-color: #007bff;
        color: white;
    }
    .card-body {
        padding: 30px;
    }
    .form-check-input {
        border-radius: 50%;
        width: 20px;
        height: 20px;
        margin-right: 10px;
    }
    .form-check-label {
        font-size: 18px;
        font-weight: 500;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 30px;
        font-size: 18px;
        border-radius: 30px;
    }
    .alert {
        margin-top: 20px;
        font-size: 16px;
    }
</style>


