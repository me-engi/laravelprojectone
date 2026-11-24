@extends('layouts.app')

@section('title', 'Dashboard - Student Management System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-3 border-bottom">
    <h1 class="h3 fw-bold">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('students.create') }}" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-person-plus"></i>
            <span>Add Student</span>
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <!-- Total Students -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase fw-semibold mb-1 opacity-75 small">Total Students</h6>
                    <h2 class="display-6 fw-bold mb-0">{{ $totalStudents }}</h2>
                </div>
                <div class="fs-1 opacity-50">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Male Students -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card bg-info text-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase fw-semibold mb-1 opacity-75 small">Male Students</h6>
                    <h2 class="display-6 fw-bold mb-0">{{ $maleStudents }}</h2>
                </div>
                <div class="fs-1 opacity-50">
                    <i class="bi bi-gender-male"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Female Students -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card bg-danger text-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase fw-semibold mb-1 opacity-75 small">Female Students</h6>
                    <h2 class="display-6 fw-bold mb-0">{{ $femaleStudents }}</h2>
                </div>
                <div class="fs-1 opacity-50">
                    <i class="bi bi-gender-female"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Other / Overview -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card bg-success text-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase fw-semibold mb-1 opacity-75 small">Other / Non-Binary</h6>
                    <h2 class="display-6 fw-bold mb-0">{{ $otherStudents }}</h2>
                </div>
                <div class="fs-1 opacity-50">
                    <i class="bi bi-gender-ambiguous"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recently Registered Students -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-bold mb-0 text-dark">
            <i class="bi bi-clock-history me-1 text-primary"></i> Recently Registered Students
        </h5>
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-3">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Course</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Enrollment Date</th>
                        <th scope="col" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentStudents as $student)
                        <tr>
                            <td class="ps-3 fw-semibold">#{{ $student->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $student->name }}</div>
                            </td>
                            <td>{{ $student->email }}</td>
                            <td><span class="badge bg-secondary">{{ $student->course }}</span></td>
                            <td>
                                @if($student->gender === 'Male')
                                    <span class="badge bg-info text-dark">Male</span>
                                @elseif($student->gender === 'Female')
                                    <span class="badge bg-danger-subtle text-danger">Female</span>
                                @else
                                    <span class="badge bg-light text-dark">Other</span>
                                @endif
                            </td>
                            <td>{{ $student->enrollment_date->format('M d, Y') }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                No students registered yet. Click "Add Student" to create your first record!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
