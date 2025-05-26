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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Franchises (Teams)</h2>
                <button id="show-form-btn" class="btn btn-primary">+ New Franchise</button>
            </div>

            <!-- Success/Error Message -->
            <div id="message" class="alert d-none"></div>

            <!-- Franchises Table -->
            <div class="card mb-4" id="franchises-list">
                <div class="card-body">
                    <table class="table table-striped" id="franchises-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tagline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($franchises as $franchise)
                            <tr data-id="{{ $franchise->id }}">
                                <td>{{ $franchise->id }}</td>
                                <td>
                                    @if($franchise->logo)
                                        <img src="{{ asset($franchise->logo) }}" alt="Logo" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        No Logo
                                    @endif
                                </td>
                                <td>{{ $franchise->name }}</td>
                                <td>{{ $franchise->email }}</td>
                                <td>{{ $franchise->tagline }}</td>
                                <td>{{ $franchise->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Franchise Form (Add/Edit) -->
            <div class="card d-none" id="franchise-form-container">
                <div class="card-header" id="form-header">Add New Franchise</div>
                <div class="card-body">
                    <form id="franchise-form" class="mx-auto" style="max-width: 60%;" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="franchise-id">
                        <div class="card p-4 shadow-sm border-0">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter franchise name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter franchise email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Logo</label>
                                <input type="file" name="logo" id="logo-input" class="form-control" accept=".png,.jpg,.jpeg">
                                <img id="logo-preview" class="logo-preview d-none" alt="Logo Preview">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tagline</label>
                                <input type="text" name="tagline" class="form-control" placeholder="Enter franchise tagline (optional)">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">About Franchise</label>
                                <textarea name="about_franchise" class="form-control" rows="3" placeholder="Write a brief description about the franchise"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="" disabled>Select status</option>
                                    <option value="active">Active</option>
                                    <option value="hold">Hold</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-25 me-2" id="submit-btn">Save Franchise</button>
                                <button type="button" id="cancel-form-btn" class="btn btn-secondary btn-lg w-25">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Show form and hide list for adding new franchise
        $('#show-form-btn').on('click', function() {
            $('#franchises-list').addClass('d-none');
            $('#franchise-form-container').removeClass('d-none');
            $('#form-header').text('Add New Franchise');
            $('#submit-btn').text('Save Franchise');
            $('#franchise-id').val('');
            $('#franchise-form')[0].reset();
            $('#logo-preview').addClass('d-none').attr('src', '');
            $('#message').addClass('d-none');
        });

        // Cancel button: hide form and show list
        $('#cancel-form-btn').on('click', function() {
            $('#franchise-form-container').addClass('d-none');
            $('#franchises-list').removeClass('d-none');
            $('#franchise-form')[0].reset();
            $('#logo-preview').addClass('d-none').attr('src', '');
            $('#message').addClass('d-none');
        });

        // Logo preview
        $('#logo-input').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logo-preview').removeClass('d-none').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                $('#logo-preview').addClass('d-none').attr('src', '');
            }
        });

        // Edit button: fetch franchise data and show form
        $(document).on('click', '.edit-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                url: '{{ route('admin.franchises.edit', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    const franchise = response.franchise;
                    $('#franchises-list').addClass('d-none');
                    $('#franchise-form-container').removeClass('d-none');
                    $('#form-header').text('Edit Franchise');
                    $('#submit-btn').text('Update Franchise');
                    $('#franchise-id').val(franchise.id);
                    $('#franchise-form [name="name"]').val(franchise.name);
                    $('#franchise-form [name="email"]').val(franchise.email);
                    if (franchise.logo) {
                        $('#logo-preview').removeClass('d-none').attr('src', '{{ asset('') }}' + franchise.logo);
                    } else {
                        $('#logo-preview').addClass('d-none').attr('src', '');
                    }
                    $('#franchise-form [name="tagline"]').val(franchise.tagline);
                    $('#franchise-form [name="about_franchise"]').val(franchise.about_franchise);
                    $('#franchise-form [name="status"]').val(franchise.status);
                    $('#message').addClass('d-none');
                },
                error: function(xhr) {
                    $('#message')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .text('Failed to load franchise data.');
                }
            });
        });

        // Delete button: confirm and mark as inactive
        $(document).on('click', '.delete-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            if (confirm('Are you sure you want to delete this franchise? This will mark it as inactive.')) {
                $.ajax({
                    url: '{{ route('admin.franchises.delete', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        row.find('td:eq(5)').text('inactive'); // Update status column (adjusted for new column order)
                        $('#message')
                            .removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text(response.message);
                    },
                    error: function(xhr) {
                        $('#message')
                            .removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Failed to delete franchise.');
                    }
                });
            }
        });

        // AJAX form submission (for both add and edit)
        $('#franchise-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#franchise-id').val();
            const url = id ? '{{ route('admin.franchises.edit', ':id') }}'.replace(':id', id) : '{{ route('admin.franchises.store') }}';
            const formData = new FormData(this);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#message')
                        .removeClass('d-none alert-danger')
                        .addClass('alert-success')
                        .text(response.message);

                    const franchise = response.franchise;
                    if (!id) { // New franchise
                        const newRow = `
                            <tr data-id="${franchise.id}">
                                <td>${franchise.id}</td>
                                <td>${franchise.logo ? '<img src="{{ asset('') }}' + franchise.logo + '" alt="Logo" style="max-width: 50px; max-height: 50px;">' : 'No Logo'}</td>
                                <td>${franchise.name}</td>
                                <td>${franchise.email}</td>
                                <td>${franchise.tagline || ''}</td>
                                <td>${franchise.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>
                        `;
                        $('#franchises-table tbody').append(newRow);
                    } else { // Edited franchise
                        const row = $(`tr[data-id="${franchise.id}"]`);
                        row.find('td:eq(1)').html(franchise.logo ? '<img src="{{ asset('') }}' + franchise.logo + '" alt="Logo" style="max-width: 50px; max-height: 50px;">' : 'No Logo');
                        row.find('td:eq(2)').text(franchise.name);
                        row.find('td:eq(3)').text(franchise.email);
                        row.find('td:eq(4)').text(franchise.tagline || '');
                        row.find('td:eq(5)').text(franchise.status);
                    }

                    $('#franchise-form-container').addClass('d-none');
                    $('#franchises-list').removeClass('d-none');
                    $('#franchise-form')[0].reset();
                    $('#logo-preview').addClass('d-none').attr('src', '');
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'An error occurred while saving the franchise.';
                    $('#message')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .text(errorMsg);
                }
            });
        });
    });
</script>
</body>
</html>
