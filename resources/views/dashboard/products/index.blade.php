@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.products')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li class="active">@lang('site.products')</li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">@lang('site.products') <small>({{ $products->total() }})</small></h3>

					<!-- Search form -->
					<form action="{{ route('dashboard.products.index') }}" method="get">
						<div class="row">
							<div class="col-md-6" style="display: flex;margin-top: 15px">
								<input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request('search') ?? '' }}" style="min-width: 67%;margin: 0 5px;">

								<select name="category_id" class="form-control" style="min-width: 40%;margin-left: 5px;">
									<option value="">@lang('site.all_categories')</option>
									
									@foreach ($categories as $category)
										<option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
									@endforeach
								</select>
								
								<!-- Search btn -->
								<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
								
								<!-- Add btn -->
								@if (auth()->user()->hasPermission('create_products'))
									<a href="{{ route('dashboard.products.create') }}" class="btn btn-primary" style="margin: 0 15px;"><i class="fa fa-plus"></i> @lang('site.add')</a>
								@else
									<button class="btn btn-primary disabled" title="You have no permission to do this action" style="margin: 0 15px;"><i class="fa fa-plus"></i> @lang('site.add')</button>
								@endif
							</div>
						</div>
					</form>
				</div>

				<div class="box-body">
					@if (count($products))
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>@lang('site.name')</th>
									<th>@lang('site.description')</th>
									<th>@lang('site.category')</th>
									<th>@lang('site.image')</th>
									<th>@lang('site.purchase_price')</th>
									<th>@lang('site.sale_price')</th>
									<th>@lang('site.profit_percent')</th>
									<th>@lang('site.action')</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($products as $index => $product)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $product->name }}</td>
										<td>{!! $product->description !!}</td>
										<td>{{ $product->category->name }}</td>
										<td><img src="{{ $product->image_path }}" style="width: 100px" class="img-thumbnail"></td>
										<td>{{ $product->purchase_price }}</td>
										<td>{{ $product->sale_price }}</td>
										<td>{{ $product->profit_percent }} %</td>
										<td>
											@if (auth()->user()->hasPermission('update_products'))
												<a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
											@else
												<button class="btn btn-info btn-sm disabled" title="You have no permission to do this action"><i class="fa fa-edit"></i> @lang('site.edit')</button>
											@endif

											@if (auth()->user()->hasPermission('delete_products'))
												<form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post" style="display: inline-block;">
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

					{{ $products->appends(request()->query())->links() }}
				</div>
			</div>
		</section>
	</div>

@endsection