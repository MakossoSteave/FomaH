@extends('layouts.app')
@section('content')
<a href="{{ route('logout')}}"
    class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Deconnection</a>
</li>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection