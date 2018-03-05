@extends('layouts.app')
@section('content')
    @php(do_action( 'woocommerce_before_main_content' ))
    @while(have_posts()) @php(the_post())
        @include('woocommerce.content-single-product')
    @endwhile
    @php(do_action( 'woocommerce_after_main_content' ))
@endsection