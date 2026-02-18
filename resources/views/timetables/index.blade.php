@extends('layouts.app')
@section('title', 'Orar - Admin Scoala')
@section('page-name', 'timetable')
@section('topbar-title', 'Orar Scoala')
@section('topbar-subtitle', 'Programul zilei')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Orar ({{ $timetables->total() }} ore)</h5>
    <a href="{{ route('timetables.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Adauga Ora
    </a>
</div>

<div class="app-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Profesor</th>
                    <th>Ziua</th>
                    <th>Ora</th>
                    <th>Clasa</th>
                    <th>Sala</th>
                    <th>Actiuni</th>
                </tr>
            </thead>
            <tbody>
                @forelse($timetables as $tt)
                    <tr>
                        <td><strong>{{ $tt->teacher->name }}</strong></td>
                        <td>{{ $tt->day }}</td>
                        <td>{{ $tt->start_time }} - {{ $tt->end_time }}</td>
                        <td>{{ $tt->class ?? '-' }}</td>
                        <td>{{ $tt->room ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('timetables.edit', $tt) }}" class="btn btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('timetables.destroy', $tt) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Sigur?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Nu exista ore</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($timetables->hasPages())
        <nav class="mt-4">
            {{ $timetables->links() }}
        </nav>
    @endif
</div>
@endsection
