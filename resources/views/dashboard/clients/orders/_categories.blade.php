<div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">@lang('site.categories') <small>({{ $categories->count() }})</small></h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
	   @foreach($categories as $index => $category)
	    <div id="accordion" class="panel-group">
	      <div class="panel panel-info">
	       <div class="panel-heading">
	        <h4 class="panel-title">
	          <a data-toggle="collapse" data-parent="#accordion" href="#{{ str_replace(' ', '-', $category->name) }}">
	            {{ $category->name }}
	          </a>
	        </h4>
	       </div>
	      </div>

	      <div id="{{ str_replace(' ', '-', $category->name) }}" class="panel-collapse collapse">
	        <div class="panel-body">
	          @if ($category->products->count())
	          	<table class="table table-bordered table-hover">
	          		<tr>
	          			<th>@lang('site.name')</th>
	          			<th>@lang('site.stock')</th>
	          			<th>@lang('site.price')</th>
	          			<th>@lang('site.add')</th>
	          		</tr>

	          		@foreach ($category->products as $product)
	          			<tr>
	          				<td>{{ $product->name }}</td>
	          				<td>{{ $product->stock }}</td>
	          				<td>{{ number_format($product->sale_price, 2) }}</td>
	          				<td>
	          					<a 
	          						href=""
	          						id="product-{{ $product->id }}"
	          						data-name="{{ $product->name }}"
	          						data-id="{{ $product->id }}"
	          						data-delete-url="{{ route('dashboard.orders.removeProduct', [$client, $order, $product]) }}"
	          						data-price="{{ $product->sale_price }}"
	          						class="btn btn-sm add-product-btn {{ isset($order) ? (in_array($product->id, $order->products->pluck('id')->toArray()) ? 'btn-default disabled' : 'btn-success') : 'btn-success'}}">
	          						<i class="fa fa-plus"></i>
	          					</a>
	          				</td>
	          			</tr>
	          		@endforeach
	          	</table>
	          @else
	          	<h4>@lang('site.no_records')</h4>
	          @endif
	        </div>
	      </div>
	    </div>
	   @endforeach
	</div>
	<!-- /.box-body -->
</div>
	<!-- /.box -->