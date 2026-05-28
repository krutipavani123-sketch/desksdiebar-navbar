@extends('layout')

@section('title', 'Add Roles')

@section('main')

<style>
    body {
        background: #f4f6fb;
    }

    .role-wrapper {
        min-height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .role-card {
        width: 100%;
        max-width: 700px;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 28px;
        transition: 0.3s;
    }

    .role-card:hover {
        transform: translateY(-3px);
    }

    .role-title {
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #444;
    }

    input[type="text"] {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        transition: 0.2s;
        font-size: 14px;
    }

    input[type="text"]:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 6px rgba(13,110,253,0.25);
    }

    .permission-box {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        margin-top: 10px;
    }

    .permission-item {
        background: #f8f9fa;
        padding: 10px 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: 0.2s;
        border: 1px solid transparent;
    }

    .permission-item:hover {
        background: #eef2ff;
        border-color: #dbe4ff;
        transform: scale(1.02);
    }

    .permission-item input {
        transform: scale(1.1);
        cursor: pointer;
    }

    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, #0d6efd, #4a90e2);
        border: none;
        padding: 12px;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        margin-top: 18px;
        transition: 0.3s;
        letter-spacing: 0.3px;
    }

    .btn-save:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 18px rgba(13,110,253,0.25);
    }

    .error-text {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<div class="role-wrapper">

    <div class="role-card">

        <div class="role-title">
            Add Roles
        </div>

        <form action="{{ route('roles.addrole') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Role Name</label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter role name">

                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Permissions</label>

                <div class="permission-box">
                    @foreach($permissions as $permission)
                        <label class="permission-item">
                            <input type="checkbox"
                                   name="permission[]"
                                   value="{{ $permission->name }}">
                            <span>{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn-save">
                Save Role
            </button>

        </form>

    </div>

</div>

@endsection