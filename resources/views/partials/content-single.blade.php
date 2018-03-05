<article @php(post_class())>
  @php
    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
  @endphp
  <header>
    <div class="jumbotron p-5 mt-5 mb-5 p-md-5 text-dark rounded bg-dark" style="background-image:url({{ $featured_img_url }});background-position: center center; background-size: cover">
      <div class="col-md-6 px-0">
        <h1 class="entry-title">{{ get_the_title() }}</h1>
        @include('partials/entry-meta')
      </div>
    </div>
  </header>
  <div class="entry-content">
    <div class="row">
      <div class="col-md-9">
        @php(the_content())
        @include('partials/footer-meta')
        @php(comments_template('/partials/comments.blade.php'))
      </div>
      <aside class="col-md-3">
        <div class="widgets pl-5">
          @include('partials.sidebar')
        </div>
      </aside>
    </div>
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
</article>