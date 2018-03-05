{{--
  Template Name: Homepage Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.homepage-header')
    @include('partials.content-page')
  @endwhile
@endsection
