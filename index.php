<?php
/**
 * The main template file
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    
    <?php if (is_home() && is_front_page()) : ?>
        
        <!-- Hero Section -->
        <?php get_template_part('template-parts/hero', 'section'); ?>
        
        <!-- About Section -->
        <?php get_template_part('template-parts/about', 'section'); ?>
        
        <!-- Reports Section -->
        <?php get_template_part('template-parts/reports', 'section'); ?>
        
        <!-- FAQ Section -->
        <?php get_template_part('template-parts/faq', 'section'); ?>
        
    <?php else : ?>
        
        <!-- Default Content Loop -->
        <div class="container">
            <section class="content-area">
                
                <?php if (have_posts()) : ?>
                    
                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('report-card'); ?>>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="report-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('rapport-thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="report-content">
                                    
                                    <?php 
                                    $ministere = get_the_terms(get_the_ID(), 'ministere');
                                    if ($ministere && !is_wp_error($ministere)) : ?>
                                        <span class="report-category"><?php echo esc_html($ministere[0]->name); ?></span>
                                    <?php endif; ?>
                                    
                                    <h2 class="report-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="report-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <div class="report-meta">
                                        <?php 
                                        $publication_date = get_post_meta(get_the_ID(), '_publication_date', true);
                                        if ($publication_date) : ?>
                                            <span class="report-date">
                                                <?php echo __('Publié le', 'rapports-publics') . ' ' . date('j F Y', strtotime($publication_date)); ?>
                                            </span>
                                        <?php else : ?>
                                            <span class="report-date">
                                                <?php echo __('Publié le', 'rapports-publics') . ' ' . get_the_date('j F Y'); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>
                                
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php
                    // Pagination
                    the_posts_navigation(array(
                        'prev_text' => __('&larr; Rapports précédents', 'rapports-publics'),
                        'next_text' => __('Rapports suivants &rarr;', 'rapports-publics'),
                    ));
                    ?>
                    
                <?php else : ?>
                    
                    <div class="no-content">
                        <h2><?php _e('Aucun rapport trouvé', 'rapports-publics'); ?></h2>
                        <p><?php _e('Il semble qu\'aucun rapport ne soit disponible pour le moment.', 'rapports-publics'); ?></p>
                    </div>
                    
                <?php endif; ?>
                
            </section>
        </div>
        
    <?php endif; ?>
    
</main>

<?php
get_footer();