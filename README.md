# Rapports Publics - WordPress Theme

Un thème WordPress officiel pour le répertoire national des rapports publics du Sénégal. Conçu pour la transparence et l'accès à l'information gouvernementale.

## Description

Ce thème WordPress convertit entièrement le design "rapports publics" en une solution de gestion de contenu complète. Il permet aux institutions gouvernementales de publier, organiser et partager facilement leurs rapports officiels.

## Fonctionnalités

### 🎨 Design & Interface
- **Design Responsive**: Optimisé pour mobile, tablette et desktop
- **Interface Professionnelle**: Design gouvernemental officiel du Sénégal
- **Navigation Intuitive**: Menu principal avec support mobile
- **Accessibilité**: Conforme aux standards d'accessibilité web

### 📊 Gestion des Rapports
- **Type de Contenu Personnalisé**: "Rapports" avec champs spécialisés
- **Taxonomies**: Organisation par ministères et catégories
- **Métadonnées**: Date de publication, taille de fichier, nombre de téléchargements
- **Images à la Une**: Support des images de couverture pour chaque rapport
- **Téléchargement**: Système de téléchargement avec comptage automatique

### 🔧 Fonctionnalités WordPress
- **Éditeur Gutenberg**: Support complet de l'éditeur de blocs
- **Patterns de Blocs**: Modèles prêts à l'emploi pour FAQ et sections
- **Zones de Widgets**: 4 zones de widgets dans le footer + sidebar
- **Personnalisation**: Options de personnalisation via l'interface WordPress
- **SEO Ready**: Structure optimisée pour le référencement

### 📱 Sections Principales
- **Section Héro**: Bannière d'accueil personnalisable
- **À Propos**: Présentation de la plateforme
- **Grille de Rapports**: Affichage des derniers rapports publiés
- **FAQ**: Section questions/réponses avec accordéon
- **Footer**: Liens organisés et réseaux sociaux

## Installation

### 1. Téléchargement
Copiez tout le contenu du dossier `wordpress-theme` vers votre installation WordPress.

### 2. Structure
```
wp-content/themes/rapports-publics/
├── style.css                    # Feuille de style principale
├── functions.php                # Fonctions du thème
├── index.php                    # Template principal
├── header.php                   # En-tête
├── footer.php                   # Pied de page
├── single-rapport.php           # Page individuelle de rapport
├── archive-rapport.php          # Archive des rapports
├── template-parts/              # Parties de templates
│   ├── hero-section.php
│   ├── about-section.php
│   ├── reports-section.php
│   └── faq-section.php
├── assets/
│   ├── js/main.js              # JavaScript
│   ├── css/                    # CSS additionnels
│   └── images/                 # Images du thème
└── README.md                   # Ce fichier
```

### 3. Activation
1. Allez dans **Apparence > Thèmes** dans l'admin WordPress
2. Activez le thème "Rapports Publics Sénégal"
3. Le thème sera automatiquement configuré

## Configuration

### 1. Menus
- Allez dans **Apparence > Menus**
- Créez un menu principal et assignez-le à l'emplacement "Primary Menu"
- Ajoutez les pages : Accueil, Rapports, À propos, Contact

### 2. Personnalisation
- Allez dans **Apparence > Personnaliser**
- Configurez le logo, les couleurs et la section héro
- Définissez les titre et sous-titre de la page d'accueil

### 3. Widgets
- Configurez les zones de widgets dans le footer (Footer 1-4)
- Ajoutez des widgets dans la sidebar des pages de rapports

### 4. Ajout de Rapports
- Allez dans **Rapports > Ajouter**
- Remplissez les informations du rapport
- Ajoutez une image à la une
- Définissez le ministère et la catégorie
- Ajoutez l'URL du fichier PDF dans les métadonnées

## Types de Contenu

### Rapport (rapport)
**Champs disponibles:**
- Titre et contenu (éditeur Gutenberg)
- Image à la une
- Extrait
- Ministère (taxonomie)
- Catégorie de rapport (taxonomie)
- Date de publication
- URL du fichier PDF
- Taille du fichier
- Nombre de téléchargements (auto-calculé)

### Taxonomies
- **Ministères** (`ministere`): Organisation par ministère
- **Catégories de Rapport** (`rapport_category`): Classification thématique

## Fonctionnalités Techniques

### JavaScript
- Menu mobile responsive
- Accordéon FAQ interactif
- Défilement fluide vers les ancres
- Lazy loading des images
- Bouton retour en haut de page

### PHP
- Templates WordPress standards
- Hooks et filtres personnalisés
- Fonctions de sécurité
- Compatibilité multilingue (prêt pour la traduction)

### CSS
- Variables CSS pour la cohérence des couleurs
- Grid et Flexbox pour les layouts
- Media queries pour le responsive
- Animations et transitions

## Personnalisation Avancée

### Couleurs du Thème
```css
:root {
  --primary: #1a3d7d;    /* Bleu principal */
  --secondary: #e63946;   /* Rouge secondaire */
  --accent: #457b9d;      /* Bleu accent */
  --dark: #1d3557;        /* Texte sombre */
  --gray: #8d99ae;        /* Gris */
  --success: #2a9d8f;     /* Vert succès */
}
```

### Ajout de Ministères
1. Allez dans **Rapports > Ministères**
2. Ajoutez les ministères avec descriptions
3. Les ministères apparaîtront automatiquement dans les filtres

### Blocs Gutenberg Personnalisés
Le thème inclut des patterns de blocs pour :
- Section FAQ
- Grille de rapports
- Section héro

## Support et Contribution

### Compatibilité
- **WordPress**: 6.0 ou supérieur
- **PHP**: 8.0 ou supérieur
- **Navigateurs**: Tous navigateurs modernes

### Fonctionnalités Futures
- Système de recherche avancée
- Export des données de téléchargement
- Notifications de nouveaux rapports
- Interface d'administration personnalisée

## Licence

Ce thème est distribué sous licence GPL v2 ou ultérieure, dans le cadre du projet de transparence gouvernementale de la République du Sénégal.

## Crédits

**Développé pour**: République du Sénégal  
**Objectif**: Transparence et accès à l'information publique  
**Design**: Basé sur les standards gouvernementaux sénégalais  
**Version**: 1.0.0