@extends('layout')
@section('title', 'Reports List')

@section('main')

<style>
body {
    background: #f4f6fb;
}

.page-wrapper {
    padding: 25px;
}

/* CARD */
.card-box {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    padding: 20px;
}

/* HEADER */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.header-bar h2 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

/* TABLE */
.table {
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
}

.table thead {
    background: #111827;
    color: #fff;
}

.table th {
    font-size: 13px;
    font-weight: 600;
    padding: 12px;
    white-space: nowrap;
}

.table td {
    font-size: 13px;
    padding: 12px;
    vertical-align: middle;
}

/* BUTTON */
.action-btn {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f8f9fa;
    transition: 0.2s;
    text-decoration: none;
}

.action-btn:hover {
    transform: translateY(-2px);
    background: #e9ecef;
}
</style>

<div class="page-wrapper">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="card-box">

            <!-- HEADER -->
            <div class="header-bar">
                <h2>  <i class="bi bi-file-earmark-text"> Reports List</i></h2>
            </div>

          
            <div class="table-responsive">
                <table class="table table-bordered table-sm">

                 <thead class="table-dark">
                        <tr>
                            <th width="80">No</th>
                            <th>Report Date</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- when data is used show the msg --}}
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>

                                <td>
                                      {{ date('d M Y', strtotime($report->report_date)) }}  {{-- convert string in time format --}}
                                </td>

                                <td>
                                    {{ basename($report->file_path) }}  {{-- extract only filename --}} 
                                </td>

                                <td class="d-flex gap-2">

                                    <!-- generate full public url , open new tab-->
                                    <a href="{{ asset('storage/' . $report->file_path) }}"
                                       target="_blank"
                                       class="action-btn text-primary"
                                       title="Download Report">

                                        <i class="bi bi-download"></i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No reports found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>  
</div>

@endsection