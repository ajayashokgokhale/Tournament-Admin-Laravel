<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Admin - Contests</title>
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
        @include('admin/left-nav')

        <!-- Right Content -->
        <main class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Contests (Matches)</h2>
                <button id="show-form-btn" class="btn btn-primary">+ New Contest</button>
            </div>

            <!-- Success/Error Message -->
            <div id="message" class="alert d-none"></div>

            <!-- Contests Table -->
            <div class="card mb-4" id="contests-list">
                <div class="card-body">
                    <table class="table table-striped" id="contests-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Date/Time</th>
                            <th>Location</th>
                            <th>Event</th>
                            <th>Team 1</th>
                            <th>Team 2</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contests as $contest)
                            <tr data-id="{{ $contest->id }}">
                                <td>{{ $contest->id }}</td>
                                <td>{{ $contest->match_title }}</td>
                                <td>{{ $contest->match_datetime ? $contest->match_datetime->format('Y-m-d H:i') : 'N/A' }}</td>
                                <td>{{ $contest->match_location }}</td>
                                <td>{{ $contest->event->event_name ?? 'N/A' }}</td>
                                <td>{{ $contest->franchise1->name ?? 'N/A' }}</td>
                                <td>{{ $contest->franchise2->name ?? 'N/A' }}</td>
                                <td>{{ $contest->score_1 }} - {{ $contest->score_2 }}</td>
                                <td>{{ $contest->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" type="button">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn" type="button">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contest Form (Add/Edit) -->
            <div class="card d-none" id="contest-form-container">
                <div class="card-header" id="form-header">Add New Contest</div>
                <div class="card-body">
                    <form id="contest-form" class="mx-auto" style="max-width: 60%;">
                        @csrf
                        <input type="hidden" name="id" id="contest-id">
                        <div class="card p-4 shadow-sm border-0">
                            <div class="mb-3">
                                <label class="form-label">Contest Title</label>
                                <input type="text" name="match_title" class="form-control" placeholder="Enter contest title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date/Time</label>
                                <input type="datetime-local" name="match_datetime" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="match_location" class="form-control" placeholder="Enter contest location" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Event</label>
                                <select name="event_id" class="form-select" required>
                                    <option value="" disabled selected>Select event</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Team 1</label>
                                <select name="franchises_1_id" class="form-select" required>
                                    <option value="" disabled selected>Select team 1</option>
                                    @foreach($franchises as $franchise)
                                        <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Team 2</label>
                                <select name="franchises_2_id" class="form-select" required>
                                    <option value="" disabled selected>Select team 2</option>
                                    @foreach($franchises as $franchise)
                                        <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Score Team 1</label>
                                <input type="number" name="score_1" class="form-control" placeholder="Enter score for team 1" min="0" value="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Score Team 2</label>
                                <input type="number" name="score_2" class="form-control" placeholder="Enter score for team 2" min="0" value="0">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="" disabled>Select status</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="live">Live</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-25 me-2" id="submit-btn">Save Contest</button>
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
        // Show form and hide list for adding new contest
        $('#show-form-btn').on('click', function() {
            $('#contests-list').addClass('d-none');
            $('#contest-form-container').removeClass('d-none');
            $('#form-header').text('Add New Contest');
            $('#submit-btn').text('Save Contest');
            $('#contest-id').val('');
            $('#contest-form')[0].reset();
            $('#message').addClass('d-none');
        });

        // Cancel button: hide form and show list
        $('#cancel-form-btn').on('click', function() {
            $('#contest-form-container').addClass('d-none');
            $('#contests-list').removeClass('d-none');
            $('#contest-form')[0].reset();
            $('#message').addClass('d-none');
        });

        // Edit button: fetch contest data and show form
        $(document).on('click', '.edit-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                url: '{{ route('admin.contests.update', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    const match = response.match;

                    // Format datetime for datetime-local input (YYYY-MM-DDTHH:mm)
                    const formatDateTime = (dateStr) => {
                        if (!dateStr) return '';
                        const date = new Date(dateStr);
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        return `${year}-${month}-${day}T${hours}:${minutes}`;
                    };

                    $('#contests-list').addClass('d-none');
                    $('#contest-form-container').removeClass('d-none');
                    $('#form-header').text('Edit Contest');
                    $('#submit-btn').text('Update Contest');
                    $('#contest-id').val(match.id);
                    $('#contest-form [name="match_title"]').val(match.match_title);
                    $('#contest-form [name="match_datetime"]').val(formatDateTime(match.match_datetime));
                    $('#contest-form [name="match_location"]').val(match.match_location);
                    $('#contest-form [name="event_id"]').val(match.event_id);
                    $('#contest-form [name="franchises_1_id"]').val(match.franchises_1_id);
                    $('#contest-form [name="franchises_2_id"]').val(match.franchises_2_id);
                    $('#contest-form [name="score_1"]').val(match.score_1);
                    $('#contest-form [name="score_2"]').val(match.score_2);
                    $('#contest-form [name="status"]').val(match.status);
                    $('#message').addClass('d-none');
                },
                error: function(xhr) {
                    $('#message')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .text('Failed to load contest data.');
                }
            });
        });

        // Delete button: confirm and mark as completed
        $(document).on('click', '.delete-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            if (confirm('Are you sure you want to delete this contest? This will mark it as completed.')) {
                $.ajax({
                    url: '{{ route('admin.contests.delete', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        row.find('td:eq(8)').text('completed'); // Update status column
                        $('#message')
                            .removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text(response.message);
                    },
                    error: function(xhr) {
                        $('#message')
                            .removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Failed to delete contest.');
                    }
                });
            }
        });

        // AJAX form submission (for both add and edit)
        $('#contest-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#contest-id').val();
            const url = id ? '{{ route('admin.contests.update', ':id') }}'.replace(':id', id) : '{{ route('admin.contests.store') }}';
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

                    const match = response.match;
                    const dateTime = match.match_datetime ? new Date(match.match_datetime).toLocaleString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false }).replace(',', '') : 'N/A';
                    if (!id) { // New contest
                        const newRow = `
                            <tr data-id="${match.id}">
                                <td>${match.id}</td>
                                <td>${match.match_title}</td>
                                <td>${dateTime}</td>
                                <td>${match.match_location}</td>
                                <td>${match.event ? match.event.event_name : 'N/A'}</td>
                                <td>${match.franchise1 ? match.franchise1.name : 'N/A'}</td>
                                <td>${match.franchise2 ? match.franchise2.name : 'N/A'}</td>
                                <td>${match.score_1} - ${match.score_2}</td>
                                <td>${match.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>
                        `;
                        $('#contests-table tbody').append(newRow);
                    } else { // Edited contest
                        const row = $(`tr[data-id="${match.id}"]`);
                        row.find('td:eq(1)').text(match.match_title);
                        row.find('td:eq(2)').text(dateTime);
                        row.find('td:eq(3)').text(match.match_location);
                        row.find('td:eq(4)').text(match.event ? match.event.event_name : 'N/A');
                        row.find('td:eq(5)').text(match.franchise1 ? match.franchise1.name : 'N/A');
                        row.find('td:eq(6)').text(match.franchise2 ? match.franchise2.name : 'N/A');
                        row.find('td:eq(7)').text(`${match.score_1} - ${match.score_2}`);
                        row.find('td:eq(8)').text(match.status);
                    }

                    $('#contest-form-container').addClass('d-none');
                    $('#contests-list').removeClass('d-none');
                    $('#contest-form')[0].reset();
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'An error occurred while saving the contest.';
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
