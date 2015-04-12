# Simple true/false, ajax-powered checkboxes for your post columns

Needs the [Fieldmanager](https://github.com/alleyinteractive/wordpress-fieldmanager) WordPress plugin to work.

## Example use

1. Put this in your theme's `functions.php` file:

```PHP
function my_theme_init_function()
{
    $fm = new Fieldmanager_Postlist_Checkbox(array('name' => '_featured_post'));
    $fm->add_column_checkbox('Featured', array('post'));
}
add_action( 'init', 'my_theme_init_function' );
```

2. Go to "Posts" in your WordPress admin area and admire the checkbox column.
3. Use something like this to pull checked posts from your DB:

```PHP
$featured_query = new WP_Query(array(
    'meta_key' => '_featured_post',
    'meta_value' => true
));
```