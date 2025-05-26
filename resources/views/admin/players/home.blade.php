<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Admin - Players</title>
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
        .photo-preview {
            max-width: 150px;
            max-height: 100px;
            margin-top: 10px;
        }
        .franchise-logo {
            max-width: 30px;
            max-height: 30px;
            margin-right: 8px;
            vertical-align: middle;
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
                <h2>Players</h2>
                <button id="show-form-btn" class="btn btn-primary">+ New Player</button>
            </div>

            <!-- Success/Error Message -->
            <div id="message" class="alert d-none"></div>

            <!-- Player Table -->
            <div class="card mb-4" id="players-list">
                <div class="card-body">
                    <table class="table table-striped" id="players-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Franchise</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($players as $player)
                            <tr data-id="{{ $player->id }}">
                                <td>{{ $player->id }}</td>
                                <td>
                                    @if($player->franchise && $player->franchise->logo)
                                        <img src="{{ asset($player->franchise->logo) }}" alt="{{ $player->franchise->name }} Logo" class="franchise-logo">
                                    @endif
                                    {{ $player->franchise->name ?? 'N/A' }}
                                </td>
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->position }}</td>
                                <td>
                                    @if($player->photo)
                                        <img src="{{ asset($player->photo) }}" alt="Photo" style="max-width: 50px; max-height: 50px;">
                                    @else
                                        No Photo
                                    @endif
                                </td>
                                <td>{{ $player->status }}</td>
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

            <!-- Player Form (Add/Edit) -->
            <div class="card d-none" id="player-form-container">
                <div class="card-header" id="form-header">Add New Player</div>
                <div class="card-body">
                    <form id="player-form" class="mx-auto" style="max-width: 60%;" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="player-id">
                        <div class="card p-4 shadow-sm border-0">
                            <div class="mb-3">
                                <label class="form-label">Franchise</label>
                                <select name="franchise_id" class="form-select" required>
                                    <option value="" disabled selected>Select franchise</option>
                                    @foreach($franchises as $franchise)
                                        <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter player name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <input type="text" name="position" class="form-control" placeholder="Enter player position (e.g., Guard)" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo</label>
                                <input type="file" name="photo" id="photo-input" class="form-control" accept=".png,.jpg,.jpeg">
                                <img id="photo-preview" class="photo-preview d-none" alt="Photo Preview">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Profile</label>
                                <textarea name="profile" class="form-control" rows="3" placeholder="Write a brief profile about the player"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">YouTube Link</label>
                                <input type="url" name="youtube_link" class="form-control" placeholder="Enter YouTube link (optional)">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="" disabled>Select status</option>
                                    <option value="active">Active</option>
                                    <option value="hold">Inactive</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-25 me-2" id="submit-btn">Submit</button>
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
        // Show form and hide list for adding new player
        $('#show-form-btn').on('click', function() {
            $('#players-list').addClass('d-none');
            $('#player-form-container').removeClass('d-none');
            $('#form-header').text('Add New Player');
            $('#submit-btn').text('Save Player');
            $('#player-id').val('');
            $('#player-form')[0].reset();
            $('#photo-preview').addClass('d-none').attr('src', '');
            $('#message').addClass('d-none');
        });

        // Cancel button: hide form and show list
        $('#cancel-form-btn').on('click', function() {
            $('#player-form-container').addClass('d-none');
            $('#players-list').removeClass('d-none');
            $('#player-form')[0].reset();
            $('#photo-preview').addClass('d-none').attr('src', '');
            $('#message').addClass('d-none');
        });

        // Photo preview
        $('#photo-input').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#photo-preview').removeClass('d-none').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                $('#photo-preview').addClass('d-none').attr('src', '');
            }
        });

        // Edit button: fetch player data and show form
        $(document).on('click', '.edit-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                url: '{{ route('admin.players.edit', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    const player = response.player;
                    $('#players-list').addClass('d-none');
                    $('#player-form-container').removeClass('d-none');
                    $('#form-header').text('Edit Player');
                    $('#submit-btn').text('Edit Player');
                    $('#player-id').val(player.id);
                    $('#player-form [name="franchise_id"]').val(player.franchise_id);
                    $('#player-form [name="name"]').val(player.name);
                    $('#player-form [name="position"]').val(player.position);
                    if (player.photo) {
                        $('#photo-preview').removeClass('d-none').attr('src', '{{ asset('') }}' + player.photo);
                    } else {
                        $('#photo-preview').addClass('d-none').attr('src', '');
                    }
                    $('#player-form [name="profile"]').val(player.profile);
                    $('#player-form [name="youtube_link"]').val(player.youtube_link);
                    $('#player-form [name="status"]').val(player.status);
                    $('#message').addClass('d-none');
                },
                error: function(xhr) {
                    $('#message')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .text('Failed to load player data.');
                }
            });
        });

        // Delete button: confirm and mark as inactive
        $(document).on('click', '.delete-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            if (confirm('Are you sure you want to delete this player? This will mark them as inactive.')) {
                $.ajax({
                    url: '{{ route('admin.players.delete', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        row.find('td:eq(5)').text('inactive'); // Update status column
                        $('#message')
                            .removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text(response.message);
                    },
                    error: function(xhr) {
                        $('#message')
                            .removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Failed to delete player.');
                    }
                });
            }
        });

        // AJAX form submission (for both add and edit)
        $('#player-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#player-id').val();
            const url = id ? '{{ route('admin.players.edit', ':id') }}'.replace(':id', id) : '{{ route('admin.players.store') }}';
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

                    const player = response.player;
                    if (!id) { // New player
                        const newRow = `
                            <tr data-id="${player.id}">
                                <td>${player.id}</td>
                                <td>
                                    ${player.franchise && player.franchise.logo ? '<img src="{{ asset('') }}' + player.franchise.logo + '" alt="' + (player.franchise.name || 'Logo') + '" class="franchise-logo">' : ''}
                                    ${player.franchise ? player.franchise.name : 'N/A'}
                                </td>
                                <td>${player.name}</td>
                                <td>${player.position}</td>
                                <td>${player.photo ? '<img src="{{ asset('') }}' + player.photo + '" alt="Photo" style="max-width: 50px; max-height: 50px;">' : 'No Photo'}</td>
                                <td>${player.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>
                        `;
                        $('#players-table tbody').append(newRow);
                    } else { // Edited player
                        const row = $(`tr[data-id="${player.id}"]`);
                        row.find('td:eq(1)').html(
                            (player.franchise && player.franchise.logo ? '<img src="{{ asset('') }}' + player.franchise.logo + '" alt="' + (player.franchise.name || 'Logo') + '" class="franchise-logo">' : '') +
                            (player.franchise ? player.franchise.name : 'N/A')
                        );
                        row.find('td:eq(2)').text(player.name);
                        row.find('td:eq(3)').text(player.position);
                        row.find('td:eq(4)').html(player.photo ? '<img src="{{ asset('') }}' + player.photo + '" alt="Photo" style="max-width: 50px; max-height: 50px;">' : 'No Photo');
                        row.find('td:eq(5)').text(player.status);
                    }

                    $('#player-form-container').addClass('d-none');
                    $('#players-list').removeClass('d-none');
                    $('#player-form')[0].reset();
                    $('#photo-preview').addClass('d-none').attr('src', '');
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'An error occurred while saving the player.';
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
