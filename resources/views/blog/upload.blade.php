@extends('layouts.app')

@section('title', 'загрузка файлов - ТЕСТ')

@section('content')

	<div class="container">
		<form action="{{route('upload')}}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			
			<input type="file" name="file">
            <button type="submit">Загрузить</button>
		</form>
	</div>
@endsection
