@extends('layouts.app')
@section('content')

@if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin'))

<div class="container">
	<div class="page-header">
		<h3>Генератор</h3>
	</div>
	<generator></generator>
</div>

@else
    
    <div class="head">
		<div class="face">
			<div class="eyes">
				<div class="eye first"></div>
				<div class="eye second"></div>
			</div>
			<div class="mouth"></div>
		</div>
	</div>

@endif
@endsection