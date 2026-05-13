@extends('layout')
@section('title', 'Profile')

@section('main')
<h2>Profile Page</h2><br><br>

<p><strong>Name:</strong> {{ $user->name }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>

@endsection

<style>
h2, p {
    text-align: center;
    margin: 10px 0;
}
</style>
