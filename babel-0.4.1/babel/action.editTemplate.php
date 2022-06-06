<?php
if (!isset($gCms)) exit;

if( isset($params['cancel']) )	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab'=>'templates') );

$tplcontent = '';
if( ( isset($params['submit']) || isset($params['apply']) ) && isset($params['tplname']) ){
	$tplcontent = $params['tplcontent'];
	if($params['tplname'] != ''){
		if(isset($params['isnew']))	$params['tplname'] = munge_string_to_url($params['tplname'], false);
		if($this->SetTemplate($params['tplname'],$params['tplcontent'],$this->GetName()));
		if(isset($params['submit'])){
			$this->Redirect($id, 'defaultadmin', $returnid, array("module_message" => $this->Lang("message_modified"), 'active_tab'=>'templates') );
		}else{
			echo $this->ShowMessage($this->Lang("message_modified"));
		}
	}else{
		echo '<div class="pageerrorcontainer">'.$this->Lang('error_missginvalue').'</div>';
	}
}elseif( isset($params['tplname']) ){
	$tplcontent = $this->GetTemplate( $params['tplname'], $this->GetName() );
}

echo '<h1>'.$this->Lang("edittemplate").'</h1>';
echo '<div style="float: right;">'.$this->Lang("templatehelp").'</div>';
echo $this->CreateFormStart($id, "editTemplate", $returnid);
echo '	<div class="pageoverflow">
		<p class="pagetext">'.$this->Lang('name').' :</p>
		<p class="pageinput">';
if(isset($params['tplname']) && $params['tplname'] != ''){
	echo $params['tplname'].$this->CreateInputHidden($id, "tplname", $params['tplname']);
}else{
	echo $this->CreateInputText($id,'tplname','',30,64);
}
echo '</p>
	</div>
';
echo '	<div class="pageoverflow">
		<p class="pagetext">'.$this->Lang('template').' :</p>
		<p class="pageinput">'.$this->CreateTextArea(false,$id,$tplcontent,'tplcontent').'</p>
	</div>
';
echo '<p>'.$this->CreateInputSubmit($id, "submit", lang("submit")).' '.$this->CreateInputSubmit($id, "apply", lang("apply")).' '.$this->CreateInputSubmit($id, "cancel", lang("cancel")).'</p>';
if(!isset($params["tplname"]) || $params["tplname"] == '')	echo $this->CreateInputHidden($id, "isnew", 1);
echo $this->CreateFormEnd();

?>
