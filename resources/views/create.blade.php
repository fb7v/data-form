@extends('layouts.main')

@section('content')
    <form action="{{ url('/upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload XML file:</label>
        <input type="file" name="file" accept=".xml" required>
        <button type="submit">Upload</button>
    </form>
@endsection