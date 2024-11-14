
    @extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
         @notifyCss
    <!-- Custom CSS -->

    @section('title') Admin Notifications @endsection

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .table th {
            cursor: pointer;
        }

        .read {
            color: green;
        }

        .unread {
            color: red;
        }

        .mark-btn:disabled {
            cursor: not-allowed;
        }

        /* Additional custom styling */
        .filter-form {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .filter-form .form-group {
            margin-right: 15px;
        }

        .form-group label {
            margin-right: 10px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table td.actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .alert {
            margin-top: 15px;
        }
    </style>

<body>
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
                 <div style="width: 1000px;">
                     <div class="col-md-12">
                         <!-- Handle Validation Errors -->

        <div class="container">
        <h1 class="text-center mb-4">All User Notifications</h1>


   <!-- Filter and Sort Form -->
   <form method="GET" action="{{ route('admin.notifications') }}"  class="form-inline mb-4">
    <div class="form-group mr-2">
    <label for="user_name">Filter by User Name:</label>
    <input type="text" name="user_name" id="user_name" value="{{ request('user_name') }}">
    </div>
    <div class="form-group mr-2">
    <label for="read_status">Filter by Status:</label>
    <select name="read_status" id="read_status">
        <option value="">All</option>
        <option value="read" {{ request('read_status') == 'read' ? 'selected' : '' }}>Read</option>
        <option value="unread" {{ request('read_status') == 'unread' ? 'selected' : '' }}>Unread</option>
    </select>
    </div>
    <div class="form-group mr-2">
    <label for="sort_order">Sort by Date:</label>
    <select name="sort_order" id="sort_order">
        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Newest First</option>
        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Oldest First</option>
    </select>
    </div>
    <button type="submit" class="btn btn-primary">Apply</button>
</form>


        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    @if(session('status'))
        <p>{{ session('status') }}</p>
    @endif



            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>User</th>
                        <th>Message</th>
                        <th>
                            <a href="{{ route('admin.notifications', ['sort' => 'created_at', 'direction' => old('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-white">
                                Created At
                                @if(old('sort') == 'created_at')
                                    ({{ old('direction') == 'asc' ? '▲' : '▼' }})
                                @endif
                            </a>
                        </th>
                        <th>Read Status</th>
                        <th>Action</th>
                    </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
                <tr>
                    <td>{{ $notification->id }}</td>
                   <td>{{ $notification ->type }}</td>
                    <td>{{ $notification->notifiable->name ?? 'N/A' }}</td>
                    <td>{{ $notification ->data }}</td>
                    <td> {{ $notification->created_at->format('Y-m-d H:i') }}</td>
                    <td class="{{ $notification->is_read ? 'read' : 'unread' }}">{{ $notification->read_at ? 'Read' : 'Unread' }}</td>
                    <td>
                        @if($notification->read_at)
                        <form action="{{ route('admin.notifications.markAsUnread', $notification->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit"  class="btn btn-sm btn-warning">Mark as urRead</button>
                        </form>
                        @else
                            <form action="{{ route('admin.notifications.markAsRead', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" >Mark as Read</button>
                            </form>
                        @endif

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
         </div>
         </div>
        </div>
    </div>

    <x-notify::notify />
        @notifyJs
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

