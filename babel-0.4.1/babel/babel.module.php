<?php
#-------------------------------------------------------------------------
# Module: Babel: Multilingual site
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project"s homepage is: http://www.cmsmadesimple.org
#
# This module was created with CTLModuleMaker 1.8.8.2
# CTLModuleMaker was created by Pierre-Luc Germain and is released under GNU
# http://dev.cmsmadesimple.org/projects/ctlmodulemaker
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

class babel extends CMSModule
{
	var $available_languages = false;
	var $all_languages = false;
	var $current_language = false;
	var $current_langcode = false;
	var $current_langentries = false;

	function GetName()
	{
		return "babel";
	}

	/*---------------------------------------------------------
	   GetFriendlyName()
	   This can return any string, preferably a localized name
	   of the module. This is the name that"s shown in the
	   Admin Menus and section pages (if the module has an admin
	   component).
	   
	   See the note on localization at the top of this file.
	  ---------------------------------------------------------*/
	function GetFriendlyName()
	{
		return $this->Lang("friendlyname");
	}
	
	/*---------------------------------------------------------
	   GetVersion()
	   This can return any string, preferably a number or
	   something that makes sense for designating a version.
	   The CMS will use this to identify whether or not
	   the installed version of the module is current, and
	   the module will use it to figure out how to upgrade
	   itself if requested.	   
	  ---------------------------------------------------------*/
	function GetVersion()
	{
		return "0.4.1";
	}


	/*---------------------------------------------------------
	   GetDependencies()
	   Your module may need another module to already be installed
	   before you can install it.
	   This method returns a list of those dependencies and
	   minimum version numbers that this module requires.
	   
	   It should return an hash, eg.
	   return array("somemodule"=>"1.0", "othermodule"=>"1.1");
	  ---------------------------------------------------------*/
	function GetDependencies()
	{
		return array();
	}

	/*---------------------------------------------------------
	   GetHelp()
	   This returns HTML information on the module.
	   Typically, you"ll want to include information on how to
	   use the module.
	   
	   See the note on localization at the top of this file.
	  ---------------------------------------------------------*/
	function GetHelp()
	{
		return $this->Lang("help");
	}

	/*---------------------------------------------------------
	   GetAuthor()
	   This returns a string that is presented in the Module
	   Admin if you click on the "About" link.
	  ---------------------------------------------------------*/
	function GetAuthor()
	{
		return "Pierre-Luc Germain (plger)";
	}


	/*---------------------------------------------------------
	   GetAuthorEmail()
	   This returns a string that is presented in the Module
	   Admin if you click on the "About" link. It helps users
	   of your module get in touch with you to send bug reports,
	   questions, cases of beer, and/or large sums of money.
	  ---------------------------------------------------------*/
	function GetAuthorEmail()
	{
		return "";
	}

    function GetChangeLog()
    {
		$filepath = dirname(__FILE__).DIRECTORY_SEPARATOR."changelog.txt";
		if(file_exists($filepath)){
			$fhandle = fopen($filepath, 'r+');
			$content = fread($fhandle, filesize($filepath));
			return '<br/><pre>'.$content.'</pre>';
		}else{
			return "";
		}
    }

	/*---------------------------------------------------------
	   IsPluginModule()
	   This function returns true or false, depending upon
	   whether users can include the module in a page or
	   template using a smarty tag of the form
	   {cms_module module="Prod" param1=val param2=val...}
	   
	   If your module does not get included in pages or
	   templates, return "false" here.
	  ---------------------------------------------------------*/
	function IsPluginModule()
	{
		return true;
	}


	/*---------------------------------------------------------
	   HasAdmin()
	   This function returns a boolean value, depending on
	   whether your module adds anything to the Admin area of
	   the site. For the rest of these comments, I"ll be calling
	   the admin part of your module the "Admin Panel" for
	   want of a better term.
	  ---------------------------------------------------------*/
	function HasAdmin() {	return true;	}
	function GetAdminSection() {return "extensions";}
	function GetAdminDescription() {return $this->Lang("admindescription");}

	function VisibleToAdminUser(){
		return $this->CheckPermission("admin_babel");
	}
		
	/*---------------------------------------------------------
	   SetParameters()
	   This function enables you to create mappings for
	   your module when using "Pretty Urls".
	   
	   Typically, modules create internal links that have
	   big ugly strings along the lines of:
	   index.php?mact=ModName,cntnt01,actionName,0&cntnt01param1=1&cntnt01param2=2&cntnt01returnid=3
	   
	   You might prefer these to look like:
	   /ModuleFunction/2/3
	   
	   To do this, you have to register routes and map
	   your parameters in a way that the API will be able
	   to understand.

	   Also note that any calls to CreateLink will need to
	   be updated to pass the pretty url parameter.
	   
	   Since the Skeleton doesn"t really create any links,
	   the section below is commented out, but you can
	   use it to figure out pretty urls.
	   
	   ---------------------------------------------------------*/
	function SetParameters()
	{
		$this->RegisterModulePlugin();
		$this->RegisterEvents();
		$this->RestrictUnknownParams();
		
		$this->CreateParameter("action", "default", $this->Lang("phelp_action"));
		$this->CreateParameter("show", "", $this->Lang("phelp_show"));
		$this->SetParameterType("show",CLEAN_STRING);
		$this->CreateParameter("template", "", $this->Lang("phelp_template"));
		$this->SetParameterType("template",CLEAN_STRING);
		$this->CreateParameter("assign", "", $this->Lang("phelp_assign"));
		$this->SetParameterType("assign",CLEAN_STRING);
		$this->SetParameterType("newlang",CLEAN_STRING);
		$this->SetParameterType("newurl",CLEAN_STRING);
	}
	
	function HandlesEvents(){
		return true;
	}
	function RegisterEvents(){
		$this->AddEventHandler( 'Core', 'ContentPreCompile', false );
	}
	function DoEvent($originator, $eventname, &$params){
		if($eventname == 'ContentPreCompile'){
			$this->assign_page_lang();
			$this->auto_redirect();
		}
	}
	function InstallPostMessage()
	{
		return $this->Lang("postinstall");
	}
	function UninstallPostMessage()
	{
		return $this->Lang("postuninstall");
	}
	function UninstallPreMessage()
	{
		return $this->Lang("really_uninstall");
	}


	/*---------------------------------------------------------
	   Install()
	   When your module is installed, you may need to do some
	   setup. Typical things that happen here are the creation
	   and prepopulation of database tables, database sequences,
	   permissions, preferences, etc.
	   	   
	   For information on the creation of database tables,
	   check out the ADODB Data Dictionary page at
	   http://phplens.com/lens/adodb/docs-datadict.htm
	   
	   This function can return a string in case of any error,
	   and CMS will not consider the module installed.
	   Successful installs should return FALSE or nothing at all.
	  ---------------------------------------------------------*/
	function Install()
	{
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		require "method.install.php";
	}

	/*---------------------------------------------------------
	   Uninstall()
	   Sometimes, an exceptionally unenlightened or ignorant
	   admin will wish to uninstall your module. While it
	   would be best to lay into these idiots with a cluestick,
	   we will do the magnanimous thing and remove the module
	   and clean up the database, permissions, and preferences
	   that are specific to it.
	   This is the method where we do this.
	  ---------------------------------------------------------*/
	function Uninstall()
	{
		global $gCms;
		require "method.uninstall.php";
	}


/* ---------------------------------------------
NOT PART OF THE NORMAL MODULE API
----------------------------------------------*/


	function get_modprefs(){
		// array('preference_name',value_on_install);
		return array(
				array('autoredirect_home',true),
				array('autoredirect_all',false),		
				array('cookies_autoredirect_home',true),
				array('cookies_autoredirect_all',false),
				array('hierarchy_redirect',true),
				array('current_link',false),
				array('default_hide',true),
				array('default_translate',true),
				array('hide_missingentries',false),
				array('wysiwyg',false)
				);
	}

	function plcreatealias($name){
		// filter keys for language entries
		// as a suggestion from AMT, the first part deals with smart quotes
 		$search = array(chr(0xe2) . chr(0x80) . chr(0x98),
						  chr(0xe2) . chr(0x80) . chr(0x99),
						  chr(0xe2) . chr(0x80) . chr(0x9c),
						  chr(0xe2) . chr(0x80) . chr(0x9d),
						  chr(0xe2) . chr(0x80) . chr(0x93),
						  chr(0xe2) . chr(0x80) . chr(0x94));
 		$name = str_replace($search, "", $name);
 		// the second part uses the cms version
 		$alias = munge_string_to_url($name, false);
 		return $alias;
	} 

	function DoAction($action, $id, $params, $returnid=-1){
		if(function_exists('cmsms')){
			$gCms = cmsms();
		}else{
			global $gCms;
		}
		
		switch($action){
			case "auto_redirect":
				if(!$this->current_langcode)	$this->assign_page_lang();
				$this->auto_redirect();
			case "assign":
				if($this->current_langcode){
					global $smarty;
					$smarty->assign('page_lang',$this->current_langcode);
					$smarty->assign('page_lang_info',$this->current_language);
				}else{
					$this->assign_page_lang();
				}
				break;
			case "sitemap":
				if(!$this->current_language) return false;
				$hierManager = $gCms->GetHierarchyManager();
				$hierarchy = $hierManager->getNodeById($this->current_language['root_id']);

				if ($hierarchy && $hierarchy->hasChildren()){
					echo '<ul class="sitemap">';
					$pagelist = array();
					foreach ($hierarchy->getChildren() as $node)	$this->echo_line($node);
					echo '</ul>';
				}	
				break;		
			case "defaultadmin":
				require "action.defaultadmin.php";
				break;
			case "menu":
				require "action.menu.php";
				break;
			case "movesomething":
				require "action.movesomething.php";
				break;
			case "editlang":
				require "action.editlang.php";
				break;
			case "editentries":
				require "action.editentries.php";
				break;
			case "editentry":
				require "action.editentry.php";
				break;
			case "editTemplate":
				require "action.editTemplate.php";
				break;
			case "deleteEntry":
				if(!$this->CheckPermission("admin_babel"))	return false;
				$entry = (isset($params['entrykey']) && $params['entrykey'] != '')?$params['entrykey']:false;
				if($entry){
					$db = $this->GetDb();
					$query = "DELETE FROM ".cms_db_prefix()."module_babel_langentries WHERE stringid=?";
					$db->Execute($query, array($entry));
					$query = "DELETE FROM ".cms_db_prefix()."module_babel_langkeys WHERE stringid=?";
					$db->Execute($query, array($entry));					
					$this->Redirect($id, 'defaultadmin', $returnid, array('module_message'=>$this->Lang('message_deleted')));
				}else{
					$this->Redirect($id, 'defaultadmin', $returnid);
				}
				break;
			case "toggleactive":
				if(isset($params["langcode"])){
					$newval = isset($params["newval"])?$params["newval"]:0;
					$db = $this->GetDb();
					$query = "UPDATE ".cms_db_prefix()."module_babel_languages SET active=? WHERE langcode=? LIMIT 1";
					$db->Execute($query, array($newval,$params["langcode"]));
				}
				$this->Redirect($id, "defaultadmin", $returnid);
				break;
			case "toggledefault":
				if(isset($params["langcode"]))	$this->SetPreference("default_language",$params["langcode"]);
				$this->Redirect($id, "defaultadmin", $returnid);
				break;
			case "changesettings":
				$modprefs = $this->get_modprefs();
				foreach($modprefs as $pref)	$this->SetPreference($pref[0], isset($params[$pref[0]]));
				$this->Redirect($id, "defaultadmin", $returnid, array("active_tab"=>"settings", "module_message"=>$this->Lang("message_modified")));
				break;
			case "deletetpl":
				$newparams = array("active_tab"=>"templates");
			    if(isset($params["tplname"]) && $this->DeleteTemplate($params["tplname"]))	   $newparams["module_message>"] = $this->Lang("message_modified");
				$this->Redirect($id, "defaultadmin", $returnid, $newparams);
				break;

			case "default":
			default:
				if(isset($params["show"])){
					$output = $this->retrieve_translation($params["show"]);
					if(!is_array($output))	$output = array($output);
					if(isset($params["assign"]) && $params["assign"] != ""){
						$keys = explode(',',$params["assign"]);
						if(count($keys) != count($output)){
							echo '
-- Babel failed to assign: var count does not match --
';
						}else{
							$smarty =& $gCms->GetSmarty();
							$i = 0;
							while(isset($output[$i])){
								$smarty->assign($keys[$i],$output[$i]);
								$i++;
							}
						}
					}else{
						echo implode($output);
					}
				}
				break;
		}

	}
	
	function countsomething($tablename,$what="id",$where=array()){
		// returns the number of elements in a table
		$db =& $this->GetDb();
		$wherestring = "";
		$wherevalues = array();
		foreach($where as $key=>$value){
			$wherestring .= ($wherestring == ""?" WHERE ":" AND ").$key."=?";
			$wherevalues[] = $value;
		}
		$query = "SELECT COUNT($what) ourcount FROM ".cms_db_prefix()."module_babel_$tablename".$wherestring;
		$dbresult = $db->Execute($query,$wherevalues);
		if ($dbresult && $row = $dbresult->FetchRow()){
			return $row["ourcount"];
		}else{
			return 0;
		}
	}	
	
	function getFileContent($filename){
		$filepath = dirname(__FILE__).DIRECTORY_SEPARATOR.$filename;
		if(file_exists($filepath)){
			$fhandle = fopen($filepath, "r+");
			$content = fread($fhandle, filesize($filepath));
			return $content;
		}else{
			return false;
		}
	}
	
	function retrieve_page_lang(){
		// retrieve root id
		if(!$this->available_languages)	$this->retrieve_languages();
		if(!$this->available_languages)	return false;
		foreach($this->available_languages as $onelang){
			if($onelang["root_id"] == $root_id){
				$this->current_langcode = $onelang["langcode"];
				$this->current_language = $onelang;
			}
		}
		$this->smarty->assign("page_lang", $this->current_langcode);
		$this->smarty->assign("current_language", $this->current_language);
	}

	function getlanguages($inactive=false){
		if($this->available_languages == false)	$this->retrieve_languages();
		return	$inactive?$this->all_languages:$this->available_languages;
	}

	function retrieve_languages(){
		// retrieves languages from the database and store them in the module object
		// to avoid multiple retrieval, use getlanguages();
		$db = $this->GetDb();
		$query = "SELECT * FROM ".cms_db_prefix()."module_babel_languages ORDER BY item_order";
		$dbresult = $db->Execute($query);
		$output = array();
		$all = array();
		while($dbresult && $row = $dbresult->FetchRow()){
			$all[$row["langcode"]] = $row;
			if($row["active"])	$output[$row["langcode"]] = $row;
		}
		$this->all_languages = $all;
		$this->available_languages = $output;
	}
	
	function admin_retrieve_languages($id, $returnid){
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		$admintheme = $gCms->variables["admintheme"];
		$db = $this->GetDb();
		$defaultlang = $this->GetPreference("default_language", false);
		$query = "SELECT * FROM ".cms_db_prefix()."module_babel_languages ORDER BY item_order";
		$dbresult = $db->Execute($query);
		$output = array();
		while($dbresult && $row = $dbresult->FetchRow()){
			$item = new StdClass();
			foreach($row as $key=>$value){
				$item->$key = $value;
			}
			$moveparams = array("langcode"=>$item->langcode,"currentorder"=>$item->item_order);
			$item->namelink = $this->CreateLink($id, "editlang", $returnid, $item->name, array("langcode"=>$item->langcode));
			$item->codelink = $this->CreateLink($id, "editlang", $returnid, $item->langcode, array("langcode"=>$item->langcode));
			$item->editentries = $this->CreateLink($id, "editentries", $returnid, $this->Lang("edit_entries"), array("langcode"=>$item->langcode));
			$item->deletelink = $this->CreateLink($id, "movesomething", $returnid, $admintheme->DisplayImage("icons/system/delete.gif",lang("delete"),"","","systemicon"), array_merge(array("move"=>"delete"),$moveparams), $this->Lang("prompt_deletelanguage", str_replace("'","\'",$item->name)));
			$item->actions = $item->editentries." ".$item->deletelink;
			$item->moveuplink = $this->CreateLink($id, "movesomething", $returnid, $admintheme->DisplayImage("icons/system/arrow-u.gif",lang("up"),"","","systemicon"), array_merge(array("move"=>"up"),$moveparams));
			$item->movedownlink = $this->CreateLink($id, "movesomething", $returnid, $admintheme->DisplayImage("icons/system/arrow-d.gif",lang("down"),"","","systemicon"), array_merge(array("move"=>"down"),$moveparams));
			$item->movelinks = $item->moveuplink ." ". $item->movedownlink;
			if($defaultlang == $item->langcode){
				$item->toggledefault = $admintheme->DisplayImage("icons/system/true.gif","true","","","systemicon");
			}else{
				$item->toggledefault = $this->CreateLink($id, "toggledefault", $returnid, $admintheme->DisplayImage("icons/system/false.gif",lang("settrue"),"","","systemicon"), array("langcode"=>$item->langcode));
			}
			if($item->active){
				$item->toggleactive = $this->CreateLink($id, "toggleactive", $returnid, $admintheme->DisplayImage("icons/system/true.gif",lang("setfalse"),"","","systemicon"), array("langcode"=>$item->langcode, "newval"=>0));
			}else{
				$item->toggleactive = $this->CreateLink($id, "toggleactive", $returnid, $admintheme->DisplayImage("icons/system/false.gif",lang("settrue"),"","","systemicon"), array("langcode"=>$item->langcode, "newval"=>1));
			}
			array_push($output, $item);
		}
		return $output;
	}
	
	function get_language_details($langcode){
		$db = $this->GetDb();
		$query = "SELECT * FROM ".cms_db_prefix()."module_babel_languages WHERE langcode=?";
		$dbresult = $db->Execute($query, array($langcode));
		if($dbresult && $row = $dbresult->FetchRow()){
			$item = new StdClass();
			foreach($row as $key=>$value){
				$item->$key = $value;
			}
		}else{
			$item = false;
		}
		return $item;
	}
	
	function retrieve_langentries(){
		// retrieves the language entries for the current language
		if(!$this->current_language)	$this->retrieve_page_lang();
		if(!$this->current_language)	return false;
		$deflang = $this->GetPreference("default_language",false);
		$partial_import = false;
		if($deflang && $deflang != $this->current_language && $this->GetPreference("default_translate",false)){
			// when the entry doesn't exist in the current language, we use the one from the default language,
			// so we load this one first
			$partial_import = true;
			$this->current_langentries = $this->load_langentries($deflang);
		}
		$current_entries = $this->load_langentries($this->current_langcode);
		if($partial_import){
			// we've already loaded the default entries, so we add/replace the ones for the current language
			foreach($current_entries as $key=>$value){
				if($value && $value != "")	$this->current_langentries[$key] = $value;
			}
		}else{
			// no need for default entries
			$this->current_langentries = $current_entries;
		}
	}
	
	function load_langentries($lang){
		// retrieves language entries for any language
		if(!$this->is_language($lang))	return false;
		$db = $this->GetDb();
		$query = "SELECT langkeys.caption caption, langentries.value FROM ".cms_db_prefix()."module_babel_langkeys langkeys LEFT JOIN ".cms_db_prefix()."module_babel_langentries langentries ON langkeys.stringid = langentries.stringid WHERE langentries.langcode=?";
		$dbresult = $db->Execute($query,array($lang));
		$output = array();
		while($dbresult && $row = $dbresult->FetchRow()){
			$output[$row["caption"]] = $row["value"]?$row["value"]:"";
		}
		return $output;
	}
	
	function is_language($code){
		// returns true if $code is an active language
		if(!$this->available_languages)	$this->retrieve_languages();
		if(!$this->available_languages)	return false;
		$result = isset($this->available_languages[$code]);
		if(!$result) echo $code.' is not a language';
		return $result;
	}
	
	function retrieve_translation($key){
		// returns string corresponding to $key in the current language
		if(!$this->current_langentries)	$this->retrieve_langentries();
		if(!$this->current_langentries)	return false;
		$keys = explode(',',$key);
		$output = array();
		foreach($keys as $key){
			if(isset($this->current_langentries[$key]) &&  $this->current_langentries[$key] != ""){
				array_push($output, $this->current_langentries[$key]);
			}elseif(!$this->GetPreference("hide_missingentries",false)){
				array_push($output, "Add me: ".$key." (".$this->current_language.")");
			}else{
				array_push($output, "");
			}
		}
		if(count($output)==1)	return $output[0];
		return $output;
	}
	
	function assign_page_lang(){
		// detects current language based on hierarchy and assign it to smarty
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		$smarty =& $gCms->getSmarty();

		$contentops = $gCms->GetContentOperations();
		$root_id = $gCms->variables['content_id'];
		$tmpid = $root_id;
		while( $tmpid > 0){
			$root_id = $tmpid;
			$currentNode = $contentops->LoadContentFromId($tmpid);
			$tmpid = $currentNode?$currentNode->ParentId():-1;
		}
		$languages = $this->getlanguages();
		foreach($languages as $language){
			if($language['root_id'] == $root_id){
				$this->current_language = $language;
				$this->current_langcode = $language['langcode'];
			}
		}
		if(!$this->current_langcode){
			// thanks nino for this add
			$deflang = $this->GetPreference("default_language", false);
			if($deflang && array_key_exists( $deflang, $languages ) ) {
				$this->current_language = $languages[ $deflang ];
				$this->current_langcode = $deflang;
			}
		}
		$smarty->assign('page_lang',$this->current_langcode);
		$smarty->assign('page_lang_info',$this->current_language);
	}
	
	function auto_redirect(){
		// redirects to the user language when a url is requested
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		if(!$this->current_language)	return false;
		$pref_browser_home = $this->GetPreference("autoredirect_home");
		$pref_browser_all = $this->GetPreference("autoredirect_all");
		$pref_cookie_home = $this->GetPreference("cookies_autoredirect_home");
		$pref_cookie_all = $this->GetPreference("cookies_autoredirect_all");
		if(!$pref_cookie_home && !$pref_cookie_all && !$pref_browser_home && !$pref_browser_all)	return false;
		$pageid = $gCms->variables['content_id'];
		$languages = $this->getlanguages();
		$is_homepage = false;
		$langcodes = array();
		$truncated = array();
		foreach($languages as $language){
			array_push($langcodes,$language['langcode']);
			$truncated[substr($language['langcode'],0,2)] = $language['langcode'];
			if($language['default_id'] == $pageid)	$is_homepage = true;
		}
		$cookie = ($is_homepage && $pref_cookie_home) || $pref_cookie_all;
		$browser = ($is_homepage && $pref_browser_home) || $pref_browser_all;
		if(!$cookie && !$browser)	return false;

		// retrieve user language :
		$usrlang = false;
		if(isset($_COOKIE['usrlang']) && $cookie && in_array($_COOKIE['usrlang'], $langcodes)){
			$usrlang = $_COOKIE['usrlang'];
		}elseif($browser){			
			$languages = strtolower( $_SERVER["HTTP_ACCEPT_LANGUAGE"] );
			$languages = str_replace( ' ', '', $languages );
			$languages = explode( ",", $languages );
			$language = substr( $languages[0], 0, 2 );
			if(isset($truncated[$language]))	$usrlang = $truncated[$language];
		}

		if($usrlang && ($pref_cookie_all || $pref_cookie_home) )	setcookie('usrlang',$usrlang,time()+86400*365,'/');

		if($usrlang && $usrlang != $this->current_langcode){
			$destpage = $this->get_urls($usrlang);
			if(isset($destpage[$usrlang]))	header("location: ".$destpage[$usrlang]['url'].$gCms->config['page_extension']);
		}		
	}
	
	function get_urls($desired_lang=false){
		if($this->GetPreference('hierarchy_redirect',true)){
			return $this->hierarchy_get_links($desired_lang);
		}else{
			return $this->manual_get_links($desired_lang);
		}
	}
	
	function cleanHier($value){
		$parts = explode('.',$value);
		$i = 0;
		while(isset($parts[$i])){
			$parts[$i] = str_pad($parts[$i], 5, "0", STR_PAD_LEFT);
			$i++;
		}
		return implode('.',$parts);
	}
	
	function hierarchy_get_links($desired_lang=false){
		// retrieves the url to the page in the desired language(s) equivalent to the current page,
		// based on hierarchy
		// if $desired_lang is false, links for all active languages will be returned
		if(!$this->available_languages || count($this->available_languages) == 0)	return false;
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		$db = $this->GetDb();
		$base_url = $this->get_base_url();
		$default_hide = $this->GetPreference('default_hide', false);
		if($desired_lang && isset($this->available_languages[$desired_lang])){
			$langs = array($desired_lang=>$this->available_languages[$desired_lang]);
		}else{
			$langs = $this->available_languages;
		}
		$module_links = $this->module_get_url();
		if(count($module_links) == count($langs) && isset($module_links[$lang[0]['langcode']]))	return $module_links;
		$current_position = explode('.', $gCms->variables['position']);
		$output = array();
		$rootids = array();
		$hierarchies = array();
		$where = "";
		$query_values = array();
		$default_paths = array();
		foreach($langs as $onelang){
			$output[$onelang['langcode']] = array('menu_text'=>"", 'name'=>"", 'url'=>"");
			$rootids[$onelang['root_id']] = $onelang['langcode'];
			$where .= ($where == ""?"":" OR ")."content_id=?";
			array_push($query_values, $onelang['root_id']);
		}
		$query = "SELECT content_name, menu_text, content_id, hierarchy, hierarchy_path FROM " . cms_db_prefix()."content WHERE (".$where.")";
		$dbresult = $db->Execute($query, $query_values);
		$query_values = array();
		$where = "";
		$newpaths = array();
		while($dbresult && $row = $dbresult->FetchRow()){
			$position = explode('.',$row['hierarchy']);
			$newposition = $current_position;
			$newposition[0] = $position[0];
			$new_hierarchy = $this->cleanHier(implode('.',$newposition));
			$hierarchies[$rootids[$row['content_id']]] = $new_hierarchy;
			array_push($query_values,$new_hierarchy);
			$newpaths[$new_hierarchy] = $rootids[$row['content_id']];
			$default_paths[$rootids[$row['content_id']]] = array("url"=>$base_url.$row["hierarchy_path"], "name"=>$row["content_name"], "menu_text"=>$row["menu_text"]);
			$where .= ($where == ""?"":" OR ")."hierarchy=?";
		}
		$query = "SELECT content_id, content_name, menu_text, hierarchy, hierarchy_path FROM ".cms_db_prefix()."content WHERE (".$where.")";
		$dbresult = $db->Execute($query, $query_values);
		$redirection = $this->get_urltype();
		while($dbresult && $row = $dbresult->FetchRow()){
			if($redirection == 'internal' || $redirection == 'mod_rewrite'){
				$url = $base_url.$row['hierarchy_path'];
			}else{
				$pathparts = explode('/',$row['hierarchy_path']);
				$url = $base_url.$pathparts[count($pathparts)-1];
			}
			$output[$newpaths[$row["hierarchy"]]] = array("url"=>$url, "name"=>$row["content_name"], "menu_text"=>$row["menu_text"]);
		}
		$final = array();
		foreach($output as $lang=>$value){
			if(isset($module_links[$lang])){
				$value["url"] = $module_links[$lang]["url"];
				$value["name"] = $module_links[$lang]["name"];
			}
			if($value["url"] == "" && $default_hide){
			}elseif($value["url"] == ""){
				$final[$lang] = $default_paths[$lang];
			}else{
				$final[$lang] = $value;
			}
		}
		return $final;
	}
	
	
	function manual_get_links($desired_lang=false){
		// retrieves the url to the page in the desired language(s) equivalent to the current page,
		// based on Marcos Cruz manual procedure (see help)
		// if $desired_lang is false, links for all active languages will be returned
		if(!$this->available_languages || count($this->available_languages) == 0)	return false;
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		$db = $this->GetDb();
		$base_url = $this->get_base_url();
		if($desired_lang && isset($this->available_languages[$desired_lang])){
			$langs = array($desired_lang=>$this->available_languages[$desired_lang]);
		}else{
			$langs = $this->available_languages;
		}
		$module_links = $this->module_get_url();
		if(count($module_links) == count($langs) && isset($module_links[$lang[0]['langcode']]))	return $module_links;
		$output = array();
		foreach($langs as $onelang){
			$output[$onelang['langcode']] = false;
		}
		$btn_text = $this->GetPreference("use_page_title",false)?"":$newlang['menu_name'];

		// we retrieve the alternatives from the content block
		$other_languages = $gCms->smarty->get_template_vars('other_languages');
		$alternatives = array();
		$wherevalues = array();
		$where = "";
		foreach ( explode(';', $other_languages) as $onelang ){
			$parts = explode('=',$onelang);
			if(count($parts)==2){
				$where .= ($where==""?"":" OR ")."content_alias=?";
				$alternatives[$parts[1]] = $parts[0];
				array_push($wherevalues, $parts[1]);
			}
		}
		$query = "SELECT menu_text, content_name, content_alias, hierarchy_path FROM ".cms_db_prefix()."content WHERE (".$where.")";
		$dbresult = $db->Execute($query, $wherevalues);
		while($dbresult && $row = $dbresult->FetchRow()){
			$output[$alternatives[$row["content_alias"]]] = array("url"=>$base_url.$row["hierarchy_path"], "name"=>$row["content_name"], "menu_text"=>$row["menu_text"]);
		}
		if($this->GetPreference('default_hide', false))	return $output;

		// we check for default alternatives
		$where = "";
		$wherevalues = array();
		$idtolang = array();
		foreach($output as $lang=>$path){
			if(!$path){
				$where .= ($where==""?"":" OR ")."content_id=?";
				array_push($wherevalues, $langs[$lang]['default_id']);
				$idtolang[$langs[$lang]['default_id']] = $lang;
			}
		}
		if($where == "")	return $output;
		
		$query = "SELECT menu_text, content_name, content_id, hierarchy, hierarchy_path FROM " . cms_db_prefix()."content WHERE (".$where.")";
		$dbresult = $db->Execute($query, $wherevalues);
		while($dbresult && $row = $dbresult->FetchRow()){
			$output[$idtolang[$row["content_id"]]] = array("url"=>$base_url.$row["hierarchy_path"], "name"=>$row["content_name"], "menu_text"=>$row["menu_text"]);
		}
		return $output;
	}

	function get_urltype(){
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		$redirection = false;
		if(isset($gCms->config["url_rewriting"])){
			// core 1.6 or more
			$redirection = $gCms->config["url_rewriting"];
		}else{
			// core below 1.6
			if($gCms->config["assume_mod_rewrite"]){
				$redirection = "mod_rewrite";
			}elseif(!$gCms->config["assume_mod_rewrite"] && $gCms->config["internal_pretty_urls"]){
				$redirection = "internal";
			}
		}		
		return $redirection;
	}

	function get_base_url(){
		if(function_exists('cmsms')){ $gCms = cmsms(); }else{ global $gCms;	}
		$redirection = $this->get_urltype();
		$baseurl = $gCms->config['root_url'];
		if($redirection == "mod_rewrite"){
			$baseurl .= '/';
		}elseif($redirection == "internal"){
			$baseurl .= '/index.php/';
		}else{
			$baseurl .= '/index.php?'.$gCms->config['query_var'].'=';
		}
		return $baseurl;
	}
	
	function module_get_url(){
		return array();
		// eventually, some custom code here can check if we are in a module action
		// and retrieve language links from the module
	}
	
}

