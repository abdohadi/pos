@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.clients')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li class="active">@lang('site.clients')</li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">@lang('site.clients') <small>({{ $clients->total() }})</small></h3>

					<!-- Search form -->
					<form action="{{ route('dashboard.clients.index') }}" method="get">
						<div class="row">
							<div class="col-md-6" style="display: flex;margin-top: 15px">
								<input type="text" name="search" placeholder="@lang('site.search')" value="{{ request('search') ?? '' }}" style="min-width: 67%;margin: 0 5px;">
								
								<!-- Search btn -->
								<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
								
								<!-- Add btn -->
								@if (auth()->user()->hasPermission('create_clients'))
									<a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary" style="margin: 0 15px;"><i class="fa fa-plus"></i> @lang('site.add')</a>
								@else
									<button class="btn btn-primary disabled" title="You have no permission to do this action" style="margin: 0 15px;"><i class="fa fa-plus"></i> @lang('site.add')</button>
								@endif
							</div>
						</div>
					</form>
				</div>

				<div class="box-body">
					@if (count($clients))
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>@lang('site.name')</th>
									<th>@lang('site.phone')</th>
									<th>@lang('site.address')</th>
									<th>@lang('site.add_order')</th>
									<th>@lang('site.action')</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($clients as $index => $client)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $client->name }}</td>
										<td>{{ implode('-', $client->phone) }}</td>
										<td>{{ $client->address }}</td>
										<td>
											@if (auth()->user()->hasPermission('create_orders'))
												<a href="{{ route('dashboard.clients.orders.create', $client->id) }}" class="btn btn-primary btn-sm">@lang('site.add_order')</a>
											@else
												<a href="{{ route('dashboard.clients.orders.create', $client->id) }}" class="btn btn-primary btn-sm disabled">@lang('site.add_order')</a>
											@endif
										</td>
										<td>
											@if (auth()->user()->hasPermission('update_clients'))
												<a href="{{ route('dashboard.clients.edit', $client->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
											@else
												<button class="btn btn-info btn-sm disabled" title="You have no permission to do this action"><i class="fa fa-edit"></i> @lang('site.edit')</button>
											@endif

											@if (auth()->user()->hasPermission('delete_clients'))
												<form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="post" style="display: inline-block;">
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

					{{ $clients->appends(request()->query())->links() }}
				</div>
			</div>
		</section>
	</div>

@endsection