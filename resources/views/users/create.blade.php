    @extends('layout')

    @section('title', 'Create User')

    @section('main')

    <style>
        body { background: #f4f6fb; }
        .role-wrapper { min-height: 85vh; display: flex; justify-content: center; align-items: center; }
        .role-card { width: 100%; max-width: 650px; background: #ffffff; border-radius: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 25px; transition: 0.3s; }
        .role-card:hover { transform: translateY(-3px); }
        .role-title { font-size: 22px; font-weight: 700; text-align: center; margin-bottom: 20px; color: #333; }
        .form-label { font-weight: 600; margin-bottom: 6px; display: block; margin-top: 10px; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 10px; outline: none; transition: 0.2s; }
        input:focus { border-color: #0d6efd; box-shadow: 0 0 5px rgba(13,110,253,0.3); }
        .permission-box { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-top: 10px; }
        .permission-item { background: #f8f9fa; padding: 8px 10px; border-radius: 10px; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: 0.2s; }
        .permission-item:hover { background: #e9ecef; }
        .btn-save { width: 100%; background: linear-gradient(135deg, #0d6efd, #4a90e2); border: none; padding: 10px; color: white; font-weight: 600; border-radius: 10px; margin-top: 25px; transition: 0.3s; }
        .btn-save:hover { transform: scale(1.02); }
    </style>

    <div class="role-wrapper">
        <div class="role-card">
            <div class="role-title">Create User & Assign Roles</div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-danger mt-1" style="font-size: 14px;">{{ $message }}</p>
                    @enderror

                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-danger mt-1" style="font-size: 14px;">{{ $message }}</p>
                    @enderror

                    <label class="form-label">Password</label>
                    <input type="password" name="password">
                    @error('password')
                        <p class="text-danger mt-1" style="font-size: 14px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-top: 15px;">
                    <label class="form-label">Roles</label>

                    <div class="roles-grid">

                        @if($roles->isNotEmpty())
                            @foreach($roles as $role)
                                <label class="roles-item">
                                    <input type="checkbox"
                                        id="role-{{ $role->id }}"
                                        name="roles[]"
                                        value="{{ $role->name }}">
                                    <span>{{ $role->name }}</span>
                                </label>
                            @endforeach
                        @endif

                    </div>
                </div>


                {{-- <div style="margin-top: 15px;">
                    <label class="form-label">Permissions</label>

                    <div class="permission-grid">

                        @if($permissions->isNotEmpty())
                            @foreach($permissions as $permission)
                                <label class="permission-item">
                                    <input type="checkbox"
                                        id="permission-{{ $permission->id }}"
                                        name="permission[]"
                                        value="{{ $permission->name }}">
                                    <span>{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        @endif

                    </div>
                </div> --}}


                <button type="submit" class="btn-save">Save User</button>
            </form>
        </div>
    </div>

    @endsection
