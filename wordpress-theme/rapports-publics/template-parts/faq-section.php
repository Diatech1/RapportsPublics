<?php
/**
 * Template part for displaying the FAQ section
 *
 * @package RapportsPublics
 * @since 1.0.0
 */
?>

<section class="faq-section" id="faq">
    <div class="container">
        
        <div class="section-header">
            <h2 class="section-title">
                <?php _e('Questions Fréquemment Posées', 'rapports-publics'); ?>
            </h2>
            <p class="section-subtitle">
                <?php _e('Trouvez rapidement les réponses aux questions les plus courantes concernant l\'accès et l\'utilisation des rapports publics', 'rapports-publics'); ?>
            </p>
        </div>

        <div class="faq-content">
            <div class="faq-list">
                
                <!-- FAQ Item 1 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Comment puis-je accéder aux rapports publics ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Tous les rapports sont accessibles gratuitement depuis notre plateforme. Vous pouvez les parcourir par catégorie, ministère, ou utiliser notre fonction de recherche pour trouver des documents spécifiques. Aucune inscription n\'est nécessaire pour consulter ou télécharger les rapports.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Les rapports sont-ils authentiques et officiels ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Oui, absolument. Tous les rapports publiés sur notre plateforme sont des documents officiels provenant directement des institutions gouvernementales et organismes publics concernés. Chaque rapport est vérifié et validé avant sa mise en ligne pour garantir son authenticité.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('À quelle fréquence de nouveaux rapports sont-ils publiés ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('La fréquence de publication varie selon les institutions et le type de rapport. Les rapports d\'activité annuels sont généralement publiés une fois par an, tandis que d\'autres études ou analyses peuvent être publiées de manière plus irrégulière selon les besoins et l\'actualité. Notre plateforme est mise à jour régulièrement dès qu\'un nouveau rapport est disponible.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Puis-je utiliser ces rapports pour mes recherches ou travaux ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Oui, ces documents sont publics et peuvent être utilisés pour des recherches académiques, professionnelles ou personnelles. Nous recommandons de citer correctement la source en mentionnant l\'institution émettrice et la date de publication. Vérifiez toutefois les conditions d\'utilisation spécifiques mentionnées dans chaque document si elles existent.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Comment puis-je être informé des nouvelles publications ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Actuellement, vous pouvez consulter régulièrement notre section "Derniers Rapports" sur la page d\'accueil. Nous travaillons sur la mise en place d\'un système de notification et d\'abonnement pour vous tenir informé des nouvelles publications selon vos centres d\'intérêt.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Les rapports sont-ils disponibles dans différents formats ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('La plupart des rapports sont disponibles au format PDF, qui garantit une présentation fidèle du document original. Certains rapports peuvent également être disponibles dans d\'autres formats selon les choix de l\'institution émettrice. Le format et la taille du fichier sont indiqués pour chaque document.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 7 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Que faire si je ne trouve pas un rapport spécifique ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Si vous ne trouvez pas un rapport spécifique, plusieurs possibilités : le document n\'est peut-être pas encore publié officiellement, il pourrait être classé dans une catégorie différente de celle que vous consultez, ou il n\'est pas encore référencé dans notre base de données. Utilisez notre fonction de recherche avec différents mots-clés et filtres. Si le rapport devrait être public mais n\'est pas disponible, contactez directement l\'institution concernée.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 8 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Comment fonctionne la fonction de recherche ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Notre moteur de recherche analyse le titre, le contenu descriptif et les métadonnées des rapports. Vous pouvez rechercher par mots-clés, nom d\'institution, sujet, ou période. Utilisez les filtres par ministère, catégorie ou année pour affiner vos résultats. La recherche fonctionne aussi bien avec des termes exacts qu\'avec des expressions partielles.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 9 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Y a-t-il des restrictions d\'accès pour certains rapports ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Seuls les rapports publics et accessibles à tous sont référencés sur notre plateforme. Certains documents gouvernementaux peuvent avoir un accès restreint ou être classifiés - ces documents ne sont pas disponibles sur notre site. Tous les rapports présents sont librement consultables et téléchargeables par le grand public.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 10 -->
                <div class="faq-item">
                    <button class="faq-question" type="button" aria-expanded="false">
                        <?php _e('Comment signaler un problème technique ou une erreur ?', 'rapports-publics'); ?>
                    </button>
                    <div class="faq-answer">
                        <p>
                            <?php _e('Si vous rencontrez des difficultés techniques (lien de téléchargement non fonctionnel, erreur d\'affichage, information incorrecte), vous pouvez nous contacter via notre formulaire de contact en précisant la nature du problème et l\'URL de la page concernée. Nous nous efforçons de résoudre rapidement tous les problèmes signalés.', 'rapports-publics'); ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional Help -->
        <div class="faq-help">
            <div class="help-card">
                <h3><?php _e('Besoin d\'aide supplémentaire ?', 'rapports-publics'); ?></h3>
                <p>
                    <?php _e('Si vous n\'avez pas trouvé la réponse à votre question, n\'hésitez pas à nous contacter. Notre équipe est là pour vous aider à naviguer efficacement dans notre collection de rapports publics.', 'rapports-publics'); ?>
                </p>
                <div class="help-actions">
                    <a href="#contact" class="btn btn-primary">
                        <?php _e('Nous Contacter', 'rapports-publics'); ?>
                    </a>
                    <a href="<?php echo esc_url(get_post_type_archive_link('rapport')); ?>" class="btn btn-secondary">
                        <?php _e('Parcourir les Rapports', 'rapports-publics'); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="quick-tips">
            <h3><?php _e('Conseils de Recherche', 'rapports-publics'); ?></h3>
            <div class="tips-grid">
                
                <div class="tip-item">
                    <div class="tip-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                            <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h4><?php _e('Utilisez des mots-clés précis', 'rapports-publics'); ?></h4>
                    <p><?php _e('Recherchez avec des termes spécifiques pour des résultats plus pertinents', 'rapports-publics'); ?></p>
                </div>

                <div class="tip-item">
                    <div class="tip-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h4><?php _e('Combinez les filtres', 'rapports-publics'); ?></h4>
                    <p><?php _e('Utilisez plusieurs filtres simultanément pour affiner votre recherche', 'rapports-publics'); ?></p>
                </div>

                <div class="tip-item">
                    <div class="tip-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h4><?php _e('Explorez par catégories', 'rapports-publics'); ?></h4>
                    <p><?php _e('Parcourez les rapports par thème ou ministère pour découvrir du contenu connexe', 'rapports-publics'); ?></p>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
.faq-section {
    padding: 4rem 0;
    background-color: var(--light-color);
}

.faq-content {
    max-width: 800px;
    margin: 0 auto;
}

.faq-list {
    margin-bottom: 3rem;
}

.faq-item {
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
    overflow: hidden;
    background: white;
}

.faq-question {
    width: 100%;
    background: var(--secondary-color);
    border: none;
    padding: 1.5rem;
    text-align: left;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    color: var(--text-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: var(--transition);
    position: relative;
}

.faq-question:hover {
    background: var(--border-color);
}

.faq-question:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: -2px;
}

.faq-question::after {
    content: '+';
    font-size: 1.5rem;
    color: var(--primary-color);
    font-weight: 300;
    transition: var(--transition);
    flex-shrink: 0;
    margin-left: 1rem;
}

.faq-item.active .faq-question::after {
    transform: rotate(45deg);
}

.faq-answer {
    padding: 0 1.5rem;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
    background: white;
}

.faq-item.active .faq-answer {
    padding: 1.5rem;
    max-height: 500px;
}

.faq-answer p {
    line-height: 1.6;
    color: var(--text-color);
    margin: 0;
}

.faq-help {
    background: var(--secondary-color);
    border-radius: var(--border-radius);
    padding: 3rem 2rem;
    text-align: center;
    margin-bottom: 3rem;
}

.help-card h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.75rem;
}

.help-card p {
    margin-bottom: 2rem;
    font-size: 1.125rem;
    color: var(--text-color);
}

.help-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.quick-tips {
    text-align: center;
}

.quick-tips h3 {
    color: var(--primary-color);
    margin-bottom: 2rem;
    font-size: 1.5rem;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.tip-item {
    text-align: center;
    padding: 1.5rem;
    background: white;
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    transition: var(--transition);
}

.tip-item:hover {
    transform: translateY(-4px);
    box-shadow: var(--box-shadow);
}

.tip-icon {
    color: var(--primary-color);
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
}

.tip-item h4 {
    color: var(--text-color);
    margin-bottom: 0.5rem;
    font-size: 1.125rem;
}

.tip-item p {
    color: var(--text-color);
    opacity: 0.8;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
}

@media (max-width: 768px) {
    .faq-question {
        padding: 1rem;
        font-size: 0.9rem;
    }
    
    .faq-answer {
        padding: 0 1rem;
    }
    
    .faq-item.active .faq-answer {
        padding: 1rem;
    }
    
    .help-actions {
        flex-direction: column;
    }
    
    .help-actions .btn {
        width: 100%;
    }
    
    .tips-grid {
        grid-template-columns: 1fr;
    }
    
    .faq-help {
        padding: 2rem 1rem;
    }
}

@media (max-width: 480px) {
    .faq-question {
        padding: 0.75rem;
        font-size: 0.85rem;
    }
    
    .faq-question::after {
        font-size: 1.25rem;
        margin-left: 0.5rem;
    }
}
</style>