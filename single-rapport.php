<?php
/**
 * Template for displaying single reports
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <div class="single-post">
            <div class="container">
                
                <!-- Report Header -->
                <div class="single-header">
                    <?php 
                    $ministere = get_the_terms(get_the_ID(), 'ministere');
                    if ($ministere && !is_wp_error($ministere)) : ?>
                        <span class="post-category"><?php echo esc_html($ministere[0]->name); ?></span>
                    <?php endif; ?>
                    
                    <h1><?php the_title(); ?></h1>
                    
                    <p class="post-date">
                        <?php 
                        $publication_date = get_post_meta(get_the_ID(), '_publication_date', true);
                        if ($publication_date) {
                            echo __('Publié le', 'rapports-publics') . ' ' . date_i18n('j F Y', strtotime($publication_date));
                        } else {
                            echo __('Publié le', 'rapports-publics') . ' ' . get_the_date('j F Y');
                        }
                        ?>
                    </p>
                </div>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-featured">
                        <?php the_post_thumbnail('rapport-featured', array('alt' => get_the_title())); ?>
                    </div>
                <?php endif; ?>

                <div class="single-content">
                    
                    <!-- Main Content Area -->
                    <div class="content-area">
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            
                            <!-- Report Meta Information -->
                            <div class="report-meta-box" style="background: #f8f9fa; padding: 1.5rem; margin-bottom: 2rem; border-radius: 8px;">
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                                    
                                    <?php 
                                    $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                                    if ($download_count) : ?>
                                        <div>
                                            <strong><?php _e('Téléchargements:', 'rapports-publics'); ?></strong><br>
                                            <?php echo number_format($download_count); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    $file_size = get_post_meta(get_the_ID(), '_file_size', true);
                                    if ($file_size) : ?>
                                        <div>
                                            <strong><?php _e('Taille:', 'rapports-publics'); ?></strong><br>
                                            <?php echo esc_html($file_size); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($ministere && !is_wp_error($ministere)) : ?>
                                        <div>
                                            <strong><?php _e('Ministère:', 'rapports-publics'); ?></strong><br>
                                            <a href="<?php echo esc_url(get_term_link($ministere[0])); ?>">
                                                <?php echo esc_html($ministere[0]->name); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                                
                                <!-- Download Button -->
                                <?php 
                                $file_url = get_post_meta(get_the_ID(), '_file_url', true);
                                if ($file_url) : ?>
                                    <div style="margin-top: 1.5rem;">
                                        <a href="<?php echo esc_url(home_url('/?download_rapport=' . get_the_ID())); ?>" 
                                           class="btn" 
                                           style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                            <i class="fas fa-download"></i>
                                            <?php _e('Télécharger le Rapport (PDF)', 'rapports-publics'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Report Content -->
                            <div class="report-content">
                                <?php the_content(); ?>
                            </div>

                        </article>

                        <!-- Navigation between reports -->
                        <div class="navigation" style="display: flex; gap: 1rem; margin-top: 3rem;">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if ($prev_post) : ?>
                                <div class="nav-card prev" style="flex: 1;">
                                    <?php if (has_post_thumbnail($prev_post->ID)) : ?>
                                        <a href="<?php echo get_permalink($prev_post); ?>">
                                            <?php echo get_the_post_thumbnail($prev_post->ID, array(400, 120)); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="nav-card-content" style="padding: 1rem;">
                                        <h4 class="nav-card-title">
                                            <a href="<?php echo get_permalink($prev_post); ?>">
                                                <?php echo get_the_title($prev_post); ?>
                                            </a>
                                        </h4>
                                        <p class="nav-card-excerpt">
                                            <?php echo wp_trim_words(get_post_field('post_excerpt', $prev_post->ID), 15); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($next_post) : ?>
                                <div class="nav-card next" style="flex: 1;">
                                    <?php if (has_post_thumbnail($next_post->ID)) : ?>
                                        <a href="<?php echo get_permalink($next_post); ?>">
                                            <?php echo get_the_post_thumbnail($next_post->ID, array(400, 120)); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="nav-card-content" style="padding: 1rem;">
                                        <h4 class="nav-card-title">
                                            <a href="<?php echo get_permalink($next_post); ?>">
                                                <?php echo get_the_title($next_post); ?>
                                            </a>
                                        </h4>
                                        <p class="nav-card-excerpt">
                                            <?php echo wp_trim_words(get_post_field('post_excerpt', $next_post->ID), 15); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div><!-- .content-area -->

                    <!-- Sidebar -->
                    <div class="sidebar" style="width: 300px;">
                        
                        <!-- Latest Reports Widget -->
                        <div class="widget" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 1.5rem;">
                            <h3 class="widget-title" style="color: var(--primary); border-bottom: 2px solid var(--accent); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                                <?php _e('Derniers Rapports', 'rapports-publics'); ?>
                            </h3>
                            
                            <?php
                            $latest_reports = new WP_Query(array(
                                'post_type' => 'rapport',
                                'posts_per_page' => 5,
                                'post__not_in' => array(get_the_ID()),
                                'post_status' => 'publish'
                            ));
                            
                            if ($latest_reports->have_posts()) : ?>
                                <ul class="latest-posts-list" style="list-style: none; margin: 0; padding: 0;">
                                    <?php while ($latest_reports->have_posts()) : $latest_reports->the_post(); ?>
                                        <li style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                                            <h4 class="latest-post-title" style="margin: 0.25rem 0; font-size: 1rem;">
                                                <a href="<?php the_permalink(); ?>" style="color: var(--dark); text-decoration: none; font-weight: 500;">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h4>
                                            <p class="latest-post-date" style="font-size: 0.85rem; color: var(--gray); margin: 0;">
                                                <?php 
                                                $pub_date = get_post_meta(get_the_ID(), '_publication_date', true);
                                                if ($pub_date) {
                                                    echo date_i18n('j F Y', strtotime($pub_date));
                                                } else {
                                                    echo get_the_date('j F Y');
                                                }
                                                ?>
                                            </p>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>

                        <!-- Categories Widget -->
                        <?php
                        $report_categories = get_terms(array(
                            'taxonomy' => 'rapport_category',
                            'hide_empty' => true,
                        ));
                        if ($report_categories && !is_wp_error($report_categories)) : ?>
                            <div class="widget" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <h3 class="widget-title" style="color: var(--primary); border-bottom: 2px solid var(--accent); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                                    <?php _e('Catégories', 'rapports-publics'); ?>
                                </h3>
                                <ul style="list-style: none; margin: 0; padding: 0;">
                                    <?php foreach ($report_categories as $category) : ?>
                                        <li style="margin-bottom: 0.5rem;">
                                            <a href="<?php echo esc_url(get_term_link($category)); ?>" style="color: var(--dark); text-decoration: none;">
                                                <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div><!-- .sidebar -->

                </div><!-- .single-content -->

            </div><!-- .container -->
        </div><!-- .single-post -->

    <?php endwhile; ?>

</main>

<?php
get_footer();