 {{-- @can('manage team') --}}
 
 @extends('layout')
@section('title', 'Add Team')




@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team') }}
        </h2>
    </x-slot>

@endsection
@section('main')
   


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



   @include('message')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

       
             <div class="p-2 text-gray-900 dark:text-gray-100">

                <h2>Team List</h2>

                @can('create team')
<div class="mb-4 d-flex justify-content-end">

    <button type="button" 
            onclick="window.location.href='{{ route('team.create') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         Create Team
    </button>
</div>
@endcan

<table id="table"
    class="table table-bordered table-sm"
    data-toggle="table"
    data-pagination="true"
    data-page-size="3"
    data-side-pagination="client"
    data-height="auto"
     data-search="true"
    data-page-list="[3,5,10,25,50,100,200,All]">



    <thead class="bg-gray-50">
        <tr class="border-b">
            <th class="px-6 py-3 text-left" width="60">No</th>
            <th class="px-6 py-3 text-left">Team Name</th>
            <th class="px-6 py-3 text-left">Team Leader</th>
            <th class="px-6 py-3 text-left">Team Member Name</th> 
                        <th class="px-6 py-3 text-left">Agent</th>

            <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>

  <tbody class="bg-white">
    @foreach($teams as $team)
    <tr>
        <td class="px-6 py-3 text-left">{{ $team->id }}</td>
        <td class="px-6 py-3 text-left">{{ $team->teamName }}</td>
       <td class="px-6 py-3 text-left">
            @if($team->leader)            {{-- leader model method name  --}}
                {{ $team->leader->name }}
            @else
                <span style="color: #999; font-style: italic;">No Leader Assigned</span>
            @endif
        </td>
        <td class="px-6 py-3 text-left">
            @if($team->users->isNotEmpty())
                {{ $team->users->pluck('name')->implode(', ') }}
            @else
                <span class="text-gray-400 italic">No members assigned</span>
            @endif
        </td>

       <td class="px-6 py-3 text-left">
    @if($team->agent)
        {{ $team->agent->name }}
    @else
        <span class="text-gray-400 italic">No Agent assigned</span>
    @endif
</td>
        {{-- @can('edit team') --}}
        <td class="px-6 py-3 text-left">
            <a href="{{ route('team.edit', $team->id) }}">
                <i class="bi bi-pencil-square"></i>
            </a>
            {{-- @endcan
            @can('delete team') --}}
            <a href="{{ route('team.delete', $team->id) }}">
                <i class="bi bi-trash2-fill text-danger"></i>
            </a>
          
        </td> 
          {{-- @endcan --}}
    </tr>
    @endforeach
</tbody>

             {{-- <td class="px-6 py-3 text-left">{{ $team->created_at->format('d M, Y') }}</td> --}}

             {{-- <td class="px-6 py-3 text-left">

                <a href="{{ route('team.edit', $team->id) }}">
    <i class="bi bi-pencil-square"></i>
</a>

                <a href="{{ route('team.delete',$team->id) }}" ><i class="bi bi-trash2-fill"></i></a>
            </td> 
        </tr>
        @endforeach
    </tbody> --}}
</table>


            </div>
        </div>
    </div>
    </div>


@endsection
{{-- 
@endcan --}}


    <style>
.bootstrap-table .fixed-table-container {
    border-bottom: 0 !important;
    height: auto !important;
}

.bootstrap-table .fixed-table-body {
    height: auto !important;
}

.bootstrap-table .fixed-table-pagination {
    margin-top: 5px !important;
}

.bootstrap-table {
    margin-bottom: 0 !important;
}
</style>