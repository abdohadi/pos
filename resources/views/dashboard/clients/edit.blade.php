@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.clients')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li><a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients')</a></li>
				<li class="active">@lang('site.edit')</li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">@lang('site.edit')</h3>
				</div>

				@include('partials._errors')

				<div class="box-body">
					<form action="{{ route('dashboard.clients.update', $client->id) }}" method="post">
						@csrf
						@method('PUT')

						<div class="form-group">
							<label for="name">@lang('site.name')</label>
							<input type="text" name="name" id="name" class="form-control" value="{{ $client->name }}">
						</div>

						@for ($i = 1; $i <= 2; $i++)
							<div class="form-group">
								<label for="phone{$i}">@lang("site.phone{$i}")</label>
								<input type="text" name="phone[]" id="phone{$i}" class="form-control" value="{{ $client->phone[$i-1] ?? '' }}">
							</div>
						@endfor

						<div class="form-group">
							<label for="address">@lang('site.address')</label>
							<textarea name="address" id="address" class="form-control">{{ $client->address }}</textarea>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>

@endsection