<p align="center">
  <a href="https://sygatechnology.github.io/syga-rating/">
    <img src="https://sygatechnology.github.io/syga-rating/assets/img/logo.png" alt="Syga Rating logo" height="72">
  </a>
</p>
<h3 align="center">Syga Rating</h3>
<p align="center">
  Une extension de classement rapide pour WordPress
</p>
<hr>
<br>

## Installation ## 
1. Téléchargez le contenu du paquet zip dans le répertoire `/ wp-content / plugins /` 
2. Activer l'extension via le menu "Extensions" de WordPress 
3. Configurez l'extension selon vos besoins.
4. Placez le fragment de code suivant où vous souhaitez que le tableau du résumé de la liste des classements par type apparaisse (normalement `single.php`,` content-single.php` ou `index.php`): 

```php
<?php 
	syga_rating_content_frame(); 
?>
```
Cette fonction l'affichera automatiquement si l'extension est activée, sinon rien ne s'affiche.
## Comment ça marche ##
Fondamentalement, nous créons un nouveau type de poste appelé `syga_rating` qui n'accepte pas des postes parents ou enfants et lie des `champs personnalisés`, où nous stockons les votes et les avis des personnes (pour éviter les votes en double).
<hr>
<a href="https://github.com/sygatechnology/">Syga Technology</a>