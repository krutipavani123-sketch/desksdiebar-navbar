@extends('layout')

@section('title', 'Edit User')

@section('main')




<div class="container d-flex justify-content-center">

    <div class="col-md-7">

        <div class="card shadow border-0 rounded-4">

            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Edit User</h4>
            </div>

            <div class="card-body p-4">
                   <form action="{{ route('users.update',$users->id) }}" method="post">
@csrf
  @method('PUT')
                        <div>
                            {{-- <label for="" class="text-lg font-medium">Edit Users</label> --}}
                         

                    <div class="mb-3">
                        <label class="form-label fw-semibold">User Name</label>
<input value="{{ old('name',$users->name) }}" name="name" type="text" class="form-control">
</div>
                       {{-- <div class="my-3">

                                <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3"></div> --}}
                                {{-- <input value="{{ old('name',$users->name) }}" name="name" type="text" class="border border-gray-300 shadow-sm w-1/2 rounded-lg"> --}}
<div class="mb-3">

 <label class="form-label fw-semibold">Email</label>
 <input value="{{ old('email',$users->email) }}" name="email"  type="text" class="form-control">
 </div>
{{-- </div>
                                <label for="" class="text-lg font-medium">Email</label>
                            <div class="my-3"></div>
                                <input value="{{ old('email',$users->email) }}" name="email" type="text" class="border border-gray-300 shadow-sm w-1/2 rounded-lg"> --}}

                                    @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                            </div>

                           <div class="mb-3">
                        <label class="form-label fw-semibold">Roles</label>
                        <div class="row">
                            @if($roles->isNotEmpty())
                                @foreach($roles as $role)
                                  <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                    {{-- {{ $hasPermissions->contains($user->name)? 'checked':'' }}  --}}
                                    <input type="checkbox" id="role-{{ $role->id }}" class="rounded" name="roles[]" value="{{ $role->name }}"
                                     {{ $users->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                    <label for="role-{{ $role->id }}" >{{ $role->name }}</label>
                               </div>
                                </div>
                                @endforeach
 </div>
                               
                                @endif
                          
                           
                                
                    
{{-- <label class="form-label fw-semibold">Permissions</label>
 <div class="row">
     @if($permissions->isNotEmpty())
                                @foreach($permissions as $permission)
                                  <div class="col-md-3 mt-2">
                                    <div class="form-check"> --}}
                                    {{-- {{ $hasPermissions->contains($user->name)? 'checked':'' }}  --}}
                                    {{-- <input type="checkbox" id="permission-{{ $permission->id }}" class="rounded" name="permissions[]" value="{{ $permission->name }}"
                                     {{ $users->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                    <label for="permission-{{ $permission->id }}" >{{ $permission->name }}</label>
                               </div>
                                </div>
                                @endforeach
 </div>
                               
                                @endif
                          
                           
                         </div> --}}


                          <button class="btn btn-success w-100">
                        Update User
                    </button>

                         </form>  
                    
                
                
            </div>
        </div>

    </div>
</div>

@endsection