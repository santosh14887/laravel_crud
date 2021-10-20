@extends('layouts.app')

@section('content')
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('authors/create') }}">Create Author</a></li>
    </ul>
</nav>

<h1>Authors</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Name</td>
            <td>Status</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
	@if(count($authors) > 0)
    @foreach($authors as $key => $value)
        <tr>
            <td>{{ $value->name }}</td>
            <td>{{ ucfirst($value->status) }}</td>
            <td>
                {{ Form::open(array('url' => 'authors/' . $value->id, 'class' => 'btn btn-small btn-info')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-small btn-info')) }}
                {{ Form::close() }}
                <a class="btn btn-small btn-info" href="{{ URL::to('authors/' . $value->id . '/edit') }}">Edit</a>

            </td>
        </tr>
    @endforeach
	@else
	<tr>
	<td colspan="4">No data Found</td>
	</tr>
	@endif
    </tbody>
</table>
<div class="d-flex justify-content-center"> {!! $authors->links() !!} </div>
</div>
@endsection
