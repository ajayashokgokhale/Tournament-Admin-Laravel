<!-- resources/views/admin/dashboard.blade.php -->
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
    </style>
</head>
<body>
<!-- Header -->
<header class="header py-2">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="d-flex align-items-center">
                    <img src="/path/to/logo.png" alt="Logo" style="width: 40px; height: 40px;">
                    <span class="ms-2 fw-bold">Tournament Admin</span>
                </div>
            </div>
            <div class="col-6 text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <span class="me-2">Welcome John</span>
                    <img src="/path/to/profile.jpg" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar -->
        <nav class="col-md-2 sidebar p-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.franchises') ? 'active' : '' }}" href="{{ route('admin.franchises') }}">Franchises</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.players') ? 'active' : '' }}" href="{{ route('admin.players') }}">Players</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.events') ? 'active' : '' }}" href="{{ route('admin.events') }}">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.matches') ? 'active' : '' }}" href="{{ route('admin.matches') }}">Matches</a>
                </li>
            </ul>
        </nav>

        <!-- Right Content -->
        <main class="col-md-10 p-4">
            <h2>Franchises</h2>

            <!-- Franchises Table -->
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tagline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($franchises as $franchise)
                            <tr>
                                <td>{{ $franchise->id }}</td>
                                <td>{{ $franchise->name }}</td>
                                <td>{{ $franchise->email }}</td>
                                <td>{{ $franchise->tagline }}</td>
                                <td>{{ $franchise->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- New Franchise Form -->
            <div class="card">
                <div class="card-header">Add New Franchise</div>
                <div class="card-body">
                    <form action="{{ route('admin.franchises.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Logo URL</label>
                            <input type="text" name="logo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="tagline" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">About Franchise</label>
                            <textarea name="about_franchise" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="hold">Hold</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Franchise</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
