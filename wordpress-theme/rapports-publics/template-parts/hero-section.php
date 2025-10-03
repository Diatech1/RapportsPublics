<?php
/**
 * Template part for displaying the hero section
 *
 * @package RapportsPublics
 * @since 1.0.0
 */
?>

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <?php _e('Rapports Publics', 'rapports-publics'); ?>
                </h1>
                <p class="hero-description">
                    <?php _e('Accédez facilement aux rapports officiels des institutions publiques. Consultez, téléchargez et restez informé des dernières publications gouvernementales.', 'rapports-publics'); ?>
                </p>
                
                <div class="hero-stats">
                    <?php
                    // Get total reports count
                    $reports_count = wp_count_posts('rapport');
                    $published_count = $reports_count->publish ?? 0;
                    
                    // Get total ministries count
                    $ministries_count = wp_count_terms(array(
                        'taxonomy' => 'ministere',
                        'hide_empty' => true
                    ));
                    
                    // Get total downloads count
                    global $wpdb;
                    $total_downloads = $wpdb->get_var("
                        SELECT SUM(CAST(meta_value AS UNSIGNED)) 
                        FROM {$wpdb->postmeta} 
                        WHERE meta_key = '_download_count' 
                        AND meta_value != ''
                    ");
                    $total_downloads = $total_downloads ?: 0;
                    ?>
                    
                    <div class="stats-grid">
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
                
                <div class="hero-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn btn-primary">
                        <?php _e('Parcourir les Rapports', 'rapports-publics'); ?>
                    </a>
                    
                    <a href="#search-section" class="btn btn-secondary scroll-to">
                        <?php _e('Rechercher un Rapport', 'rapports-publics'); ?>
                    </a>
                </div>
            </div>
            
            <div class="hero-image">
                <div class="hero-visual">
                    <!-- You can replace this with an actual image -->
                    <div class="visual-placeholder">
                        <svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="300" fill="#f8f9fa"/>
                            <rect x="50" y="50" width="100" height="120" fill="#2c5aa0" opacity="0.1"/>
                            <rect x="170" y="80" width="100" height="90" fill="#2c5aa0" opacity="0.2"/>
                            <rect x="290" y="60" width="100" height="110" fill="#2c5aa0" opacity="0.15"/>
                            
                            <rect x="60" y="190" width="80" height="4" fill="#2c5aa0"/>
                            <rect x="60" y="200" width="60" height="4" fill="#2c5aa0" opacity="0.6"/>
                            <rect x="60" y="210" width="70" height="4" fill="#2c5aa0" opacity="0.4"/>
                            
                            <rect x="180" y="190" width="80" height="4" fill="#2c5aa0"/>
                            <rect x="180" y="200" width="60" height="4" fill="#2c5aa0" opacity="0.6"/>
                            <rect x="180" y="210" width="70" height="4" fill="#2c5aa0" opacity="0.4"/>
                            
                            <rect x="300" y="190" width="80" height="4" fill="#2c5aa0"/>
                            <rect x="300" y="200" width="60" height="4" fill="#2c5aa0" opacity="0.6"/>
                            <rect x="300" y="210" width="70" height="4" fill="#2c5aa0" opacity="0.4"/>
                            
                            <circle cx="200" cy="40" r="8" fill="#28a745"/>
                            <text x="200" y="45" font-family="Inter" font-size="12" fill="#ffffff" text-anchor="middle">✓</text>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 4rem 0;
    margin-bottom: 3rem;
}

.hero-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
    line-height: 1.1;
}

.hero-description {
    font-size: 1.25rem;
    color: var(--text-color);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.hero-stats {
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-color);
    font-weight: 500;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.hero-visual {
    display: flex;
    justify-content: center;
    align-items: center;
}

.visual-placeholder svg {
    max-width: 100%;
    height: auto;
    filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
}

@media (max-width: 992px) {
    .hero-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .hero-actions {
        flex-direction: column;
    }
    
    .hero-actions .btn {
        width: 100%;
    }
}
</style>