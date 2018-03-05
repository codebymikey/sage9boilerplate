@php
    $args = array(
        'posts_per_page' => 1,
        'post__in'  => get_option( 'sticky_posts' ),
        'ignore_sticky_posts' => 1
    );
    $query = new WP_Query( $args );
@endphp

@if ($query->have_posts())
    @php
    $query->the_post();
    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
    @endphp
<div class="jumbotron p-3 mt-5 mb-5 p-md-5 text-dark rounded bg-dark" style="background-image:url({{ $featured_img_url }});background-position: center center; background-size: cover;min-height: 350px">
    <div class="col-md-6 px-0">
        <h1 class="mt-5">{{ get_the_title() }}</h1>
        <p class="lead my-3 mb-5">{{ get_the_excerpt() }}</p>
        <p class="lead mt-5 mb-5"><a href="{{ get_the_permalink() }}" class="text-primary font-weight-bold">Continue reading...</a></p>
    </div>
</div>
@endif