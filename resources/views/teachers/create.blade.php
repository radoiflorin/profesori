@extends('layouts.app')
@section('title', 'Adauga Profesor - Admin Scoala')
@section('page-name', 'teacher-add')
@section('topbar-title', 'Adauga Profesor')
@section('topbar-subtitle', 'Completeaza formularul')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="app-card p-4">
            <form method="POST" action="{{ route('teachers.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nume *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Disciplina *</label>
                    <select class="form-select @error('subject') is-invalid @enderror" name="subject" required>
                        <option value="">-- Selecteaza --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" @if(old('subject') == $subject) selected @endif>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol *</label>
                    <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                        <option value="">-- Selecteaza --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" @if(old('role') == $role) selected @endif>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefon</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone') }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Observatii</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror"
                              name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Salveaza
                    </button>
                    <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Inapoi
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
