<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #e3f2fd;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link.active {
            background-color: #bbdefb;
            color: #1976d2;
        }
        .header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .card {
            border-radius: 10px;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.5);
        }
    </style>
</head>
<body>
<!-- Header -->
<header class="header py-2">
    @include('admin.top-header')
</header>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar -->
        @include('admin.left-nav')

        <!-- Right Content -->
        <main class="col-md-10 p-4">
            <h2>Dashboard</h2>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card stat-card shadow-sm p-3 bg-primary text-white">
                        <h5>Total Franchises</h5>
                        <h3>{{ $totalFranchises ?? 10 }}</h3>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card shadow-sm p-3 bg-success text-white">
                        <h5>Past Contests</h5>
                        <h3>{{ $pastContests ?? 5 }}</h3>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card shadow-sm p-3 bg-warning text-dark">
                        <h5>Today's Contests</h5>
                        <h3>{{ $todayContests ?? 2 }}</h3>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card shadow-sm p-3 bg-info text-white">
                        <h5>Upcoming Contests</h5>
                        <h3>{{ $upcomingContests ?? 8 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Matches and Chart -->
            <div class="row">
                <!-- Matches Card -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">Recent Contests</div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Team 1</th>
                                    <th>Team 2</th>
                                    <th>Date/Time</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contests as $contest)
                                    <tr>
                                        <td>{{ $contest->id }}</td>
                                        <td>{{ $contest->franchise1->name ?? 'N/A' }}</td>
                                        <td>{{ $contest->franchise2->name ?? 'N/A' }}</td>
                                        <td>{{ $contest->match_datetime ? $contest->match_datetime->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td>{{ $contest->status }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Chart Card -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">Contest Statistics</div>
                        <div class="card-body">
                            <canvas id="contestChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<!-- Include Bootstrap and Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Contest Chart
    const ctx = document.getElementById('contestChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Past Contests', 'Today\'s Contests', 'Upcoming Contests'],
            datasets: [{
                label: 'Number of Contests',
                data: [{{ $pastContests ?? 5 }}, {{ $todayContests ?? 2 }}, {{ $upcomingContests ?? 8 }}],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.6)',  // Success (Past)
                    'rgba(255, 193, 7, 0.6)',  // Warning (Today)
                    'rgba(23, 162, 184, 0.6)'  // Info (Upcoming)
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(23, 162, 184, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

</body>
</html>
