<?php
if(!isset($gCms)) exit;

// Typical Database Initialization
$db = &$this->cms->db;
$dict = NewDataDictionary($db);



	$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_babel_languages");
	$dict->ExecuteSQLArray($sqlarray);
	$db->DropSequence(cms_db_prefix()."module_babel_languages_seq");
	

	$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_babel_langkeys");
	$dict->ExecuteSQLArray($sqlarray);
	$db->DropSequence(cms_db_prefix()."module_babel_langkeys_seq");
	

	$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_babel_langentries");
	$dict->ExecuteSQLArray($sqlarray);
	
	$this->DeleteTemplate("",$this->GetName());

	$this->RemovePermission("admin_babel");
	$this->RemovePreference();

// put mention into the admin log
	$this->Audit( 0, $this->Lang("friendlyname"), $this->Lang("uninstalled"));

?>
