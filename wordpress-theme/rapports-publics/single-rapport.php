<?php
/**
 * The template for displaying single report posts
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main single-report-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <!-- Modern Breadcrumb Navigation -->
            <nav class="modern-breadcrumb" aria-label="<?php _e('Navigation', 'rapports-publics'); ?>">
                <div class="breadcrumb-container">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="breadcrumb-home">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                        <?php _e('Accueil', 'rapports-publics'); ?>
                    </a>
                    <span class="breadcrumb-separator">/</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="breadcrumb-link">
                        <?php _e('Rapports', 'rapports-publics'); ?>
                    </a>
                    <?php
                    $ministries = get_the_terms(get_the_ID(), 'ministere');
                    if ($ministries && !is_wp_error($ministries)) :
                        $ministry = array_shift($ministries);
                        ?>
                        <span class="breadcrumb-separator">/</span>
                        <a href="<?php echo esc_url(get_term_link($ministry)); ?>" class="breadcrumb-link">
                            <?php echo esc_html($ministry->name); ?>
                        </a>
                    <?php endif; ?>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current"><?php echo wp_trim_words(get_the_title(), 8); ?></span>
                </div>
            </nav>

            <article id="post-<?php the_ID(); ?>" <?php post_class('modern-single-rapport'); ?>>
                
                <!-- Professional Report Hero Section -->
                <div class="report-hero-section">
                    <div class="hero-background"></div>
                    <div class="hero-content">
                        
                        <!-- Report Category Tags -->
                        <div class="report-taxonomy-tags">
                            <?php
                            // Ministry with Icon
                            if ($ministries && !is_wp_error($ministries)) :
                                foreach ($ministries as $ministry) :
                                    ?>
                                    <a href="<?php echo esc_url(get_term_link($ministry)); ?>" class="taxonomy-tag ministry-tag">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        <?php echo esc_html($ministry->name); ?>
                                    </a>
                                    <?php
                                endforeach;
                            endif;
                            ?>

                            <?php
                            // Categories with Icon
                            $categories = get_the_terms(get_the_ID(), 'rapport_category');
                            if ($categories && !is_wp_error($categories)) :
                                foreach ($categories as $category) :
                                    ?>
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="taxonomy-tag category-tag">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M20 6L9 17l-5-5"/>
                                        </svg>
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </div>

                        <!-- Main Report Title -->
                        <h1 class="modern-report-title"><?php the_title(); ?></h1>

                        <!-- Professional Meta Information Grid -->
                        <div class="professional-meta-grid">
                            <?php
                            // Publication Date with Icon
                            $publication_date = get_post_meta(get_the_ID(), '_publication_date', true);
                            if ($publication_date) :
                                $formatted_date = date_i18n(get_option('date_format'), strtotime($publication_date));
                                ?>
                                <div class="meta-card">
                                    <div class="meta-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                    </div>
                                    <div class="meta-content">
                                        <span class="meta-label"><?php _e('Publié le', 'rapports-publics'); ?></span>
                                        <time datetime="<?php echo esc_attr($publication_date); ?>" class="meta-value">
                                            <?php echo esc_html($formatted_date); ?>
                                        </time>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php
                            // File Size with Icon
                            $file_size = get_post_meta(get_the_ID(), '_file_size', true);
                            if ($file_size) :
                                ?>
                                <div class="meta-card">
                                    <div class="meta-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14,2 14,8 20,8"/>
                                            <line x1="16" y1="13" x2="8" y2="13"/>
                                            <line x1="16" y1="17" x2="8" y2="17"/>
                                            <polyline points="10,9 9,9 8,9"/>
                                        </svg>
                                    </div>
                                    <div class="meta-content">
                                        <span class="meta-label"><?php _e('Taille', 'rapports-publics'); ?></span>
                                        <span class="meta-value"><?php echo esc_html($file_size); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Download Count with Icon
                            $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                            if ($download_count > 0) :
                                ?>
                                <div class="meta-card">
                                    <div class="meta-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="7,10 12,15 17,10"/>
                                            <line x1="12" y1="15" x2="12" y2="3"/>
                                        </svg>
                                    </div>
                                    <div class="meta-content">
                                        <span class="meta-label"><?php _e('Téléchargements', 'rapports-publics'); ?></span>
                                        <span class="meta-value"><?php echo number_format_i18n($download_count); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Premium Download Button -->
                        <?php
                        $file_url = get_post_meta(get_the_ID(), '_file_url', true);
                        if ($file_url) :
                            $download_url = rapports_publics_get_download_url(get_the_ID());
                            ?>
                            <div class="premium-download-section">
                                <a href="<?php echo esc_url($download_url); ?>" 
                                   class="premium-download-btn"
                                   onclick="trackDownload(<?php echo get_the_ID(); ?>, '<?php echo esc_js(get_the_title()); ?>')"
                                   target="_blank">
                                    <div class="download-btn-content">
                                        <div class="download-icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                                            </svg>
                                        </div>
                                        <div class="download-text">
                                            <span class="download-title"><?php _e('Télécharger le Rapport', 'rapports-publics'); ?></span>
                                            <?php if ($file_size) : ?>
                                                <span class="download-meta"><?php _e('Format PDF', 'rapports-publics'); ?> • <?php echo esc_html($file_size); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>

                <!-- Professional Two-Column Layout -->
                <div class="professional-content-layout">
                    
                    <!-- Main Content Column -->
                    <div class="main-content-column">
                        
                        <!-- Report Preview Card -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="report-preview-card">
                                <div class="preview-header">
                                    <h3><?php _e('Aperçu du document', 'rapports-publics'); ?></h3>
                                </div>
                                <div class="preview-image">
                                    <?php the_post_thumbnail('rapport-large', array(
                                        'alt' => get_the_title(),
                                        'class' => 'document-preview'
                                    )); ?>
                                    <div class="preview-overlay">
                                        <div class="preview-icon">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
                                            </svg>
                                        </div>
                                        <span><?php _e('Cliquez pour agrandir', 'rapports-publics'); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Professional Content Card -->
                        <div class="professional-content-card">
                            <div class="content-header">
                                <h2><?php _e('Résumé exécutif', 'rapports-publics'); ?></h2>
                                <div class="content-divider"></div>
                            </div>
                            <div class="rich-content">
                                <?php
                                the_content();

                                wp_link_pages(array(
                                    'before' => '<div class="elegant-page-links"><span class="page-links-title">' . __('Pages du rapport :', 'rapports-publics') . '</span>',
                                    'after'  => '</div>',
                                    'link_before' => '<span class="page-number">',
                                    'link_after' => '</span>',
                                ));
                                ?>
                            </div>
                        </div>

                        <!-- Enhanced Information Cards Grid -->
                        <div class="enhanced-info-grid">
                            
                            <!-- Document Specifications Card -->
                            <div class="info-card document-specs">
                                <div class="card-icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14,2 14,8 20,8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10,9 9,9 8,9"/>
                                    </svg>
                                </div>
                                <h3><?php _e('Spécifications du document', 'rapports-publics'); ?></h3>
                                <div class="specs-grid">
                                    <div class="spec-item">
                                        <span class="spec-label"><?php _e('Type', 'rapports-publics'); ?></span>
                                        <span class="spec-value"><?php _e('Rapport officiel', 'rapports-publics'); ?></span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label"><?php _e('Statut', 'rapports-publics'); ?></span>
                                        <span class="spec-value"><?php _e('Document public', 'rapports-publics'); ?></span>
                                    </div>
                                    <?php if ($publication_date) : ?>
                                        <div class="spec-item">
                                            <span class="spec-label"><?php _e('Année', 'rapports-publics'); ?></span>
                                            <span class="spec-value"><?php echo date('Y', strtotime($publication_date)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="spec-item">
                                        <span class="spec-label"><?php _e('Format', 'rapports-publics'); ?></span>
                                        <span class="spec-value"><?php _e('PDF', 'rapports-publics'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Classification Card -->
                            <?php if ($categories || has_tag()) : ?>
                                <div class="info-card classification-card">
                                    <div class="card-icon">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                                        </svg>
                                    </div>
                                    <h3><?php _e('Classification et sujets', 'rapports-publics'); ?></h3>
                                    
                                    <?php if ($categories) : ?>
                                        <div class="classification-section">
                                            <h4><?php _e('Domäines concernés', 'rapports-publics'); ?></h4>
                                            <div class="elegant-tags">
                                                <?php foreach ($categories as $category) : ?>
                                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                                                       class="elegant-tag category-tag">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                            <path d="M20 6L9 17l-5-5"/>
                                                        </svg>
                                                        <?php echo esc_html($category->name); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (has_tag()) : ?>
                                        <div class="classification-section">
                                            <h4><?php _e('Mots-clés', 'rapports-publics'); ?></h4>
                                            <div class="elegant-tags keyword-tags">
                                                <?php
                                                $tags = get_the_tags();
                                                if ($tags) :
                                                    foreach ($tags as $tag) :
                                                        ?>
                                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                                           class="elegant-tag keyword-tag">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                                                <line x1="7" y1="7" x2="7.01" y2="7"/>
                                                            </svg>
                                                            <?php echo esc_html($tag->name); ?>
                                                        </a>
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>

                        <!-- Premium Social Sharing Card -->
                        <div class="premium-sharing-card">
                            <div class="sharing-header">
                                <div class="sharing-icon">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M18 8a3 3 0 0 0-3-3v0a3 3 0 0 0-3 3v5a3 3 0 0 0 3 3v0a3 3 0 0 0 3-3V8z"/>
                                        <circle cx="9" cy="9" r="2"/>
                                        <path d="M13 5l0 0"/>
                                        <path d="M13 19l0 0"/>
                                        <path d="M20 12h0"/>
                                        <path d="M4 12h0"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3><?php _e('Partager ce rapport', 'rapports-publics'); ?></h3>
                                    <p><?php _e('Diffusez cette information importante', 'rapports-publics'); ?></p>
                                </div>
                            </div>
                            <div class="premium-sharing-buttons">
                                <a href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . urlencode(get_permalink()) . '&text=' . urlencode(get_the_title())); ?>" 
                                   target="_blank" 
                                   rel="noopener"
                                   class="premium-share-btn twitter">
                                    <div class="share-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M23.32 4.56c-.85.38-1.78.64-2.75.76 1-.6 1.76-1.55 2.12-2.68-.93.55-1.96.95-3.06 1.17-.88-.94-2.13-1.53-3.51-1.53-2.66 0-4.81 2.16-4.81 4.81 0 .38.04.75.13 1.1-4-.2-7.57-2.12-9.95-5.04-.42.72-.66 1.55-.66 2.44 0 1.67.85 3.14 2.14 4-.79-.02-1.53-.24-2.18-.6v.06c0 2.33 1.66 4.28 3.86 4.72-.4.11-.83.17-1.27.17-.31 0-.62-.03-.92-.08.62 1.94 2.43 3.35 4.57 3.39-1.68 1.31-3.79 2.09-6.08 2.09-.39 0-.78-.02-1.17-.07 2.18 1.4 4.77 2.21 7.55 2.21 9.06 0 14.01-7.5 14.01-14.01 0-.21 0-.42-.01-.63.96-.69 1.8-1.56 2.46-2.55l-.04-.02z"/>
                                        </svg>
                                    </div>
                                    <span><?php _e('Twitter', 'rapports-publics'); ?></span>
                                </a>
                                <a href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . urlencode(get_permalink())); ?>" 
                                   target="_blank" 
                                   rel="noopener"
                                   class="premium-share-btn facebook">
                                    <div class="share-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M24 12.07C24 5.41 18.63.07 12 .07S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.69 4.54-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.5 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.5h-2.8V24C19.62 23.1 24 18.1 24 12.07"/>
                                        </svg>
                                    </div>
                                    <span><?php _e('Facebook', 'rapports-publics'); ?></span>
                                </a>
                                <a href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode(get_permalink())); ?>" 
                                   target="_blank" 
                                   rel="noopener"
                                   class="premium-share-btn linkedin">
                                    <div class="share-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.95v5.66H9.34V9h3.41v1.56h.05c.48-.9 1.65-1.85 3.39-1.85 3.63 0 4.3 2.39 4.3 5.49v6.25zM5.34 7.43c-1.14 0-2.07-.93-2.07-2.07s.93-2.07 2.07-2.07 2.07.93 2.07 2.07-.93 2.07-2.07 2.07zM7.12 20.45H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.73V1.73C24 .77 23.21 0 22.23 0z"/>
                                        </svg>
                                    </div>
                                    <span><?php _e('LinkedIn', 'rapports-publics'); ?></span>
                                </a>
                                <button type="button" 
                                        class="premium-share-btn copy-link" 
                                        onclick="copyToClipboard('<?php echo esc_js(get_permalink()); ?>')">
                                    <div class="share-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                        </svg>
                                    </div>
                                    <span><?php _e('Copier', 'rapports-publics'); ?></span>
                                </button>
                            </div>
                        </div>

                        <!-- Premium Report Navigation -->
                        <nav class="premium-report-navigation" aria-label="<?php _e('Navigation entre les rapports', 'rapports-publics'); ?>">
                            <?php
                            $prev_post = get_previous_post(true, '', 'ministere');
                            $next_post = get_next_post(true, '', 'ministere');
                            
                            if ($prev_post || $next_post) : ?>
                                <div class="navigation-header">
                                    <h3><?php _e('Autres rapports de ce ministère', 'rapports-publics'); ?></h3>
                                </div>
                                <div class="premium-nav-links">
                                    <?php if ($prev_post) : ?>
                                        <div class="premium-nav-card prev-report">
                                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                                <div class="nav-card-content">
                                                    <div class="nav-direction">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                            <path d="M15 18l-6-6 6-6"/>
                                                        </svg>
                                                        <span><?php _e('Précédent', 'rapports-publics'); ?></span>
                                                    </div>
                                                    <h4 class="nav-title"><?php echo esc_html(wp_trim_words(get_the_title($prev_post->ID), 8)); ?></h4>
                                                    <div class="nav-meta">
                                                        <?php
                                                        $prev_date = get_post_meta($prev_post->ID, '_publication_date', true);
                                                        if ($prev_date) :
                                                            echo date_i18n('Y', strtotime($prev_date));
                                                        endif;
                                                        ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($next_post) : ?>
                                        <div class="premium-nav-card next-report">
                                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                                <div class="nav-card-content">
                                                    <div class="nav-direction next">
                                                        <span><?php _e('Suivant', 'rapports-publics'); ?></span>
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                            <path d="M9 18l6-6-6-6"/>
                                                        </svg>
                                                    </div>
                                                    <h4 class="nav-title"><?php echo esc_html(wp_trim_words(get_the_title($next_post->ID), 8)); ?></h4>
                                                    <div class="nav-meta">
                                                        <?php
                                                        $next_date = get_post_meta($next_post->ID, '_publication_date', true);
                                                        if ($next_date) :
                                                            echo date_i18n('Y', strtotime($next_date));
                                                        endif;
                                                        ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </nav>

                    </div>

                    <!-- Enhanced Professional Sidebar -->
                    <aside class="professional-sidebar">
                        <div class="sidebar-sticky">
                            
                            <!-- Quick Actions Card -->
                            <div class="sidebar-card quick-actions">
                                <h3><?php _e('Actions rapides', 'rapports-publics'); ?></h3>
                                <div class="quick-actions-list">
                                    <?php if ($file_url) : ?>
                                        <a href="<?php echo esc_url($download_url); ?>" class="quick-action download-action" target="_blank">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                                            </svg>
                                            <?php _e('Télécharger', 'rapports-publics'); ?>
                                        </a>
                                    <?php endif; ?>
                                    <a href="#" class="quick-action print-action" onclick="window.print(); return false;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <polyline points="6,9 6,2 18,2 18,9"/>
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                            <rect x="6" y="14" width="12" height="8"/>
                                        </svg>
                                        <?php _e('Imprimer', 'rapports-publics'); ?>
                                    </a>
                                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="quick-action back-action">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                                        </svg>
                                        <?php _e('Tous les rapports', 'rapports-publics'); ?>
                                    </a>
                                </div>
                            </div>

                            <!-- Table of Contents (if content has headings) -->
                            <div class="sidebar-card table-of-contents">
                                <h3><?php _e('Sommaire', 'rapports-publics'); ?></h3>
                                <div id="toc-container">
                                    <p class="toc-placeholder"><?php _e('Le sommaire sera généré automatiquement à partir des titres du contenu.', 'rapports-publics'); ?></p>
                                </div>
                            </div>

                            <!-- Related Reports -->
                            <?php
                            $related_args = array(
                                'post_type' => 'rapport',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID()),
                                'tax_query' => array(),
                                'meta_key' => '_publication_date',
                                'orderby' => 'meta_value',
                                'order' => 'DESC'
                            );

                            if ($ministries && !is_wp_error($ministries)) :
                                $ministry_ids = wp_list_pluck($ministries, 'term_id');
                                $related_args['tax_query'][] = array(
                                    'taxonomy' => 'ministere',
                                    'field' => 'term_id',
                                    'terms' => $ministry_ids,
                                );
                            endif;

                            $related_query = new WP_Query($related_args);
                            
                            if ($related_query->have_posts()) : ?>
                                <div class="sidebar-card related-reports">
                                    <h3><?php _e('Rapports similaires', 'rapports-publics'); ?></h3>
                                    <div class="related-reports-list">
                                        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                            <div class="related-report-item">
                                                <a href="<?php the_permalink(); ?>" class="related-report-link">
                                                    <h4><?php echo wp_trim_words(get_the_title(), 6); ?></h4>
                                                    <?php
                                                    $related_date = get_post_meta(get_the_ID(), '_publication_date', true);
                                                    if ($related_date) :
                                                        ?>
                                                        <span class="related-date"><?php echo date_i18n('Y', strtotime($related_date)); ?></span>
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                                <?php
                                wp_reset_postdata();
                            endif;
                            ?>

                            <!-- Default Sidebar Content -->
                            <?php get_sidebar(); ?>
                            
                        </div>
                    </aside>

                </div>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<script>
// Enhanced Professional JavaScript for Single Report Page

// Copy to clipboard with premium animation
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Find the button that was clicked
        const btn = event.target.closest('.premium-share-btn');
        const originalContent = btn.innerHTML;
        
        // Show success state with icon
        btn.innerHTML = `
            <div class="share-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
            </div>
            <span><?php echo esc_js(__('Copié !', 'rapports-publics')); ?></span>
        `;
        
        btn.style.background = '#10b981';
        btn.style.color = 'white';
        
        // Reset after 2 seconds
        setTimeout(() => {
            btn.innerHTML = originalContent;
            btn.style.background = '';
            btn.style.color = '';
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
        // Show error state
        const btn = event.target.closest('.premium-share-btn');
        const originalBg = btn.style.background;
        btn.style.background = '#ef4444';
        btn.style.color = 'white';
        setTimeout(() => {
            btn.style.background = originalBg;
            btn.style.color = '';
        }, 1500);
    });
}

// Auto-generate table of contents from content headings
document.addEventListener('DOMContentLoaded', function() {
    generateTableOfContents();
    enhanceImagePreview();
    addScrollProgress();
});

function generateTableOfContents() {
    const content = document.querySelector('.rich-content');
    const tocContainer = document.getElementById('toc-container');
    
    if (!content || !tocContainer) return;
    
    const headings = content.querySelectorAll('h2, h3, h4');
    
    if (headings.length === 0) return;
    
    // Clear placeholder
    tocContainer.innerHTML = '';
    
    const tocList = document.createElement('ul');
    tocList.className = 'toc-list';
    
    headings.forEach((heading, index) => {
        // Add ID to heading for anchor links
        const id = `heading-${index}`;
        heading.id = id;
        
        // Create TOC item
        const li = document.createElement('li');
        li.className = `toc-item toc-${heading.tagName.toLowerCase()}`;
        
        const link = document.createElement('a');
        link.href = `#${id}`;
        link.textContent = heading.textContent;
        link.className = 'toc-link';
        
        // Smooth scroll
        link.addEventListener('click', function(e) {
            e.preventDefault();
            heading.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        
        li.appendChild(link);
        tocList.appendChild(li);
    });
    
    tocContainer.appendChild(tocList);
    
    // Add TOC styles
    if (!document.getElementById('toc-styles')) {
        const tocStyles = document.createElement('style');
        tocStyles.id = 'toc-styles';
        tocStyles.textContent = `
            .toc-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .toc-item {
                margin-bottom: 0.5rem;
            }
            .toc-link {
                display: block;
                padding: 0.5rem 0.75rem;
                color: #64748b;
                text-decoration: none;
                border-radius: 6px;
                font-size: 0.875rem;
                line-height: 1.4;
                transition: all 0.2s ease;
            }
            .toc-link:hover {
                background: #f1f5f9;
                color: var(--primary-color);
                padding-left: 1rem;
            }
            .toc-h2 .toc-link {
                font-weight: 600;
            }
            .toc-h3 .toc-link {
                padding-left: 1.5rem;
                font-size: 0.8rem;
            }
            .toc-h4 .toc-link {
                padding-left: 2rem;
                font-size: 0.75rem;
                opacity: 0.8;
            }
        `;
        document.head.appendChild(tocStyles);
    }
}

function enhanceImagePreview() {
    const previewImage = document.querySelector('.document-preview');
    if (!previewImage) return;
    
    previewImage.addEventListener('click', function() {
        // Create modal overlay
        const modal = document.createElement('div');
        modal.className = 'image-modal';
        modal.innerHTML = `
            <div class="modal-backdrop"></div>
            <div class="modal-content">
                <button class="modal-close">&times;</button>
                <img src="${this.src}" alt="${this.alt}" class="modal-image">
            </div>
        `;
        
        // Add modal styles
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;
        
        const backdrop = modal.querySelector('.modal-backdrop');
        backdrop.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
        `;
        
        const content = modal.querySelector('.modal-content');
        content.style.cssText = `
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        `;
        
        const closeBtn = modal.querySelector('.modal-close');
        closeBtn.style.cssText = `
            position: absolute;
            top: -40px;
            right: 0;
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        `;
        
        const modalImg = modal.querySelector('.modal-image');
        modalImg.style.cssText = `
            max-width: 100%;
            max-height: 100%;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        `;
        
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
        
        // Animate in
        requestAnimationFrame(() => {
            modal.style.opacity = '1';
            content.style.transform = 'scale(1)';
        });
        
        // Close handlers
        function closeModal() {
            modal.style.opacity = '0';
            content.style.transform = 'scale(0.9)';
            setTimeout(() => {
                document.body.removeChild(modal);
                document.body.style.overflow = '';
            }, 300);
        }
        
        closeBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    });
}

function addScrollProgress() {
    // Create scroll progress bar
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color) 0%, #667eea 100%);
        z-index: 9999;
        transition: width 0.1s ease;
    `;
    document.body.appendChild(progressBar);
    
    // Update progress on scroll
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = (scrollTop / docHeight) * 100;
        progressBar.style.width = progress + '%';
    });
}

// Enhanced download tracking
function trackDownload(reportId, reportTitle) {
    // Analytics tracking (if available)
    if (typeof gtag !== 'undefined') {
        gtag('event', 'download', {
            'event_category': 'rapport',
            'event_label': reportTitle,
            'value': reportId
        });
    }
    
    // Visual feedback
    const downloadBtn = event.target.closest('.premium-download-btn');
    if (downloadBtn) {
        const originalTransform = downloadBtn.style.transform;
        downloadBtn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            downloadBtn.style.transform = originalTransform;
        }, 150);
    }
}
</script>

<style>
/* ===== PROFESSIONAL SINGLE REPORT DESIGN ===== */

/* Main Layout */
.single-report-main {
    padding: 2rem 0;
    background: linear-gradient(135deg, #f8fafe 0%, #ffffff 100%);
    min-height: 100vh;
}

.modern-single-rapport {
    margin-bottom: 4rem;
}

/* ===== MODERN BREADCRUMB ===== */
.modern-breadcrumb {
    margin-bottom: 3rem;
    padding: 1rem 0;
}

.breadcrumb-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    font-size: 0.9rem;
    color: #64748b;
}

.breadcrumb-home {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.breadcrumb-home:hover {
    color: var(--hover-color);
}

.breadcrumb-separator {
    color: #cbd5e1;
    font-weight: 300;
}

.breadcrumb-link {
    color: var(--primary-color);
    text-decoration: none;
    transition: var(--transition);
}

.breadcrumb-link:hover {
    color: var(--hover-color);
}

.breadcrumb-current {
    color: #475569;
    font-weight: 500;
}

/* ===== PROFESSIONAL HERO SECTION ===== */
.report-hero-section {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 3rem;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="2" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    padding: 3rem;
    color: white;
}

.report-taxonomy-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.taxonomy-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    color: white;
    transition: all 0.3s ease;
}

.taxonomy-tag:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    color: white;
}

.modern-report-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 2rem;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* ===== PROFESSIONAL META GRID ===== */
.professional-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 2.5rem;
}

.meta-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    transition: var(--transition);
}

.meta-card:hover {
    background: rgba(255, 255, 255, 0.2);
}

.meta-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
}

.meta-content {
    flex: 1;
    min-width: 0;
}

.meta-label {
    display: block;
    font-size: 0.75rem;
    opacity: 0.9;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.meta-value {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
}

/* ===== PREMIUM DOWNLOAD BUTTON ===== */
.premium-download-section {
    text-align: center;
}

.premium-download-btn {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 2.5rem;
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.premium-download-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
    background: linear-gradient(135deg, #ff5252 0%, #ff7979 100%);
    color: white;
}

.download-btn-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.download-icon {
    width: 24px;
    height: 24px;
}

.download-text {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.download-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.download-meta {
    font-size: 0.8rem;
    opacity: 0.9;
    font-weight: 400;
}

/* ===== PROFESSIONAL CONTENT LAYOUT ===== */
.professional-content-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
    margin-top: 3rem;
}

.main-content-column {
    min-width: 0;
}

/* ===== REPORT PREVIEW CARD ===== */
.report-preview-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
}

.preview-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
}

.preview-header h3 {
    margin: 0;
    color: var(--primary-color);
    font-size: 1.25rem;
    font-weight: 600;
}

.preview-image {
    position: relative;
    padding: 1.5rem;
}

.document-preview {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: var(--transition);
}

.preview-overlay {
    position: absolute;
    top: 1.5rem;
    left: 1.5rem;
    right: 1.5rem;
    bottom: 1.5rem;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
    border-radius: 12px;
    color: white;
    cursor: pointer;
}

.preview-image:hover .preview-overlay {
    opacity: 1;
}

.preview-icon {
    margin-bottom: 1rem;
}

/* ===== PROFESSIONAL CONTENT CARD ===== */
.professional-content-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
}

.content-header {
    padding: 2rem 2rem 0;
}

.content-header h2 {
    margin: 0 0 1rem;
    color: var(--primary-color);
    font-size: 1.5rem;
    font-weight: 700;
}

.content-divider {
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color) 0%, #e2e8f0 100%);
    border-radius: 2px;
    margin-bottom: 2rem;
}

.rich-content {
    padding: 0 2rem 2rem;
    line-height: 1.8;
    color: #374151;
}

.rich-content h3, .rich-content h4, .rich-content h5 {
    color: var(--primary-color);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.rich-content p {
    margin-bottom: 1.5rem;
}

.elegant-page-links {
    margin: 2rem 0;
    text-align: center;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.page-links-title {
    display: block;
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--primary-color);
}

.page-number {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: var(--transition);
}

.page-number:hover {
    background: var(--hover-color);
    transform: translateY(-2px);
}

/* ===== ENHANCED INFO GRID ===== */
.enhanced-info-grid {
    display: grid;
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    transition: var(--transition);
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--hover-color) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    color: white;
}

.info-card h3 {
    margin: 0 0 1.5rem;
    color: var(--primary-color);
    font-size: 1.25rem;
    font-weight: 700;
}

.specs-grid {
    display: grid;
    gap: 1rem;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.spec-label {
    font-weight: 500;
    color: #64748b;
    font-size: 0.9rem;
}

.spec-value {
    font-weight: 600;
    color: #1e293b;
}

.classification-section {
    margin-bottom: 1.5rem;
}

.classification-section:last-child {
    margin-bottom: 0;
}

.classification-section h4 {
    margin: 0 0 1rem;
    color: #475569;
    font-size: 1rem;
    font-weight: 600;
}

.elegant-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.elegant-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #f1f5f9;
    color: #475569;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid #e2e8f0;
    transition: var(--transition);
}

.elegant-tag:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

/* ===== PREMIUM SHARING CARD ===== */
.premium-sharing-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    margin-bottom: 2rem;
}

.sharing-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.sharing-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.sharing-header h3 {
    margin: 0 0 0.25rem;
    color: var(--primary-color);
    font-size: 1.25rem;
    font-weight: 700;
}

.sharing-header p {
    margin: 0;
    color: #64748b;
    font-size: 0.9rem;
}

.premium-sharing-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
}

.premium-share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.premium-share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.premium-share-btn.twitter:hover {
    background: #1DA1F2;
    color: white;
}

.premium-share-btn.facebook:hover {
    background: #4267B2;
    color: white;
}

.premium-share-btn.linkedin:hover {
    background: #0077B5;
    color: white;
}

.premium-share-btn.copy-link:hover {
    background: var(--primary-color);
    color: white;
}

.share-icon {
    width: 18px;
    height: 18px;
}

/* ===== PREMIUM NAVIGATION ===== */
.premium-report-navigation {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    margin-top: 3rem;
}

.navigation-header {
    margin-bottom: 2rem;
}

.navigation-header h3 {
    margin: 0;
    color: var(--primary-color);
    font-size: 1.25rem;
    font-weight: 700;
}

.premium-nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.premium-nav-card {
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: var(--transition);
}

.premium-nav-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.premium-nav-card a {
    display: block;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
}

.nav-card-content {
    height: 100%;
}

.nav-direction {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.nav-direction.next {
    justify-content: flex-end;
}

.nav-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.4;
    margin-bottom: 0.5rem;
}

.nav-meta {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

/* ===== PROFESSIONAL SIDEBAR ===== */
.professional-sidebar {
    position: relative;
}

.sidebar-sticky {
    position: sticky;
    top: 2rem;
}

.sidebar-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    margin-bottom: 2rem;
}

.sidebar-card h3 {
    margin: 0 0 1.5rem;
    color: var(--primary-color);
    font-size: 1.125rem;
    font-weight: 700;
}

.quick-actions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-action {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: #f8fafc;
    color: #475569;
    text-decoration: none;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    font-weight: 500;
    font-size: 0.9rem;
    transition: var(--transition);
}

.quick-action:hover {
    background: var(--primary-color);
    color: white;
    transform: translateX(4px);
}

.toc-placeholder {
    font-size: 0.875rem;
    color: #64748b;
    font-style: italic;
    margin: 0;
}

.related-reports-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.related-report-item {
    padding: 1rem;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    transition: var(--transition);
}

.related-report-item:hover {
    background: #f1f5f9;
    transform: translateY(-2px);
}

.related-report-link {
    text-decoration: none;
    color: inherit;
}

.related-report-item h4 {
    margin: 0 0 0.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--primary-color);
    line-height: 1.3;
}

.related-date {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 500;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
    .professional-content-layout {
        grid-template-columns: 1fr 300px;
        gap: 2rem;
    }
    
    .premium-nav-links {
        gap: 1.5rem;
    }
}

@media (max-width: 992px) {
    .professional-content-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .professional-meta-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .premium-nav-links {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .premium-sharing-buttons {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .single-report-main {
        padding: 1rem 0;
    }
    
    .hero-content {
        padding: 2rem 1.5rem;
    }
    
    .modern-report-title {
        font-size: 2rem;
    }
    
    .professional-meta-grid {
        grid-template-columns: 1fr;
    }
    
    .premium-download-btn {
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }
    
    .premium-sharing-buttons {
        grid-template-columns: 1fr;
    }
    
    .sidebar-sticky {
        position: static;
    }
}

@media (max-width: 480px) {
    .breadcrumb-container {
        font-size: 0.8rem;
    }
    
    .hero-content {
        padding: 1.5rem 1rem;
    }
    
    .modern-report-title {
        font-size: 1.75rem;
    }
    
    .professional-content-layout {
        gap: 1.5rem;
    }
    
    .info-card {
        padding: 1.5rem;
    }
    
    .premium-sharing-card {
        padding: 1.5rem;
    }
    
    .premium-report-navigation {
        padding: 1.5rem;
    }
}
</style>

<?php get_footer(); ?>