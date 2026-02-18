@extends('layouts.app')

@section('title', 'Admin Scoala - Dashboard')
@section('page-name', 'dashboard')
@section('topbar-title', 'Dashboard')
@section('topbar-subtitle', 'Administrare Profesori si Orar')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <small>Total Profesori</small>
                <h3>{{ $totalTeachers }}</h3>
            </div>
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <small>Total Ore</small>
                <h3>{{ $totalTimetables }}</h3>
            </div>
            <div class="stat-icon"><i class="bi bi-clock-fill"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <small>Discipline Unice</small>
                <h3>{{ $uniqueSubjects }}</h3>
            </div>
            <div class="stat-icon"><i class="bi bi-book-fill"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <small>Mediu Ore/Zi</small>
                <h3>{{ round($totalTimetables / 5, 1) }}</h3>
            </div>
            <div class="stat-icon"><i class="bi bi-calculator-fill"></i></div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="app-card p-4">
            <h5 class="mb-3"><i class="bi bi-mortarboard"></i> Profesori Recenti</h5>
            <div class="list-group list-group-flush">
                @forelse($recentTeachers as $teacher)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $teacher->name }}</strong>
                            <small class="d-block text-muted">{{ $teacher->subject ?? 'N/A' }}</small>
                        </div>
                        <span class="badge bg-primary">{{ $teacher->role }}</span>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Nu exista profesori</p>
                @endforelse
            </div>
            <div class="mt-3">
                <a href="{{ route('teachers.index') }}" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-arrow-right"></i> Vezi Toti Profesorii
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="app-card p-4">
            <h5 class="mb-3"><i class="bi bi-graph-up"></i> Actiuni Rapide</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('teachers.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle"></i> Adauga Profesor
                </a>
                <a href="{{ route('timetables.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-calendar-plus"></i> Adauga Ora
                </a>
                <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-list"></i> Vezi Profesori
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
