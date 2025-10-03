# Installation Guide - Rapports Publics WordPress Theme

## Installation Rapide

### Étape 1: Téléchargement
Téléchargez tous les fichiers du dossier `wordpress-theme` sur votre serveur WordPress.

### Étape 2: Installation
1. **Via FTP/cPanel:**
   - Uploadez le dossier `wordpress-theme` vers `/wp-content/themes/`
   - Renommez-le en `rapports-publics` si nécessaire

2. **Via WordPress Admin:**
   - Créez un fichier ZIP du dossier `wordpress-theme`
   - Allez dans **Apparence > Thèmes > Ajouter**
   - Téléversez le fichier ZIP

### Étape 3: Activation
1. Allez dans **Apparence > Thèmes**
2. Activez "Rapports Publics Sénégal"
3. Le thème est maintenant actif!

## Configuration Initiale

### 1. Menu Principal (Obligatoire)
```
Apparence > Menus > Créer un nouveau menu
- Nom: "Menu Principal"
- Emplacement: "Primary Menu"
- Ajoutez: Accueil, Rapports, À propos, Contact
```

### 2. Page d'Accueil
```
Réglages > Lecture
- Sélectionnez "Une page statique"
- Page d'accueil: Créez une page "Accueil"
```

### 3. Permaliens (Important)
```
Réglages > Permaliens
- Sélectionnez "Nom de l'article" ou "Structure personnalisée"
- Sauvegardez pour actualiser les règles
```

## Ajout de Contenu

### Créer un Rapport
1. Allez dans **Rapports > Ajouter**
2. Remplissez:
   - **Titre**: Nom du rapport
   - **Contenu**: Description détaillée
   - **Image à la une**: Couverture du rapport
   - **Extrait**: Résumé court

3. **Métadonnées du rapport** (dans la boîte à droite):
   - Date de publication
   - URL du fichier PDF
   - Taille du fichier (ex: "2.5 MB")

4. **Catégorisation**:
   - Sélectionnez un **Ministère**
   - Choisissez une **Catégorie de rapport**

### Créer des Ministères
```
Rapports > Ministères > Ajouter
- Nom: "Ministère des Finances"
- Description: Courte description du ministère
```

### Créer des Catégories
```
Rapports > Catégories de Rapport > Ajouter
- Nom: "Rapport Annuel"
- Description: Type de rapport
```

## Personnalisation

### 1. Customizer
```
Apparence > Personnaliser
- Identité du site: Logo et titre
- Section Héro: Titre et sous-titre de la page d'accueil
- Couleurs: Personnalisation des couleurs
```

### 2. Widgets Footer
```
Apparence > Widgets
- Footer 1: Menu "Navigation"
- Footer 2: Menu "Thèmes" (catégories de rapports)
- Footer 3: Menu "Support" (pages d'aide)
- Footer 4: Widget personnalisé
```

## Pages Recommandées

Créez ces pages dans **Pages > Ajouter**:

1. **À propos** (`/a-propos`)
   - Contenu: Mission et objectifs de la plateforme

2. **Contact** (`/contact`)
   - Contenu: Informations de contact et formulaire

3. **FAQ** (`/faq`)
   - Contenu: Questions fréquentes (optionnel, déjà dans l'accueil)

4. **Guide d'utilisation** (`/guide`)
   - Contenu: Comment utiliser la plateforme

5. **Politique de confidentialité** (`/confidentialite`)
   - Contenu: Politique de confidentialité

## Configuration Avancée

### 1. Fichiers PDF
- Uploadez les fichiers PDF dans **Médias**
- Copiez l'URL du fichier
- Collez-la dans le champ "URL du Fichier PDF" du rapport

### 2. Images Optimisées
Le thème utilise ces tailles d'images:
- **Thumbnail rapport**: 400x200px
- **Featured rapport**: 800x400px
- **Hero background**: 1920x1080px

### 3. Sécurité
Ajoutez ce code dans `.htaccess` pour protéger les téléchargements:
```apache
# Protection des fichiers PDF (optionnel)
<FilesMatch "\.(pdf)$">
    Header set Content-Disposition attachment
</FilesMatch>
```

## Dépannage

### Problème: Menu ne s'affiche pas
**Solution**: Vérifiez que le menu est assigné à l'emplacement "Primary Menu"

### Problème: Page d'accueil ne s'affiche pas correctement
**Solution**: 
1. Allez dans **Réglages > Lecture**
2. Sélectionnez "Derniers articles" temporairement
3. Puis revenez à "Page statique" avec votre page d'accueil

### Problème: URLs des rapports ne fonctionnent pas
**Solution**: Allez dans **Réglages > Permaliens** et cliquez "Enregistrer"

### Problème: Styles ne s'appliquent pas
**Solution**: Videz le cache du navigateur (Ctrl+F5) et du cache WordPress si activé

## Support

Pour toute question technique:
1. Vérifiez la **console développeur** du navigateur (F12)
2. Activez le **debug WordPress** dans `wp-config.php`:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   ```
3. Consultez les logs dans `/wp-content/debug.log`

## Checklist Post-Installation

- [ ] Thème activé
- [ ] Menu principal créé et assigné
- [ ] Page d'accueil définie
- [ ] Permaliens configurés
- [ ] Au moins un ministère créé
- [ ] Au moins une catégorie de rapport créée
- [ ] Premier rapport de test publié
- [ ] Logo uploadé (optionnel)
- [ ] Widgets footer configurés (optionnel)

Une fois cette checklist complétée, votre site "Rapports Publics" est opérationnel! 🇸🇳