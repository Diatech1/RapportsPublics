<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main">
        <?php _e('Aller au contenu principal', 'rapports-publics'); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                
                <!-- Site Branding -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_front_page() && is_home()) : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                    <?php else : ?>
                        <p class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) : ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Main Navigation -->
                <nav id="site-navigation" class="main-navigation" aria-label="<?php _e('Menu principal', 'rapports-publics'); ?>">
                    
                    <!-- Mobile Menu Toggle -->
                    <button id="menuToggle" 
                            class="menu-toggle" 
                            aria-controls="primary-menu" 
                            aria-expanded="false"
                            type="button">
                        <span class="hamburger">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </span>
                        <span class="screen-reader-text"><?php _e('Ouvrir le menu', 'rapports-publics'); ?></span>
                    </button>

                    <!-- Primary Menu -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'rapports_publics_default_menu',
                    ));
                    ?>
                </nav>

                <!-- Header Actions -->
                <div class="header-actions">
                    
                    <!-- Quick Search -->
                    <div class="quick-search">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="hidden" name="post_type" value="rapport" />
                            <label for="header-search" class="screen-reader-text">
                                <?php _e('Rechercher des rapports', 'rapports-publics'); ?>
                            </label>
                            <input type="search" 
                                   id="header-search" 
                                   name="s" 
                                   placeholder="<?php _e('Rechercher...', 'rapports-publics'); ?>" 
                                   class="search-field" 
                                   value="<?php echo get_search_query(); ?>" />
                            <button type="submit" class="search-submit" aria-label="<?php _e('Lancer la recherche', 'rapports-publics'); ?>">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                                    <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Accessibility Menu -->
                    <div class="accessibility-menu">
                        <button type="button" class="accessibility-toggle" aria-label="<?php _e('Options d\'accessibilité', 'rapports-publics'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                <path d="M12 1v6m0 6v6M1 12h6m6 0h6" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </button>
                        
                        <div class="accessibility-options" style="display: none;">
                            <button type="button" onclick="adjustFontSize(1.2)" class="accessibility-btn">
                                <?php _e('Augmenter la taille du texte', 'rapports-publics'); ?>
                            </button>
                            <button type="button" onclick="adjustFontSize(0.8)" class="accessibility-btn">
                                <?php _e('Diminuer la taille du texte', 'rapports-publics'); ?>
                            </button>
                            <button type="button" onclick="toggleHighContrast()" class="accessibility-btn">
                                <?php _e('Contraste élevé', 'rapports-publics'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?php
    // Display page-specific headers
    if (is_post_type_archive('rapport') || is_tax(array('ministere', 'rapport_category'))) :
        ?>
        <div class="archive-header">
            <div class="container">
                <div class="archive-info">
                    <?php
                    if (is_tax()) :
                        $term = get_queried_object();
                        ?>
                        <h1 class="archive-title">
                            <?php echo esc_html($term->name); ?>
                        </h1>
                        <?php if ($term->description) : ?>
                            <p class="archive-description">
                                <?php echo esc_html($term->description); ?>
                            </p>
                        <?php endif; ?>
                    <?php else : ?>
                        <h1 class="archive-title">
                            <?php _e('Tous les Rapports Publics', 'rapports-publics'); ?>
                        </h1>
                        <p class="archive-description">
                            <?php _e('Découvrez tous les rapports officiels des institutions publiques', 'rapports-publics'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    endif;
    ?>

<?php
/**
 * Fallback menu if no menu is assigned
 */
function rapports_publics_default_menu() {
    echo '<ul id="primary-menu" class="primary-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Accueil', 'rapports-publics') . '</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('rapport')) . '">' . __('Rapports', 'rapports-publics') . '</a></li>';
    
    // Ministry links
    $ministries = get_terms(array(
        'taxonomy' => 'ministere',
        'hide_empty' => true,
        'number' => 5
    ));
    
    if (!empty($ministries) && !is_wp_error($ministries)) {
        echo '<li class="menu-item-has-children">';
        echo '<a href="#">' . __('Ministères', 'rapports-publics') . '</a>';
        echo '<ul class="sub-menu">';
        foreach ($ministries as $ministry) {
            echo '<li><a href="' . esc_url(get_term_link($ministry)) . '">' . esc_html($ministry->name) . '</a></li>';
        }
        echo '</ul>';
        echo '</li>';
    }
    
    echo '</ul>';
}
?>

<style>
/* Header Styles */
.site-header {
    background: var(--light-color);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: var(--box-shadow);
}

.header-content {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    gap: 2rem;
    padding: 1rem 0;
}

.site-branding .site-title {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
}

.site-branding .site-title a {
    color: var(--primary-color);
    text-decoration: none;
}

.site-description {
    margin: 0;
    font-size: 0.875rem;
    color: var(--text-color);
    opacity: 0.8;
}

/* Navigation */
.main-navigation {
    position: relative;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    border-radius: var(--border-radius);
}

.hamburger {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.hamburger-line {
    width: 20px;
    height: 2px;
    background: var(--text-color);
    transition: var(--transition);
}

.primary-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 1rem;
}

.primary-menu li a {
    display: block;
    padding: 0.75rem 1rem;
    color: var(--text-color);
    text-decoration: none;
    font-weight: 500;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.primary-menu li a:hover,
.primary-menu li.current-menu-item a {
    background: var(--secondary-color);
    color: var(--primary-color);
}

/* Submenu */
.menu-item-has-children {
    position: relative;
}

.sub-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: var(--transition);
    z-index: 1000;
}

.menu-item-has-children:hover .sub-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.sub-menu li {
    width: 100%;
}

.sub-menu li a {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--border-color);
}

.sub-menu li:last-child a {
    border-bottom: none;
}

/* Header Actions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.search-form {
    position: relative;
    display: flex;
    align-items: center;
}

.search-field {
    padding: 0.5rem 2.5rem 0.5rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    background: var(--secondary-color);
    width: 200px;
    transition: var(--transition);
}

.search-field:focus {
    outline: none;
    border-color: var(--primary-color);
    background: var(--light-color);
    width: 250px;
}

.search-submit {
    position: absolute;
    right: 0.5rem;
    background: none;
    border: none;
    color: var(--text-color);
    cursor: pointer;
    padding: 0.25rem;
}

/* Accessibility */
.accessibility-menu {
    position: relative;
}

.accessibility-toggle {
    background: none;
    border: none;
    color: var(--text-color);
    padding: 0.5rem;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
}

.accessibility-toggle:hover {
    background: var(--secondary-color);
}

.accessibility-options {
    position: absolute;
    top: 100%;
    right: 0;
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    min-width: 200px;
    z-index: 1000;
}

.accessibility-btn {
    display: block;
    width: 100%;
    padding: 0.75rem 1rem;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    transition: var(--transition);
    border-bottom: 1px solid var(--border-color);
}

.accessibility-btn:hover {
    background: var(--secondary-color);
}

.accessibility-btn:last-child {
    border-bottom: none;
}

/* Archive Header */
.archive-header {
    background: var(--secondary-color);
    padding: 2rem 0;
    border-bottom: 1px solid var(--border-color);
}

.archive-title {
    color: var(--primary-color);
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.archive-description {
    color: var(--text-color);
    font-size: 1.125rem;
    margin: 0;
}

/* Skip Link */
.skip-link {
    position: absolute;
    left: -9999px;
}

.skip-link:focus {
    position: absolute;
    left: 6px;
    top: 7px;
    z-index: 999999;
    padding: 8px 16px;
    background: var(--primary-color);
    color: var(--light-color);
    text-decoration: none;
    border-radius: var(--border-radius);
}

/* Responsive Design */
@media (max-width: 992px) {
    .header-content {
        grid-template-columns: auto 1fr;
        gap: 1rem;
    }
    
    .header-actions {
        grid-column: 1 / -1;
        justify-content: space-between;
        margin-top: 1rem;
    }
    
    .search-field {
        width: 150px;
    }
    
    .search-field:focus {
        width: 200px;
    }
}

@media (max-width: 768px) {
    .menu-toggle {
        display: block;
    }
    
    .primary-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--light-color);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        flex-direction: column;
        gap: 0;
        box-shadow: var(--box-shadow);
        z-index: 1000;
    }
    
    .primary-menu.show {
        display: flex;
    }
    
    .primary-menu li {
        width: 100%;
        border-bottom: 1px solid var(--border-color);
    }
    
    .primary-menu li:last-child {
        border-bottom: none;
    }
    
    .primary-menu li a {
        padding: 1rem;
        border-radius: 0;
    }
    
    .sub-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        border: none;
        box-shadow: none;
        background: var(--secondary-color);
    }
    
    .header-content {
        grid-template-columns: 1fr auto;
    }
    
    .header-actions {
        grid-column: auto;
        margin-top: 0;
    }
    
    .search-field {
        width: 120px;
    }
    
    .search-field:focus {
        width: 150px;
    }
}

@media (max-width: 480px) {
    .site-branding .site-title {
        font-size: 1.5rem;
    }
    
    .header-content {
        gap: 0.5rem;
    }
    
    .header-actions {
        gap: 0.5rem;
    }
    
    .search-field {
        width: 100px;
        font-size: 0.875rem;
    }
    
    .search-field:focus {
        width: 120px;
    }
}
</style>

<script>
// Accessibility functions
function adjustFontSize(factor) {
    const elements = document.querySelectorAll('body, body *');
    elements.forEach(el => {
        const currentSize = window.getComputedStyle(el).fontSize;
        const newSize = parseFloat(currentSize) * factor;
        el.style.fontSize = newSize + 'px';
    });
}

function toggleHighContrast() {
    document.body.classList.toggle('high-contrast');
}

// Accessibility menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const accessibilityToggle = document.querySelector('.accessibility-toggle');
    const accessibilityOptions = document.querySelector('.accessibility-options');
    
    if (accessibilityToggle && accessibilityOptions) {
        accessibilityToggle.addEventListener('click', function() {
            const isVisible = accessibilityOptions.style.display !== 'none';
            accessibilityOptions.style.display = isVisible ? 'none' : 'block';
        });
        
        // Close on outside click
        document.addEventListener('click', function(e) {
            if (!accessibilityToggle.contains(e.target) && !accessibilityOptions.contains(e.target)) {
                accessibilityOptions.style.display = 'none';
            }
        });
    }
});
</script>