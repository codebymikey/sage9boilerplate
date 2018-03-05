<div class="page-header mb-3 mt-6">
    @if(shortcode_exists( 'display_featured_grid' ))
        @php echo do_shortcode( '[display_featured_grid]' ); @endphp
    @else
        {{ App\display_message( 'danger', 'Octo Featured Grid plugin is not activated or is missing.') }}
    @endif
</div>