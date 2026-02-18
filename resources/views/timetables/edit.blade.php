@extends('layouts.app')
@section('title', 'Editeaza Ora - Admin Scoala')
@section('page-name', 'timetable-edit')
@section('topbar-title', 'Editeaza Ora')
@section('topbar-subtitle', $timetable->teacher->name)

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="app-card p-4">
            <form method="POST" action="{{ route('timetables.update', $timetable) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Profesor *</label>
                    <select class="form-select @error('teacher_id') is-invalid @enderror" name="teacher_id" required>
                        <option value="">-- Selecteaza --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @if(old('teacher_id', $timetable->teacher_id) == $teacher->id) selected @endif>
                                {{ $teacher->name }} ({{ $teacher->subject }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ziua *</label>
                    <select class="form-select @error('day') is-invalid @enderror" name="day" required>
                        @foreach($days as $day)
                            <option value="{{ $day }}" @if(old('day', $timetable->day) == $day) selected @endif>{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Inceput *</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                               name="start_time" value="{{ old('start_time', $timetable->start_time) }}" required>
                        @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sfarsit *</label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                               name="end_time" value="{{ old('end_time', $timetable->end_time) }}" required>
                        @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Clasa</label>
                        <input type="text" class="form-control" name="class" value="{{ old('class', $timetable->class) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sala</label>
                        <input type="text" class="form-control" name="room" value="{{ old('room', $timetable->room) }}">
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Actualizeaza
                    </button>
                    <a href="{{ route('timetables.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Inapoi
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
