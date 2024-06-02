<?php
class Mlpm_Helper
{
    function check_odd_even($data)
    {
        if ($data % 2 == 0) {
            $data = "Even";
        } else {
            $data = "Odd";
        }

        return $data;
    }

    function client_ratings($count)
    {
        $out = '';
        for ($i = 0; $i < $count; $i++) {
            $out .= '<i class="fas fa-star"></i>';
        }
        return $out;
    }

    function get_that_link($link)
    {

        $url = $link['url'] ? 'href=' . esc_url($link['url']) . '' : '';
        $ext = $link['is_external'] ? 'target= _blank' : '';
        $nofollow = $link['nofollow'] ? 'rel="nofollow"' : '';
        $link = $url . ' ' . $ext . ' ' . $nofollow;
        return $link;
    }

    function get_that_image($source, $class = 'image')
    {
        if ($source) {
            $image = '<img class="' . $class . '" src="' . esc_url($source['url']) . '" alt="' . get_bloginfo('name') . '">';
        }
        return $image;
    }
    function get_wp_menus() {
        $menus = wp_get_nav_menus();
        $items = array();
        $i     = 0;
        foreach ( $menus as $menu ) {
            if ( $i == 0 ) {
                $default = $menu->slug;
                $i ++;
            }
            $items[ $menu->slug ] = $menu->name;
        }

        return $items;
    }
}

// Add custom meta fields to menu items
function custom_menu_meta_fields($item_id, $item, $depth, $args) {
    // Add Mega Menu checkbox
    ?>
    <p class="field-megamenu description description-wide">
        <label for="edit-menu-item-megamenu-<?php echo $item_id; ?>">
            <input type="checkbox" id="edit-menu-item-megamenu-<?php echo $item_id; ?>" name="menu-item-megamenu[<?php echo $item_id; ?>]" value="1" <?php checked( get_post_meta( $item_id, '_menu_item_megamenu', true ), 1 ); ?>>
            Enable Mega Menu
        </label>
    </p>
    <?php
    // Dropdown to select post
    ?>
    <p class="field-dropdown-post description description-wide">
        <label for="edit-menu-item-dropdown-post-<?php echo $item_id; ?>">
            Select Post:
            <select id="edit-menu-item-dropdown-post-<?php echo $item_id; ?>" name="menu-item-dropdown-post[<?php echo $item_id; ?>]">
                <option value="">Select a post</option>
                <?php
                $posts = get_posts(array('post_type' => 'post', 'posts_per_page' => -1));
                foreach ($posts as $post) {
                    echo '<option value="' . $post->ID . '" ' . selected( get_post_meta( $item_id, '_menu_item_dropdown_post', true ), $post->ID, false ) . '>' . $post->post_title . '</option>';
                }
                ?>
            </select>
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'custom_menu_meta_fields', 10, 4);

// Save menu item meta data
function save_menu_meta_fields($menu_id, $menu_item_db_id, $menu_item_args) {
    if (isset($_POST['menu-item-megamenu'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_megamenu', $_POST['menu-item-megamenu'][$menu_item_db_id]);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_megamenu');
    }

    if (isset($_POST['menu-item-dropdown-post'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_dropdown_post', $_POST['menu-item-dropdown-post'][$menu_item_db_id]);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_dropdown_post');
    }
}
add_action('wp_update_nav_menu_item', 'save_menu_meta_fields', 10, 3);

// Display Mega Menu and Post Content
function display_menu_meta_data($items, $args) {
    foreach ($items as $item) {
        // Check if Mega Menu is enabled
        $megamenu = get_post_meta($item->ID, '_menu_item_megamenu', true);

        // Add class for Mega Menu switch
        if ($megamenu) {
            $item->classes[] = 'mega-menu-enabled';
            $item->classes[] = 'menu-item-has-children';
        }

        // If Mega Menu is enabled
        if ($megamenu) {
            // Get the post content for the Mega Menu
            $dropdown_post = get_post_meta($item->ID, '_menu_item_dropdown_post', true);

            // If post content exists
            if ($dropdown_post) {
                // Get post content
                $post_content = get_post_field('post_content', $dropdown_post);

                $post_content = '<ul class="sub-menu">' . $post_content . '</ul>';

                // Add the post content under the menu item's link
                $item_output = '<a href="' . $item->url . '" class="menu-item-link">' . $item->title . '</a>'; // Output menu item link
                $item_output .= $post_content; // Output post content as submenu

                // Assign the modified item output to the menu item
                $item->title = $item_output;
            }
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'display_menu_meta_data', 10, 2);

