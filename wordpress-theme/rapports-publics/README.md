# Rapports Publics - WordPress Theme

## 📋 Description

**Rapports Publics** est un thème WordPress moderne et sécurisé conçu spécifiquement pour la gestion et l'affichage de rapports publics des institutions gouvernementales. Il offre une interface intuitive, accessible et optimisée pour faciliter l'accès transparent aux documents officiels.

## ✨ Fonctionnalités Principales

### 🔐 Sécurité
- **Vérification de nonce** pour tous les téléchargements
- **Sanitisation complète** des données utilisateur
- **Protection contre les injections** SQL et XSS
- **Validation stricte** des entrées
- **Gestion sécurisée** des métadonnées

### 🎨 Interface Utilisateur
- **Design responsive** adapté à tous les écrans
- **Accessibilité WCAG** intégrée
- **Navigation intuitive** avec fil d'Ariane
- **Recherche avancée** avec filtres multiples
- **Thème sombre/clair** et options d'accessibilité

### 📊 Gestion des Rapports
- **Post type personnalisé** pour les rapports
- **Taxonomies dédiées** (ministères, catégories)
- **Métadonnées complètes** (taille, date, téléchargements)
- **Suivi des téléchargements** avec analytics
- **Organisation par catégories** et ministères

### 🔍 Recherche et Filtrage
- **Moteur de recherche AJAX** en temps réel
- **Filtres par ministère** et catégorie
- **Recherche par année** de publication
- **Suggestions automatiques** de recherche
- **Résultats paginés** et optimisés

### 📱 Responsive Design
- **Mobile-first** approach
- **Grilles CSS modernes** (Grid & Flexbox)
- **Images optimisées** avec lazy loading
- **Performance améliorée** sur tous les appareils

## 🛠️ Installation

### Prérequis
- WordPress 5.0 ou supérieur
- PHP 7.4 ou supérieur
- MySQL 5.6 ou supérieur

### Étapes d'installation

1. **Télécharger le thème**
   ```bash
   # Copier le dossier dans wp-content/themes/
   cp -r rapports-publics /path/to/wordpress/wp-content/themes/
   ```

2. **Activer le thème**
   - Aller dans `Apparence > Thèmes` dans l'admin WordPress
   - Cliquer sur "Activer" sous le thème Rapports Publics

3. **Configuration initiale**
   - Aller dans `Rapports Publics` dans le menu admin
   - Créer les taxonomies (ministères, catégories)
   - Configurer les menus dans `Apparence > Menus`

## 📁 Structure des Fichiers

```
rapports-publics/
├── assets/
│   ├── css/                    # Styles additionnels
│   ├── js/
│   │   └── main.js            # JavaScript principal
│   └── images/                # Images du thème
├── template-parts/
│   ├── hero-section.php       # Section héros
│   ├── about-section.php      # Section à propos
│   ├── reports-section.php    # Section rapports
│   └── faq-section.php        # Section FAQ
├── style.css                  # Feuille de style principale
├── functions.php              # Fonctions du thème
├── index.php                  # Template principal
├── header.php                 # En-tête
├── footer.php                 # Pied de page
├── sidebar.php                # Barre latérale
├── single-rapport.php         # Page de rapport individuel
├── archive-rapport.php        # Archive des rapports
└── README.md                  # Documentation
```

## 🎯 Configuration

### 1. Menus
Créer et assigner les menus suivants :
- **Menu Principal** (primary) : Navigation principale
- **Menu Pied de Page** (footer) : Liens du footer

### 2. Widgets
Le thème supporte les zones de widgets :
- **Barre Latérale Principale** : Widgets de la sidebar
- **Pied de Page** : Widgets du footer

### 3. Types de Contenu

#### Rapports (rapport)
- **Titre** : Nom du rapport
- **Contenu** : Description détaillée
- **Image à la Une** : Couverture ou illustration
- **Métadonnées** :
  - Date de publication
  - URL du fichier
  - Taille du fichier
  - Nombre de téléchargements

#### Taxonomies
- **Ministères** (ministere) : Organisation émettrice
- **Catégories de Rapports** (rapport_category) : Type de document

## 🔧 Personnalisation

### Variables CSS
Le thème utilise des variables CSS personnalisables :

```css
:root {
    --primary-color: #2c5aa0;        /* Couleur principale */
    --secondary-color: #f8f9fa;      /* Couleur secondaire */
    --text-color: #333333;           /* Couleur du texte */
    --background: #ffffff;           /* Arrière-plan */
    --border-color: #dddddd;         /* Bordures */
    --hover-color: #1e3f73;          /* Survol */
    --font-family: 'Inter', sans-serif; /* Police */
}
```

### Hooks et Filtres
Le thème offre plusieurs hooks pour la personnalisation :

```php
// Modifier la requête principale des rapports
add_action('pre_get_posts', 'custom_reports_query');

// Ajouter des champs personnalisés
add_filter('rapports_publics_meta_fields', 'add_custom_fields');

// Personnaliser les classes CSS
add_filter('body_class', 'custom_body_classes');
```

## 🔍 Fonctions Utilitaires

### Récupérer l'URL de téléchargement sécurisée
```php
$download_url = rapports_publics_get_download_url($post_id);
```

### Vérifier si un rapport a un fichier
```php
$file_url = get_post_meta($post_id, '_file_url', true);
if ($file_url) {
    // Le rapport a un fichier attaché
}
```

### Obtenir le nombre de téléchargements
```php
$download_count = get_post_meta($post_id, '_download_count', true);
```

## 📊 Analytics et Suivi

Le thème intègre un système de suivi des téléchargements :

- **Comptage automatique** des téléchargements
- **Logging des accès** pour analytics
- **Protection contre les bots** et téléchargements frauduleux
- **Statistiques dans l'admin** WordPress

## 🌐 Accessibilité

### Standards Respectés
- **WCAG 2.1 AA** : Conformité aux standards
- **Navigation au clavier** : Tous les éléments accessibles
- **Lecteurs d'écran** : Structure sémantique optimisée
- **Contraste élevé** : Option d'affichage alternatif

### Fonctionnalités d'Accessibilité
- **Skip links** pour navigation rapide
- **ARIA labels** sur les éléments interactifs
- **Tailles de police** ajustables
- **Mode contraste élevé** disponible

## 🚀 Performance

### Optimisations Intégrées
- **Lazy loading** des images
- **Minification CSS/JS** recommandée
- **Cache des requêtes** taxonomies
- **Pagination efficace** des résultats
- **Requêtes optimisées** pour les métadonnées

### Recommandations
- Utiliser un plugin de cache (WP Rocket, W3 Total Cache)
- Optimiser les images (WebP, compression)
- Utiliser un CDN pour les fichiers statiques
- Configurer la compression GZIP

## 🔧 Développement

### Environnement de Développement
```bash
# Installation des dépendances (si applicable)
npm install

# Compilation des assets
npm run build

# Mode développement
npm run dev
```

### Standards de Code
- **WordPress Coding Standards** respectés
- **Documentation PHP** complète
- **Commentaires en français** pour la compréhension
- **Sécurité first** dans toutes les fonctions

## 📝 Changelog

### Version 1.0.0 (2024-10-03)
#### ✅ Ajouté
- Structure complète du thème WordPress
- Gestion sécurisée des téléchargements avec nonces
- Sanitisation et validation complètes des données
- Interface responsive et accessible
- Système de recherche AJAX avancé
- Métadonnées complètes pour les rapports
- Suivi des téléchargements avec analytics
- Templates personnalisés pour tous les types de pages
- Variables CSS pour personnalisation facile

#### 🔒 Sécurité
- Protection contre injections SQL/XSS
- Validation stricte des entrées utilisateur
- Nonces pour toutes les actions sensibles
- Sanitisation des métadonnées
- Contrôle des permissions utilisateur

#### 🐛 Corrections
- Problèmes d'encodage UTF-8 résolus
- JavaScript inline supprimé pour la sécurité
- CSS grid responsive optimisé
- Variables CSS manquantes ajoutées

## 🤝 Contribution

### Comment Contribuer
1. **Fork** le projet
2. **Créer** une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. **Commiter** les changements (`git commit -m 'Ajouter nouvelle fonctionnalité'`)
4. **Push** vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. **Créer** une Pull Request

### Standards de Contribution
- Suivre les **WordPress Coding Standards**
- **Tester** toutes les fonctionnalités
- **Documenter** les nouvelles fonctions
- **Respecter** les principes de sécurité

## 📞 Support

### Problèmes Connus
- Aucun problème majeur connu actuellement

### Obtenir de l'Aide
1. **Consulter** la documentation
2. **Vérifier** les issues GitHub existantes
3. **Créer** une nouvelle issue si nécessaire
4. **Contacter** l'équipe de développement

## 📄 Licence

Ce thème est distribué sous licence **GPL v2 ou ultérieure**.

```
Copyright (C) 2024 Rapports Publics Theme

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## 🙏 Remerciements

- **Équipe WordPress** pour le framework
- **Communauté open source** pour les contributions
- **Testeurs** et utilisateurs pour les retours
- **Institutions publiques** pour la transparence

---

**Developed with ❤️ for government transparency and public access to information.**

---

## 📋 Checklist de Déploiement

Avant de mettre en production :

- [ ] **Tester** sur différents navigateurs
- [ ] **Valider** l'accessibilité WCAG
- [ ] **Optimiser** les performances
- [ ] **Configurer** les sauvegardes
- [ ] **Sécuriser** les permissions fichiers
- [ ] **Activer** SSL/HTTPS
- [ ] **Configurer** les analytics
- [ ] **Tester** les téléchargements
- [ ] **Vérifier** la responsive design
- [ ] **Valider** le SEO technique