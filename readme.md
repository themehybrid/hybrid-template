# Hybrid\\Template

Hybrid Template is a package for registering custom post templates. Technically, it works for any object type (e.g., post, term, user, etc.), but does not add any UI elements of its own.

The major difference between this and the typical WordPress page template system is that the template doesn't have to exist for registration.  It also defaults to supporting all post types instead of just `page`.

## Requirements

* WordPress 4.9+.
* PHP 5.6+ (preferably 7+).
* [Composer](https://getcomposer.org/) for managing PHP dependencies.

## Documentation

This project a part of the Hybrid Core framework. It may require other packages, which will be installed via Composer.

### Installation

First, you'll need to open your command line tool and change directories to your theme folder.

```bash
cd path/to/wp-content/themes/<your-theme-name>
```

Then, use Composer to install the package.

```bash
composer require themehybrid/hybrid-template
```

### Register the Service Provider

You need to register the service provider during your bootstrapping process.  In your bootstrapping code, you should have something like the following:

```php
$themeslug = new \Hybrid\Core\Application();
```

After that point, you can register the service provider:

```php
$themeslug->provider( \Hybrid\Template\Provider::class );
```

## Register Templates

The following registers a custom post template named `template-canvas.html` (or `template-canvas.php` in classic WordPress themes).

```php
add_action( 'hybrid/templates/register', function( $templates ) {

	$templates->add( 'template-canvas', [
		'label' => __( 'Canvas' )
	] );
} );
```

By default, the system will register the template for every post type.  You can limit it to specific post types like so:

```php
add_action( 'hybrid/templates/register', function( $templates ) {

	$templates->add( 'template-canvas', [
		'label'      => __( 'Canvas' ),
		'post_types' => [ 'page', 'post' ]
	] );
} );
```

## Copyright and License

This project is licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2008&thinsp;&ndash;&thinsp;2021 &copy; [Justin Tadlock](https://themehybrid.com).
