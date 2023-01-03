@extends('template.app')

@section('pagetitle', 'Dashboard')

@section('content')
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3>{{ $transaction }}</h3>
            <p>Penjualan Bulan ini</p>
        </div>
        <div class="icon">
            <i class="fa fa-shopping-cart"></i>
        </div>
    </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>{{ $productSale }}</h3>
            <p>Unit Terjual Bulan ini</p>
        </div>
        <div class="icon">
            <i class="fa fa-shopping-cart"></i>
        </div>
    </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>{{ $customer }}</h3>
            <p>Customers</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
    </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>{{ $products }}</h3>
            <p>Produk</p>
        </div>
        <div class="icon">
            <i class="fa fa-dropbox"></i>
        </div>
    </div>
</div>
@endsection
