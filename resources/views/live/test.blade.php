@extends('layouts.app')

@section('title', '{{ $title }}')

@section('content')

	<form>
		<send-code-field></send-code-field>
	</form>

@endsection