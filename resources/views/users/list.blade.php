@extends('layout')
@section('title', 'Roles List')

@section('main')

<div class="app-card">

    <div class="d-flex justify-content-between mb-3">
        <h4>Users List</h4>
         <button type="button" 
            onclick="window.location.href='{{ route('users.create') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         Create USer
    </button>
    </div>

    <table id="table"
           class="table table-bordered table-sm"
           data-toggle="table"
           data-pagination="true"
           data-page-size="3"
           data-side-pagination="client"
           data-height="auto"
           data-page-list="[3,5,10,25,50,100,200,All]">

        <thead>
            <tr> <!-- Fixed missing open row tag -->
                <th data-field="id" class="px-6 py-3 text-left" width="60">No</th>
                <th data-field="name" class="px-6 py-3 text-left">Name</th>
                <th data-field="role" class="px-6 py-3 text-left">Role</th>
                <th data-field="permissions" class="px-6 py-3 text-left">Permissions</th>
                <th data-field="created" class="px-6 py-3 text-left">Created</th>
                <th data-field="action" class="px-6 py-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody class="bg-white">
            @foreach($users as $user)
            <tr>
                <td class="px-6 py-3 text-left">{{ $user->id }}</td>
                <td class="px-6 py-3 text-left">{{ $user->name }}</td>
                <td class="px-6 py-3 text-left">
    {{ $user->roles->pluck('name')->implode(', ') }}

                     {{-- @forelse($user->roles as $role)
        <span class="text-muted">{{ $role->name }}</span>
    @empty
        <span class="text-muted">No Role</span>
    @endforelse --}}
                    {{-- @if($user->roles->isNotEmpty())
                        {{ $user->roles->pluck('name')->implode(', ') }}
                    @else
                        <span class="text-muted">No Role</span>
                    @endif --}}
                </td>



                <td class="px-6 py-3 text-left">

                  
    {{ $user->getAllPermissions()->pluck('name')->implode(', ') }}

                     {{-- @foreach($user->permissions as $permission)
 <span class="text-muted">{{ $permission->name }}</span>
                     @endforeach

                     @foreach($user->roles as $role)
                     @foreach($role->permissions as $permission)
                     <span class="text-muted">{{ $permission->name}}@unless($loop->last), @endunless</span>
                     @endforeach
                     @endforeach --}}
                    {{-- @if($user->roles->isNotEmpty())
                        {{ $user->roles->flatMap->permissions->pluck('name')->unique()->implode(', ') }}
                    @else
                        <span class="text-muted">No Permissions</span>
                    @endif --}}
                </td>


                <td class="px-6 py-3 text-left">{{ $user->created_at->format('d M, Y') }}</td>
                <td class="px-6 py-3 text-left">
                    <a href="{{ route('users.edit', $user->id) }}" class="me-2">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="{{ route('users.delete', $user->id) }}" class="text-danger">
                        <i class="bi bi-trash2-fill"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>


@endsection
