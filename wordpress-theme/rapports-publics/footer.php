    <footer id="colophon" class="site-footer">
        <div class="container">
            
            <!-- Footer Widgets -->
            <?php if (is_active_sidebar('footer-widgets')) : ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-widgets'); ?>
                </div>
            <?php else : ?>
                
                <!-- Default Footer Content -->
                <div class="footer-content">
                    
                    <!-- About Section -->
                    <div class="footer-section">
                        <h3><?php _e('À propos', 'rapports-publics'); ?></h3>
                        <p>
                            <?php _e('Plateforme officielle d\'accès aux rapports publics des institutions gouvernementales. Transparence, accessibilité et fiabilité au service de l\'information citoyenne.', 'rapports-publics'); ?>
                        </p>
                        <div class="footer-stats">
                            <?php
                            $reports_count = wp_count_posts('rapport');
                            $published_count = $reports_count->publish ?? 0;
                            ?>
                            <div class="stat">
                                <strong><?php echo number_format_i18n($published_count); ?></strong>
                                <span><?php _e('Rapports disponibles', 'rapports-publics'); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-section">
                        <h3><?php _e('Liens rapides', 'rapports-publics'); ?></h3>
                        <ul class="footer-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Accueil', 'rapports-publics'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>"><?php _e('Tous les rapports', 'rapports-publics'); ?></a></li>
                            <li><a href="#search-section"><?php _e('Recherche avancée', 'rapports-publics'); ?></a></li>
                            <li><a href="#faq"><?php _e('Questions fréquentes', 'rapports-publics'); ?></a></li>
                            <li><a href="#about"><?php _e('À propos', 'rapports-publics'); ?></a></li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div class="footer-section">
                        <h3><?php _e('Catégories populaires', 'rapports-publics'); ?></h3>
                        <ul class="footer-menu">
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'rapport_category',
                                'hide_empty' => true,
                                'number' => 6,
                                'orderby' => 'count',
                                'order' => 'DESC'
                            ));
                            
                            if (!empty($categories) && !is_wp_error($categories)) :
                                foreach ($categories as $category) :
                                    ?>
                                    <li>
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
                    </div>

                    <!-- Ministries -->
                    <div class="footer-section">
                        <h3><?php _e('Ministères', 'rapports-publics'); ?></h3>
                        <ul class="footer-menu">
                            <?php
                            $ministries = get_terms(array(
                                'taxonomy' => 'ministere',
                                'hide_empty' => true,
                                'number' => 6,
                                'orderby' => 'count',
                                'order' => 'DESC'
                            ));
                            
                            if (!empty($ministries) && !is_wp_error($ministries)) :
                                foreach ($ministries as $ministry) :
                                    ?>
                                    <li>
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
                    </div>

                </div>
                
            <?php endif; ?>

            <!-- Footer Navigation -->
            <?php if (has_nav_menu('footer')) : ?>
                <div class="footer-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-nav-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                </div>
            <?php endif; ?>

            <!-- Newsletter Signup -->
            <div class="newsletter-section">
                <div class="newsletter-content">
                    <h3><?php _e('Restez informé', 'rapports-publics'); ?></h3>
                    <p><?php _e('Recevez une notification lors de la publication de nouveaux rapports dans vos domaines d\'intérêt.', 'rapports-publics'); ?></p>
                    
                    <form class="newsletter-form" action="#" method="post">
                        <div class="form-group">
                            <label for="newsletter-email" class="sr-only">
                                <?php _e('Adresse email', 'rapports-publics'); ?>
                            </label>
                            <input type="email" 
                                   id="newsletter-email" 
                                   name="email" 
                                   placeholder="<?php _e('Votre adresse email', 'rapports-publics'); ?>" 
                                   required>
                            <button type="submit" class="btn btn-primary">
                                <?php _e('S\'abonner', 'rapports-publics'); ?>
                            </button>
                        </div>
                        <small class="privacy-note">
                            <?php _e('Nous respectons votre vie privée. Désabonnement possible à tout moment.', 'rapports-publics'); ?>
                        </small>
                    </form>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                
                <!-- Copyright -->
                <div class="footer-copyright">
                    <p>
                        &copy; <?php echo date('Y'); ?> 
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                        <?php _e('- Tous droits réservés', 'rapports-publics'); ?>
                    </p>
                </div>

                <!-- Footer Links -->
                <div class="footer-links">
                    <ul class="footer-legal-menu">
                        <li><a href="#mentions-legales"><?php _e('Mentions légales', 'rapports-publics'); ?></a></li>
                        <li><a href="#politique-confidentialite"><?php _e('Politique de confidentialité', 'rapports-publics'); ?></a></li>
                        <li><a href="#accessibilite"><?php _e('Accessibilité', 'rapports-publics'); ?></a></li>
                        <li><a href="#contact"><?php _e('Contact', 'rapports-publics'); ?></a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div class="footer-social">
                    <div class="social-links">
                        <a href="#" class="social-link" title="<?php _e('Suivez-nous sur Twitter', 'rapports-publics'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="sr-only"><?php _e('Twitter', 'rapports-publics'); ?></span>
                        </a>
                        <a href="#" class="social-link" title="<?php _e('Suivez-nous sur Facebook', 'rapports-publics'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="sr-only"><?php _e('Facebook', 'rapports-publics'); ?></span>
                        </a>
                        <a href="#" class="social-link" title="<?php _e('Suivez-nous sur LinkedIn', 'rapports-publics'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="4" cy="4" r="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="sr-only"><?php _e('LinkedIn', 'rapports-publics'); ?></span>
                        </a>
                        <a href="#" class="social-link" title="<?php _e('Flux RSS', 'rapports-publics'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 11a9 9 0 0 1 9 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 4a16 16 0 0 1 16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="5" cy="19" r="1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="sr-only"><?php _e('RSS', 'rapports-publics'); ?></span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Back to Top Button -->
            <div class="back-to-top-container">
                <button id="back-to-top" class="back-to-top-btn" title="<?php _e('Retour en haut', 'rapports-publics'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m18 15-6-6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="sr-only"><?php _e('Retour en haut', 'rapports-publics'); ?></span>
                </button>
            </div>

        </div>
    </footer>

</div><!-- #page -->

<style>
/* Footer Styles */
.site-footer {
    background: var(--text-color);
    color: var(--light-color);
    padding: 3rem 0 1rem;
    margin-top: 4rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.footer-section h3 {
    color: var(--light-color);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.footer-section p {
    line-height: 1.6;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.footer-stats {
    margin-top: 1rem;
}

.stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--border-radius);
}

.stat strong {
    font-size: 1.5rem;
    color: var(--light-color);
    display: block;
}

.stat span {
    font-size: 0.875rem;
    opacity: 0.8;
}

.footer-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-menu li {
    margin-bottom: 0.5rem;
}

.footer-menu li a {
    color: #cccccc;
    text-decoration: none;
    transition: var(--transition);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-menu li a:hover {
    color: var(--light-color);
    padding-left: 0.5rem;
}

.footer-menu small {
    opacity: 0.7;
}

/* Footer Navigation */
.footer-navigation {
    margin-bottom: 2rem;
}

.footer-nav-menu {
    display: flex;
    justify-content: center;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 2rem;
    flex-wrap: wrap;
}

.footer-nav-menu li a {
    color: #cccccc;
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.footer-nav-menu li a:hover {
    color: var(--light-color);
}

/* Newsletter Section */
.newsletter-section {
    background: rgba(255, 255, 255, 0.1);
    padding: 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    text-align: center;
}

.newsletter-content h3 {
    color: var(--light-color);
    margin-bottom: 0.5rem;
}

.newsletter-content p {
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.newsletter-form .form-group {
    display: flex;
    gap: 0.5rem;
    max-width: 400px;
    margin: 0 auto;
}

.newsletter-form input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: var(--border-radius);
    background: rgba(255, 255, 255, 0.1);
    color: var(--light-color);
}

.newsletter-form input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.newsletter-form input:focus {
    outline: none;
    border-color: var(--light-color);
    background: rgba(255, 255, 255, 0.2);
}

.privacy-note {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    opacity: 0.7;
}

/* Footer Bottom */
.footer-bottom {
    display: grid;
    grid-template-columns: 1fr auto auto;
    align-items: center;
    gap: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.footer-copyright p {
    margin: 0;
    font-size: 0.875rem;
    opacity: 0.8;
}

.footer-copyright a {
    color: var(--light-color);
    text-decoration: none;
}

.footer-legal-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 1.5rem;
}

.footer-legal-menu li a {
    color: #cccccc;
    text-decoration: none;
    font-size: 0.875rem;
    transition: var(--transition);
}

.footer-legal-menu li a:hover {
    color: var(--light-color);
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    color: var(--light-color);
    text-decoration: none;
    border-radius: 50%;
    transition: var(--transition);
}

.social-link:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

/* Back to Top */
.back-to-top-container {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
}

.back-to-top-btn {
    display: none;
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: var(--light-color);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: var(--box-shadow);
    transition: var(--transition);
}

.back-to-top-btn:hover {
    background: var(--hover-color);
    transform: translateY(-2px);
}

.back-to-top-btn.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* High Contrast Mode */
.high-contrast {
    filter: contrast(200%) brightness(150%);
}

.high-contrast .site-footer {
    background: #000000;
    color: #ffffff;
}

/* Responsive Design */
@media (max-width: 992px) {
    .footer-bottom {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 1rem;
    }
    
    .footer-legal-menu {
        justify-content: center;
        flex-wrap: wrap;
    }
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
    }
    
    .footer-nav-menu {
        flex-direction: column;
        gap: 1rem;
    }
    
    .newsletter-form .form-group {
        flex-direction: column;
    }
    
    .newsletter-form input,
    .newsletter-form .btn {
        width: 100%;
    }
    
    .footer-legal-menu {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .social-links {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .site-footer {
        padding: 2rem 0 1rem;
    }
    
    .newsletter-section {
        padding: 1.5rem;
        margin: 0 1rem 2rem;
    }
    
    .back-to-top-container {
        bottom: 1rem;
        right: 1rem;
    }
    
    .back-to-top-btn {
        width: 45px;
        height: 45px;
    }
}
</style>

<?php wp_footer(); ?>

</body>
</html>