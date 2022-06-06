<?php
$lang["friendlyname"] = "Babel: Multilingual site";
$lang["moddescription"] = "Allows the management of (and navigation through) multiple languages for the frontend.";
$lang["admindescription"] = "Manage frontend languages and multilingual behaviors.";

$lang["active"] = "Active";

$lang["language"] = "Language";
$lang["languages"] = "Languages";
$lang["add_language"] = "Add language";
$lang["add_entry"] = "Add a new language entry";
$lang["entry"] = "Language entry";
$lang["edit_language"] = "Edit language";
$lang["name"] = "Name";
$lang["entryname"] = "Entry name (used to call this language entry)";
$lang["menu_name"] = "Menu name";
$lang["langcode"] = "Language code";
$lang["langcode_prompt"] = "Language code (eg: en_US )";
$lang["root_id"] = "Root page associated with the language";
$lang["default_id"] = "Default page for redirection to this language";
$lang["langselect"] = "(optional) Auto-fill for the following language:";
$lang["isdefault"] = "Default?";
$lang["actions"] = "Actions";
$lang["active"] = "Active";
$lang["prompt_deletelanguage"] = "Really delete this language (%s)?";
$lang["prompt_deleteentry"] = "Really delete this entry?";
$lang["delete_entry"] = "Delete this entry";

$lang["submit"] = "Submit";
$lang["cancel"] = "Cancel";
$lang["apply"] = "Apply";

$lang["edit_entries"] = "Edit language entries";




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
$lang["activate"] = "Activate";
$lang["unactivate"] = "Turn off";
$lang["searchthistable"] = "Search this table for:";
$lang["Yes"] = "Yes";
$lang["No"] = "No";
$lang["Actions"] = "Actions";
$lang["reorder"] = "Reorder";
$lang["listtemplate"] = "List template for";
$lang["templates"] = "Menu templates";
$lang["template"] = "Template";
$lang["defaulttemplate"] = "Default template";
$lang["templatevars"] = "Template variables";
$lang["edittemplate"] = "Edit template";
$lang["addtemplate"] = "Add template";
$lang["filterby"] = "Filter by";
$lang["showall"] = "Show all (no filter)";
$lang["message_deleted"] = "Element deleted";
$lang["message_modified"] = "Modification saved";
$lang["error_missginvalue"] = "One or more necessary values have not been entered.";
$lang["error_alreadyexists"] = "There is already an element bearing that name.";
$lang["error_noparent"] = "No parent is defined!";
$lang["error_notfound"] = "The item could not be found.";
$lang["error_noitemfound"] = "No item found.";
$lang["error_denied"] = "Permission denied";
$lang["givenerror"] = "Error: ";
$lang["prompt_generaldelete"] = "Do you really want to delete this?";
$lang["results"] = "Results";

// MODULE INTERACTION
$lang["postinstall"] = "Module successfully added.";
$lang["postuninstall"] = "Module successfully removed.";
$lang["really_uninstall"] = "All of this module's content will be lost. Continue?";
$lang["uninstalled"] = "Module Uninstalled.";
$lang["installed"] = "Module version %s installed.";
$lang["help"] = "<h3>What Does This Do?</h3>
				<p>This module manages multiples languages for the frontend and navigation through the languages.</p>
			<br/><h3>How Do I Use It?</h3>
				<br/><h4>Tree branches</h4>
					<p>This module uses an approach to multilingual sites called \"separated tree branches\", which has been developped by other cmsms developers (namely Marcos Cruz - see <a href=\"http://forum.cmsmadesimple.org/index.php/topic,19099.msg94749.html#msg94749\" target=\"_blank\">this topic</a>).</p><br/>
					<p>Should you need to use it in your templates, the current language code will be stored in the $"."page_lang variable. More information on the language can also be retrieved using the $"."page_lang_info object (with the same attributes as in the menu templates).</p>
				<h4>Part 1: setting up the pages</h4>			
					<p>To use this, you will have to create different root pages for each language. For example:</p>
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
					<p>Root language pages (1. and 2.) should be section headers. You can name them (alias and all) any way you want.</p>
					<p>In order to display menu correctly (that is, not to display language header pages and pages belonging to other languages), all you have to do is add the start_level=\"2\" to your menu tags:<br/>
					{menu start_level=\"2\"}</p>
				<br/><h4>Part 2: setting up the languages</h4>
					<p>Next, go to Extensions-&gt;Babel: Multilingual site. For each language, click Add Language and enter the appropriate informations. The \"Root page\" should be the section headers you've created for each language (1.English, 2.Fran&ccedil;ais). The \"Default page\" should be the home page for each language. As of the language code, you could use any 5 characters code, but in order to provide good compatibility with the modules, you should use the same as the cms (you may use the drop down list on the top right to partially fill the form).</p>
					<p>( *When ready, make sur you activate each language... )</p>
				<br/><h4>Part 3: Language menu</h4>
					<p>To get a language menu, you may use the following tag:<br/>
					{babel action=\"menu\"}<br/>
					or, to use a template other than the default one:<br/>
					{babel action=\"menu\" template=\"template_name\"}</p>
					<p>The \"show\" parameter can be used to choose which languages should be displayed.</p>
				<br/><h4>Part 4 (optional) : Custom language entries</h4>
					<p>In modules, global content blocks or whatsoever, you will need to change the content depending on the language. The traditional way to do this was to create conditions with the page_lang variable:<br/>
					{if $"."page_lang == \"en_US\"}English text{elseif $"."page_lang == \"fr_FR\"}Texte en fran&ccedil;ais{/if}</p>
					<p>Will you can still use this method with the module, another more centralized way is provided. In the admin panel of this module, you will find for each language a link to edit the language entries. Language entries are strings that exist for each language but hold different text (or html). What you can do is to create a new language entry (for example: \"welcome text\", enter its content for all languages, and simply call the entry wherever you need it using the default action:<br/>
					{babel show=\"welcome text\"}<br/>
					Should you ever need to edit the strings and add languages, you will find this solution to be more handy. But if you prefer the old one, it will work just as much.</p>
					<p>You can also assign language entries to smarty variables, using: <br/>
					{babel show=\"welcome text\" assign=\"welcome\"}<br/>
					or, if you want to assign multiple entries, seperate them by commas:<br/>
					{babel show=\"entry1,entry2,entry3\" assign=\"var1,var2,var3\"}</p>
			<br/><h3>Language redirection methods</h3>	
				<p>There are two possible methods to tell the cms which page is the equivalent in another language of a given page. By default, the hirerarchy solution is activated, but you can change that in the settings tab.</p>
				<br/><h4>Marcos Cruz's definition solution</h4>
					<p><i>Pros:</i> allows thight customization and partial translation.<br/>
					<i>Cons:</i> need to specify language alternatives for each page, and to update it if an alias changes.</p>
					<p>Add the following tag in each of your page templates :<br/>
					{content block='Other languages' oneline='true' assign=other_languages wysiwyg='false'}<br/>
					This will add a content block to be filled when you edit the page. We will use this block to define the equivalents in other languages for this page, by filling it in the following way:<br/>
					\"en_US=page1;fr_FR=page2;de_DE=page3\" (without the quotes - the order does not matter, but no spaces are allowed)<br/>
					where page1, page2 and page3 are the page aliases.</p>
					<p>To make sure the modules uses this method, make sure to untick the \"Use hierarchy for redirection\" option in the settings tab.</p>
				<br/><h4>The hierarchy solution</h4>
					<p><i>Pros:</i> it's automatic - you don't have to do anything.<br/>
					<i>Cons:</i> the page structure must be identical for each language.</p>
					<p>This solution uses the page hierarchy to know which pages are equivalent. In our example above, \"2.3. Page 3\" would be the french equivalent of \"1.3. 3rd page\", because it occupies the equivalent position in the french branch.<br/>
					In other words, should the page be ordered differently, all would be messed up:</p>
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
					<p>Here, \"Page 2\" occupies the third position, so it would be deemed equivalent to the 3rd page in english.<br/>
					This also means that if all pages do not exist in all languages, you have to be careful. For example:</p>
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
					<p>Here, \"1st page\" would be taken to be equivalent to \"Page 2\" and \"3rd page\" would be deemed to have no traduction, although it does.</p>
			<br/><h3>Troubleshooting</h3>
				<p>Page language should be detected and assigned to the smarty variables before the template is processed by an event handler. However, it is possible that at some point in the page template the page language is lost (especially since the page head is processed separatly from the page body). Should it happend, you can use the tag {babel action=\"assign\"} to reassign it.<br/>
				Note that you may also use {babel action=\"auto_redirect\" at the beginning of your template if, for some reason, redirection does not occur (I don't see why this should happen though).</p>
			<br/><h3>Copyright and License</h3>
				<p>This module has been created by Pierre-Luc Germain (plger), based on an approach by Marcos Cruz, and is released under the GNU Public License.</p><br/><br/>";


//SETTINGS
$lang["settings"] = "Settings";
$lang["pref_autoredirect_home"] = "Auto-redirect on home page based on request (browser) language?*<br/>When the user gets on a home page (a page defined as default page for a language), if his browser language is different from the page language he will be redirected to the appropriate page.";
$lang["pref_autoredirect_all"] = "Auto-redirect on all pages based on request language?*<br/>(same as above, but for all pages)";
$lang["pref_cookies_autoredirect_home"] = "Auto-redirect on home page based on language stored in cookies?<br/>If the user has previously navigated the site in a selected language before, he will be fowarded to this language upon visiting any home page (any page that has been set as default page for a language).";
$lang["pref_cookies_autoredirect_all"] = "Auto-redirect on all pages based on cookies?<br/>(same as above, but for all pages)";
$lang["pref_hierarchy_redirect"] = "Use hierarchy for redirection? (see help for more info)<br/>This means that the page structure must be exactly the same for all languages. If you don't use the hierarchy, you will have to specify the pages manually.";
$lang["pref_default_hide"] = "Hide menu link when the according page does not exist?<br/>If the language link should lead to a page that does not exist, hide the link (otherwise, the link will lead to the language's default page).";
$lang["pref_default_translate"] = "Use default language where language-specific entries haven't been supplied.";
$lang["pref_hide_missingentries"] = "Hide error message for unknown language entries.";
$lang["pref_wysiwyg"] = "Enable wysiwyg in language entries.";
$lang["pref_use_page_title"] = "Use page title in language links (instead of language name).";
$lang["pref_current_link"] = "In the language menu, show link for current page (that is, current language) too.";
$lang["help_redirection"] = "*Note: If you use redirection based on request (browser) language, make sure to activate the corresponding cookie redirection, otherwise the users will be <b>forced</b> to view the page in their browser language.";


//PARAMETERS
$lang["phelp_action"] = "Possible actions: \"default\" (for translations) or \"menu\".";
$lang["phelp_show"] = "For the menu action, this parameter specifies which languages to show in the menu (use language code and separate with a comma). For the default action, this holds the key to the string to be translated.";
$lang["phelp_template"] = "Template to use for the menu.";
$lang["phelp_assign"] = "Instead of displaying the result immediately, you can assign it to a smarty variable specified with the \"assign\" parameter.";



?>
