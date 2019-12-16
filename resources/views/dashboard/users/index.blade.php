@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.users')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li class="active">@lang('site.users')</li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">@lang('site.users') <small>({{ $users->total() }})</small></h3>

					<form action="{{ route('dashboard.users.index') }}" method="get">
						<div class="row">
							<div class="col-md-6" style="display: flex;margin-top: 15px">
								<input type="text" name="search" placeholder="@lang('site.search')" value="{{ request('search') ?? '' }}" style="min-width: 67%;margin-left: 5px;">
								
								<button type="submit" class="btn btn-primary" style="margin-left: 15px;"><i class="fa fa-search"></i> @lang('site.search')</button>
								
								@if (auth()->user()->hasPermission('create_users'))
									<a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
								@else
									<button class="btn btn-primary disabled" title="You have no permission to do this action"><i class="fa fa-plus"></i> @lang('site.add')</button>
								@endif
							</div>
						</div>
					</form>
				</div>

				<div class="box-body">
					@if ($users->count())
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>@lang('site.first_name')</th>
									<th>@lang('site.last_name')</th>
									<th>@lang('site.email')</th>
									<th>@lang('site.action')</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($users as $index => $user)
									<tr>
										<td>{{ $index }}</td>
										<td>{{ $user->first_name }}</td>
										<td>{{ $user->last_name }}</td>
										<td>{{ $user->email }}</td>
										<td>
											@if (auth()->user()->hasPermission('update_users'))
												<a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
											@else
												<button class="btn btn-info btn-sm disabled" title="You have no permission to do this action"><i class="fa fa-edit"></i> @lang('site.edit')</button>
											@endif

											@if (auth()->user()->hasPermission('delete_users'))
												<form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post" style="display: inline-block;">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i> @lang('site.delete')</button>
												</form>
											@else
												<button class="btn btn-danger btn-sm disabled" title="You have no permission to do this action"><i class="fa fa-remove"></i> @lang('site.delete')</button>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
						<h3>@lang('site.no_data_found')</h3>
					@endif

					{{ $users->appends(request()->query())->links() }}
				</div>
			</div>
		</section>
	</div>

@endsection