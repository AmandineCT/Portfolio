<?php
if (!isset($gCms)) exit;
if(!$this->CheckPermission("admin_babel")) {	echo $this->ShowErrors("Permission denied."); return false; }

$admintheme = $gCms->variables["admintheme"];
$active_tab = isset($params["active_tab"])?$params["active_tab"]:"languages";

echo $this->StartTabHeaders();
	echo $this->SetTabHeader("languages", $this->Lang("languages"), "languages" == $active_tab ? true : false);
	echo $this->SetTabHeader("templates", $this->Lang("templates"), "templates" == $active_tab ? true : false);
	echo $this->SetTabHeader("settings", $this->Lang("settings"), "settings" == $active_tab ? true : false);
echo $this->EndTabHeaders();

echo $this->StartTabContent();

	echo $this->StartTab("languages");

		$this->smarty->assign("addnew", $this->CreateLink($id, "editlang", $returnid, $admintheme->DisplayImage("icons/system/newobject.gif", "","","","systemicon")." ".$this->Lang("add_language"),array("is_new"=>1)));
		
		$itemlist = $this->admin_retrieve_languages($id, $returnid);
		$this->smarty->assign("itemlist", $itemlist);

		$adminshow = array(
			array($this->Lang("langcode"),"codelink"),
			array($this->Lang("name"),"namelink"),
			array($this->Lang("active"),"toggleactive"),
			array($this->Lang("isdefault"),"toggledefault"),
			array($this->Lang("reorder"),"movelinks"),
			array($this->Lang("actions"),"actions")		
			);
		$this->smarty->assign("adminshow", $adminshow);
		echo $this->ProcessTemplate("adminpanel.tpl");

	echo $this->EndTab();


	echo $this->StartTab("templates");
	
		if(isset($params["defaulttemplate"]))	$this->SetPreference("defaulttemplate",$params["defaulttemplate"]);
		echo "<fieldset style=\"width: 600px;\"><legend><b>".$this->Lang("defaulttemplate")."</b></legend>";
		echo $this->CreateFormStart($id, "defaultadmin", $returnid);
		echo $this->CreateInputHidden($id, "active_tab", "templates");
		$templatelist = $this->ListTemplates($this->GetName());
		$deftpl = $this->GetPreference("defaulttemplate");
		$tploptions = array();
		$itemlist = array();
		foreach($templatelist as $onetpl){
		   $tploptions[$onetpl] = $onetpl;
		   $tpl = new stdClass();
		   $tpl->editlink = $this->CreateLink( $id, "editTemplate", $returnid, $onetpl, array("tplname"=>$onetpl) );
		   $tpl->deletelink = ($onetpl == $deftpl)?"":$this->CreateLink( $id, "deletetpl", $returnid, $admintheme->DisplayImage("icons/system/delete.gif", $this->Lang("delete"), "", "", "systemicon"), array("tplname"=>$onetpl) );
		   array_push($itemlist, $tpl);
		}
		echo '<div class="pageoverflow"><p class="pageinput">'.$this->CreateInputDropdown($id,"defaulttemplate",$tploptions,-1,$deftpl)."<br/>".$this->CreateInputSubmit($id, "submit", lang("submit")).'</p></div>
		';
		echo $this->CreateFormEnd();
		echo "</fieldset><br/><br/>";
		
		$this->smarty->assign("itemlist", $itemlist);
		$this->smarty->assign("addnew", $this->CreateLink($id, "editTemplate", $returnid, $admintheme->DisplayImage("icons/system/newobject.gif", "","","","systemicon")." ".$this->Lang("addtemplate")));
		$adminshow = array(	array($this->Lang("template"), "editlink"), array($this->Lang("actions"), "deletelink")	);
		$this->smarty->assign("adminshow", $adminshow);
		echo $this->ProcessTemplate("adminpanel.tpl");
		
	echo $this->EndTab();


	echo $this->StartTab("settings");

		echo $this->CreateFormStart($id, "changesettings", $returnid);

		$modprefs = $this->get_modprefs();
		foreach($modprefs as $onepref){
			$thepref = $onepref[0];
			echo '
	<div class="pageoverflow">
		<p class="pagetext">'.$this->CreateInputCheckbox($id, $thepref, true, $this->GetPreference($thepref,false))." ".$this->Lang("pref_".$thepref).'</p>
	</div>';
		}
		echo "<br/><p>".$this->CreateInputSubmit($id, "submit", lang("submit"))."</p>";
		echo $this->CreateFormEnd();
	echo $this->EndTab();

echo $this->EndTabContent();

?>
