<?php
/**
 * Template for displaying reports archive
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    
    <div class="page-template">
        <div class="container">
            
            <!-- Page Header -->
            <div class="page-header" style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem; color: var(--dark); margin-bottom: 1rem;">
                    <?php 
                    if (is_tax('ministere')) {
                        $term = get_queried_object();
                        printf(__('Rapports - %s', 'rapports-publics'), $term->name);
                    } elseif (is_tax('rapport_category')) {
                        $term = get_queried_object();
                        printf(__('Catégorie: %s', 'rapports-publics'), $term->name);
                    } else {
                        _e('Tous les Rapports Publics', 'rapports-publics');
                    }
                    ?>
                </h1>
                
                <?php if (is_tax()) : 
                    $term = get_queried_object();
                    if ($term->description) : ?>
                        <p style="font-size: 1.1rem; color: var(--gray); max-width: 600px; margin: 0 auto;">
                            <?php echo esc_html($term->description); ?>
                        </p>
                    <?php endif;
                endif; ?>
            </div>

            <!-- Filter and Search Section -->
            <div class="archive-filters" style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-bottom: 3rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; align-items: end;">
                    
                    <!-- Search Form -->
                    <div>
                        <label for="report-search" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                            <?php _e('Rechercher:', 'rapports-publics'); ?>
                        </label>
                        <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="hidden" name="post_type" value="rapport">
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="search" 
                                       id="report-search"
                                       name="s" 
                                       value="<?php echo get_search_query(); ?>" 
                                       placeholder="<?php _e('Titre, ministère, mots-clés...', 'rapports-publics'); ?>"
                                       style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                                <button type="submit" class="btn" style="padding: 0.75rem 1.5rem;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Ministry Filter -->
                    <div>
                        <label for="ministry-filter" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                            <?php _e('Ministère:', 'rapports-publics'); ?>
                        </label>
                        <select id="ministry-filter" onchange="location = this.value;" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>">
                                <?php _e('Tous les ministères', 'rapports-publics'); ?>
                            </option>
                            <?php
                            $ministeres = get_terms(array(
                                'taxonomy' => 'ministere',
                                'hide_empty' => true,
                            ));
                            if ($ministeres && !is_wp_error($ministeres)) :
                                foreach ($ministeres as $ministere) : ?>
                                    <option value="<?php echo esc_url(get_term_link($ministere)); ?>"
                                            <?php selected(is_tax('ministere', $ministere->slug)); ?>>
                                        <?php echo esc_html($ministere->name); ?> (<?php echo $ministere->count; ?>)
                                    </option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category-filter" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                            <?php _e('Catégorie:', 'rapports-publics'); ?>
                        </label>
                        <select id="category-filter" onchange="location = this.value;" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>">
                                <?php _e('Toutes les catégories', 'rapports-publics'); ?>
                            </option>
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'rapport_category',
                                'hide_empty' => true,
                            ));
                            if ($categories && !is_wp_error($categories)) :
                                foreach ($categories as $category) : ?>
                                    <option value="<?php echo esc_url(get_term_link($category)); ?>"
                                            <?php selected(is_tax('rapport_category', $category->slug)); ?>>
                                        <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                                    </option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                </div>
            </div>

            <!-- Results Count -->
            <div style="margin-bottom: 2rem; color: var(--gray);">
                <?php
                global $wp_query;
                $total = $wp_query->found_posts;
                $current_page = max(1, get_query_var('paged'));
                $per_page = get_query_var('posts_per_page');
                $start = ($current_page - 1) * $per_page + 1;
                $end = min($current_page * $per_page, $total);

                if ($total > 0) {
                    printf(__('Affichage de %d-%d sur %d rapports', 'rapports-publics'), $start, $end, $total);
                } else {
                    _e('Aucun rapport trouvé', 'rapports-publics');
                }
                ?>
            </div>

            <!-- Reports Grid -->
            <?php if (have_posts()) : ?>
                <div class="reports-grid" style="margin-bottom: 3rem;">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="report-card">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('rapport-thumbnail', array('alt' => get_the_title())); ?>
                                </a>
                            <?php else : ?>
                                <div class="report-placeholder" style="height: 200px; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="report-content">
                                
                                <?php 
                                $ministere = get_the_terms(get_the_ID(), 'ministere');
                                if ($ministere && !is_wp_error($ministere)) : ?>
                                    <span class="report-category"><?php echo esc_html($ministere[0]->name); ?></span>
                                <?php endif; ?>
                                
                                <h3 class="report-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <p class="report-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                
                                <div class="report-meta" style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; font-size: 0.85rem; color: var(--gray);">
                                    <span class="report-date">
                                        <?php 
                                        $publication_date = get_post_meta(get_the_ID(), '_publication_date', true);
                                        if ($publication_date) {
                                            echo date_i18n('j M Y', strtotime($publication_date));
                                        } else {
                                            echo get_the_date('j M Y');
                                        }
                                        ?>
                                    </span>
                                    
                                    <?php 
                                    $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                                    if ($download_count) : ?>
                                        <span class="download-count">
                                            <i class="fas fa-download"></i> <?php echo number_format($download_count); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="archive-pagination" style="text-align: center;">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Précédent', 'rapports-publics'),
                        'next_text' => __('Suivant', 'rapports-publics') . ' <i class="fas fa-chevron-right"></i>',
                        'mid_size' => 2,
                        'type' => 'list',
                    ));
                    ?>
                </div>

            <?php else : ?>
                
                <!-- No Results -->
                <div class="no-reports" style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;">
                    <i class="fas fa-search" style="font-size: 4rem; color: var(--gray); margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--dark); margin-bottom: 1rem;"><?php _e('Aucun rapport trouvé', 'rapports-publics'); ?></h3>
                    <p style="color: var(--gray); margin-bottom: 2rem;">
                        <?php _e('Essayez de modifier vos critères de recherche ou de navigation.', 'rapports-publics'); ?>
                    </p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn">
                        <?php _e('Voir Tous les Rapports', 'rapports-publics'); ?>
                    </a>
                </div>

            <?php endif; ?>

        </div><!-- .container -->
    </div><!-- .page-template -->

</main>

<?php
get_footer();