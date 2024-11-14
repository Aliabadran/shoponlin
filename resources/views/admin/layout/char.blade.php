<div class="main-panel">
    <div class="content-wrapper">

        <div class="scrollable-container"  >
            <div class="wide-content" >
                <div style="width: 1000px;" style="color: rgb(29, 73, 218)"> <!-- Example wide content -->

<div class="container">
    <h1>Admin Dashboard</h1>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <h4>{{ $productsCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h4>{{ $usersCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    <h4>{{ $ordersCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <h4>{{ $categoriesCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Roles</div>
                <div class="card-body">
                    <h4>{{ $rolesCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Revenue</div>
                <div class="card-body">
                    <h4>${{ number_format($totalRevenue, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Cost</div>
                <div class="card-body">
                    <h4>${{ number_format($totalCost, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Purchase</div>
                <div class="card-body">
                    <h4>${{ number_format($totalPurchase, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Order Statuses</h3>
            <canvas id="orderStatusChart" width="400" height="200"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Payment Methods</h3>
            <canvas id="paymentMethodChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Delivery Options</h3>
            <canvas id="deliveryOptionChart" width="200" height="100"></canvas>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Current Tasks</h3>
            <ul class="list-group">
                @foreach ($tasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span style="color: rgb(29, 73, 218)">{{ $task->title }}</span>
                        <div>
                            <form action="{{ route('admin.tasks.update', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                            </form>
                            <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Order Status Chart
    var ctxOrder = document.getElementById('orderStatusChart').getContext('2d');
    var orderStatusChart = new Chart(ctxOrder, {
        type: 'pie',
        data: {
            labels: {!! json_encode($orderStatusLabels) !!},
            datasets: [{
                label: 'Order Status',
                data: {!! json_encode($orderStatusData) !!},
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Payment Method Chart
    var ctxPayment = document.getElementById('paymentMethodChart').getContext('2d');
    var paymentMethodChart = new Chart(ctxPayment, {
        type: 'bar',
        data: {
            labels: {!! json_encode($paymentMethodLabels) !!},
            datasets: [{
                label: 'Payment Methods',
                data: {!! json_encode($paymentMethodData) !!},
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Delivery Option Chart
    var ctxDelivery = document.getElementById('deliveryOptionChart').getContext('2d');
    var deliveryOptionChart = new Chart(ctxDelivery, {
        type: 'doughnut', // Change the chart type as needed
        data: {
            labels: {!! json_encode($deliveryOptionLabels) !!},
            datasets: [{
                label: 'Delivery Options',
                data: {!! json_encode($deliveryOptionData) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

