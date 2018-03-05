<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    if (remove_action('wp_head', 'wp_enqueue_scripts', 1)) {
        wp_enqueue_scripts();
    }

    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                        "{$template}.blade.php",
                        "{$template}.php",
                    ];
                });
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_message( $type, $message)
{
	$class_alert = '';

	switch($type){
		case "success":
			$class_alert = 'alert-success';
		break;
		case "warning":
			$class_alert = 'alert-warning';
		break;
		case "danger":
			$class_alert = 'alert-danger';
		break;
		default:
			$class_alert = 'alert-info';
		break;

	}
	echo '<div class="alert '.$class_alert.'">';
	echo $message;
	echo '</div>';
}

/**
 * Numeric pagination
 * @return string
 */
if ( ! function_exists( 'textdomain_content_query_nav' ) ) :
    /**
     * Display numberic pagination when applicable
     */
    function textdomain_content_query_nav() {

        if( is_singular() )
            return;

        global $wp_query;
        $wp_query->set( 'ignore_sticky_posts', true );

        //* Stop execution if there's only 1 page
        if( $wp_query->max_num_pages <= 1 )
            return;

        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
        $max   = intval( $wp_query->max_num_pages );

        //* Add current page to the array
        if ( $paged >= 1 )
            $links[] = $paged;

        //* Add the pages around the current page to the array
        if ( $paged >= 3 ) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if ( ( $paged + 2 ) <= $max ) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }


        echo '<div class="navigation"><ul class="pagination justify-content-center">' . "\n";


        //* Previous Post Link
        if ( get_previous_posts_link() )
            printf( '<li class="page-item">%s</li>' . "\n", get_previous_posts_link( '' . __( 'Prev', 'textdomain' ) ) );


        //* Link to first page, plus ellipses if necessary
        if ( ! in_array( 1, $links ) ) {

            $class = 1 == $paged ? ' class="page-item active"' : ' class="page-item"';

            printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

            if ( ! in_array( 2, $links ) )
                echo '<li class="pagination-omission">&#x02026;</li>';

        }

        //* Link to current page, plus 2 pages in either direction if necessary
        sort( $links );
        foreach ( (array) $links as $link ) {
            $class = $paged == $link ? ' class="page-item active"' : ' class="page-item"';
            printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
        }

        //* Link to last page, plus ellipses if necessary
        if ( ! in_array( $max, $links ) ) {

            if ( ! in_array( $max - 1, $links ) )
                echo '<li class="pagination-omission">&#x02026;</li>' . "\n";

            $class = $paged == $max ? ' class="page-item active"' : ' class="page-item"';
            printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );

        }

        //* Next Post Link
        if ( get_next_posts_link() )
            printf( '<li class="page-item">%s</li>' . "\n", get_next_posts_link( __( 'Next', 'textdomain' ) . '' ) );

        echo '</ul></div>' . "\n";
    }
endif;
