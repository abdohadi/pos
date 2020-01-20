@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.orders')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li class="active">@lang('site.orders')</li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-8">
				 <div class="box box-primary">
				   <div class="box-header with-border">
						<h3 class="box-title">@lang('site.orders') <small>({{ $orders->total() }})</small></h3>

						<!-- Search form -->
						<form action="{{ route('dashboard.orders.index') }}" method="get">
							<div class="row">
								<div class="col-md-6" style="display: flex;margin-top: 15px">
									<input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request('search') ?? '' }}" style="min-width: 67%;margin: 0 5px;">
									
									<!-- Search btn -->
									<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
								</div>
							</div>
						</form>
					</div>

					<div class="box-body">
						@if (count($orders))
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>@lang('site.client_name')</th>
										<th>@lang('site.price')</th>
										<th>@lang('site.created_at')</th>
										<th>@lang('site.action')</th>
									</tr>
								</thead>

								<tbody>
									@foreach ($orders as $index => $order)
										<tr>
											<td>{{ $index + 1 }}</td>
											<td>{{ $order->client->name }}</td>
											<td>{{ number_format($order->total_price, 2) }}</td>
											<td>{{ $order->created_at->toFormattedDateString() }}</td>
											<td>	
												{{-- show order products btn --}}
												<button class="btn btn-primary btn-sm show-order-products-btn" 
													data-url="{{ route('dashboard.orders.products', $order->id) }}"
													data-method="get">
													<i class="fa fa-list"></i> @lang('site.show')</button>

												{{-- edit order btn --}}
												@if (auth()->user()->hasPermission('update_orders'))
													<a href="{{ route('dashboard.clients.orders.edit', ['client'=>$order->client->id, 'order'=>$order->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
												@else
													<button class="btn btn-info btn-sm disabled" title="You have no permission to do this action"><i class="fa fa-edit"></i> @lang('site.edit')</button>
												@endif

												{{-- delete order btn --}}
												@if (auth()->user()->hasPermission('delete_orders'))
													<form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="post" style="display: inline-block;">
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

						{{ $orders->appends(request()->query())->links() }}
					</div>
				   <!-- /.box-body -->
				 </div>
				 <!-- /.box -->
				</div>
				
				<div class="col-md-4">
					<div class="box box-primary">
					   <div class="box-header">
					     <h3 class="box-title">@lang('site.show_products')</h3>
					   </div>
					   <!-- /.box-header -->
					   <div class="box-body">
				   		<div style="display: none;" class="text-center" id="loading">
				   			<div class="loader" style="margin: auto;"></div>
				   			<p>@lang('site.loading')</p>
				   		</div>

				   		<div id="order-products-list">
				   			{{-- products shown by ajax --}}
				   		</div>
					   </div>
					</div>
				</div>
			</div>
		</section>
	</div>

@endsection