@extends('layouts.dashboard.app')

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('site.dashboard')</h1>
			
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
	        <div class="col-lg-3 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <h3>{{ $categories_count }}</h3>

	              <p>@lang('site.categories')</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-stats-bars"></i>
	            </div>
	            <a href="{{ route('dashboard.categories.index') }}" class="small-box-footer">@lang('site.show')<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	        <!-- ./col -->
	        <div class="col-lg-3 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-green">
	            <div class="inner">
	              <h3>{{ $products_count }}</h3>

	              <p>@lang('site.products')</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-bag"></i>
	            </div>
	            <a href="{{ route('dashboard.products.index') }}" class="small-box-footer">@lang('site.show')<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	        <!-- ./col -->
	        <div class="col-lg-3 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-yellow">
	            <div class="inner">
	              <h3>{{ $clients_count }}</h3>

	              <p>@lang('site.clients')</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-person-add"></i>
	            </div>
	            <a href="{{ route('dashboard.clients.index') }}" class="small-box-footer">@lang('site.show')<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	        <!-- ./col -->
	        <div class="col-lg-3 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-red">
	            <div class="inner">
	              <h3>{{ $admins_count }}</h3>

	              <p>@lang('site.users')</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-pie-graph"></i>
	            </div>
	            <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">@lang('site.show')<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	        <!-- ./col -->
	      </div>
	      <!-- /.row -->

	      {{-- orders chart --}}
      	<div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">@lang('site.sales_graph')</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
		</section>
	</div>

@endsection


@push('scripts')
	<script type="text/javascript">

		var line = new Morris.Line({
	    element          : 'line-chart',
	    resize           : true,
	    data             : [
	    	@foreach ($sales_data as $data)
		      { 
		      	ym: "{{ $data->year }}-{{ $data->month }}", sum: "{{ $data->sum }}"
		      },
			@endforeach
	    ],
	    xkey             : 'ym',
	    ykeys            : ['sum'],
	    labels           : ['@lang("site.total")'],
	    lineColors       : ['#efefef'],
	    lineWidth        : 2,
	    hideHover        : 'auto',
	    gridTextColor    : '#fff',
	    gridStrokeWidth  : 0.4,
	    pointSize        : 4,
	    pointStrokeColors: ['#efefef'],
	    gridLineColor    : '#efefef',
	    gridTextFamily   : 'Open Sans',
	    gridTextSize     : 10
	  });	

	</script>
@endpush