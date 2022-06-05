<?php
if (!isset($gCms)) exit;

$newparams = isset($params["levelname"])?array("active_tab"=>$params["levelname"]):array();

if (!isset($params["move"]) || !isset($params["langcode"]) || !isset($params["currentorder"]) )
$this->Redirect($id, "defaultadmin", $returnid, $newparams);

$db =& $this->GetDb();
$dbtable = cms_db_prefix()."module_babel_languages";
$currentorder = $params["currentorder"];
$langcode = $params["langcode"];

switch($params["move"]){
	
	case "delete":
		$query = "DELETE FROM ".cms_db_prefix()."module_langentries WHERE langcode=?";
		$db->Execute($query, array($langcode));
		$query = "DELETE FROM $dbtable WHERE langcode = ? LIMIT 1";
		$db->Execute($query, array($langcode));

		// UPDATE THE ORDER OF THE ITEMS
		$query = "UPDATE $dbtable SET item_order=(item_order-1) WHERE item_order > ? ";
		$db->Execute($query, array($currentorder));
		
		$newparams["module_message"] = $this->lang("message_deleted");
		break;	

	case "up":
		if ($currentorder != 1){
			$query = "UPDATE $dbtable SET item_order=(item_order+1) WHERE item_order = ? LIMIT 1;";
			$db->Execute($query, array($currentorder-1));
			$query = "UPDATE $dbtable SET item_order=(item_order-1) WHERE langcode = ? LIMIT 1;";
			$db->Execute($query, array($langcode));
		}
		break;
		
	case "down":
		$query = "UPDATE $dbtable SET item_order=(item_order-1) WHERE item_order = ? LIMIT 1;";
		if( $db->Execute($query, array($currentorder+1)) ){
			$query = "UPDATE $dbtable SET item_order=(item_order+1) WHERE langcode = ? LIMIT 1;";
			$db->Execute($query, array($langcode));
		}
		break;
}

$this->Redirect($id, "defaultadmin", $returnid);
?>
