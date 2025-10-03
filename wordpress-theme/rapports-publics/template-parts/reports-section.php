<?php
/**
 * Template part for displaying the latest reports section
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

// Query for latest reports
$latest_reports_query = new WP_Query(array(
    'post_type' => 'rapport',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_query' => array(
        array(
            'key' => '_file_url',
            'compare' => 'EXISTS'
        )
    )
));
?>

<section class="reports-section" id="latest-reports">
    <div class="container">
        
        <div class="section-header">
            <h2 class="section-title">
                <?php _e('Derniers Rapports Publiés', 'rapports-publics'); ?>
            </h2>
            <p class="section-subtitle">
                <?php _e('Découvrez les dernières publications officielles des institutions publiques', 'rapports-publics'); ?>
            </p>
        </div>

        <?php if ($latest_reports_query->have_posts()) : ?>
            
            <div class="reports-grid">
                <?php while ($latest_reports_query->have_posts()) : $latest_reports_query->the_post(); ?>
                    
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
                                <div class="report-overlay">
                                    <span class="report-badge">
                                        <?php _e('Nouveau', 'rapports-publics'); ?>
                                    </span>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="report-thumbnail no-image">
                                <div class="placeholder-content">
                                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="14,2 14,8 20,8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <line x1="16" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <line x1="16" y1="17" x2="8" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="10,9 9,9 8,9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="report-overlay">
                                    <span class="report-badge">
                                        <?php _e('Nouveau', 'rapports-publics'); ?>
                                    </span>
                                </div>
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
                                <?php else : ?>
                                    <span class="report-date">
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Report Title -->
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Report Excerpt -->
                            <?php if (has_excerpt()) : ?>
                                <div class="report-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                            <?php else : ?>
                                <div class="report-excerpt">
                                    <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Report Categories -->
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'rapport_category');
                            if ($categories && !is_wp_error($categories)) : ?>
                                <div class="report-categories">
                                    <?php foreach (array_slice($categories, 0, 2) as $category) : ?>
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                                           class="category-tag">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                    <?php if (count($categories) > 2) : ?>
                                        <span class="more-categories">
                                            +<?php echo (count($categories) - 2); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Report Actions -->
                            <div class="report-actions">
                                <a href="<?php the_permalink(); ?>" class="btn btn-secondary">
                                    <?php _e('Voir le détail', 'rapports-publics'); ?>
                                </a>
                                
                                <?php
                                $file_url = get_post_meta(get_the_ID(), '_file_url', true);
                                if ($file_url) :
                                    $download_url = rapports_publics_get_download_url(get_the_ID());
                                    ?>
                                    <a href="<?php echo esc_url($download_url); ?>" 
                                       class="btn btn-primary"
                                       onclick="trackDownload(<?php echo get_the_ID(); ?>, '<?php echo esc_js(get_the_title()); ?>')"
                                       target="_blank">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <?php _e('Télécharger', 'rapports-publics'); ?>
                                        <?php
                                        $file_size = get_post_meta(get_the_ID(), '_file_size', true);
                                        if ($file_size) :
                                            ?>
                                            <small>(<?php echo esc_html($file_size); ?>)</small>
                                            <?php
                                        endif;
                                        ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Download Stats -->
                            <?php
                            $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                            if ($download_count > 0) :
                                ?>
                                <div class="download-stats">
                                    <small class="download-count">
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

            <!-- View All Reports Button -->
            <div class="section-footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn btn-large">
                    <?php _e('Voir Tous les Rapports', 'rapports-publics'); ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m9 18 6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                
                <div class="total-count">
                    <?php
                    $total_reports = wp_count_posts('rapport');
                    $published_count = $total_reports->publish ?? 0;
                    printf(
                        _n(
                            'Au total, %d rapport disponible',
                            'Au total, %d rapports disponibles',
                            $published_count,
                            'rapports-publics'
                        ),
                        number_format_i18n($published_count)
                    );
                    ?>
                </div>
            </div>

        <?php else : ?>
            
            <!-- No Reports Found -->
            <div class="no-reports">
                <div class="no-reports-content">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="14,2 14,8 20,8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3><?php _e('Aucun rapport disponible', 'rapports-publics'); ?></h3>
                    <p><?php _e('Les nouveaux rapports seront publiés ici dès qu\'ils seront disponibles.', 'rapports-publics'); ?></p>
                </div>
            </div>
            
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>
</section>

<style>
.reports-section {
    padding: 4rem 0;
    background-color: var(--secondary-color);
}

.section-footer {
    text-align: center;
    margin-top: 3rem;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.total-count {
    margin-top: 1rem;
    color: var(--text-color);
    font-size: 0.875rem;
}

.report-thumbnail {
    position: relative;
    overflow: hidden;
}

.report-thumbnail.no-image {
    background: var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    color: var(--text-color);
}

.placeholder-content {
    opacity: 0.5;
}

.report-overlay {
    position: absolute;
    top: 0;
    right: 0;
    padding: 0.5rem;
}

.report-badge {
    background: var(--success-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.report-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
}

.report-ministry a {
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

.report-ministry a:hover {
    background: var(--hover-color);
}

.report-date {
    color: var(--text-color);
    opacity: 0.8;
    font-size: 0.8rem;
}

.report-categories {
    margin-bottom: 1rem;
}

.category-tag {
    background: var(--border-color);
    color: var(--text-color);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-size: 0.75rem;
    margin-right: 0.5rem;
    display: inline-block;
    margin-bottom: 0.25rem;
}

.category-tag:hover {
    background: var(--primary-color);
    color: white;
}

.more-categories {
    background: var(--text-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.report-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}

.report-actions .btn {
    flex: 1;
    min-width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary svg {
    fill: none;
}

.download-stats {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-color);
    opacity: 0.8;
}

.download-count {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
}

.no-reports {
    text-align: center;
    padding: 3rem 0;
}

.no-reports-content svg {
    color: var(--border-color);
    margin-bottom: 1rem;
}

.no-reports-content h3 {
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.no-reports-content p {
    color: var(--text-color);
    opacity: 0.8;
}

@media (max-width: 768px) {
    .report-actions {
        flex-direction: column;
    }
    
    .report-actions .btn {
        width: 100%;
    }
    
    .report-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>