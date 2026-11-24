@extends('layouts.app')

@section('title', 'Student Management - StudentMS')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-3 border-bottom">
    <h1 class="h3 fw-bold">Student Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('students.create') }}" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-person-plus-fill"></i>
            <span>Add New Student</span>
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <!-- Search Form -->
        <form action="{{ route('students.index') }}" method="GET" class="row g-2 align-items-center mb-3">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                    @if(request('search'))
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary" title="Clear Search">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </div>
            @if(request('search'))
                <div class="col-12 text-muted small">
                    Showing results for search: "<strong>{{ request('search') }}</strong>"
                </div>
            @endif
        </form>

        <!-- Students Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-striped-columns">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="ps-3">ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Course</th>
                        <th scope="col">Enrollment Date</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td class="ps-3 fw-semibold">#{{ $student->id }}</td>
                            <td class="fw-bold">{{ $student->name }}</td>
                            <td><a href="mailto:{{ $student->email }}" class="text-decoration-none">{{ $student->email }}</a></td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                @if($student->gender === 'Male')
                                    <span class="badge bg-info text-dark">Male</span>
                                @elseif($student->gender === 'Female')
                                    <span class="badge bg-danger text-white">Female</span>
                                @else
                                    <span class="badge bg-secondary">Other</span>
                                @endif
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $student->course }}</span></td>
                            <td>{{ $student->enrollment_date->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-warning" title="Edit Student">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <!-- Delete Button triggers confirmation modal -->
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-student-id="{{ $student->id }}" 
                                            data-student-name="{{ $student->name }}"
                                            title="Delete Student">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                @if(request('search'))
                                    No students found matching "<strong>{{ request('search') }}</strong>".
                                    <div class="mt-2">
                                        <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">Clear Search Filter</a>
                                    </div>
                                @else
                                    No students available in the database.
                                    <div class="mt-2">
                                        <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">Add Your First Student</a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted">
                Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
            </div>
            <div>
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete student <strong id="deleteStudentName"></strong>?
                <p class="text-danger small mt-2 mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const studentId = button.getAttribute('data-student-id');
            const studentName = button.getAttribute('data-student-name');

            document.getElementById('deleteStudentName').textContent = studentName;
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/students/${studentId}`;
        });
    }
</script>
@endpush
