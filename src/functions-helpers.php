<?php
/**
 * Template functions.
 *
 * Helper functions and template tags related to templates.
 *
 * @package   HybridTemplate
 * @link      https://github.com/themehybrid/hybrid-template
 *
 * @author    Theme Hybrid
 * @copyright Copyright (c) 2008 - 2024, Theme Hybrid
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Hybrid\Template;

if ( ! function_exists( __NAMESPACE__ . '\\locate' ) ) {
    /**
     * A better `locate_template()` function than what core WP provides. Note that
     * this function merely locates templates and does no loading. Use the core
     * `load_template()` function for actually loading the template.
     *
     * @param array|string $templates
     * @return string
     */
    function locate( $templates ) {
        $located = '';

        foreach ( (array) $templates as $template ) {

            foreach ( locations() as $location ) {

                $file = trailingslashit( $location ) . $template;

                if ( file_exists( $file ) ) {
                    $located = $file;
                    break 2;
                }
            }
        }

        return $located;
    }
}

if ( ! function_exists( __NAMESPACE__ . '\\path' ) ) {
    /**
     * Returns the relative path to where templates are held in the theme.
     *
     * @param string $file
     * @return string
     */
    function path( $file = '' ) {

        $file = ltrim( $file, '/' );
        $path = apply_filters( 'hybrid/template/path', 'public/views' );

        return $file ? trailingslashit( $path ) . $file : $path;
    }
}

if ( ! function_exists( __NAMESPACE__ . '\\locations' ) ) {
    /**
     * Returns an array of locations to look for templates.
     *
     * Note that this won't work with the core WP template hierarchy due to an
     * issue that hasn't been addressed since 2010.
     *
     * @link   https://core.trac.wordpress.org/ticket/13239
     * @return array
     */
    function locations() {

        $path = ltrim( path(), '/' );

        // Add active theme path.
        $locations = [ get_stylesheet_directory() . "/{$path}" ];

        // If child theme, add parent theme path second.
        if ( is_child_theme() ) {
            $locations[] = get_template_directory() . "/{$path}";
        }

        return (array) apply_filters( 'hybrid/template/locations', $locations );
    }
}

if ( ! function_exists( __NAMESPACE__ . '\\filter_templates' ) ) {
    /**
     * Filters an array of templates and prefixes them with the view path.
     *
     * @param array $templates
     * @return array
     */
    function filter_templates( $templates ) {

        $path = path();

        if ( $path ) {
            array_walk( $templates, static function ( &$template, $key ) use ( $path ) {

                $template = ltrim( str_replace( $path, '', $template ), '/' );

                $template = "{$path}/{$template}";
            } );
        }

        return $templates;
    }
}
