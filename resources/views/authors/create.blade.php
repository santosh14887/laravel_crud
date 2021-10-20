@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
					<div class="card-header">{{ __('Add Author') }} </div>

				<div class="card-body">
					<nav class="navbar navbar-inverse">
						<ul class="nav navbar-nav">
							<li><a href="{{ URL::to('authors') }}">View All authors</a></li>
						</ul>
					</nav>
					{{ Form::open(array('url' => 'authors')) }}

						<div class="form-group">
							{{ Form::label('name', 'Name') }}
							{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
							{!! $errors->first('name','<span class="help-inline text-danger">:message</span>') !!}
						</div>
						<div class="form-group">
						@php
						$status_array = array('active' => 'Active', 'inactive' => 'Inactive');
						@endphp
							{{ Form::label('Status', 'Status') }}
							{{ Form::select('status', $status_array, Input::old('Status'), array('class' => 'form-control')) }}
							{!! $errors->first('status','<span class="help-inline text-danger">:message</span>') !!}
						</div>
						{{ Form::submit('Add Author!', array('class' => 'btn btn-primary')) }}

					{{ Form::close() }}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
