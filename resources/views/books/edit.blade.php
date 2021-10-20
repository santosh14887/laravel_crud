@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
					<div class="card-header">{{ __('Edit Book') }} </div>

				<div class="card-body">
					<nav class="navbar navbar-inverse">
						<ul class="nav navbar-nav">
							<li><a href="{{ URL::to('books') }}">View All books</a></li>
						</ul>
					</nav>
					{{ Form::model($books, array('route' => array('books.update', $books->id), 'method' => 'PUT')) }}

						<div class="form-group">
							{{ Form::label('name', 'Name') }}
							{{ Form::text('name', null, array('class' => 'form-control')) }}
							{!! $errors->first('name','<span class="help-inline text-danger">:message</span>') !!}
						</div>
						<div class="form-group">
						@php
						$tag_selected = array();
						@endphp
						@foreach($books->tags as $values)
							@php
							$tag_selected[] = $values->id;
							@endphp
						@endforeach
							{{ Form::label('Tag', 'Tag *') }}
							<select class="form-control tags" multiple id="tags" name="tag[]">
							@foreach($tags as $tags_key => $tags_vals)
							@php
							$tagSelect = '';
							if(in_array($tags_key,$tag_selected))
							{
								$tagSelect = 'selected';
							}
							else{}
							@endphp
							<option value="{{$tags_key}}" {{$tagSelect}}>{{$tags_vals}}</option>
							@endforeach
							</select>
							<ul>
							@if ($errors->has('tag.*')  || $errors->has('tag'))
								<span class="help-inline text-danger">Tag must be selected</span>
							@endif
							</ul>
						</div>
						<div class="form-group">
							{{ Form::label('Author', 'Author *') }}
							{{ Form::select('author_id', $authors, null, array('class' => 'form-control')) }}
							{!! $errors->first('author_id','<span class="help-inline text-danger">:message</span>') !!}
						</div>
						{{ Form::submit('Edit books!', array('class' => 'btn btn-primary')) }}

					{{ Form::close() }}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
