<?php
/**
 * Rapports Publics Theme Functions
 * 
 * @package RapportsPublics
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function rapports_publics_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'rapports-publics'),
        'footer' => __('Footer Menu', 'rapports-publics'),
    ));
    
    // Add support for custom header and background
    add_theme_support('custom-header', array(
        'default-image' => get_template_directory_uri() . '/assets/images/hero-section.png',
        'width' => 1920,
        'height' => 1080,
    ));
    
    add_theme_support('custom-background');
}
add_action('after_setup_theme', 'rapports_publics_setup');

/**
 * Enqueue scripts and styles
 */
function rapports_publics_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('rapports-publics-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Enqueue custom JavaScript
    wp_enqueue_script('rapports-publics-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('rapports-publics-script', 'rapports_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rapports_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'rapports_publics_scripts');

/**
 * Register Custom Post Type for Reports
 */
function rapports_publics_register_post_types() {
    $labels = array(
        'name' => __('Rapports', 'rapports-publics'),
        'singular_name' => __('Rapport', 'rapports-publics'),
        'menu_name' => __('Rapports', 'rapports-publics'),
        'add_new' => __('Ajouter un nouveau', 'rapports-publics'),
        'add_new_item' => __('Ajouter un nouveau rapport', 'rapports-publics'),
        'edit_item' => __('Modifier le rapport', 'rapports-publics'),
        'new_item' => __('Nouveau rapport', 'rapports-publics'),
        'view_item' => __('Voir le rapport', 'rapports-publics'),
        'search_items' => __('Rechercher des rapports', 'rapports-publics'),
        'not_found' => __('Aucun rapport trouvé', 'rapports-publics'),
        'not_found_in_trash' => __('Aucun rapport trouvé dans la corbeille', 'rapports-publics'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true, // Enable Gutenberg editor
        'query_var' => true,
        'rewrite' => array('slug' => 'rapport'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('rapport', $args);
}
add_action('init', 'rapports_publics_register_post_types');

/**
 * Register Taxonomies for Reports
 */
function rapports_publics_register_taxonomies() {
    // Ministry taxonomy
    register_taxonomy('ministere', 'rapport', array(
        'labels' => array(
            'name' => __('Ministères', 'rapports-publics'),
            'singular_name' => __('Ministère', 'rapports-publics'),
        ),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'ministere'),
    ));

    // Report category taxonomy
    register_taxonomy('rapport_category', 'rapport', array(
        'labels' => array(
            'name' => __('Catégories de Rapport', 'rapports-publics'),
            'singular_name' => __('Catégorie de Rapport', 'rapports-publics'),
        ),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'categorie-rapport'),
    ));
}
add_action('init', 'rapports_publics_register_taxonomies');

/**
 * Add custom meta boxes for reports
 */
function rapports_publics_add_meta_boxes() {
    add_meta_box(
        'rapport_details',
        __('Détails du Rapport', 'rapports-publics'),
        'rapports_publics_rapport_details_callback',
        'rapport',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'rapports_publics_add_meta_boxes');

/**
 * Meta box callback for report details
 */
function rapports_publics_rapport_details_callback($post) {
    wp_nonce_field('rapports_publics_save_meta', 'rapports_publics_meta_nonce');
    
    $publication_date = get_post_meta($post->ID, '_publication_date', true);
    $download_count = get_post_meta($post->ID, '_download_count', true);
    $file_url = get_post_meta($post->ID, '_file_url', true);
    $file_size = get_post_meta($post->ID, '_file_size', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="publication_date"><?php _e('Date de Publication', 'rapports-publics'); ?></label></th>
            <td><input type="date" id="publication_date" name="publication_date" value="<?php echo esc_attr($publication_date); ?>" /></td>
        </tr>
        <tr>
            <th><label for="download_count"><?php _e('Nombre de Téléchargements', 'rapports-publics'); ?></label></th>
            <td><input type="number" id="download_count" name="download_count" value="<?php echo esc_attr($download_count); ?>" /></td>
        </tr>
        <tr>
            <th><label for="file_url"><?php _e('URL du Fichier PDF', 'rapports-publics'); ?></label></th>
            <td><input type="url" id="file_url" name="file_url" value="<?php echo esc_attr($file_url); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="file_size"><?php _e('Taille du Fichier', 'rapports-publics'); ?></label></th>
            <td><input type="text" id="file_size" name="file_size" value="<?php echo esc_attr($file_size); ?>" placeholder="ex: 2.5 MB" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function rapports_publics_save_meta($post_id) {
    if (!isset($_POST['rapports_publics_meta_nonce']) || !wp_verify_nonce($_POST['rapports_publics_meta_nonce'], 'rapports_publics_save_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('publication_date', 'download_count', 'file_url', 'file_size');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'rapports_publics_save_meta');

/**
 * Register widget areas
 */
function rapports_publics_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'rapports-publics'),
        'id' => 'sidebar-1',
        'description' => __('Widgets area for sidebar', 'rapports-publics'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer 1', 'rapports-publics'),
        'id' => 'footer-1',
        'description' => __('First footer widget area', 'rapports-publics'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer 2', 'rapports-publics'),
        'id' => 'footer-2',
        'description' => __('Second footer widget area', 'rapports-publics'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer 3', 'rapports-publics'),
        'id' => 'footer-3',
        'description' => __('Third footer widget area', 'rapports-publics'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer 4', 'rapports-publics'),
        'id' => 'footer-4',
        'description' => __('Fourth footer widget area', 'rapports-publics'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'rapports_publics_widgets_init');

/**
 * Customizer additions
 */
function rapports_publics_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Section Héro', 'rapports-publics'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default' => 'Répertoire National des Rapports Publics du Sénégal',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label' => __('Titre de la section héro', 'rapports-publics'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Accédez, lisez et téléchargez gratuitement les rapports officiels du gouvernement sénégalais.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Sous-titre de la section héro', 'rapports-publics'),
        'section' => 'hero_section',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'rapports_publics_customize_register');

/**
 * Download tracking functionality
 */
function rapports_publics_track_download() {
    if (isset($_GET['download_rapport']) && is_numeric($_GET['download_rapport'])) {
        $post_id = intval($_GET['download_rapport']);
        $download_count = get_post_meta($post_id, '_download_count', true);
        $download_count = $download_count ? $download_count + 1 : 1;
        update_post_meta($post_id, '_download_count', $download_count);
        
        $file_url = get_post_meta($post_id, '_file_url', true);
        if ($file_url) {
            wp_redirect($file_url);
            exit;
        }
    }
}
add_action('template_redirect', 'rapports_publics_track_download');

/**
 * Add custom image sizes
 */
function rapports_publics_image_sizes() {
    add_image_size('rapport-thumbnail', 400, 200, true);
    add_image_size('rapport-featured', 800, 400, true);
}
add_action('after_setup_theme', 'rapports_publics_image_sizes');

/**
 * Gutenberg block patterns
 */
function rapports_publics_register_block_patterns() {
    // FAQ Pattern
    register_block_pattern('rapports-publics/faq-section', array(
        'title' => __('Section FAQ', 'rapports-publics'),
        'description' => __('Section de questions fréquemment posées', 'rapports-publics'),
        'content' => '<!-- wp:group {"className":"faq-section"} -->
        <div class="wp-block-group faq-section">
            <h2 class="section-title">Questions Fréquentes</h2>
            <!-- wp:html -->
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        Qu\'est-ce que rapports publics ? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>rapports publics est une plateforme d\'accès libre aux rapports officiels produits par les institutions publiques du Sénégal.</p>
                    </div>
                </div>
            </div>
            <!-- /wp:html -->
        </div>
        <!-- /wp:group -->',
        'categories' => array('rapports-publics'),
    ));
}
add_action('init', 'rapports_publics_register_block_patterns');

/**
 * Register block pattern category
 */
function rapports_publics_register_pattern_category() {
    register_block_pattern_category('rapports-publics', array(
        'label' => __('Rapports Publics', 'rapports-publics'),
    ));
}
add_action('init', 'rapports_publics_register_pattern_category');

/**
 * Fallback menu function
 */
function rapports_publics_fallback_menu() {
    echo '<ul id="primary-menu" class="primary-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Accueil', 'rapports-publics') . '</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('rapport')) . '">' . __('Rapports', 'rapports-publics') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/a-propos')) . '">' . __('À propos', 'rapports-publics') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">' . __('Contact', 'rapports-publics') . '</a></li>';
    echo '</ul>';
}