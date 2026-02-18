@extends('layouts.app')
@section('title', $teacher->name . ' - Admin Scoala')
@section('page-name', 'teacher-detail')
@section('topbar-title', 'Profil Profesor')
@section('topbar-subtitle', $teacher->name)

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="app-card p-4">
            <div class="text-center mb-4">
                <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            border-radius: 50%; display: flex; align-items: center; justify-content: center;
                            margin: 0 auto; color: white; font-size: 48px; font-weight: bold;">
                    {{ substr($teacher->name, 0, 1) }}
                </div>
            </div>
            <h5 class="text-center mb-1">{{ $teacher->name }}</h5>
            <p class="text-center text-muted mb-4">{{ $teacher->subject ?? 'N/A' }}</p>

            <div class="list-group list-group-flush">
                <div class="list-group-item">
                    <small class="text-muted">Rol</small>
                    <div><strong>{{ $teacher->role }}</strong></div>
                </div>
                <div class="list-group-item">
                    <small class="text-muted">Telefon</small>
                    <div><strong>{{ $teacher->phone ?? 'N/A' }}</strong></div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editeaza
                </a>
                <a href="{{ route('teachers.edit-profile', $teacher) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-file-person"></i> Profil Detaliat
                </a>
                <form method="POST" action="{{ route('teachers.destroy', $teacher) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Sigur?')">
                        <i class="bi bi-trash"></i> Sterge
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="app-card p-4">
            <h5 class="mb-3"><i class="bi bi-calendar3"></i> Orar Profesor</h5>
            @if($teacher->timetables->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Ziua</th>
                                <th>Ora</th>
                                <th>Clasa</th>
                                <th>Sala</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teacher->timetables->sortBy('day') as $tt)
                                <tr>
                                    <td>{{ $tt->day }}</td>
                                    <td>{{ $tt->start_time }} - {{ $tt->end_time }}</td>
                                    <td>{{ $tt->class ?? '-' }}</td>
                                    <td>{{ $tt->room ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-3">Nu exista ore programate</p>
            @endif
        </div>

        @if($teacher->profile)
            <div class="app-card p-4 mt-4">
                <h5 class="mb-3"><i class="bi bi-info-circle"></i> Informatii Profil</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted">CNP</small>
                        <div><strong>{{ $teacher->profile->cnp ?? '-' }}</strong></div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Email</small>
                        <div><strong>{{ $teacher->profile->email ?? '-' }}</strong></div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Data Nasterii</small>
                        <div><strong>{{ $teacher->profile->birth_date?->format('d.m.Y') ?? '-' }}</strong></div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Ore/Saptamana</small>
                        <div><strong>{{ $teacher->profile->teaching_hours_per_week ?? '-' }}</strong></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
