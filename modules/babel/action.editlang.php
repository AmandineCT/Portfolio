<?php
if(!isset($gCms))	exit;
if(!$this->CheckPermission("admin_babel")){
	echo '<p>'.$this->Lang("error_denied").'</p>';
	return false;
}
if(isset($params["cancel"]))	$this->Redirect($id, "defaultadmin", $returnid, array());

$admintheme = $gCms->variables["admintheme"];

$is_new = isset($params["is_new"])?$params["is_new"]:0;

$db =& $this->GetDb();


// CHECK IF THE FORM IS BEING SUBMITTED :
if (isset($params["submit"]) || isset($params["apply"]) )	{

	// RETRIEVING THE FORM VALUES
	if(!isset($item)) $item = new stdClass();
	$item->langcode = $this->plcreatealias((isset($params["langcode"])?$params["langcode"]:""));
	$item->root_id = isset($params["root_id"])?$params["root_id"]:false;
	$item->default_id = isset($params["default_id"])?$params["default_id"]:"";
	$item->name = isset($params["name"])?$params["name"]:"";
	$item->menu_name = isset($params["menu_name"])?$params["menu_name"]:"";
	
	if(!$item->root_id || $item->langcode == "" || $item->name == ""){
		echo $this->ShowErrors($this->Lang("error_missginvalue"));
	}else{
		############ DOING THE UPDATE


		// FIELDS TO UPDATE
		$query = ($is_new?"INSERT INTO ":"UPDATE ").cms_db_prefix()."module_babel_languages SET 
			root_id=?,
			default_id=?,
			name=?,
			menu_name=?";
			
		// VALUES
		$values = array($item->root_id, $item->default_id, $item->name, $item->menu_name, $item->langcode);

		if($is_new){
			// NEW ITEM
			$new_order = $this->countsomething("languages","langcode") + 1;
			$query .= ", langcode=?, item_order=?, active=0";
			array_push($values,$new_order);
		}else{
			// EXISTING ITEM
			$query .= " WHERE langcode=? LIMIT 1";
		}
		$db->Execute($query, $values);

		if(mysql_error()){
			echo $this->ShowErrors(mysql_error());
			echo $this->ShowMessage($this->Lang("error_couldnotinsert"));
		}else{
			$is_new = false;
			if(isset($params["apply"])){
				echo $this->ShowMessage($this->Lang("message_modified"));
			}else{
				$this->Redirect($id, "defaultadmin", $returnid, array("module_message" => $this->Lang("message_modified")));	
			}
		}
	}
	// END OF FORM SUBMISSION
}elseif(isset($params["langcode"])){
	$item = $this->get_language_details($params["langcode"]);
}

/* ## PREPARING SMARTY ELEMENTS */
$hidden = "";

// prepare root pages combo
$languages = $this->getlanguages();
$languages_rootids = array();
$languages_codes = array();
foreach($languages as $onelang){
	$languages_rootids[] = $onelang["root_id"];
	$languages_codes[] = $onelang["langcode"];
}
$dbresult = $db->Execute("SELECT content_id, content_name FROM `".cms_db_prefix()."content` WHERE parent_id < 1");
$options = array();
while($dbresult && $row = $dbresult->FetchRow()){
	if(!in_array($row["content_id"], $languages_rootids) || (isset($item->root_id) && $row["content_id"] == $item->root_id))	$options[$row["content_name"]] = $row["content_id"];
}
$this->smarty->assign("root_id_input", $this->CreateInputDropdown($id,"root_id",$options,-1,isset($item)?$item->root_id:0));

// prepare default pages combo
$cntoperations = $gCms->getContentOperations();
$this->smarty->assign("default_id_input", $cntoperations->CreateHierarchyDropdown("",isset($item->default_id)?$item->default_id:"-1",$id."default_id"));

if($is_new){
	if(function_exists('get_language_list')){
		$langlist = get_language_list();
	}else{
		// older cmsms
		global $nls;
		$langlist = $nls["language"];
	}
	$possiblelangs = array("-"=>"/");
	asort($langlist);
	foreach ($langlist as $key=>$val) {
		$lname = explode('(', $val);
		if(count($lname) == 1){
			$lname = $val;
		}else{
			$lname = trim(trim($lname[1],')'));
		}
		if(!in_array($key,$languages_codes))	$possiblelangs[$key." / ".$val] = $key.'/'.$lname;
	}
	$langselect = $this->CreateInputDropdown($id,"langselect",$possiblelangs);
	$langcode_input = $this->CreateInputHidden($id, "is_new", 1).$this->CreateInputText($id,"langcode","",15,8);
}else{
	$langcode_input = $this->CreateInputHidden($id, "is_new", 0).$this->CreateInputHidden($id, "langcode", $item->langcode).$item->langcode;
	$langselect = false;
}
$this->smarty->assign("langselect", $langselect);
$this->smarty->assign("langcode_input", $langcode_input);

$this->smarty->assign("name_input", $this->CreateInputText($id,"name",isset($item)?$item->name:"",50,64));
$this->smarty->assign("menu_name_input", $this->CreateInputText($id,"menu_name",isset($item)?$item->menu_name:"",50,64));

// preparing labels
$this->smarty->assign("name_label", $this->Lang("name"));
$this->smarty->assign("menu_name_label", $this->Lang("menu_name"));
$this->smarty->assign("root_id_label", $this->Lang("root_id"));
$this->smarty->assign("default_id_label", $this->Lang("default_id"));
$this->smarty->assign("langcode_label", $this->Lang("langcode_prompt"));
$this->smarty->assign("langselect_label", $this->Lang("langselect"));
$this->smarty->assign("plid", $id);

$this->smarty->assign("edittitle", $is_new?$this->Lang("add_language"):$this->Lang("edit_language"));

$this->smarty->assign("submit", $this->CreateInputSubmit($id, "submit", lang("submit")));
$this->smarty->assign("apply", (isset($item) && isset($item->id))?$this->CreateInputSubmit($id, "apply", lang("apply")):"");
$this->smarty->assign("cancel", $this->CreateInputSubmit($id, "cancel", lang("cancel")));


// DISPLAYING
echo $this->CreateFormStart($id, "editlang", $returnid);
echo $this->ProcessTemplate("editlang.tpl");
echo $this->CreateFormEnd();

?>
