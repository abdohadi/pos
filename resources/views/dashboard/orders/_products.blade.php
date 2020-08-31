<div id="print-area">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<td>@lang('site.name')</td>
				<td>@lang('site.quantity')</td>
				<td>@lang('site.price')</td>
			</tr>
		</thead>

		<tbody>
			@foreach ($products as $product)
				<tr>
					<td>{{ $product->name }}</td>
					<td>{{ $product->pivot->quantity }}</td>
					<td>{{ number_format($product->sale_price * $product->pivot->quantity, 2) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<h4>@lang('site.total'): <span class="total-price">{{ number_format($order->total_price, 2) }}</span></h4>
</div>

<button class="btn btn-primary btn-block print-btn"><i class="fa fa-print"></i> @lang('site.print')</button>