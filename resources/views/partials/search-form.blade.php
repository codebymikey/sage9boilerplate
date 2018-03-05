<section class="widget widget-search">
    <form role="search" method="get" class="search-form form-inline" action="{{ esc_url( home_url( '/' ) ) }}">
        <label>
            <span class="screen-reader-text">{{ __('Search for', 'sage') }}</span>
            <input type="search" class="search-field form-control" placeholder="Type here …" value="{{ esc_attr( get_search_query() ) }}" name="s">
        </label>
        <button class="mt-1 btn btn-outline-success my-2" type="submit">{{ __('Search', 'sage') }}</button>
    </form>
</section>