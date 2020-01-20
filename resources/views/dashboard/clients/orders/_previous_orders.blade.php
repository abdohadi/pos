@if ($orders->count())
	<div class="box box-primary">
		<div class="box-header">
		  <h3 class="box-title">@lang('site.previous_orders') <small>({{ $orders->total() }})</small></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
		   @foreach($orders as $order)
		    <div id="accordion" class="panel-group">
		      <div class="panel panel-success">
		       <div class="panel-heading">
		        <h4 class="panel-title">
		          <a data-toggle="collapse" data-parent="#accordion" href="#{{ $order->created_at->format('d-m-Y-s') }}">
		            {{ $order->created_at->toFormattedDateString() }}
		          </a>
		        </h4>
		       </div>
		      </div>

		      <div id="{{ $order->created_at->format('d-m-Y-s') }}" class="panel-collapse collapse">
		        <div class="panel-body">
		          <table class="table table-bordered table-hover">
		          	<thead>
		          		<tr>
		          			<th>@lang('site.products')</th>
		          		</tr>
		          	</thead>

		          	<tbody>
				         @foreach ($order->products as $product)
			          		<tr>
					          	<td class="list-group-item">{{ $product->name }}</td>
					         </tr>
				         @endforeach
				      </tbody>
		          </table>

		          <h4>@lang('site.total_price'): {{ number_format($order->total_price) }}</h4>
		        </div>
		      </div>
		    </div>
		   @endforeach

		   {{ $orders->links() }}
		</div>
		<!-- /.box-body -->
	</div>
 	<!-- /.box -->
@endif