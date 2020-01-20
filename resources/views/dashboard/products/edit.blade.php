@extends('layouts.dashboard.app')

@section('content')

	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.products')</h1>
			
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
				<li><a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
				<li class="active">@lang('site.edit')</li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">@lang('site.edit')</h3>
				</div>

				@include('partials._errors')

				<div class="box-body">
					<form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
						@csrf
						@method('PUT')

						<div class="form-group">
							<label for="categories">@lang('site.categories')</label>

							<select name="category_id" id="categories" class="form-control" required>
								<option value="">---</option>
								@foreach ($categories as $category)
									<option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
								@endforeach
							</select>
						</div>

						@foreach (config('translatable.locales') as $locale)
							<div class="form-group">
								<label for="name">@lang('site.' .$locale. '.name')</label>
								<input type="text" name="{{ $locale }}[name]" id="name" class="form-control" value="{{ $product->name }}" required>
							</div>

							<div class="form-group">
								<label for="description">@lang("site.{$locale}.description")</label>
								<textarea name="{{ $locale }}[description]" id="description" class="form-control ckeditor" required>{{ $product->description }}</textarea>
							</div>
						@endforeach

						<div class="form-group">
							<label for="image">@lang('site.image')</label>
							<input type="file" name="image" id="image" class="form-control image-input">
						</div>

						<div class="form-group">
							<img src="{{ asset('uploads/product_images/' .$product->image) }}" class="img-thumbnail image-preview" style="width: 100px">
						</div>

						<div class="form-group">
							<label for="purchase_price">@lang('site.purchase_price')</label>
							<input type="number" step="0.01" min="1" name="purchase_price" id="purchase_price" class="form-control" value="{{ $product->purchase_price }}">
						</div>

						<div class="form-group">
							<label for="sale_price">@lang('site.sale_price')</label>
							<input type="number" step="0.01" min="1" name="sale_price" id="sale_price" class="form-control" value="{{ $product->sale_price }}">
						</div>

						<div class="form-group">
							<label for="stock">@lang('site.stock')</label>
							<input type="number" min="1" name="stock" id="stock" class="form-control" value="{{ $product->stock }}">
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>

@endsection