@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
					<div class="card-header">{{ __('Add Book') }} </div>

				<div class="card-body">
					<nav class="navbar navbar-inverse">
						<ul class="nav navbar-nav">
							<li><a href="{{ URL::to('books') }}">View All books</a></li>
						</ul>
					</nav>
					{{ Form::open(array('url' => 'books')) }}

						<div class="form-group">
							{{ Form::label('name', 'Name *') }}
							{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
							{!! $errors->first('name','<span class="help-inline text-danger">:message</span>') !!}
						</div>
						<div class="form-group">
							{{ Form::label('Tag', 'Tag *') }}
							{{ Form::select('tag[]', $tags, Input::old('tags'), array('class' => 'form-control tags','id' => 'tags','multiple' => 'multiple')) }}
							<ul>
							@if ($errors->has('tag.*') || $errors->has('tag'))
								<span class="help-inline text-danger">Tag must be selected</span>
							@endif
							</ul>
						</div>
						<div class="form-group">
							{{ Form::label('Author', 'Author *') }}
							{{ Form::select('author_id', $authors, Input::old('author_id'), array('class' => 'form-control')) }}
							{!! $errors->first('author_id','<span class="help-inline text-danger">:message</span>') !!}
						</div>
						{{ Form::submit('Add Book!', array('class' => 'btn btn-primary')) }}

					{{ Form::close() }}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
