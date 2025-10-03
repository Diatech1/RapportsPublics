<?php
/**
 * The template for displaying single report posts
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <!-- Breadcrumb Navigation -->
            <nav class="breadcrumb-nav" aria-label="<?php _e('Fil d\'Ariane', 'rapports-publics'); ?>">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php _e('Accueil', 'rapports-publics'); ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>">
                            <?php _e('Rapports', 'rapports-publics'); ?>
                        </a>
                    </li>
                    <?php
                    $ministries = get_the_terms(get_the_ID(), 'ministere');
                    if ($ministries && !is_wp_error($ministries)) :
                        $ministry = array_shift($ministries);
                        ?>
                        <li class="breadcrumb-item">
                            <a href="<?php echo esc_url(get_term_link($ministry)); ?>">
                                <?php echo esc_html($ministry->name); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php the_title(); ?>
                    </li>
                </ol>
            </nav>

            <article id="post-<?php the_ID(); ?>" <?php post_class('single-rapport'); ?>>
                
                <!-- Report Header -->
                <header class="report-header">
                    <div class="report-meta-top">
                        <?php
                        // Ministry
                        if ($ministries && !is_wp_error($ministries)) :
                            foreach ($ministries as $ministry) :
                                ?>
                                <span class="ministry-tag">
                                    <a href="<?php echo esc_url(get_term_link($ministry)); ?>">
                                        <?php echo esc_html($ministry->name); ?>
                                    </a>
                                </span>
                                <?php
                            endforeach;
                        endif;
                        ?>

                        <?php
                        // Categories
                        $categories = get_the_terms(get_the_ID(), 'rapport_category');
                        if ($categories && !is_wp_error($categories)) :
                            foreach ($categories as $category) :
                                ?>
                                <span class="category-tag">
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                </span>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <h1 class="report-title"><?php the_title(); ?></h1>

                    <div class="report-meta-info">
                        <?php
                        // Publication Date
                        $publication_date = get_post_meta(get_the_ID(), '_publication_date', true);
                        if ($publication_date) :
                            $formatted_date = date_i18n(get_option('date_format'), strtotime($publication_date));
                            ?>
                            <div class="meta-item">
                                <span class="meta-label"><?php _e('Date de publication :', 'rapports-publics'); ?></span>
                                <time datetime="<?php echo esc_attr($publication_date); ?>" class="meta-value">
                                    <?php echo esc_html($formatted_date); ?>
                                </time>
                            </div>
                        <?php endif; ?>

                        <?php
                        // File Size
                        $file_size = get_post_meta(get_the_ID(), '_file_size', true);
                        if ($file_size) :
                            ?>
                            <div class="meta-item">
                                <span class="meta-label"><?php _e('Taille du fichier :', 'rapports-publics'); ?></span>
                                <span class="meta-value"><?php echo esc_html($file_size); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Download Count
                        $download_count = get_post_meta(get_the_ID(), '_download_count', true);
                        if ($download_count > 0) :
                            ?>
                            <div class="meta-item">
                                <span class="meta-label"><?php _e('Téléchargements :', 'rapports-publics'); ?></span>
                                <span class="meta-value"><?php echo number_format_i18n($download_count); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Download Button -->
                    <?php
                    $file_url = get_post_meta(get_the_ID(), '_file_url', true);
                    if ($file_url) :
                        $download_url = rapports_publics_get_download_url(get_the_ID());
                        ?>
                        <div class="download-section">
                            <a href="<?php echo esc_url($download_url); ?>" 
                               class="btn btn-primary btn-download"
                               onclick="trackDownload(<?php echo get_the_ID(); ?>, '<?php echo esc_js(get_the_title()); ?>')"
                               target="_blank">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <?php _e('Télécharger le Rapport', 'rapports-publics'); ?>
                                <?php if ($file_size) : ?>
                                    <small>(<?php echo esc_html($file_size); ?>)</small>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- Single Content Layout with Proper Grid -->
                <div class="single-content">
                    
                    <!-- Main Content Area -->
                    <div class="content-area">
                        
                        <!-- Report Thumbnail -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="report-featured-image">
                                <?php the_post_thumbnail('rapport-large', array(
                                    'alt' => get_the_title(),
                                    'class' => 'featured-image'
                                )); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Report Content -->
                        <div class="report-content">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . __('Pages :', 'rapports-publics'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <!-- Report Details Grid -->
                        <div class="report-details-grid">
                            
                            <!-- Additional Information -->
                            <div class="detail-section">
                                <h3><?php _e('Informations Complémentaires', 'rapports-publics'); ?></h3>
                                <dl class="detail-list">
                                    <dt><?php _e('Type de document', 'rapports-publics'); ?></dt>
                                    <dd><?php _e('Rapport officiel', 'rapports-publics'); ?></dd>
                                    
                                    <dt><?php _e('Statut', 'rapports-publics'); ?></dt>
                                    <dd><?php _e('Document public', 'rapports-publics'); ?></dd>
                                    
                                    <?php if ($publication_date) : ?>
                                        <dt><?php _e('Année de publication', 'rapports-publics'); ?></dt>
                                        <dd><?php echo date('Y', strtotime($publication_date)); ?></dd>
                                    <?php endif; ?>
                                    
                                    <dt><?php _e('Format', 'rapports-publics'); ?></dt>
                                    <dd><?php _e('PDF', 'rapports-publics'); ?></dd>
                                </dl>
                            </div>

                            <!-- Tags and Categories -->
                            <?php if ($categories || has_tag()) : ?>
                                <div class="detail-section">
                                    <h3><?php _e('Classification', 'rapports-publics'); ?></h3>
                                    
                                    <?php if ($categories) : ?>
                                        <div class="taxonomy-group">
                                            <h4><?php _e('Catégories', 'rapports-publics'); ?></h4>
                                            <div class="taxonomy-terms">
                                                <?php foreach ($categories as $category) : ?>
                                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                                                       class="term-link category-link">
                                                        <?php echo esc_html($category->name); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (has_tag()) : ?>
                                        <div class="taxonomy-group">
                                            <h4><?php _e('Mots-clés', 'rapports-publics'); ?></h4>
                                            <div class="taxonomy-terms">
                                                <?php the_tags('', '', ''); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>

                        <!-- Social Sharing -->
                        <div class="social-sharing">
                            <h3><?php _e('Partager ce rapport', 'rapports-publics'); ?></h3>
                            <div class="sharing-buttons">
                                <a href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . urlencode(get_permalink()) . '&text=' . urlencode(get_the_title())); ?>" 
                                   target="_blank" 
                                   rel="noopener"
                                   class="share-btn twitter-btn">
                                    <span class="sr-only"><?php _e('Partager sur Twitter', 'rapports-publics'); ?></span>
                                    Twitter
                                </a>
                                <a href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . urlencode(get_permalink())); ?>" 
                                   target="_blank" 
                                   rel="noopener"
                                   class="share-btn facebook-btn">
                                    <span class="sr-only"><?php _e('Partager sur Facebook', 'rapports-publics'); ?></span>
                                    Facebook
                                </a>
                                <a href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode(get_permalink())); ?>" 
                                   target="_blank" 
                                   rel="noopener"
                                   class="share-btn linkedin-btn">
                                    <span class="sr-only"><?php _e('Partager sur LinkedIn', 'rapports-publics'); ?></span>
                                    LinkedIn
                                </a>
                                <button type="button" 
                                        class="share-btn copy-btn" 
                                        onclick="copyToClipboard('<?php echo esc_js(get_permalink()); ?>')">
                                    <span class="sr-only"><?php _e('Copier le lien', 'rapports-publics'); ?></span>
                                    <?php _e('Copier le lien', 'rapports-publics'); ?>
                                </button>
                            </div>
                        </div>

                        <!-- Navigation between reports -->
                        <nav class="post-navigation" aria-label="<?php _e('Navigation entre les rapports', 'rapports-publics'); ?>">
                            <?php
                            $prev_post = get_previous_post(true, '', 'ministere');
                            $next_post = get_next_post(true, '', 'ministere');
                            
                            if ($prev_post || $next_post) : ?>
                                <div class="nav-links">
                                    <?php if ($prev_post) : ?>
                                        <div class="nav-previous">
                                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                                <span class="nav-direction"><?php _e('« Précédent', 'rapports-publics'); ?></span>
                                                <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($next_post) : ?>
                                        <div class="nav-next">
                                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                                <span class="nav-direction"><?php _e('Suivant »', 'rapports-publics'); ?></span>
                                                <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </nav>

                    </div>

                    <!-- Sidebar -->
                    <aside class="sidebar">
                        <?php get_sidebar(); ?>
                    </aside>

                </div>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<script>
// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const btn = event.target;
        const originalText = btn.textContent;
        btn.textContent = '<?php echo esc_js(__('Copié !', 'rapports-publics')); ?>';
        setTimeout(() => {
            btn.textContent = originalText;
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>

<style>
/* Single Report Specific Styles */
.single-rapport {
    margin-bottom: 3rem;
}

/* Breadcrumb Navigation */
.breadcrumb-nav {
    margin-bottom: 2rem;
}

.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.875rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    margin: 0 0.5rem;
    color: var(--text-color);
    opacity: 0.6;
}

.breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: var(--text-color);
    opacity: 0.8;
}

/* Report Header */
.report-header {
    background: var(--light-color);
    padding: 2rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.report-meta-top {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.ministry-tag a,
.category-tag a {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ministry-tag a {
    background: var(--primary-color);
    color: white;
}

.ministry-tag a:hover {
    background: var(--hover-color);
}

.category-tag a {
    background: var(--border-color);
    color: var(--text-color);
}

.category-tag a:hover {
    background: var(--text-color);
    color: white;
}

.report-title {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    line-height: 1.3;
}

.report-meta-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.meta-item {
    display: flex;
    flex-direction: column;
}

.meta-label {
    font-size: 0.875rem;
    color: var(--text-color);
    opacity: 0.8;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.meta-value {
    font-weight: 600;
    color: var(--text-color);
}

.download-section {
    text-align: center;
}

.btn-download {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 250px;
    justify-content: center;
}

/* Single Content Layout - Fixed CSS Grid */
.single-content {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 3rem;
    margin-top: 2rem;
}

.content-area {
    min-width: 0; /* Prevent grid overflow */
}

.sidebar {
    /* Sidebar styles handled in main CSS */
}

/* Report Content */
.report-featured-image {
    margin-bottom: 2rem;
}

.featured-image {
    width: 100%;
    height: auto;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
}

.report-content {
    background: var(--light-color);
    padding: 2rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
    line-height: 1.8;
}

.report-content h2,
.report-content h3,
.report-content h4 {
    color: var(--primary-color);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.report-content h2:first-child,
.report-content h3:first-child,
.report-content h4:first-child {
    margin-top: 0;
}

/* Report Details Grid */
.report-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.detail-section {
    background: var(--light-color);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
}

.detail-section h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.detail-list {
    margin: 0;
}

.detail-list dt {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.25rem;
    margin-top: 1rem;
}

.detail-list dt:first-child {
    margin-top: 0;
}

.detail-list dd {
    margin-left: 0;
    margin-bottom: 0.5rem;
    color: var(--text-color);
    opacity: 0.8;
}

.taxonomy-group {
    margin-bottom: 1.5rem;
}

.taxonomy-group:last-child {
    margin-bottom: 0;
}

.taxonomy-group h4 {
    font-size: 1rem;
    color: var(--primary-color);
    margin-bottom: 0.75rem;
}

.taxonomy-terms {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.term-link {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: var(--border-color);
    color: var(--text-color);
    text-decoration: none;
    border-radius: 12px;
    font-size: 0.875rem;
    transition: var(--transition);
}

.term-link:hover {
    background: var(--primary-color);
    color: white;
}

/* Social Sharing */
.social-sharing {
    background: var(--secondary-color);
    padding: 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    text-align: center;
}

.social-sharing h3 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.sharing-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.share-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    color: white;
    display: inline-block;
}

.twitter-btn { background: #1DA1F2; }
.facebook-btn { background: #4267B2; }
.linkedin-btn { background: #0077B5; }
.copy-btn { background: var(--text-color); }

.share-btn:hover {
    transform: translateY(-2px);
    opacity: 0.9;
    color: white;
}

/* Post Navigation */
.post-navigation {
    margin-top: 3rem;
}

.nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.nav-previous,
.nav-next {
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    overflow: hidden;
    transition: var(--transition);
}

.nav-previous:hover,
.nav-next:hover {
    box-shadow: var(--box-shadow);
    transform: translateY(-2px);
}

.nav-previous a,
.nav-next a {
    display: block;
    padding: 1.5rem;
    text-decoration: none;
    color: var(--text-color);
}

.nav-next {
    text-align: right;
}

.nav-direction {
    display: block;
    font-size: 0.875rem;
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.nav-title {
    display: block;
    font-weight: 500;
    line-height: 1.4;
}

/* Page Links */
.page-links {
    margin: 2rem 0;
    text-align: center;
}

.page-links a {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: var(--border-radius);
}

.page-links a:hover {
    background: var(--hover-color);
}

/* Responsive Design */
@media (max-width: 992px) {
    .single-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .report-meta-info {
        grid-template-columns: 1fr;
    }
    
    .report-details-grid {
        grid-template-columns: 1fr;
    }
    
    .nav-links {
        grid-template-columns: 1fr;
    }
    
    .nav-next {
        text-align: left;
    }
}

@media (max-width: 768px) {
    .report-header {
        padding: 1.5rem;
    }
    
    .report-title {
        font-size: 1.75rem;
    }
    
    .report-content {
        padding: 1.5rem;
    }
    
    .detail-section {
        padding: 1rem;
    }
    
    .social-sharing {
        padding: 1.5rem;
    }
    
    .sharing-buttons {
        flex-direction: column;
    }
    
    .share-btn {
        width: 100%;
    }
    
    .btn-download {
        min-width: auto;
        width: 100%;
    }
}

@media (max-width: 480px) {
    .breadcrumb {
        font-size: 0.75rem;
    }
    
    .report-header {
        padding: 1rem;
    }
    
    .report-title {
        font-size: 1.5rem;
    }
    
    .report-content {
        padding: 1rem;
    }
    
    .single-content {
        gap: 1rem;
    }
}
</style>

<?php get_footer(); ?>