<h1>{$edittitle}</h1>
{if $langselect}
	<div id="babel_langselectdiv" class="pageoverflow" style="text-align: right; border-bottom: 1px solid #000;">
		<p>{$langselect_label}<br/>{$langselect}<br/></p>
	</div>
{/if}

	<div class="pageoverflow">
		<p class="pagetext">{$name_label}* :</p>
		<p class="pageinput">{$name_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$langcode_label}* :</p>
		<p class="pageinput">{$langcode_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$menu_name_label} :</p>
		<p class="pageinput">{$menu_name_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$root_id_label}* :</p>
		<p class="pageinput">{$root_id_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$default_id_label} :</p>
		<p class="pageinput">{$default_id_input}</p>
	</div>
<br/>
<p>{$submit} {$apply} {$cancel}</p>
<script type="text/javascript">
var moduleid = "{$plid}";
{literal}
function languagefill(rawdata){
	var newdata = rawdata.split('/');
	document.getElementById(moduleid+'langcode').value = newdata[0];
	document.getElementById(moduleid+'name').value = newdata[1];
	document.getElementById(moduleid+'menu_name').value = newdata[1];
	return false;
}
var langselect = document.getElementById('babel_langselectdiv').getElementsByTagName('select');
if(langselect[0]) langselect[0].onchange = function(){
	languagefill(this.value);
};
langselect = null;
{/literal}
</script>
