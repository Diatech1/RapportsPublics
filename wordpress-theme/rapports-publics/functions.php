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

// Define theme constants
define('RAPPORTS_PUBLICS_VERSION', '1.0.0');
define('RAPPORTS_PUBLICS_THEME_URL', get_template_directory_uri());
define('RAPPORTS_PUBLICS_THEME_PATH', get_template_directory());

/**
 * Theme Setup
 */
function rapports_publics_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style'
    ));
    add_theme_support('customize-selective-refresh-widgets');

    // Set post thumbnail size
    set_post_thumbnail_size(400, 300, true);
    
    // Add image sizes
    add_image_size('rapport-thumbnail', 300, 200, true);
    add_image_size('rapport-large', 800, 600, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'rapports-publics'),
        'footer' => __('Menu Pied de Page', 'rapports-publics'),
    ));

    // Load theme textdomain
    load_theme_textdomain('rapports-publics', RAPPORTS_PUBLICS_THEME_PATH . '/languages');
}
add_action('after_setup_theme', 'rapports_publics_setup');

/**
 * Enqueue Scripts and Styles
 */
function rapports_publics_scripts() {
    // Enqueue styles
    wp_enqueue_style(
        'rapports-publics-style',
        get_stylesheet_uri(),
        array(),
        RAPPORTS_PUBLICS_VERSION
    );

    // Enqueue main JavaScript
    wp_enqueue_script(
        'rapports-publics-main',
        RAPPORTS_PUBLICS_THEME_URL . '/assets/js/main.js',
        array('jquery'),
        RAPPORTS_PUBLICS_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script('rapports-publics-main', 'rapportsPublics', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rapports_publics_nonce'),
        'strings' => array(
            'searchPlaceholder' => __('Rechercher un rapport...', 'rapports-publics'),
            'noResults' => __('Aucun résultat trouvé', 'rapports-publics'),
            'loading' => __('Chargement...', 'rapports-publics'),
            'error' => __('Une erreur est survenue', 'rapports-publics'),
        )
    ));

    // Enqueue Google Fonts
    wp_enqueue_style(
        'rapports-publics-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'rapports_publics_scripts');

/**
 * Register Custom Post Type for Reports
 */
function rapports_publics_register_post_type() {
    $labels = array(
        'name' => __('Rapports', 'rapports-publics'),
        'singular_name' => __('Rapport', 'rapports-publics'),
        'menu_name' => __('Rapports Publics', 'rapports-publics'),
        'add_new' => __('Ajouter un Rapport', 'rapports-publics'),
        'add_new_item' => __('Ajouter un Nouveau Rapport', 'rapports-publics'),
        'edit_item' => __('Modifier le Rapport', 'rapports-publics'),
        'new_item' => __('Nouveau Rapport', 'rapports-publics'),
        'view_item' => __('Voir le Rapport', 'rapports-publics'),
        'search_items' => __('Rechercher des Rapports', 'rapports-publics'),
        'not_found' => __('Aucun rapport trouvé', 'rapports-publics'),
        'not_found_in_trash' => __('Aucun rapport trouvé dans la corbeille', 'rapports-publics'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'rapport'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
    );

    register_post_type('rapport', $args);
}
add_action('init', 'rapports_publics_register_post_type');

/**
 * Register Custom Taxonomies
 */
function rapports_publics_register_taxonomies() {
    // Ministry taxonomy
    register_taxonomy('ministere', 'rapport', array(
        'label' => __('Ministères', 'rapports-publics'),
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ministere'),
        'show_in_rest' => true,
    ));

    // Category taxonomy
    register_taxonomy('rapport_category', 'rapport', array(
        'label' => __('Catégories de Rapports', 'rapports-publics'),
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'categorie-rapport'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'rapports_publics_register_taxonomies');

/**
 * Add Custom Meta Boxes
 */
function rapports_publics_add_meta_boxes() {
    add_meta_box(
        'rapport_details',
        __('Détails du Rapport', 'rapports-publics'),
        'rapports_publics_meta_box_callback',
        'rapport',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'rapports_publics_add_meta_boxes');

/**
 * Meta Box Callback
 */
function rapports_publics_meta_box_callback($post) {
    wp_nonce_field('rapports_publics_save_meta', 'rapports_publics_meta_nonce');
    
    $publication_date = get_post_meta($post->ID, '_publication_date', true);
    $download_count = get_post_meta($post->ID, '_download_count', true);
    $file_url = get_post_meta($post->ID, '_file_url', true);
    $file_size = get_post_meta($post->ID, '_file_size', true);
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="publication_date"><?php _e('Date de Publication', 'rapports-publics'); ?></label>
            </th>
            <td>
                <input type="date" id="publication_date" name="publication_date" 
                       value="<?php echo esc_attr($publication_date); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="file_url"><?php _e('URL du Fichier', 'rapports-publics'); ?></label>
            </th>
            <td>
                <input type="url" id="file_url" name="file_url" 
                       value="<?php echo esc_url($file_url); ?>" class="regular-text" />
                <p class="description"><?php _e('URL complète vers le fichier PDF du rapport', 'rapports-publics'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="file_size"><?php _e('Taille du Fichier', 'rapports-publics'); ?></label>
            </th>
            <td>
                <input type="text" id="file_size" name="file_size" 
                       value="<?php echo esc_attr($file_size); ?>" class="regular-text" />
                <p class="description"><?php _e('Ex: 2.5 MB', 'rapports-publics'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="download_count"><?php _e('Nombre de Téléchargements', 'rapports-publics'); ?></label>
            </th>
            <td>
                <input type="number" id="download_count" name="download_count" 
                       value="<?php echo esc_attr($download_count ? $download_count : 0); ?>" 
                       min="0" readonly />
                <p class="description"><?php _e('Géré automatiquement par le système', 'rapports-publics'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Meta Box Data with Proper Sanitization and Security
 */
function rapports_publics_save_meta($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['rapports_publics_meta_nonce']) || 
        !wp_verify_nonce($_POST['rapports_publics_meta_nonce'], 'rapports_publics_save_meta')) {
        return;
    }

    // Check if user has permission to edit
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check post type
    if (get_post_type($post_id) !== 'rapport') {
        return;
    }

    // Sanitize and save meta fields
    if (isset($_POST['publication_date'])) {
        $publication_date = sanitize_text_field($_POST['publication_date']);
        // Validate date format
        if (DateTime::createFromFormat('Y-m-d', $publication_date) !== false) {
            update_post_meta($post_id, '_publication_date', $publication_date);
        }
    }

    if (isset($_POST['download_count'])) {
        $download_count = absint($_POST['download_count']);
        update_post_meta($post_id, '_download_count', $download_count);
    }

    if (isset($_POST['file_url'])) {
        $file_url = esc_url_raw($_POST['file_url']);
        if (filter_var($file_url, FILTER_VALIDATE_URL)) {
            update_post_meta($post_id, '_file_url', $file_url);
        }
    }

    if (isset($_POST['file_size'])) {
        $file_size = sanitize_text_field($_POST['file_size']);
        // Validate file size format (e.g., "2.5 MB", "1.2 GB")
        if (preg_match('/^\d+(\.\d+)?\s?(KB|MB|GB)$/i', $file_size)) {
            update_post_meta($post_id, '_file_size', $file_size);
        }
    }
}
add_action('save_post', 'rapports_publics_save_meta');

/**
 * Secure Download Tracking with Nonce Verification
 */
function rapports_publics_track_download() {
    if (!isset($_GET['download_rapport']) || !is_numeric($_GET['download_rapport'])) {
        return;
    }

    $post_id = intval($_GET['download_rapport']);
    
    // Verify nonce for security
    if (!isset($_GET['_wpnonce']) || 
        !wp_verify_nonce($_GET['_wpnonce'], 'download_rapport_' . $post_id)) {
        wp_die(__('Vérification de sécurité échouée', 'rapports-publics'), 
               __('Erreur de Sécurité', 'rapports-publics'), 
               array('response' => 403));
    }

    // Verify post exists and is published
    $post = get_post($post_id);
    if (!$post || $post->post_status !== 'publish' || $post->post_type !== 'rapport') {
        wp_die(__('Rapport non trouvé', 'rapports-publics'), 
               __('Erreur 404', 'rapports-publics'), 
               array('response' => 404));
    }

    // Update download count
    $download_count = get_post_meta($post_id, '_download_count', true);
    $download_count = $download_count ? $download_count + 1 : 1;
    update_post_meta($post_id, '_download_count', $download_count);

    // Log download for analytics
    error_log("Rapport téléchargé: ID {$post_id}, Titre: {$post->post_title}, IP: " . $_SERVER['REMOTE_ADDR']);

    // Get file URL and redirect
    $file_url = get_post_meta($post_id, '_file_url', true);
    if ($file_url && filter_var($file_url, FILTER_VALIDATE_URL)) {
        wp_redirect(esc_url($file_url));
        exit;
    } else {
        wp_die(__('Fichier non disponible', 'rapports-publics'), 
               __('Fichier Introuvable', 'rapports-publics'), 
               array('response' => 404));
    }
}
add_action('init', 'rapports_publics_track_download');

/**
 * AJAX Search Functionality
 */
function rapports_publics_ajax_search() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'rapports_publics_nonce')) {
        wp_send_json_error(__('Vérification de sécurité échouée', 'rapports-publics'));
    }

    $query = sanitize_text_field($_POST['query']);
    
    if (strlen($query) < 3) {
        wp_send_json_error(__('La requête doit contenir au moins 3 caractères', 'rapports-publics'));
    }

    $search_args = array(
        'post_type' => 'rapport',
        'post_status' => 'publish',
        's' => $query,
        'posts_per_page' => 10,
        'meta_query' => array(
            array(
                'key' => '_file_url',
                'compare' => 'EXISTS'
            )
        )
    );

    $search_query = new WP_Query($search_args);
    $results = array();

    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 20)
            );
        }
    }

    wp_reset_postdata();
    wp_send_json_success($results);
}
add_action('wp_ajax_search_reports', 'rapports_publics_ajax_search');
add_action('wp_ajax_nopriv_search_reports', 'rapports_publics_ajax_search');

/**
 * AJAX Download Tracking
 */
function rapports_publics_ajax_track_download() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'rapports_publics_nonce')) {
        wp_send_json_error(__('Vérification de sécurité échouée', 'rapports-publics'));
    }

    $report_id = intval($_POST['report_id']);
    
    if (!$report_id) {
        wp_send_json_error(__('ID de rapport invalide', 'rapports-publics'));
    }

    // Update download count
    $download_count = get_post_meta($report_id, '_download_count', true);
    $download_count = $download_count ? $download_count + 1 : 1;
    update_post_meta($report_id, '_download_count', $download_count);

    wp_send_json_success(array(
        'download_count' => $download_count,
        'message' => __('Téléchargement enregistré', 'rapports-publics')
    ));
}
add_action('wp_ajax_track_download', 'rapports_publics_ajax_track_download');
add_action('wp_ajax_nopriv_track_download', 'rapports_publics_ajax_track_download');

/**
 * Custom Query Modifications
 */
function rapports_publics_modify_main_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Show only reports with file URLs on archive pages
        if (is_post_type_archive('rapport') || is_tax(array('ministere', 'rapport_category'))) {
            $query->set('meta_query', array(
                array(
                    'key' => '_file_url',
                    'compare' => 'EXISTS'
                )
            ));
            $query->set('posts_per_page', 12);
            $query->set('orderby', 'date');
            $query->set('order', 'DESC');
        }
    }
}
add_action('pre_get_posts', 'rapports_publics_modify_main_query');

/**
 * Helper function to get secure download URL
 */
function rapports_publics_get_download_url($post_id) {
    return wp_nonce_url(
        home_url('/?download_rapport=' . $post_id),
        'download_rapport_' . $post_id
    );
}

/**
 * Add Custom CSS Classes to Body
 */
function rapports_publics_body_classes($classes) {
    if (is_post_type_archive('rapport')) {
        $classes[] = 'archive-rapports';
    }
    
    if (is_singular('rapport')) {
        $classes[] = 'single-rapport';
    }
    
    return $classes;
}
add_filter('body_class', 'rapports_publics_body_classes');

/**
 * Register Widget Areas
 */
function rapports_publics_widgets_init() {
    register_sidebar(array(
        'name' => __('Barre Latérale Principale', 'rapports-publics'),
        'id' => 'sidebar-main',
        'description' => __('Widgets affichés sur la barre latérale principale', 'rapports-publics'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Pied de Page', 'rapports-publics'),
        'id' => 'footer-widgets',
        'description' => __('Widgets affichés dans le pied de page', 'rapports-publics'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'rapports_publics_widgets_init');

/**
 * Add Admin Styles
 */
function rapports_publics_admin_styles() {
    echo '<style>
        .form-table th { width: 200px; }
        .form-table input[readonly] { background-color: #f1f1f1; }
        .rapports-meta-box { margin-top: 20px; }
    </style>';
}
add_action('admin_head', 'rapports_publics_admin_styles');