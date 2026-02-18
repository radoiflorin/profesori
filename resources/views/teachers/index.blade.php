@extends('layouts.app')
@section('title', 'Profesori - Admin Scoala')
@section('page-name', 'teachers')
@section('topbar-title', 'Profesori')
@section('topbar-subtitle', 'Lista toti profesori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Lista Profesori ({{ $teachers->total() }})</h5>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Adauga Profesor
    </a>
</div>

<div class="app-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nume</th>
                    <th>Disciplina</th>
                    <th>Rol</th>
                    <th>Telefon</th>
                    <th>Actiuni</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td><strong>{{ $teacher->name }}</strong></td>
                        <td>{{ $teacher->subject ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $teacher->role }}</span></td>
                        <td>{{ $teacher->phone ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-outline-primary" title="Profil">
                                    <i class="bi bi-person-badge"></i>
                                </a>
                                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-outline-warning" title="Editeaza">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Sigur?')" title="Sterge">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Nu exista profesori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($teachers->hasPages())
        <nav class="mt-4">
            {{ $teachers->links() }}
        </nav>
    @endif
</div>
@endsection
