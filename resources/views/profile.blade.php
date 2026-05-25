@extends('layout')

@section('title', 'Profile')

@section('main')

<div class="container py-4">

    <div class="profile-header mb-4">
        <h3 class="fw-bold">👤 My Profile</h3>
        <p class="text-muted">Your account information</p>
    </div>

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card profile-card shadow-sm border-0">

                <div class="card-body text-center p-4">

                    <!-- Avatar -->
                    <div class="avatar mb-3">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    <p class="text-muted mb-4">{{ $user->email }}</p>

                    <hr>

                    <div class="info-box text-start">

                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Name</span>
                            <span class="fw-semibold">{{ $user->name }}</span>
                        </div>

                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Email</span>
                            <span class="fw-semibold">{{ $user->email }}</span>
                        </div>

                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Joined</span>
                            <span class="fw-semibold">
                                {{ $user->created_at->format('M d, Y') }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')
<style>
.profile-card {
    border-radius: 18px;
    transition: 0.3s;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
}

.avatar i {
    font-size: 80px;
    color: #4f46e5;
}

.info-box {
    font-size: 15px;
}
</style>
@endpush