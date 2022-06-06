<?php
if(!isset($gCms))	exit;
if(!$this->CheckPermission("admin_babel")){
	echo '<p>'.$this->Lang("error_denied").'</p>';
	return false;
}
if(isset($params["cancel"]))		$this->Redirect($id, "defaultadmin", $returnid, array());


$wysiwyg = $this->GetPreference("wysiwyg",false);

$db = $this->GetDb();

$entry = isset($params["entrykey"])?$params["entrykey"]:false;
$caption = isset($params["caption"])?$params["caption"]:"";
$values = array();

if($caption != "" && (isset($params["submit"]) || isset($params["apply"]))){
	$caption = preg_replace("/[^a-zA-Z0-9_-\s]/", "", $caption);
	if($entry){
		$query = "DELETE FROM ".cms_db_prefix()."module_babel_langentries WHERE stringid=?";
		$db->Execute($query, array($entry));
	}else{
		$entry = $db->GenID(cms_db_prefix()."module_babel_langentries_seq");
		$query = "INSERT INTO ".cms_db_prefix()."module_babel_langkeys SET stringid=?, caption=?";
		$db->Execute($query, array($entry, $caption));
	}
	$query = "INSERT INTO ".cms_db_prefix()."module_babel_langentries SET stringid=?, langcode=?, value=?";
	foreach($params as $key=>$value){
		if(substr($key,0,6) == "entry_" && $value != ""){
			$values[substr($key,6)] = $value;
			$db->Execute($query, array($entry, substr($key,6), $value));
		}
	}
	if(isset($params["submit"])){
		$this->Redirect($id, "defaultadmin", $returnid, array('module_message'=>$this->Lang("message_modified")));
	}else{
		echo $this->ShowMessage($this->Lang("message_modified"));
	}
	
}elseif($entry){
	$query = "SELECT stringid, caption FROM ".cms_db_prefix()."module_babel_langkeys WHERE stringid=? LIMIT 1";
	$dbresult = $db->Execute($query, array($entry));
	if($dbresult && $row = $dbresult->FetchRow()){
		$entry = $row["stringid"];
		$caption = $row["caption"];
		$query = "SELECT langcode, value FROM ".cms_db_prefix()."module_babel_langentries WHERE stringid=?";
		$dbresult = $db->Execute($query, array($entry));
		while($dbresult && $row = $dbresult->FetchRow()){
			$values[$row["langcode"]] = $row["value"];
		}
	}
}

$languages = $this->getlanguages(true);

$buttons = '<p>'.$this->CreateInputSubmit($id, "submit", lang("submit")).' '.$this->CreateInputSubmit($id, "apply", lang("apply")).' '.$this->CreateInputSubmit($id, "cancel", lang("cancel")).'</p>';

echo "<h1>".$this->Lang("entry")."</h1><br/>";

echo $this->CreateFormStart($id, "editentry", $returnid);

echo $buttons;

if($entry){
	echo '<p>'.$this->Lang("entryname").' : '.$caption.'</p>';
	echo $this->CreateInputHidden($id, "entrykey", $entry);
	echo $this->CreateInputHidden($id, "caption", $caption);
	echo '<p>'.$this->CreateLink($id, 'deleteEntry', $returnid, $this->Lang("delete_entry"), array('entrykey'=>$entry), $this->Lang('prompt_deleteentry')).'</p>';
}else{
	echo '<p>'.$this->Lang("entryname").'* : '.$this->CreateInputText($id, "caption", $returnid, "", 64, 64).'</p>';
}
echo '<table cellspacing="0" class="pagetable">';
foreach($languages as $key=>$onelang){
	echo '
	<tr>
		<td>'.$this->CreateLink($id, "editentries", $returnid, $onelang["name"].' ('.$key.')', array("langcode"=>$key)).'</td>
		<td>'.$this->CreateTextArea($wysiwyg,$id,(isset($values[$key]) && $values[$key])?$values[$key]:"",'entry_'.$key).'</td>
	</tr>';
}
echo '
</tbody>
</table>
';
echo $buttons;
echo $this->CreateFormEnd();

?>


