@extends('layout')

@section('content')
<h1>Contact Page!</h1>


@can('home.secret')
 <p>Special contact details.</p>
 <a href="{{ route('secret') }}">Go to Special Contact Details</a>
@endcan

@endsection

