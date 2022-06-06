<?php
if (!isset($gCms)) exit;
if(!$this->current_langcode)	$this->assign_page_lang();
if(!$this->current_langcode)	return false;	// no page lang assigned... maybe we aren't in a page that has a particular language?
$current_language = $this->current_langcode;

$shown = (isset($params["show"]) && $params["show"] != "")?explode(",",$params["show"]):false;

$use_cookies = $this->GetPreference("cookies_autoredirect_all", false) || $this->GetPreference("cookies_autoredirect_home",false);
$default_hide = $this->GetPreference("default_hide", false);
$use_page_title = $this->GetPreference("use_page_title",false);

$languages = $this->getlanguages();

$links = $this->get_urls();

$itemlist = array();
$show_current = $this->GetPreference("current_link",false);

foreach($languages as $language){
	if((!$shown || in_array($language->langcode, $shown)) && ($show_current || $language['langcode'] != $current_language)){
		$item = new StdClass();
		$item->code = $language['langcode'];
		$item->name = $language['name'];
		$item->menu_name = $language['menu_name'];
		$item->is_current = ($language['langcode'] == $current_language);
		$item->page_menu_text = isset($links[$item->code])?$links[$item->code]['menu_text']:"";
		$item->page_name = isset($links[$item->code])?$links[$item->code]['name']:"";
		$item->url = (isset($links[$item->code]) && $links[$item->code])?$links[$item->code]['url'].$gCms->config['page_extension']:false;
		if($item->url && $use_cookies)		$item->url = $gCms->config['root_url'].'/modules/babel/redirect.php?newlang='.$item->code.'&amp;newurl='.$item->url;

		if($item->url || !$default_hide || $item->is_current)	array_push($itemlist, $item);
	}
}
$this->smarty->assign("languages", $itemlist);

if (isset($params["template"]) && ($template = $this->GetTemplate($params["template"]))){
	echo $this->ProcessTemplateFromData($template);
}else{
	$template = $this->GetPreference("defaulttemplate","default");
	if($template)	echo $this->ProcessTemplateFromDatabase($template);	
}

