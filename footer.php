<?php
/**
 * The template for displaying the footer
 *
 * @package RapportsPublics
 * @since 1.0.0
 */
?>

    <!-- Footer -->
    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-container">
                
                <!-- Footer About -->
                <div class="footer-about">
                    <div class="footer-logo">
                        <i class="fas fa-file-alt"></i>
                        <span>rapports publics</span>
                    </div>
                    <p><?php _e('Plateforme d\'accès libre aux rapports publics officiels du Sénégal. Transparence, reddition des comptes et bonne gouvernance.', 'rapports-publics'); ?></p>
                    <div class="social-links">
                        <a href="#" aria-label="<?php _e('Facebook', 'rapports-publics'); ?>">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" aria-label="<?php _e('Twitter', 'rapports-publics'); ?>">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" aria-label="<?php _e('LinkedIn', 'rapports-publics'); ?>">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" aria-label="<?php _e('YouTube', 'rapports-publics'); ?>">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Footer Widget 1 -->
                <div class="footer-links">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <h3><?php _e('Navigation', 'rapports-publics'); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Accueil', 'rapports-publics'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>"><?php _e('Rapports', 'rapports-publics'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/a-propos')); ?>"><?php _e('À propos', 'rapports-publics'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php _e('Contact', 'rapports-publics'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Footer Widget 2 -->
                <div class="footer-links">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <h3><?php _e('Thèmes', 'rapports-publics'); ?></h3>
                        <ul>
                            <?php
                            $ministeres = get_terms(array(
                                'taxonomy' => 'ministere',
                                'hide_empty' => true,
                                'number' => 4,
                            ));
                            if ($ministeres && !is_wp_error($ministeres)) :
                                foreach ($ministeres as $ministere) : ?>
                                    <li><a href="<?php echo esc_url(get_term_link($ministere)); ?>"><?php echo esc_html($ministere->name); ?></a></li>
                                <?php endforeach;
                            endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Footer Widget 3 -->
                <div class="footer-links">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <h3><?php _e('Support', 'rapports-publics'); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/faq')); ?>"><?php _e('FAQ', 'rapports-publics'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/guide')); ?>"><?php _e('Guide d\'utilisation', 'rapports-publics'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/accessibilite')); ?>"><?php _e('Accessibilité', 'rapports-publics'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/confidentialite')); ?>"><?php _e('Confidentialité', 'rapports-publics'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Footer Widget 4 -->
                <?php if (is_active_sidebar('footer-4')) : ?>
                    <div class="footer-links">
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                <?php endif; ?>

            </div><!-- .footer-container -->

            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <strong>rapports publics</strong>. <?php _e('Tous droits réservés. Plateforme de transparence publique du Sénégal.', 'rapports-publics'); ?></p>
            </div>
        </div><!-- .container -->
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>