<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Admin - Events</title>
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
                <h2>Events (Tournament)</h2>
                <button id="show-form-btn" class="btn btn-primary">+ New Event</button>
            </div>

            <!-- Success/Error Message -->
            <div id="message" class="alert d-none"></div>

            <!-- Events Table -->
            <div class="card mb-4" id="events-list">
                <div class="card-body">
                    <table class="table table-striped" id="events-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Location</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr data-id="{{ $event->id }}">
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->event_name }}</td>
                                <td>{{ $event->event_start->format('Y-m-d H:i') }}</td>
                                <td>{{ $event->event_end->format('Y-m-d H:i') }}</td>
                                <td>{{ $event->event_location }}</td>
                                <td>
                                    @if($event->event_photo)
                                        <img src="{{ asset($event->event_photo) }}" alt="Photo" style="max-width: 50px; max-height: 50px;">
                                    @else
                                        No Photo
                                    @endif
                                </td>
                                <td>{{ $event->event_status }}</td>
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

            <!-- Event Form (Add/Edit) -->
            <div class="card d-none" id="event-form-container">
                <div class="card-header" id="form-header">Add New Event</div>
                <div class="card-body">
                    <form id="event-form" class="mx-auto" style="max-width: 60%;" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="event-id">
                        <div class="card p-4 shadow-sm border-0">
                            <div class="mb-3">
                                <label class="form-label">Event Name</label>
                                <input type="text" name="event_name" class="form-control" placeholder="Enter event name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="datetime-local" name="event_start" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="datetime-local" name="event_end" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="event_location" class="form-control" placeholder="Enter event location" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo</label>
                                <input type="file" name="event_photo" id="photo-input" class="form-control" accept=".png,.jpg,.jpeg">
                                <img id="photo-preview" class="photo-preview d-none" alt="Photo Preview">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">YouTube Link</label>
                                <input type="url" name="event_youtube_link" class="form-control" placeholder="Enter YouTube link (optional)">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Status</label>
                                <select name="event_status" class="form-select" required>
                                    <option value="" disabled>Select status</option>
                                    <option value="upcoming">Upcoming</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-25 me-2" id="submit-btn">Save Event</button>
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
        // Show form and hide list for adding new event
        $('#show-form-btn').on('click', function() {
            $('#events-list').addClass('d-none');
            $('#event-form-container').removeClass('d-none');
            $('#form-header').text('Add New Event');
            $('#submit-btn').text('Save Event');
            $('#event-id').val('');
            $('#event-form')[0].reset();
            $('#photo-preview').addClass('d-none').attr('src', '');
            $('#message').addClass('d-none');
        });

        // Cancel button: hide form and show list
        $('#cancel-form-btn').on('click', function() {
            $('#event-form-container').addClass('d-none');
            $('#events-list').removeClass('d-none');
            $('#event-form')[0].reset();
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

        // Edit button: fetch event data and show form
        $(document).on('click', '.edit-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                url: '{{ route('admin.events.edit', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    const event = response.event;

                    // Format dates for datetime-local input (YYYY-MM-DDTHH:mm)
                    const formatDateTime = (dateStr) => {
                        const date = new Date(dateStr);
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        return `${year}-${month}-${day}T${hours}:${minutes}`;
                    };

                    $('#events-list').addClass('d-none');
                    $('#event-form-container').removeClass('d-none');
                    $('#form-header').text('Edit Event');
                    $('#submit-btn').text('Update Event');
                    $('#event-id').val(event.id);
                    $('#event-form [name="event_name"]').val(event.event_name);
                    $('#event-form [name="event_start"]').val(formatDateTime(event.event_start));
                    $('#event-form [name="event_end"]').val(formatDateTime(event.event_end));
                    $('#event-form [name="event_location"]').val(event.event_location);
                    if (event.event_photo) {
                        $('#photo-preview').removeClass('d-none').attr('src', '{{ asset('') }}' + event.event_photo);
                    } else {
                        $('#photo-preview').addClass('d-none').attr('src', '');
                    }
                    $('#event-form [name="event_youtube_link"]').val(event.event_youtube_link);
                    $('#event-form [name="event_status"]').val(event.event_status);
                    $('#message').addClass('d-none');
                },
                error: function(xhr) {
                    $('#message')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .text('Failed to load event data.');
                }
            });
        });

        // Delete button: confirm and mark as completed
        $(document).on('click', '.delete-btn', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            if (confirm('Are you sure you want to delete this event? This will mark it as completed.')) {
                $.ajax({
                    url: '{{ route('admin.events.delete', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        row.find('td:eq(6)').text('completed'); // Update status column
                        $('#message')
                            .removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text(response.message);
                    },
                    error: function(xhr) {
                        $('#message')
                            .removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Failed to delete event.');
                    }
                });
            }
        });

        // AJAX form submission (for both add and edit)
        $('#event-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#event-id').val();
            const url = id ? '{{ route('admin.events.edit', ':id') }}'.replace(':id', id) : '{{ route('admin.events.store') }}';
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

                    const event = response.event;
                    const startDate = new Date(event.event_start).toLocaleString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false }).replace(',', '');
                    const endDate = new Date(event.event_end).toLocaleString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false }).replace(',', '');
                    if (!id) { // New event
                        const newRow = `
                            <tr data-id="${event.id}">
                                <td>${event.id}</td>
                                <td>${event.event_name}</td>
                                <td>${startDate}</td>
                                <td>${endDate}</td>
                                <td>${event.event_location}</td>
                                <td>${event.event_photo ? '<img src="{{ asset('') }}' + event.event_photo + '" alt="Photo" style="max-width: 50px; max-height: 50px;">' : 'No Photo'}</td>
                                <td>${event.event_status}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>
                        `;
                        $('#events-table tbody').append(newRow);
                    } else { // Edited event
                        const row = $(`tr[data-id="${event.id}"]`);
                        row.find('td:eq(1)').text(event.event_name);
                        row.find('td:eq(2)').text(startDate);
                        row.find('td:eq(3)').text(endDate);
                        row.find('td:eq(4)').text(event.event_location);
                        row.find('td:eq(5)').html(event.event_photo ? '<img src="{{ asset('') }}' + event.event_photo + '" alt="Photo" style="max-width: 50px; max-height: 50px;">' : 'No Photo');
                        row.find('td:eq(6)').text(event.event_status);
                    }

                    $('#event-form-container').addClass('d-none');
                    $('#events-list').removeClass('d-none');
                    $('#event-form')[0].reset();
                    $('#photo-preview').addClass('d-none').attr('src', '');
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'An error occurred while saving the event.';
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
