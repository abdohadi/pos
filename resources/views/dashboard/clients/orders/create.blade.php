@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.add_order')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li><a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients')</a></li>
				<li class="active">@lang('site.add_order')</li>
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
				   		<form action="{{ route('dashboard.clients.orders.store', $client) }}" method="post">
						   	<table class="table table-bordered table-hover">
					   			@csrf

						   		<thead>
						   			<th>@lang('site.product')</th>
						   			<th>@lang('site.quantity')</th>
						   			<th>@lang('site.price')</th>
						   		</thead>

						   		<tbody class="order-list">
						   			{{-- order list from javascript --}}
						   		</tbody>
						   	</table>

					   		<h4>@lang('site.total'): <span class="total-price">0</span></h4>

						   	<button class="btn btn-primary btn-block disabled" id="add-order-btn"><i class="fa fa-plus"></i> @lang('site.add_order')</button>
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