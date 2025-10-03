<?php
/**
 * The sidebar containing the main widget area
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

if (!is_active_sidebar('sidebar-main')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    
    <?php if (is_active_sidebar('sidebar-main')) : ?>
        <?php dynamic_sidebar('sidebar-main'); ?>
    <?php else : ?>
        
        <!-- Default Sidebar Content -->
        
        <!-- Search Widget -->
        <div id="search-widget" class="widget widget_search">
            <h3 class="widget-title"><?php _e('Rechercher', 'rapports-publics'); ?></h3>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="post_type" value="rapport" />
                <label for="sidebar-search" class="screen-reader-text">
                    <?php _e('Rechercher des rapports', 'rapports-publics'); ?>
                </label>
                <input type="search" 
                       id="sidebar-search" 
                       name="s" 
                       placeholder="<?php _e('Rechercher un rapport...', 'rapports-publics'); ?>" 
                       class="search-field" 
                       value="<?php echo get_search_query(); ?>" />
                <button type="submit" class="search-submit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                        <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="sr-only"><?php _e('Rechercher', 'rapports-publics'); ?></span>
                </button>
            </form>
        </div>

        <!-- Filter Widget -->
        <div id="filter-widget" class="widget">
            <h3 class="widget-title"><?php _e('Filtrer par', 'rapports-publics'); ?></h3>
            
            <!-- Ministry Filter -->
            <div class="filter-section">
                <h4 class="filter-title"><?php _e('Ministères', 'rapports-publics'); ?></h4>
                <ul class="taxonomy-list">
                    <?php
                    $ministries = get_terms(array(
                        'taxonomy' => 'ministere',
                        'hide_empty' => true,
                        'number' => 8,
                        'orderby' => 'count',
                        'order' => 'DESC'
                    ));
                    
                    if (!empty($ministries) && !is_wp_error($ministries)) :
                        foreach ($ministries as $ministry) :
                            $current = (is_tax('ministere', $ministry->slug)) ? 'current' : '';
                            ?>
                            <li class="<?php echo $current; ?>">
                                <a href="<?php echo esc_url(get_term_link($ministry)); ?>">
                                    <?php echo esc_html($ministry->name); ?>
                                    <small>(<?php echo $ministry->count; ?>)</small>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
                <div class="filter-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>?taxonomy=ministere" class="view-all-link">
                        <?php _e('Voir tous les ministères', 'rapports-publics'); ?>
                    </a>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="filter-section">
                <h4 class="filter-title"><?php _e('Catégories', 'rapports-publics'); ?></h4>
                <ul class="taxonomy-list">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'rapport_category',
                        'hide_empty' => true,
                        'number' => 8,
                        'orderby' => 'count',
                        'order' => 'DESC'
                    ));
                    
                    if (!empty($categories) && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            $current = (is_tax('rapport_category', $category->slug)) ? 'current' : '';
                            ?>
                            <li class="<?php echo $current; ?>">
                                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <small>(<?php echo $category->count; ?>)</small>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
                <div class="filter-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>?taxonomy=rapport_category" class="view-all-link">
                        <?php _e('Voir toutes les catégories', 'rapports-publics'); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Reports Widget -->
        <div id="recent-reports-widget" class="widget">
            <h3 class="widget-title"><?php _e('Rapports Récents', 'rapports-publics'); ?></h3>
            <?php
            $recent_reports = new WP_Query(array(
                'post_type' => 'rapport',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => '_file_url',
                        'compare' => 'EXISTS'
                    )
                )
            ));
            
            if ($recent_reports->have_posts()) : ?>
                <ul class="recent-reports-list">
                    <?php while ($recent_reports->have_posts()) : $recent_reports->the_post(); ?>
                        <li class="recent-report-item">
                            <a href="<?php the_permalink(); ?>" class="report-link">
                                <h4 class="report-title"><?php echo wp_trim_words(get_the_title(), 8); ?></h4>
                                <div class="report-meta">
                                    <?php
                                    $ministries = get_the_terms(get_the_ID(), 'ministere');
                                    if ($ministries && !is_wp_error($ministries)) :
                                        $ministry = array_shift($ministries);
                                        ?>
                                        <span class="report-ministry"><?php echo esc_html($ministry->name); ?></span>
                                    <?php endif; ?>
                                    <span class="report-date"><?php echo get_the_date('d/m/Y'); ?></span>
                                </div>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p><?php _e('Aucun rapport récent disponible.', 'rapports-publics'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Popular Downloads Widget -->
        <div id="popular-downloads-widget" class="widget">
            <h3 class="widget-title"><?php _e('Téléchargements Populaires', 'rapports-publics'); ?></h3>
            <?php
            $popular_reports = new WP_Query(array(
                'post_type' => 'rapport',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'meta_key' => '_download_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_file_url',
                        'compare' => 'EXISTS'
                    ),
                    array(
                        'key' => '_download_count',
                        'value' => 0,
                        'compare' => '>'
                    )
                )
            ));
            
            if ($popular_reports->have_posts()) : ?>
                <ul class="popular-reports-list">
                    <?php while ($popular_reports->have_posts()) : $popular_reports->the_post(); ?>
                        <li class="popular-report-item">
                            <a href="<?php the_permalink(); ?>" class="report-link">
                                <h4 class="report-title"><?php echo wp_trim_words(get_the_title(), 8); ?></h4>
                                <div class="report-meta">
                                    <span class="download-count">
                                        <?php
                                        $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                                        printf(
                                            _n('%d téléchargement', '%d téléchargements', $download_count, 'rapports-publics'),
                                            number_format_i18n($download_count)
                                        );
                                        ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p><?php _e('Aucun téléchargement enregistré pour le moment.', 'rapports-publics'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Statistics Widget -->
        <div id="statistics-widget" class="widget">
            <h3 class="widget-title"><?php _e('Statistiques', 'rapports-publics'); ?></h3>
            <div class="stats-list">
                <?php
                // Total reports
                $reports_count = wp_count_posts('rapport');
                $published_count = $reports_count->publish ?? 0;
                
                // Total ministries
                $ministries_count = wp_count_terms(array(
                    'taxonomy' => 'ministere',
                    'hide_empty' => true
                ));
                
                // Total categories
                $categories_count = wp_count_terms(array(
                    'taxonomy' => 'rapport_category',
                    'hide_empty' => true
                ));
                
                // Total downloads
                global $wpdb;
                $total_downloads = $wpdb->get_var("
                    SELECT SUM(CAST(meta_value AS UNSIGNED)) 
                    FROM {$wpdb->postmeta} 
                    WHERE meta_key = '_download_count' 
                    AND meta_value != '' 
                    AND meta_value > 0
                ");
                $total_downloads = $total_downloads ?: 0;
                ?>
                
                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format_i18n($published_count); ?></span>
                    <span class="stat-label">
                        <?php 
                        printf(
                            _n('Rapport disponible', 'Rapports disponibles', $published_count, 'rapports-publics')
                        );
                        ?>
                    </span>
                </div>

                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format_i18n($ministries_count); ?></span>
                    <span class="stat-label">
                        <?php 
                        printf(
                            _n('Ministère', 'Ministères', $ministries_count, 'rapports-publics')
                        );
                        ?>
                    </span>
                </div>

                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format_i18n($categories_count); ?></span>
                    <span class="stat-label">
                        <?php 
                        printf(
                            _n('Catégorie', 'Catégories', $categories_count, 'rapports-publics')
                        );
                        ?>
                    </span>
                </div>

                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format_i18n($total_downloads); ?></span>
                    <span class="stat-label">
                        <?php 
                        printf(
                            _n('Téléchargement', 'Téléchargements', $total_downloads, 'rapports-publics')
                        );
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions Widget -->
        <div id="quick-actions-widget" class="widget">
            <h3 class="widget-title"><?php _e('Actions Rapides', 'rapports-publics'); ?></h3>
            <div class="quick-actions-list">
                <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="quick-action-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="14,2 14,8 20,8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php _e('Tous les Rapports', 'rapports-publics'); ?>
                </a>
                
                <a href="#search-section" class="quick-action-btn scroll-to">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                        <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php _e('Recherche Avancée', 'rapports-publics'); ?>
                </a>
                
                <a href="#faq" class="quick-action-btn scroll-to">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php _e('Questions Fréquentes', 'rapports-publics'); ?>
                </a>
            </div>
        </div>

    <?php endif; ?>
    
</aside>

<style>
/* Sidebar Styles */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.widget {
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    box-shadow: var(--box-shadow);
}

.widget-title {
    color: var(--primary-color);
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--border-color);
}

/* Search Widget */
.widget_search .search-form {
    position: relative;
}

.widget_search .search-field {
    width: 100%;
    padding: 0.75rem 3rem 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 0.9rem;
}

.widget_search .search-field:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
}

.widget_search .search-submit {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-color);
    cursor: pointer;
    padding: 0.25rem;
}

/* Filter Widget */
.filter-section {
    margin-bottom: 1.5rem;
}

.filter-section:last-child {
    margin-bottom: 0;
}

.filter-title {
    font-size: 1rem;
    color: var(--text-color);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.taxonomy-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.taxonomy-list li {
    margin-bottom: 0.5rem;
}

.taxonomy-list li a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0.75rem;
    color: var(--text-color);
    text-decoration: none;
    border-radius: var(--border-radius);
    transition: var(--transition);
    font-size: 0.9rem;
}

.taxonomy-list li a:hover,
.taxonomy-list li.current a {
    background: var(--secondary-color);
    color: var(--primary-color);
    padding-left: 1rem;
}

.taxonomy-list small {
    opacity: 0.7;
    font-size: 0.8rem;
}

.filter-actions {
    margin-top: 0.75rem;
}

.view-all-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.view-all-link:hover {
    text-decoration: underline;
}

/* Recent Reports Widget */
.recent-reports-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-report-item {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.recent-report-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.recent-report-item .report-link {
    text-decoration: none;
    color: var(--text-color);
    display: block;
}

.recent-report-item .report-title {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: var(--primary-color);
    font-weight: 600;
    line-height: 1.4;
}

.recent-report-item .report-link:hover .report-title {
    color: var(--hover-color);
}

.report-meta {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    font-size: 0.8rem;
    opacity: 0.8;
}

.report-ministry {
    font-weight: 500;
}

.report-date {
    color: var(--text-color);
}

/* Popular Reports Widget */
.popular-reports-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.popular-report-item {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.popular-report-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.popular-report-item .report-link {
    text-decoration: none;
    color: var(--text-color);
    display: block;
}

.popular-report-item .report-title {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: var(--primary-color);
    font-weight: 600;
    line-height: 1.4;
}

.popular-report-item .report-link:hover .report-title {
    color: var(--hover-color);
}

.download-count {
    font-size: 0.8rem;
    color: var(--success-color);
    font-weight: 500;
}

/* Statistics Widget */
.stats-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: var(--secondary-color);
    border-radius: var(--border-radius);
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-color);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Quick Actions Widget */
.quick-actions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: var(--secondary-color);
    color: var(--text-color);
    text-decoration: none;
    border-radius: var(--border-radius);
    font-weight: 500;
    transition: var(--transition);
    font-size: 0.9rem;
}

.quick-action-btn:hover {
    background: var(--primary-color);
    color: var(--light-color);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 992px) {
    .sidebar {
        order: -1;
        margin-bottom: 2rem;
    }
    
    .stats-list {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 768px) {
    .widget {
        padding: 1rem;
    }
    
    .stats-list {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .sidebar {
        gap: 1rem;
    }
    
    .widget-title {
        font-size: 1.125rem;
    }
    
    .stats-list {
        grid-template-columns: 1fr;
    }
    
    .stat-item {
        padding: 0.75rem;
    }
    
    .stat-number {
        font-size: 1.25rem;
    }
}
</style>