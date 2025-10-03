<?php
/**
 * The template for displaying report category taxonomy archives
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        
        <!-- Taxonomy Header -->
        <header class="taxonomy-header">
            <?php
            $term = get_queried_object();
            ?>
            <h1 class="taxonomy-title">
                <?php echo esc_html($term->name); ?>
            </h1>
            
            <?php if ($term->description) : ?>
                <div class="taxonomy-description">
                    <?php echo wp_kses_post($term->description); ?>
                </div>
            <?php else : ?>
                <p class="taxonomy-description">
                    <?php 
                    printf(
                        __('Tous les rapports de la catégorie %s', 'rapports-publics'), 
                        '<strong>' . esc_html($term->name) . '</strong>'
                    ); 
                    ?>
                </p>
            <?php endif; ?>

            <!-- Taxonomy Meta -->
            <div class="taxonomy-meta">
                <div class="meta-item">
                    <span class="meta-label"><?php _e('Catégorie :', 'rapports-publics'); ?></span>
                    <span class="meta-value"><?php echo esc_html($term->name); ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label"><?php _e('Nombre de rapports :', 'rapports-publics'); ?></span>
                    <span class="meta-value"><?php echo $term->count; ?></span>
                </div>
            </div>
        </header>

        <!-- Filter Options -->
        <section class="taxonomy-filters">
            <div class="filter-actions">
                <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn btn-secondary">
                    <?php _e('← Tous les Rapports', 'rapports-publics'); ?>
                </a>
                
                <!-- Ministry Filter for this Category -->
                <div class="ministry-filter">
                    <label for="ministry-filter-category">
                        <?php _e('Filtrer par ministère dans cette catégorie :', 'rapports-publics'); ?>
                    </label>
                    <select id="ministry-filter-category">
                        <option value=""><?php _e('Tous les ministères', 'rapports-publics'); ?></option>
                        <?php
                        // Get ministries that have posts in this category
                        $ministries = get_terms(array(
                            'taxonomy' => 'ministere',
                            'hide_empty' => true,
                        ));
                        
                        if (!empty($ministries) && !is_wp_error($ministries)) :
                            foreach ($ministries as $ministry) :
                                // Check if this ministry has posts in current category
                                $posts_in_both = get_posts(array(
                                    'post_type' => 'rapport',
                                    'numberposts' => 1,
                                    'tax_query' => array(
                                        'relation' => 'AND',
                                        array(
                                            'taxonomy' => 'rapport_category',
                                            'field' => 'slug',
                                            'terms' => $term->slug,
                                        ),
                                        array(
                                            'taxonomy' => 'ministere',
                                            'field' => 'slug', 
                                            'terms' => $ministry->slug,
                                        ),
                                    ),
                                ));
                                
                                if (!empty($posts_in_both)) :
                                    $filter_url = add_query_arg('ministere', $ministry->slug, get_term_link($term));
                                    ?>
                                    <option value="<?php echo esc_url($filter_url); ?>">
                                        <?php echo esc_html($ministry->name); ?>
                                    </option>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
        </section>

        <!-- Reports Count -->
        <?php
        global $wp_query;
        $total_reports = $wp_query->found_posts;
        ?>
        <div class="results-info">
            <p class="results-count">
                <?php
                if ($total_reports > 0) {
                    printf(
                        _n(
                            '%d rapport dans cette catégorie',
                            '%d rapports dans cette catégorie',
                            $total_reports,
                            'rapports-publics'
                        ),
                        $total_reports
                    );
                } else {
                    _e('Aucun rapport dans cette catégorie', 'rapports-publics');
                }
                ?>
            </p>
        </div>

        <!-- Reports Grid -->
        <?php if (have_posts()) : ?>
            <div class="reports-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('report-card card'); ?>>
                        
                        <!-- Report Thumbnail -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="report-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('rapport-thumbnail', array(
                                        'alt' => get_the_title(),
                                        'loading' => 'lazy'
                                    )); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            
                            <!-- Report Meta -->
                            <div class="report-meta">
                                <!-- Ministry -->
                                <?php
                                $ministries = get_the_terms(get_the_ID(), 'ministere');
                                if ($ministries && !is_wp_error($ministries)) :
                                    $ministry = array_shift($ministries);
                                    ?>
                                    <span class="ministry-badge">
                                        <a href="<?php echo esc_url(get_term_link($ministry)); ?>">
                                            <?php echo esc_html($ministry->name); ?>
                                        </a>
                                    </span>
                                <?php endif; ?>

                                <!-- Publication Date -->
                                <?php
                                $publication_date = get_post_meta(get_the_ID(), '_publication_date', true);
                                if ($publication_date) :
                                    $formatted_date = date_i18n(get_option('date_format'), strtotime($publication_date));
                                    ?>
                                    <span class="report-date">
                                        <time datetime="<?php echo esc_attr($publication_date); ?>">
                                            <?php echo esc_html($formatted_date); ?>
                                        </time>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Report Title -->
                            <h2 class="card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <!-- Report Excerpt -->
                            <?php if (has_excerpt()) : ?>
                                <div class="report-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Report Actions -->
                            <div class="report-actions">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php _e('Voir le Détail', 'rapports-publics'); ?>
                                </a>
                                
                                <!-- NO DOWNLOAD BUTTON HERE - Only on single report pages -->
                            </div>

                            <!-- Download Count (Read-only info) -->
                            <?php
                            $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                            if ($download_count > 0) :
                                ?>
                                <div class="download-info">
                                    <small>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <?php
                                        printf(
                                            _n(
                                                '%d téléchargement',
                                                '%d téléchargements',
                                                $download_count,
                                                'rapports-publics'
                                            ),
                                            number_format_i18n($download_count)
                                        );
                                        ?>
                                    </small>
                                </div>
                            <?php endif; ?>

                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <nav class="pagination-nav" aria-label="<?php _e('Navigation des rapports', 'rapports-publics'); ?>">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('« Précédent', 'rapports-publics'),
                    'next_text' => __('Suivant »', 'rapports-publics'),
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'rapports-publics') . ' </span>',
                ));
                ?>
            </nav>

        <?php else : ?>
            
            <!-- No Reports Found -->
            <div class="no-reports-found">
                <h2><?php _e('Aucun rapport trouvé', 'rapports-publics'); ?></h2>
                <p>
                    <?php
                    printf(
                        __('Cette catégorie ne contient pas encore de rapports. Consultez %s pour voir tous les rapports disponibles.', 'rapports-publics'),
                        '<a href="' . esc_url(get_post_type_archive_link('rapport')) . '">' . __('la liste complète', 'rapports-publics') . '</a>'
                    );
                    ?>
                </p>
            </div>

        <?php endif; ?>

        <!-- Related Categories -->
        <section class="related-categories">
            <h2><?php _e('Autres Catégories', 'rapports-publics'); ?></h2>
            <div class="categories-grid">
                <?php
                $other_categories = get_terms(array(
                    'taxonomy' => 'rapport_category',
                    'hide_empty' => true,
                    'exclude' => $term->term_id,
                    'number' => 8,
                ));
                
                if (!empty($other_categories) && !is_wp_error($other_categories)) :
                    foreach ($other_categories as $category) :
                        ?>
                        <div class="category-card">
                            <h3>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </h3>
                            <p class="category-count">
                                <?php
                                printf(
                                    _n(
                                        '%d rapport',
                                        '%d rapports',
                                        $category->count,
                                        'rapports-publics'
                                    ),
                                    $category->count
                                );
                                ?>
                            </p>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>

    </div>
</main>

<style>
/* Category-specific styles (inherits from taxonomy styles in taxonomy-ministere.php) */
.ministry-badge a {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ministry-badge a:hover {
    background: var(--hover-color);
}

.ministry-filter {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.ministry-filter label {
    font-weight: 500;
    white-space: nowrap;
}

.ministry-filter select {
    min-width: 200px;
}

.related-categories {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.category-card {
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 1rem;
    text-align: center;
    transition: var(--transition);
}

.category-card:hover {
    box-shadow: var(--box-shadow);
    transform: translateY(-2px);
}

.category-card h3 {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.category-card a {
    color: var(--primary-color);
    text-decoration: none;
}

.category-card a:hover {
    color: var(--hover-color);
}

.category-count {
    font-size: 0.875rem;
    color: var(--text-color);
    opacity: 0.8;
    margin: 0;
}

@media (max-width: 768px) {
    .ministry-filter {
        justify-content: space-between;
    }
    
    .ministry-filter select {
        min-width: auto;
        flex: 1;
    }
    
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    }
}
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>