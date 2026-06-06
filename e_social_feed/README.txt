SOCIAL WALL : Liste des confs
		
	Facebook :
		> identifiant de la page a remonté (sur le site facebook, par exemple dans "https://fr-fr.facebook.com/Versailles.officiel/", c'est "Versailles.officiel")
		> Nombre d'éléments à remonté dans le mur
		
		> fbVariable
		> nbElement
		
	Twitter :
		> identifiant du compte a remonté (c'est le nom de l'utilisateur @machin, par exemple "@Versailles")
		> Nombre d'éléments à remonté dans le mur
		
		> twVariable
		> nbElement
		
	Instagram :
		> identifiant du compte a remonté, récuperable de la facon suivante :
			// Le tag villedeversailles est à remplacer par celui voulu
			$test = file_get_contents('https://www.instagram.com/villedeversailles/?__a=1');
			$test2 = json_decode($test);
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($test2->user->id);
		> Nombre d'éléments à remonté dans le mur
			
		> insVariable
		> nbElement