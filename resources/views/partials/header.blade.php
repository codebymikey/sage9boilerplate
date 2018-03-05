<header class="banner">
  <nav class="navbar navbar-expand-lg navbar-light bg-light p-3 border-bottom box-shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

        @if (has_nav_menu('primary_navigation'))
          {!!  wp_nav_menu([
              'menu'            => 'primary_navigation',
              'theme_location'  => 'primary_navigation',
              'container'       => 'div',
              'container_id'    => 'bs4navbar',
              'container_class' => 'collapse navbar-collapse',
              'menu_id'         => false,
              'menu_class'      => 'navbar-nav ml-auto',
              'depth'           => 2,
              'fallback_cb'     => 'bs4navwalker::fallback',
              'walker'          => new App\Bs4nav_Walker()
          ]) !!}
        @endif

    </div>
  </nav>

</header>
