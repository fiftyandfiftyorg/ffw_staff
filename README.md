## Fifty & Fifty Frame Work Staff Plugin
==========

Create simple events for your site.

Needs: Shortcodes.


### Features

Quickly change the slug with

```
if( !defined('FFW_STAFF_SLUG') ){
	define( 'FFW_STAFF_SLUG', 'team' );
}
```

or quickly change the labels with

`function ffw_staff_labels( $labels ) {
	$labels = array(
	   'singular' => __('Team Member', 'your-domain'),
	   'plural' => __('Team Members', 'your-domain')
	);
	return $labels;
}
add_filter('ffw_staff_default_name', 'ffw_staff_labels');`


### Changelog

Coming soon.