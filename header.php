<?php
/**
 * The header for our theme
 *
 * @package RapportsPublics
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    
    <!-- Header -->
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-container">
                
                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" rel="home">
                            <i class="fas fa-file-alt"></i>
                            <span><?php bloginfo('name'); ?></span>
                        </a>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <!-- Mobile Menu Button -->
                <button class="menu-toggle" id="menuToggle" aria-controls="primary-menu" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Navigation Menu -->
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'rapports_publics_fallback_menu',
                    ));
                    ?>
                </nav><!-- #site-navigation -->
                
            </div><!-- .header-container -->
        </div><!-- .container -->
    </header><!-- #masthead -->