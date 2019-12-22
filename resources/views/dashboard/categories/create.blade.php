@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.categories')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li><a href="{{ route('dashboard.categories.index') }}"> @lang('site.categories')</a></li>
				<li class="active">@lang('site.add')</li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">@lang('site.add')</h3>
				</div>

				@include('partials._errors')

				<div class="box-body">
					<form action="{{ route('dashboard.categories.store') }}" method="post">
						@csrf

						@foreach (config('translatable.locales') as $locale)
							<div class="form-group">
								<label for="name">@lang('site.' .$locale. '.name')</label>
								{{-- ar => ['name' => 'ar name'] --}}
								{{-- en => ['name' => 'en name'] --}}
								<input type="text" name="{{ $locale }}[name]" id="name" class="form-control" value="{{ old($locale. '.name') }}" required>
							</div>
						@endforeach

						<div class="form-group">
							<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>

@endsection