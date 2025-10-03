<?php
/**
 * Template part for displaying the about section
 *
 * @package RapportsPublics
 * @since 1.0.0
 */
?>

<section class="about-section" id="about">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <?php _e('À propos des Rapports Publics', 'rapports-publics'); ?>
            </h2>
            <p class="section-subtitle">
                <?php _e('Une plateforme centralisée pour accéder à l\'information gouvernementale officielle', 'rapports-publics'); ?>
            </p>
        </div>

        <div class="about-content">
            <div class="about-grid">
                
                <!-- Mission -->
                <div class="about-card card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7l10 5 10-5-10-5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="m2 17 10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="card-title">
                            <?php _e('Notre Mission', 'rapports-publics'); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p>
                            <?php _e('Fournir un accès transparent et facile aux rapports officiels des institutions publiques, favorisant ainsi la transparence gouvernementale et l\'information citoyenne.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- Transparence -->
                <div class="about-card card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                <path d="m12 1 0 6m0 6 0 6M1 12l6 0m6 0 6 0" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3 class="card-title">
                            <?php _e('Transparence', 'rapports-publics'); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p>
                            <?php _e('Tous les rapports sont accessibles gratuitement et sans restriction, dans le respect des principes de transparence administrative et d\'accès à l\'information publique.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- Accessibilité -->
                <div class="about-card card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="card-title">
                            <?php _e('Accessibilité', 'rapports-publics'); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p>
                            <?php _e('Interface intuitive et accessible, optimisée pour tous les utilisateurs. Recherche avancée et filtres multiples pour trouver rapidement les documents souhaités.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- Fiabilité -->
                <div class="about-card card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2"/>
                                <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="card-title">
                            <?php _e('Fiabilité', 'rapports-publics'); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p>
                            <?php _e('Documents officiels vérifiés et validés par les institutions compétentes. Chaque rapport est authentique et provient directement des sources gouvernementales.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional Info -->
        <div class="about-info">
            <div class="info-grid">
                
                <div class="info-item">
                    <h4><?php _e('Types de Documents', 'rapports-publics'); ?></h4>
                    <ul>
                        <li><?php _e('Rapports d\'activité annuels', 'rapports-publics'); ?></li>
                        <li><?php _e('Études et analyses sectorielles', 'rapports-publics'); ?></li>
                        <li><?php _e('Rapports d\'audit et d\'évaluation', 'rapports-publics'); ?></li>
                        <li><?php _e('Documents de politique publique', 'rapports-publics'); ?></li>
                        <li><?php _e('Bilans et statistiques officielles', 'rapports-publics'); ?></li>
                    </ul>
                </div>

                <div class="info-item">
                    <h4><?php _e('Organismes Contributeurs', 'rapports-publics'); ?></h4>
                    <ul>
                        <li><?php _e('Ministères et secrétariats d\'État', 'rapports-publics'); ?></li>
                        <li><?php _e('Institutions publiques nationales', 'rapports-publics'); ?></li>
                        <li><?php _e('Agences gouvernementales', 'rapports-publics'); ?></li>
                        <li><?php _e('Organismes de contrôle et d\'audit', 'rapports-publics'); ?></li>
                        <li><?php _e('Instances consultatives officielles', 'rapports-publics'); ?></li>
                    </ul>
                </div>

                <div class="info-item">
                    <h4><?php _e('Mise à Jour', 'rapports-publics'); ?></h4>
                    <p>
                        <?php _e('La plateforme est mise à jour régulièrement avec les dernières publications. Les nouveaux rapports sont ajoutés dès leur validation officielle et leur mise à disposition publique.', 'rapports-publics'); ?>
                    </p>
                    <p>
                        <strong><?php _e('Dernière mise à jour :', 'rapports-publics'); ?></strong>
                        <time datetime="<?php echo current_time('c'); ?>">
                            <?php echo date_i18n(get_option('date_format'), current_time('timestamp')); ?>
                        </time>
                    </p>
                </div>

            </div>
        </div>

        <!-- Call to Action -->
        <div class="about-cta">
            <h3><?php _e('Commencez dès maintenant', 'rapports-publics'); ?></h3>
            <p>
                <?php _e('Explorez notre collection de rapports publics et restez informé des dernières publications gouvernementales.', 'rapports-publics'); ?>
            </p>
            <div class="cta-actions">
                <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn">
                    <?php _e('Explorer les Rapports', 'rapports-publics'); ?>
                </a>
                <a href="#search-section" class="btn btn-secondary scroll-to">
                    <?php _e('Recherche Avancée', 'rapports-publics'); ?>
                </a>
            </div>
        </div>

    </div>
</section>

<style>
.about-section {
    padding: 4rem 0;
    background-color: var(--light-color);
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.25rem;
    color: var(--text-color);
    max-width: 600px;
    margin: 0 auto;
}

.about-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.about-card {
    text-align: center;
    transition: var(--transition);
}

.about-card:hover {
    transform: translateY(-8px);
}

.card-icon {
    color: var(--primary-color);
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
}

.about-info {
    margin: 3rem 0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.info-item h4 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.info-item ul {
    list-style: none;
    padding: 0;
}

.info-item ul li {
    padding: 0.5rem 0;
    padding-left: 1.5rem;
    position: relative;
}

.info-item ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--success-color);
    font-weight: bold;
}

.about-cta {
    background: var(--secondary-color);
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    text-align: center;
    margin-top: 3rem;
}

.about-cta h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.75rem;
}

.about-cta p {
    margin-bottom: 2rem;
    font-size: 1.125rem;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .about-grid {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-actions {
        flex-direction: column;
    }
    
    .cta-actions .btn {
        width: 100%;
    }
    
    .about-cta {
        padding: 2rem 1rem;
    }
}
</style>