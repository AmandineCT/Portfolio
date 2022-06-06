<?php
$lang["friendlyname"] = "Babel: Site multilingue";
$lang["moddescription"] = "Permet la gestion de plusieurs langues pour le frontend et la navigation à travers celles-ci.";
$lang["admindescription"] = "Gestion des langues de contenu et des param&egrave;tres de langue.";

$lang["language"] = "Langue";
$lang["languages"] = "Langues";
$lang["add_language"] = "Ajouter une langue";
$lang["add_entry"] = "Ajouter une entr&eacute;e linguistique";
$lang["entry"] = "Entr&eacute;e linguistique";
$lang["edit_language"] = "Modifier la langue";
$lang["name"] = "Nom";
$lang["entryname"] = "Nom de l'entr&eacute; (sera utilis&eacute; pour l'appeler)";
$lang["menu_name"] = "Nom dans le menu";
$lang["langcode"] = "Code de langue";
$lang["langcode_prompt"] = "Code de lange (ex: en_US )";
$lang["root_id"] = "Page racine associ&eacute;e &agrave; la langue";
$lang["default_id"] = "Page par d&eacute;faut pour la redirection &agrave; cette langue";
$lang["langselect"] = "(facultatif) Remplir automatiquement pour la langue suivante:";
$lang["isdefault"] = "Par d&eacute;faut?";
$lang["actions"] = "Actions";
$lang["active"] = "Active";
$lang["prompt_deletelanguage"] = "Vraiment supprimer cette langue (%s)?";
$lang["prompt_deleteentry"] = "Voulez-vous vraiment supprimer cette entr&eacute;e?";
$lang["delete_entry"] = "Supprimer cette entr&eacute;e";


$lang["submit"] = "Envoyer";
$lang["cancel"] = "Annuler";
$lang["apply"] = "Appliquer";

$lang["edit_entries"] = "Modifier les entr&eacute;es linguistiques";




$lang["templatehelp"] = '<ul>
<li>$languages (array of $language)</li>
<li>$language-&gt;name</li>
<li>$language-&gt;code</li>
<li>$language-&gt;menu_name</li>
<li>$language-&gt;page_name</li>
<li>$language-&gt;page_menu_text</li>
<li>$language-&gt;url</li>
<li>$language-&gt;is_current</li>
</ul>';
	
// GENERAL
$lang["activate"] = "Activer";
$lang["unactivate"] = "D&eacute;sactiver";
$lang["searchthistable"] = "Chercher dans ce tableau:";
$lang["Yes"] = "Oui";
$lang["No"] = "Non";
$lang["Actions"] = "Actions";
$lang["reorder"] = "R&eacute;ordonner";
$lang["templates"] = "Gabarits de menu";
$lang["template"] = "Gabarit";
$lang["defaulttemplate"] = "Gabarit par d&eacute;faut";
$lang["templatevars"] = "Variables smarty";
$lang["edittemplate"] = "Modifier le gabarit";
$lang["addtemplate"] = "Ajouter un gabarit";
$lang["filterby"] = "Filtrer par";
$lang["showall"] = "Tout afficher (aucun filtre)";
$lang["message_deleted"] = "Supprim&eacute;";
$lang["message_modified"] = "Modification sauvegard&eacute;e";
$lang["error_missginvalue"] = "Des valeurs obligatoires sont manquantes.";
$lang["error_alreadyexists"] = "Il y a d&eacute;j&agrave; un &eacute;l&eacute;ment portant ce nom.";
$lang["error_notfound"] = "Aucun r&eacute;sultat.";
$lang["error_noitemfound"] = "Aucun r&eacute;sultat.";
$lang["givenerror"] = "Erreur: ";
$lang["prompt_generaldelete"] = "Supprimer?";


// MODULE INTERACTION
$lang["postinstall"] = "Module ajout&eacute;.";
$lang["postuninstall"] = "Module d&eacute;sinstall&eacute;.";
$lang["really_uninstall"] = "Vraiment d&eacute;sinstaller babel?";
$lang["uninstalled"] = "Module d&eacute;sinstall&eacute;.";
$lang["installed"] = "Module version %s install&eacute;.";

$lang["help"] = "<h3>&quot;Tree branches&quot;</h3>
					<p>Ce module utilise une approche de &quot;branches s&eacute;par&eacute;es&quot; (\"separated tree branches\") des sites multilingue d&eacute;velopp&eacute;e par d'autres d&eacute;veloppeurs de cmsms (principalement Marcos Cruz - voir <a href=\"http://forum.cmsmadesimple.org/index.php/topic,19099.msg94749.html#msg94749\" target=\"_blank\">cette conversation</a>).</p><br/>
					<p>Dans vos gabarits, vous pourrez r&eacute;cup&eacute;rer le code de la langue actuelle &agrave; l'aide de {".'$page_lang'."}, et plus d'informations sur la langue &agrave; l'aide de l'objet {".'$page_lang_info'."} (avec les m&ecirc;mes attributs que dans les gabarits de menu).</p>
				<br/><h3>&Eacute;tape 1: pr&eacute;paration des pages</h3>			
					<p>Vous devez d'abord cr&eacute;er diff&eacute;rentes pages racine pour chaque langue. Par example:</p>
					<ul>
						<li>1. English<ul>
							<li>1.1. 1st page</li>
							<li>1.2. 2nd page</li>
							<li>1.3. 3rd page</li>
						</ul></li>
						<li>2. Fran&ccedil;ais<ul>
							<li>2.1. Page 1</li>
							<li>2.2. Page 2</li>
							<li>2.3. Page 3</li>
						</ul></li>
					</ul>
					<p>Les pages racine (1. and 2.) devrait &ecirc;tre des en-t&ecirc;tes de section. Vous pouvez leur donner n'importe quel nom ou alias.</p>
					<p>Pour afficher vos menus correctement (c'est-&agrave;-dire, pour ne pas afficher les pages racines et les pages d'une autre langue), il vous suffira d'ajouter start_level=\"2\" &agrave; vos balises de menu:<br/>
					{menu start_level=\"2\"}</p>
				<br/><h3>&Eacute;tape 2: cr&eacute;ation des langues</h3>
					<p>Ensuite, rendez-vous dans Extensions-&gt;Babel: Site multilingue. Pour chaque langue, cliquez Ajouter une langue et entrez les informations appropri&eacute;es. La \"Page racine\" devrait &ecirc;tre l'en-t&ecirc;te de section que vous avez cr&eacute;&eacute; pour chaque langue (1.English, 2.Fran&ccedil;ais). La \"Page par d&eacute;faut\" devrait être la page d'accueil pour chaque langue. En ce qui concerne le code de langue, vous pourriez utiliser n'importe quel code de 5 caract&egrave;res, mais pour une bonne compatibilit&eacute; avec les autres modules, il est pr&eacute;f&eacute;rable d'utiliser les m&ecirc;mes que le cms (vous pouvez utiliser la liste d&eacute;roulante en haut &agrave; droite pour remplir partiellement le formulaire).</p>
					<p>( *Lorsque les langues sont pr&ecirc;tes &agrave; l'utilisation, n'oubliez pas de les activer...)</p>
				<br/><h3>&Eacute;tape 3: menu de langues</h3>
					<p>Pour afficher le menu des langues, utilisez la balise suivante:<br/>
					{babel action=\"menu\"}<br/>
					ou, pour sp&eacute;cifier un autre gabarit que celui par d&eacute;faut:<br/>
					{babel action=\"menu\" template=\"template_name\"}</p>
					<p>Le param&egrave;tre \"show\" peut &ecirc;tre utilis&eacute; pour choisir quelles langues afficher.</p>
				<br/><h3>&Eacute;tape 4 (facultative) : Entr&eacute;es linguistiques</h3>
					<p>Dans les modules, les blocs de contenu globaux ou n'importe o&ugrave;, vous aurez besoin d'afficher du contenu d&eacute;pendant de la langue. Traditionnellement, cela est accompli en utilisant des conditions avec la variable page_lang:<br/>
					{if $"."page_lang == \"en_US\"}English text{elseif $"."page_lang == \"fr_FR\"}Texte en fran&ccedil;ais{/if}</p>
					<p>Cette m&eacute;thode fonctionne toujours avec ce module, mais une autre m&eacute;thode, plus centralis&eacute;e, vous est offerte. Dans le panneau d'administration du module, vous trouverez pour chaque langue un lien pour modifier ses entr&eacute;es linguistiques. Les entr&eacute;es linguistiques sont des bouts de texte (ou html) ayant un contenu diff&eacute;rent pour chaque langue. Vous cr&eacute;ez une entr&eacute;e linguisitque (par example: \"welcome text\"), entrez son contenu pour chaque langue, et appelez l'entr&eacute;e la où vous en avez besoin dans les gabarits en utilisant l'action par d&eacute;faut et le param&egrave;tre \"show\":<br/>
					{babel show=\"welcome text\"}<br/>
					Si vous avez plusieurs langues, ou si vous avez plus tard &agrave; modifier les entr&eacute;es ou ajouter des langues, vous trouvez cette solution beaucoup plus pratique. Mais si vous pr&eacute;f&eacute;rez la premi&egrave;re, elle ne fonctionne pas moins.</p>
					<p>Il est aussi possible d'assigner les entr&eacute;es: <br/>
					{babel show=\"welcome text\" assign=\"welcome\"}<br/>
					ou, si vous voulez assigner plusieurs entr&eacute;es d'un seul coup, il suffit de les s&eacute;parer par des virgules:<br/>
					{babel show=\"entry1,entry2,entry3\" assign=\"var1,var2,var3\"}</p>	
			<br/><h3>M&eacute;thodes de redirection</h3>	
				<p>Il y a deux m&eacute;thodes possibles pour dire au cms quelle page est &eacute;quivalente &agrave; la page actuelle. Par d&eacute;faut, la m&eacute;thode hi&eacute;rarchique est activ&eacute;e, mais vous pouvez changer de m&eacute;thode dans l'onglet param&egrave;tres du module.</p>
				<br/><h4>La m&eacute;thode par d&eacute;finition de Marcos Cruz</h4>
					<p><i>Avantages:</i> Permet la personnalisation et les traductions partielles.<br/>
					<i>Inconv&eacute;nients:</i> Vous devez sp&eacute;cifier les alternatives linguistiques pour chaque page, et les mettre &agrave; jour sir l'alias change.</p>
					<p>Ajouter la balise suivante dans chacun de vos gabarit de page :<br/>
					{content block='Autres langues' oneline='true' assign=other_languages wysiwyg='false'}<br/>
					Un nouveau bloc de contenu &agrave; remplir sera ajout&eacute; lorsque vous modifier la page. Ce bloc sera utilis&eacute; pour d&eacute;finir les &eacute;quivalents linguisitiques dans les autres langues pour cette page, de la mani&egrave;re suivante:<br/>
					\"en_US=page1;fr_FR=page2;de_DE=page3\" (sans les guillemets - l'ordre est sans importance, mais il ne doit pas y avoir d'espace)<br/>
					o&ugrave; page1, page2 et page3 sont respectivement les alias des pages.</p>
					<p>Pour que le module utilise cette m&eacute;thode, assurez-vous que l'option \"Utiliser la hierarchie pour la redirection\" est d&eacute;coch&eacute;e dans l'onglet param&egrave;tres.</p>
				<br/><h4>La m&eacute;thode hi&eacute;rarchique</h4>
					<p><i>Avantages:</i> c'est automatique - vous n'avez rien &agrave; faire.<br/>
					<i>Inconv&eacute;nients:</i> la structure des pages doit &ecirc;tre identique pour chaque langue.</p>
					<p>Cette solution utilise la hi&eacute;rarchie des pages pour savoir quelles pages sont &eacute;quivalentes. Dans l'exemple ci-haut, \"2.3. Page 3\" serait l'&eacute;quivalent fran&ccedil;ais de \"1.3. 3rd page\", parce qu'elle occupe la m&ecirc;me position relative dans la branche fran&ccedil;aise.<br/>
					En d'autres mots, si les pages &eacute;taient ordonn&eacute;es diff&eacute;remment, tout serait m&eacute;lang&eacute;:</p>
					<ul>
						<li>1. English<ul>
							<li>1.1. 1st page</li>
							<li>1.2. 2nd page</li>
							<li>1.3. 3rd page</li>
						</ul></li>
						<li>2. Fran&ccedil;ais<ul>
							<li>2.1. Page 1</li>
							<li>2.2. Page 3</li>
							<li>2.3. Page 2</li>
						</ul></li>
					</ul>
					<p>Ici, \"Page 2\" occupe la troisi&egrave;me position, ainsi elle serait prise pour &eacute;quivalent &agrave; la troisi&egrave;me page (1.3. 3rd page) en anglais.<br/>
					Cela signifie aussi que si toutes les pages n'existent pas dans toutes les langues, vous devez faire attention. Par example:</p>
					<ul>
						<li>1. English<ul>
							<li>1.1. 1st page</li>
							<li>1.2. 2nd page</li>
							<li>1.3. 3rd page</li>
						</ul></li>
						<li>2. Fran&ccedil;ais<ul>
							<li>2.1. Page 2</li>
							<li>2.2. Page 3</li>
						</ul></li>
					</ul>
					<p>Ici, \"1st page\" serait l'&eacute;quivalent de \"Page 2\" et le syst&egrave;me croirait que \"3rd page\" n'a pas de traduction, alors qu'elle en a bien une.</p>
			<br/><h3>Probl&egrave;mes</h3>
				<p>La langue de la page devrait &ecirc;tre d&eacute;tect&eacute;e automatiquement (sur la base d'un &eacute;v&eacute;nement) et assign&eacute;e aux variables smarty avait que le gabarit ne soit trait&eacute;. Il est toutefois possible qu'&agrave; certains endroits dans le gabarit de page (consid&eacute;rant qu'il est trait&eacute; par morceaux) la variable contenu la langue soit perdue. Si vous rencontrez des probl&egrave;mes de ce genre, vous pouvez utiliser la balise {babel action=\"assign\"} pour la r&eacute;assigner.<br/>
				Notez que vous pouvez aussi utiliser {babel action=\"auto_redirect\"} au d&eacute;but de vos gabarit si (je ne vois pas de raison) la redirection ne s'effectue pas automatiquement.</p>
			<br/><h3>Copyright and License</h3>
				<p>Ce module a &eacute;t&eacute; cr&eacute;&eacute; par Pierre-Luc Germain (plger), bas&eacute; sur une approche par Marcos Cruz, et est rendu publique sous la GNU Public License.</p><br/><br/>";


//SETTINGS
$lang["settings"] = "Param&egrave;tres";
$lang["pref_autoredirect_home"] = "Redirection automatique sur les pages selon la langue du navigateur?*<br/>Lorsque l'utilisateur arrive sur une des pages d'accueil, si la langue de son navigateur correspond &agrave; l'une des langues disponibles il sera redirig&eacute; vers cette langue.";
$lang["pref_autoredirect_all"] = "Redirection automatique pour toutes les pages selon la langue du navigateur?*<br/>(comme l'option pr&eacute;c&eacute;dente, mais pour toutes les pages)";
$lang["pref_cookies_autoredirect_home"] = "Redirection automatique selon la langue enregistr&eacute;e dans les cookies pour les pages d'accueil?<br/>Si l'utilisateur arrive sur une des pages d'accueil et a auparavant navigu&eacute; le site dans une autre langue, il sera redirig&eacute; vers cette langue.";
$lang["pref_cookies_autoredirect_all"] = "Redirection automatique selon la langue enregistr&eacute;e dans les cookies pour toutes les pages?<br/>(comme l'option pr&eacute;c&eacute;dente, mais pour toutes les pages)";
$lang["pref_hierarchy_redirect"] = "Utiliser la hi&eacute;rarchie pour la redirection? (voir l'aide pour plus d'information)<br/>Cela implique que la structure des pages doit &ecirc;tre la m&ecirc;me pour chaque langue. Si vous n'utilisez pas cette option, il vous faudra d&eacute;finir les alternatives linguistiques manuellement.";
$lang["pref_default_hide"] = "Cacher le lien dans le menu de langues lorsque la page n'existe pas.<br/>Si le lien de langue pointe vers une page qui n'existe pas, cacher le lien (sinon, le lien pointera vers la page par d&eacute;faut de la langue).";
$lang["pref_default_translate"] = "Utiliser la langue par d&eacute;faut lorsque les entr&eacute;es linguistiques sont vides pour la langue actuelle.";
$lang["pref_hide_missingentries"] = "Cacher les messages d'erreur pour les entr&eacute;es linguistiques inconnues.";
$lang["pref_wysiwyg"] = "Activer le wysiwyg dans les entr&eacute;es linguistiques.";
$lang["pref_use_page_title"] = "Utiliser le titre des pages dans les liens du menu de langues (plut&ocirc;t que le nom de la langue).";
$lang["pref_current_link"] = "Dans le menu de langues, afficher aussi le lien vers la page (la langue) actuelle.";
$lang["help_redirection"] = "*Note: Si vous utilisez la redirection selon la langue du navigateur, assurez-vous d'utiliser aussi la redirection par cookies correspondante, sinon vos utilisateurs seront <b>forc&eacute;s</b> de voir la page dans la langue de leur navigateur.";


//PARAMETERS
$lang["phelp_action"] = "Actions disponibles: \"default\" (pour les traductions) ou \"menu\".";
$lang["phelp_show"] = "Pour l'action menu, sp&eacute;cifie les langues &agrave; afficher (utiliser les codes de langue et s&eacute;parer par des virgules). Pour l'action par d&eacute;faut, sp&eacute;cifie le nom de l'entr&eacute;e linguistique &agrave; afficher.";
$lang["phelp_template"] = "Gabarit &agrave; utiliser pour le menu.";
$lang["phelp_assign"] = "Plut&ocirc;t que d'afficher le r&eacute;sultat imm&eacute;diatement, vous pouvez l'assigner &agrave; la variable sp&eacute;cifi&eacute;e par ce param&egrave;tre.";



?>
