<?php
/**
 * The main template file
 *
 * @package RapportsPublics
 * @since 1.0.0
 */

get_header(); ?>

<?php get_template_part('template-parts/hero-section'); ?>

<?php get_template_part('template-parts/about-section'); ?>

<?php get_template_part('template-parts/reports-section'); ?>

<section class="search-section" id="search-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <?php _e('Rechercher un Rapport', 'rapports-publics'); ?>
            </h2>
            <p class="section-subtitle">
                <?php _e('Utilisez notre moteur de recherche avancé pour trouver rapidement le rapport qui vous intéresse', 'rapports-publics'); ?>
            </p>
        </div>

        <div class="search-form-container">
            <form role="search" method="get" class="advanced-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="post_type" value="rapport" />
                
                <div class="search-grid">
                    <div class="search-group">
                        <label for="main-search"><?php _e('Mots-clés', 'rapports-publics'); ?></label>
                        <input type="search" 
                               id="main-search" 
                               name="s" 
                               placeholder="<?php _e('Rechercher par titre, contenu...', 'rapports-publics'); ?>" 
                               class="search-input" />
                    </div>

                    <div class="search-group">
                        <label for="ministry-search"><?php _e('Ministère', 'rapports-publics'); ?></label>
                        <select id="ministry-search" name="ministere">
                            <option value=""><?php _e('Tous les ministères', 'rapports-publics'); ?></option>
                            <?php
                            $ministries = get_terms(array(
                                'taxonomy' => 'ministere',
                                'hide_empty' => true,
                            ));
                            
                            if (!empty($ministries) && !is_wp_error($ministries)) :
                                foreach ($ministries as $ministry) :
                                    ?>
                                    <option value="<?php echo esc_attr($ministry->slug); ?>">
                                        <?php echo esc_html($ministry->name); ?>
                                    </option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                    <div class="search-group">
                        <label for="category-search"><?php _e('Catégorie', 'rapports-publics'); ?></label>
                        <select id="category-search" name="rapport_category">
                            <option value=""><?php _e('Toutes les catégories', 'rapports-publics'); ?></option>
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'rapport_category',
                                'hide_empty' => true,
                            ));
                            
                            if (!empty($categories) && !is_wp_error($categories)) :
                                foreach ($categories as $category) :
                                    ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="search-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                            <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php _e('Rechercher', 'rapports-publics'); ?>
                    </button>
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn btn-secondary">
                        <?php _e('Parcourir Tous les Rapports', 'rapports-publics'); ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/faq-section'); ?>

<style>
.search-section {
    padding: 4rem 0;
    background: var(--light-color);
}

.search-form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
}

.search-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.search-group {
    display: flex;
    flex-direction: column;
}

.search-group label {
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-color);
}

.search-input,
.search-group select {
    padding: 0.75rem;
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
}

.search-input:focus,
.search-group select:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
}

.search-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.search-actions .btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 160px;
    justify-content: center;
}

@media (max-width: 768px) {
    .search-grid {
        grid-template-columns: 1fr;
    }
    
    .search-actions {
        flex-direction: column;
    }
    
    .search-actions .btn {
        width: 100%;
    }
    
    .search-form-container {
        padding: 1.5rem;
        margin: 0 1rem;
    }
}
</style>

<?php get_footer(); ?>