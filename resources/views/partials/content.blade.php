  @if (is_home())
      <div class="col-md-6">
        @else
      <div class="col-md-12">
@endif

  <article @php(post_class())>
    <div class="card flex-md-row mb-4 box-shadow h-md-250" style="height:342px;">
      <div class="card-body d-flex flex-column align-items-start">
        <strong class="d-inline-block mb-2 text-success">World</strong>
        <header>
          <h3 class="mb-0">
            <a class="text-dark" href="{{ get_permalink() }}">{{ get_the_title() }}</a>
          </h3>
        </header>
        <div class="mb-1 text-muted article-meta">
          @include('partials/entry-meta')
        </div>
        <div class="entry-summary">
          <p class="card-text mb-auto">@php(the_excerpt())</p>
        </div>

        <a href="{{ get_permalink() }}">Continue reading</a>
      </div>
      @php
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
      @endphp
      @if($featured_img_url)
      <div class="d-flex d-md-block align-items-stretch bg-image" style="min-width:250px;height:342px;background-image:url({{ $featured_img_url }});background-position: center center; background-size: cover">
        <a title="{{ get_the_title() }}" href="{{ get_permalink() }}"></a>
      </div>
      @endif
    </div>
  </article>
</div>