<?php
if(!isset($gCms))	exit;
if(!$this->CheckPermission("admin_babel")){
	echo '<p>'.$this->Lang("error_denied").'</p>';
	return false;
}
if(isset($params["cancel"]) || !isset($params["langcode"]) || !$this->is_language($params["langcode"], false))		$this->Redirect($id, "defaultadmin", $returnid, array());

$wysiwyg = $this->GetPreference("wysiwyg",false);

$languages = $this->getlanguages(true);
$language = $languages[$params["langcode"]];

$newentry = '<div style="float: right;">'.$this->CreateLink($id, "editentry", $returnid, $gCms->variables["admintheme"]->DisplayImage("icons/system/newobject.gif", "","","","systemicon")." ".$this->Lang("add_entry")).'</div>';
echo $newentry;
echo "<h1>".$language['name']." (".$language['langcode'].")</h1><br/>";

$db = $this->GetDb();
$query = "SELECT langkeys.stringid stringid, langkeys.caption caption, langentries.value FROM ".cms_db_prefix()."module_babel_langkeys langkeys LEFT JOIN ".cms_db_prefix()."module_babel_langentries langentries ON langkeys.stringid = langentries.stringid WHERE langentries.langcode=?";
$dbresult = $db->Execute($query,array($params["langcode"]));
$values = array();
$captions = array();
while($dbresult && $row = $dbresult->FetchRow()){
	$captions[$row["stringid"]] = $row["caption"];
	$values[$row["stringid"]] = $row["value"];
}
	
if(isset($params["submit"]) || isset($params["apply"]))	{
	$query = "DELETE FROM ".cms_db_prefix()."module_babel_langentries WHERE langcode=?";
	$db->Execute($query, array($params["langcode"]));
	$values = array();
	$query = "INSERT INTO ".cms_db_prefix()."module_babel_langentries SET langcode=?, stringid=?, value=?";
	foreach($params as $key=>$value){
		if(substr($key,0,6) == "entry_" && $value != ""){
			$values[substr($key,6)] = $value;
			$db->Execute($query, array($params["langcode"], substr($key,6), $value));
		}
	}
	if(isset($params["submit"])){
		$this->Redirect($id, "defaultadmin", $returnid, array('module_message'=>$this->Lang("message_modified")));
	}else{
		echo $this->ShowMessage($this->Lang("message_modified"));
	}
}	

$buttons = '<p>'.$this->CreateInputSubmit($id, "submit", lang("submit")).' '.$this->CreateInputSubmit($id, "apply", lang("apply")).' '.$this->CreateInputSubmit($id, "cancel", lang("cancel")).'</p>';

echo $this->CreateFormStart($id, "editentries", $returnid);
echo $this->CreateInputHidden($id, "langcode", $params["langcode"]);
if(!$wysiwyg)	echo '
<script type="text/javascript">
function instant_table_search(what){
	var destination = document.getElementById("babel_language_entries");
	if(!destination) return;
	var therows = destination.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
	for(i=0;i<therows.length;i++){
		var thecolumn = therows[i].getElementsByTagName("td")[0].getElementsByTagName("a")[0];
		if(thecolumn && thecolumn.innerHTML.toLowerCase().indexOf(what.toLowerCase()) >= 0){
			therows[i].style.display = "table-row";
		}else{
			therows[i].style.display = "none";
		}
	}
}
</script>
';
echo $buttons;
echo '<table id="babel_language_entries" cellspacing="0" class="pagetable">
';
if(!$wysiwyg) echo '
<thead>
	<tr><th>'.$this->Lang("searchthistable").'<input type="text" onkeyup="instant_table_search(this.value);"/></th><th></th></tr>
</thead>
';
echo '<tbody>
	';
foreach($captions as $key=>$label){
	echo '<tr>
		<td>'.$this->CreateLink($id, "editentry", $returnid, $label, array("entrykey"=>$key)).'</td>
		<td>'.$this->CreateTextArea($wysiwyg,$id,(isset($values[$key]) && $values[$key])?$values[$key]:"",'entry_'.$key).'</td>
	</tr>
	';
}
echo '
</tbody>
</table>
';
echo $buttons;
echo $newentry;
echo $this->CreateFormEnd();

?>
