@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.edit_order')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li><a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients')</a></li>
				<li class="active">@lang('site.edit_order')</li>
			</ol>
		</section>

		<section class="content">
			
			<div class="row">
				<div class="col-md-6">
					@include('dashboard.clients.orders._categories')
				</div>
				
				<div class="col-md-6">
					<div class="box box-primary">
					   <div class="box-header">
					     <h3 class="box-title">@lang('site.orders')</h3>
					   </div>
					   <!-- /.box-header -->
					   <div class="box-body">
				   		<form action="{{ route('dashboard.clients.orders.update', ['client'=>$client, 'order'=>$order]) }}" method="post">
						   	<table class="table table-bordered table-hover">
					   			@csrf
					   			@method('PUT')

						   		<thead>
						   			<th>@lang('site.product')</th>
						   			<th>@lang('site.quantity')</th>
						   			<th>@lang('site.price')</th>
						   		</thead>

						   		<tbody class="order-list">
						   			@foreach ($order->products as $product)
						   				<tr>
											<td>{{ $product->name }}</td>
											<td><input type="number" name="products[{{ $product->id }}][quantity]" class="form-control product-quantity" data-price="{{ number_format($product->sale_price, 2) }}" min="1" value="{{ $product->pivot->quantity }}"></td>
											<td class="product-price">{{ number_format($product->sale_price * $product->pivot->quantity, 2) }}</td>
											<td>
												<button class="btn btn-danger btn-sm remove-product-btn" 
														data-id="{{ $product->id }}"
														data-url="{{ route('dashboard.orders.removeProduct', [$client, $order, $product]) }}">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										</tr>
						   			@endforeach
						   		</tbody>
						   	</table>

					   		<h4>@lang('site.total'): <span class="total-price">{{ number_format($order->total_price, 2) }}</span></h4>

						   	<button class="btn btn-primary btn-block disabled" id="add-order-btn"><i class="fa fa-edit"></i> @lang('site.edit_order')</button>
							</form>
					   </div>
					</div>
					<!-- /.box-primary -->

					@include('dashboard.clients.orders._previous_orders')
				</div>
			</div>
		</section>
	</div>

@endsection