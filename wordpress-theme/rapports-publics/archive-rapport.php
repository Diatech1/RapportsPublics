<?php
/**
 * The template for displaying archive pages for reports
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        
        <!-- Page Header -->
        <header class="page-header">
            <h1 class="page-title">
                <?php
                if (is_tax()) {
                    single_term_title();
                } else {
                    _e('Tous les Rapports Publics', 'rapports-publics');
                }
                ?>
            </h1>
            
            <?php if (is_tax() && term_description()) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php else : ?>
                <p class="archive-description">
                    <?php _e('Consultez et téléchargez les rapports publics des différents ministères et organismes gouvernementaux.', 'rapports-publics'); ?>
                </p>
            <?php endif; ?>
        </header>

        <!-- Filters Section -->
        <section class="filters-section">
            <div class="filters-grid">
                
                <!-- Ministry Filter -->
                <div class="filter-group">
                    <label for="ministry-filter">
                        <?php _e('Filtrer par Ministère', 'rapports-publics'); ?>
                    </label>
                    <select id="ministry-filter">
                        <option value=""><?php _e('Tous les ministères', 'rapports-publics'); ?></option>
                        <?php
                        $ministries = get_terms(array(
                            'taxonomy' => 'ministere',
                            'hide_empty' => true,
                        ));
                        
                        if (!empty($ministries) && !is_wp_error($ministries)) :
                            foreach ($ministries as $ministry) :
                                $selected = (is_tax('ministere', $ministry->slug)) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_url(get_term_link($ministry)); ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($ministry->name); ?>
                                    (<?php echo $ministry->count; ?>)
                                </option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <!-- Category Filter -->
                <div class="filter-group">
                    <label for="category-filter">
                        <?php _e('Filtrer par Catégorie', 'rapports-publics'); ?>
                    </label>
                    <select id="category-filter">
                        <option value=""><?php _e('Toutes les catégories', 'rapports-publics'); ?></option>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'rapport_category',
                            'hide_empty' => true,
                        ));
                        
                        if (!empty($categories) && !is_wp_error($categories)) :
                            foreach ($categories as $category) :
                                $selected = (is_tax('rapport_category', $category->slug)) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_url(get_term_link($category)); ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($category->name); ?>
                                    (<?php echo $category->count; ?>)
                                </option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <!-- Year Filter -->
                <div class="filter-group">
                    <label for="year-filter">
                        <?php _e('Filtrer par Année', 'rapports-publics'); ?>
                    </label>
                    <select id="year-filter">
                        <option value=""><?php _e('Toutes les années', 'rapports-publics'); ?></option>
                        <?php
                        // Get years from publication dates
                        global $wpdb;
                        $years = $wpdb->get_col("
                            SELECT DISTINCT YEAR(STR_TO_DATE(meta_value, '%Y-%m-%d')) as year
                            FROM {$wpdb->postmeta} pm
                            INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                            WHERE pm.meta_key = '_publication_date'
                            AND p.post_type = 'rapport'
                            AND p.post_status = 'publish'
                            AND pm.meta_value != ''
                            ORDER BY year DESC
                        ");
                        
                        if (!empty($years)) :
                            foreach ($years as $year) :
                                if ($year && $year > 0) :
                                    $year_url = add_query_arg('year', $year, get_post_type_archive_link('rapport'));
                                    $selected = (isset($_GET['year']) && $_GET['year'] == $year) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo esc_url($year_url); ?>" <?php echo $selected; ?>>
                                        <?php echo esc_html($year); ?>
                                    </option>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <!-- Search Form -->
                <div class="filter-group">
                    <label for="search-input">
                        <?php _e('Rechercher', 'rapports-publics'); ?>
                    </label>
                    <form role="search" method="get" id="report-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="hidden" name="post_type" value="rapport" />
                        <input type="search" 
                               id="search-input" 
                               name="s" 
                               value="<?php echo get_search_query(); ?>" 
                               placeholder="<?php _e('Rechercher un rapport...', 'rapports-publics'); ?>" />
                    </form>
                    <div id="search-results" class="search-results" style="display: none;"></div>
                </div>

            </div>
        </section>

        <!-- Active Filters Display -->
        <?php
        $active_filters = array();
        
        if (is_tax('ministere')) {
            $active_filters[] = array(
                'label' => __('Ministère:', 'rapports-publics'),
                'value' => single_term_title('', false),
                'remove_url' => get_post_type_archive_link('rapport')
            );
        }
        
        if (is_tax('rapport_category')) {
            $active_filters[] = array(
                'label' => __('Catégorie:', 'rapports-publics'),
                'value' => single_term_title('', false),
                'remove_url' => get_post_type_archive_link('rapport')
            );
        }
        
        if (isset($_GET['year']) && $_GET['year']) {
            $active_filters[] = array(
                'label' => __('Année:', 'rapports-publics'),
                'value' => sanitize_text_field($_GET['year']),
                'remove_url' => remove_query_arg('year')
            );
        }
        
        if (get_search_query()) {
            $active_filters[] = array(
                'label' => __('Recherche:', 'rapports-publics'),
                'value' => get_search_query(),
                'remove_url' => get_post_type_archive_link('rapport')
            );
        }
        
        if (!empty($active_filters)) : ?>
            <div class="active-filters">
                <h3><?php _e('Filtres actifs:', 'rapports-publics'); ?></h3>
                <div class="filters-list">
                    <?php foreach ($active_filters as $filter) : ?>
                        <span class="filter-tag">
                            <?php echo esc_html($filter['label']); ?>
                            <strong><?php echo esc_html($filter['value']); ?></strong>
                            <a href="<?php echo esc_url($filter['remove_url']); ?>" 
                               class="remove-filter" 
                               title="<?php _e('Supprimer ce filtre', 'rapports-publics'); ?>">×</a>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Results Count -->
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
                            '%d rapport trouvé',
                            '%d rapports trouvés',
                            $total_reports,
                            'rapports-publics'
                        ),
                        $total_reports
                    );
                } else {
                    _e('Aucun rapport trouvé', 'rapports-publics');
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
                                <?php
                                // Ministry
                                $ministries = get_the_terms(get_the_ID(), 'ministere');
                                if ($ministries && !is_wp_error($ministries)) :
                                    $ministry = array_shift($ministries);
                                    ?>
                                    <span class="report-ministry">
                                        <a href="<?php echo esc_url(get_term_link($ministry)); ?>">
                                            <?php echo esc_html($ministry->name); ?>
                                        </a>
                                    </span>
                                <?php endif; ?>

                                <?php
                                // Publication Date
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

                            <!-- Report Categories -->
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'rapport_category');
                            if ($categories && !is_wp_error($categories)) : ?>
                                <div class="report-categories">
                                    <?php foreach ($categories as $category) : ?>
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                                           class="category-tag">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Report Actions -->
                            <div class="report-actions">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php _e('Voir le Détail', 'rapports-publics'); ?>
                                </a>
                                
                                <!-- File info only (download available on single page) -->
                                <?php
                                $file_url = get_post_meta(get_the_ID(), '_file_url', true);
                                $file_size = get_post_meta(get_the_ID(), '_file_size', true);
                                if ($file_url && $file_size) :
                                    ?>
                                    <span class="file-info">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <polyline points="14,2 14,8 20,8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <?php _e('PDF disponible', 'rapports-publics'); ?>
                                        <small>(<?php echo esc_html($file_size); ?>)</small>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Download Count -->
                            <?php
                            $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                            if ($download_count > 0) :
                                ?>
                                <div class="download-count">
                                    <small>
                                        <?php
                                        printf(
                                            _n(
                                                '%d téléchargement',
                                                '%d téléchargements',
                                                $download_count,
                                                'rapports-publics'
                                            ),
                                            $download_count
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
                    if (is_search()) {
                        printf(
                            __('Aucun rapport ne correspond à votre recherche pour "%s". Essayez avec d\'autres termes.', 'rapports-publics'),
                            '<strong>' . get_search_query() . '</strong>'
                        );
                    } elseif (is_tax() || isset($_GET['year'])) {
                        _e('Aucun rapport ne correspond aux filtres sélectionnés. Essayez de modifier vos critères de recherche.', 'rapports-publics');
                    } else {
                        _e('Aucun rapport n\'est actuellement disponible. Revenez plus tard pour découvrir les nouvelles publications.', 'rapports-publics');
                    }
                    ?>
                </p>
                
                <div class="no-results-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn">
                        <?php _e('Voir tous les rapports', 'rapports-publics'); ?>
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>