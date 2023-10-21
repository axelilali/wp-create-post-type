<?php
namespace Ilali\PostType;

class PostType
{
 private $name;
 private $slug;
 private $icon;
 private $add_new_capability;

 public function __construct($name, $slug, $icon = 'dashicons-admin-post', $add_new_capability = true)
 {
  $this->name               = $name;
  $this->slug               = $slug;
  $this->icon               = $icon;
  $this->add_new_capability = $add_new_capability;

  add_action('init', array($this, 'register_custom_post_type'));
 }

 public function register_custom_post_type()
 {
  $labels = array(
   'name'               => $this->name,
   'singular_name'      => $this->name,
   'menu_name'          => $this->name,
   'name_admin_bar'     => $this->name,
   'add_new'            => $this->add_new_capability ? 'Add New' : false,
   'add_new_item'       => $this->add_new_capability ? 'Add New ' . $this->name : false,
   'new_item'           => 'New ' . $this->name,
   'edit_item'          => 'Edit ' . $this->name,
   'view_item'          => 'View ' . $this->name,
   'all_items'          => 'All ' . $this->name,
   'search_items'       => 'Search ' . $this->name,
   'parent_item_colon'  => 'Parent ' . $this->name . ':',
   'not_found'          => 'No ' . strtolower($this->name) . ' found.',
   'not_found_in_trash' => 'No ' . strtolower($this->name) . ' found in Trash.',
  );

  $args = array(
   'labels'        => $labels,
   'public'        => true,
   'show_ui'       => true,
   'menu_icon'     => $this->icon,
   'supports'      => array('title', 'thumbnail', 'custom-fields'),
   'rewrite'       => array('slug' => $this->slug),
   'has_archive'   => true,
   'hierarchical'  => false,
   'menu_position' => 5,
   'show_in_rest'  => true,
  );

  if (!$this->add_new_capability) {
   // Hide the "Add New" button and disable adding new items from the admin menu.
   $args['capabilities'] = array(
    'create_posts' => 'do_not_allow',
   );
  }

  register_post_type($this->slug, $args);
 }

}
