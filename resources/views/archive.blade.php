@extends('layouts.app')

@section('content')

    @include('partials.archive-header')

    @if (!have_posts())
        <div class="alert alert-warning">
            {{ __('Sorry, no results were found.', 'sage') }}
        </div>
        {!! get_search_form(false) !!}
    @endif

    <div class="row mb-2">
        <div class="col-md-9">
            <div class="row">
                @while (have_posts()) @php(the_post())
                @include('partials.content-'.get_post_type())
                @endwhile
            </div>

        </div>
        <aside class="col-md-3">
            <div class="widgets pl-5">
                @include('partials.sidebar')
            </div>
        </aside>


    </div>
    {{ App\textdomain_content_query_nav() }}
@endsection