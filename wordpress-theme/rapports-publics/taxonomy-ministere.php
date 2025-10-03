<?php
/**
 * The template for displaying ministry taxonomy archives
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
                        __('Tous les rapports publiés par %s', 'rapports-publics'), 
                        '<strong>' . esc_html($term->name) . '</strong>'
                    ); 
                    ?>
                </p>
            <?php endif; ?>

            <!-- Taxonomy Meta -->
            <div class="taxonomy-meta">
                <div class="meta-item">
                    <span class="meta-label"><?php _e('Ministère :', 'rapports-publics'); ?></span>
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
                
                <!-- Category Filter for this Ministry -->
                <div class="category-filter">
                    <label for="category-filter-ministry">
                        <?php _e('Filtrer par catégorie dans ce ministère :', 'rapports-publics'); ?>
                    </label>
                    <select id="category-filter-ministry">
                        <option value=""><?php _e('Toutes les catégories', 'rapports-publics'); ?></option>
                        <?php
                        // Get categories that have posts in this ministry
                        $categories = get_terms(array(
                            'taxonomy' => 'rapport_category',
                            'hide_empty' => true,
                        ));
                        
                        if (!empty($categories) && !is_wp_error($categories)) :
                            foreach ($categories as $category) :
                                // Check if this category has posts in current ministry
                                $posts_in_both = get_posts(array(
                                    'post_type' => 'rapport',
                                    'numberposts' => 1,
                                    'tax_query' => array(
                                        'relation' => 'AND',
                                        array(
                                            'taxonomy' => 'ministere',
                                            'field' => 'slug',
                                            'terms' => $term->slug,
                                        ),
                                        array(
                                            'taxonomy' => 'rapport_category',
                                            'field' => 'slug', 
                                            'terms' => $category->slug,
                                        ),
                                    ),
                                ));
                                
                                if (!empty($posts_in_both)) :
                                    $filter_url = add_query_arg('rapport_category', $category->slug, get_term_link($term));
                                    ?>
                                    <option value="<?php echo esc_url($filter_url); ?>">
                                        <?php echo esc_html($category->name); ?>
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
                            '%d rapport de ce ministère',
                            '%d rapports de ce ministère',
                            $total_reports,
                            'rapports-publics'
                        ),
                        $total_reports
                    );
                } else {
                    _e('Aucun rapport de ce ministère', 'rapports-publics');
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

                                <!-- Categories -->
                                <?php
                                $categories = get_the_terms(get_the_ID(), 'rapport_category');
                                if ($categories && !is_wp_error($categories)) :
                                    foreach ($categories as $category) :
                                        ?>
                                        <span class="category-badge">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
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
                        __('Ce ministère n\'a pas encore publié de rapports. Consultez %s pour voir tous les rapports disponibles.', 'rapports-publics'),
                        '<a href="' . esc_url(get_post_type_archive_link('rapport')) . '">' . __('la liste complète', 'rapports-publics') . '</a>'
                    );
                    ?>
                </p>
            </div>

        <?php endif; ?>

        <!-- Related Ministries -->
        <section class="related-ministries">
            <h2><?php _e('Autres Ministères', 'rapports-publics'); ?></h2>
            <div class="ministries-grid">
                <?php
                $other_ministries = get_terms(array(
                    'taxonomy' => 'ministere',
                    'hide_empty' => true,
                    'exclude' => $term->term_id,
                    'number' => 6,
                ));
                
                if (!empty($other_ministries) && !is_wp_error($other_ministries)) :
                    foreach ($other_ministries as $ministry) :
                        ?>
                        <div class="ministry-card">
                            <h3>
                                <a href="<?php echo esc_url(get_term_link($ministry)); ?>">
                                    <?php echo esc_html($ministry->name); ?>
                                </a>
                            </h3>
                            <p class="ministry-count">
                                <?php
                                printf(
                                    _n(
                                        '%d rapport',
                                        '%d rapports',
                                        $ministry->count,
                                        'rapports-publics'
                                    ),
                                    $ministry->count
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
/* Taxonomy-specific styles */
.taxonomy-header {
    background: var(--light-color);
    padding: 2rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.taxonomy-title {
    color: var(--primary-color);
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.taxonomy-description {
    font-size: 1.125rem;
    color: var(--text-color);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.taxonomy-meta {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.taxonomy-meta .meta-item {
    display: flex;
    flex-direction: column;
}

.taxonomy-meta .meta-label {
    font-size: 0.875rem;
    color: var(--text-color);
    opacity: 0.8;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.taxonomy-meta .meta-value {
    font-weight: 600;
    color: var(--primary-color);
}

.taxonomy-filters {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--secondary-color);
    border-radius: var(--border-radius);
}

.filter-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.category-filter {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.category-filter label {
    font-weight: 500;
    white-space: nowrap;
}

.category-filter select {
    min-width: 200px;
}

.category-badge {
    background: var(--border-color);
    color: var(--text-color);
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.download-info {
    margin-top: 0.75rem;
    color: var(--text-color);
    opacity: 0.8;
}

.download-info svg {
    vertical-align: middle;
    margin-right: 0.25rem;
}

.related-ministries {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.ministries-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.ministry-card {
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 1rem;
    text-align: center;
    transition: var(--transition);
}

.ministry-card:hover {
    box-shadow: var(--box-shadow);
    transform: translateY(-2px);
}

.ministry-card h3 {
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.ministry-card a {
    color: var(--primary-color);
    text-decoration: none;
}

.ministry-card a:hover {
    color: var(--hover-color);
}

.ministry-count {
    font-size: 0.875rem;
    color: var(--text-color);
    opacity: 0.8;
    margin: 0;
}

@media (max-width: 768px) {
    .taxonomy-title {
        font-size: 2rem;
    }
    
    .filter-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .category-filter {
        justify-content: space-between;
    }
    
    .category-filter select {
        min-width: auto;
        flex: 1;
    }
    
    .taxonomy-meta {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>