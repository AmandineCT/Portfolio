<?php
if(!isset($gCms)) exit;

$db =& $this->GetDB();
$dict = NewDataDictionary($db);
$taboptarray = array("mysql" => "TYPE=MyISAM");


// Creates the languages table
$flds = "
	langcode C(8) KEY,
	root_id I,
	default_id I,
	name C(64),
	menu_name C(64),
	active L,
	item_order I
	";

$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_babel_languages", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence(cms_db_prefix()."module_babel_languages_seq");
	

// Creates the language keys table
$flds = "
	stringid I KEY,
	caption C(128)
	";

$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_babel_langkeys", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence(cms_db_prefix()."module_babel_langkeys_seq");


// Creates the language entries table
$flds = "
	stringid I,
	langcode C(5),
	value C(255)
	";

$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_babel_langentries", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$this->CreatePermission("admin_babel", "Babel: admin");

$modprefs = $this->get_modprefs();
foreach($modprefs as $onepref)	$this->SetPreference($onepref[0],$onepref[1]);

$deftpl = '<ul id="language_menu">
{foreach from=$languages item="language"}
   {if $language->is_current}<li class="active"><a {if $language->url}href="{$language->url}" {/if}class="active">{else}<li><a href="{$language->url}">{/if}{$language->menu_name}</a></li>
{/foreach}
</ul>';
$this->SetTemplate("default",$deftpl);
$this->SetPreference("defaulttemplate","default");
$this->RegisterEvents();

// put mention into the admin log
$this->Audit( 0, $this->Lang("friendlyname"), $this->Lang("installed",$this->GetVersion()));

