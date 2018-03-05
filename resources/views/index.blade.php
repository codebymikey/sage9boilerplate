@extends('layouts.app')

@section('content')
  @include('partials.sticky-post')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  <div class="row mb-2">

  @while (have_posts()) @php(the_post())
    @include('partials.content-'.get_post_type())
  @endwhile

  </div>
  {{ App\textdomain_content_query_nav() }}
@endsection