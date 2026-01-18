@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h3>Verifiko Emailin</h3>
    <p>Ne kemi dërguar një link verifikimi në adresën tënde.</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-primary">Dërgo përsëri</button>
    </form>
</div>
@endsection
