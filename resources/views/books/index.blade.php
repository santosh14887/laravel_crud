@extends('layouts.app')

@section('content')
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('books/create') }}">Create Book</a></li>
    </ul>
</nav>

<h1>Books</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Name</td>
            <td>Author</td>
            <td>Tags</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
	@if(count($books) > 0)
    @foreach($books as $key => $value)
        <tr>
            <td>{{ $value->name }}</td>
            <td>{{ $value->getAuthor->name }}</td>
            <td>
			<ul>
				@foreach($value->tags as $tag)
				<li>{{ $tag->name }}</li>
				@endforeach
			</ul>
			</td>
            <td>
                {{ Form::open(array('url' => 'books/' . $value->id, 'class' => 'btn btn-small btn-info')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-small btn-info')) }}
                {{ Form::close() }}
                <a class="btn btn-small btn-info" href="{{ URL::to('books/' . $value->id . '/edit') }}">Edit</a>
                <a class="btn btn-small btn-info" href="{{ URL::to('books/' . $value->id . '/review') }}">
				@if(null !== $value->reviews && count($value->reviews ) > 0)
				Add / List Review
				@else
				Add Review
				@endif
				
				</a>

            </td>
        </tr>
    @endforeach
	@else
	<tr>
	<td colspan="5">No data Found</td>
	</tr>
	@endif
    </tbody>
</table>
<div class="d-flex justify-content-center"> {!! $books->links() !!} </div>
</div>
@endsection
