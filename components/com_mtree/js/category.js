function loadcat(){
	cc(this.value);
}
function addSecCat(){
	if(active_cat>=0){
		if(jQuery('#other_cats').val()!=''){
			jQuery('#other_cats').val(jQuery('#other_cats').val()+','+active_cat);
		}else{
			jQuery('#other_cats').val(active_cat);
		}
		var newLi = document.createElement("LI");
		newLi.id = 'lc'+active_cat;
		var newLink=document.createElement("A");
		newLink.href="javascript:remSecCat("+active_cat+")";
		newLink.appendChild(document.createTextNode(txtRemove));
	    newLi.appendChild(newLink);
	    var liTxt = document.createTextNode(jQuery('#mc_active_pathway').text());
	    newLi.appendChild(liTxt);
		gebid('linkcats').appendChild(newLi);					
	}		
	toggleMcBut(active_cat);
}
function remSecCat(cat_id){
	var oc=jQuery('#other_cats').val().split(',');
	if(oc!=''){
		var new_oc=new Array();
		for (var i=0; i < oc.length; i++) {
			if(oc[i]!=cat_id) {
				new_oc.push(oc[i]);
			}
		};
	}
	document.adminForm.other_cats.value=new_oc.join(',');
	var li=gebid('lc'+cat_id);
	li.parentNode.removeChild(li);
	toggleMcBut(active_cat);
			
}
function updateMainCat(){
	var newLi = document.createElement("LI");
    var liTxt = document.createTextNode(jQuery('#mc_active_pathway').text());
	newLi.id = 'lc'+active_cat;
    newLi.appendChild(liTxt);
	var i=0;
	do {
		var oldLi = gebid('linkcats').childNodes[i++];
	} while(oldLi.nodeType != 1)
	gebid('linkcats').replaceChild(newLi,oldLi);
	jQuery('#lc'+active_cat).html(jQuery('#lc'+active_cat).html());
	document.adminForm.cat_id.value=active_cat;
	toggleMcBut(active_cat);
	togglemc();
}
function cc(parent_cat_id){
	if(parent_cat_id >= 0 && parent_cat_id != '') {
		jQuery.ajax({
		  type: "POST",
		  url: mosConfig_live_site+"/index.php",
		  data: "option=com_mtree&task=getcats&cat_id="+parent_cat_id+"&format=raw&tmpl=component",
		  dataType: "html",
		  success: function(str){
				if(str != 'NA') {
					var cats = str.split("\n");
					totalcats = cats.length;
					if ( totalcats > 1 ) {
						clearList('browsecat');
						jQuery('#mc_active_pathway').html(cats[0]);
						for (c=1; c < totalcats; c++) {
							if(cats[c].length>2) {
								var s = cats[c].split("|");
								gebid('browsecat').options[c-1] = new Option(s[1],s[0]);
							}
						}
					}
					active_cat = parent_cat_id;
					switch(document.adminForm.task.value){
						case 'editlink':
						case 'savelisting':
						case 'editcat':
							toggleMcBut(parent_cat_id);
							break;
						case 'cats_copy':
						case 'cats_move':
						case 'links_move':
						case 'links_copy':
							document.adminForm.new_cat_parent.value=active_cat;
							break;
					}
				}
			}
		});	
	}
}
function toggleMcBut(cat_id){
	if(gebid('mcbut1') != null) {
		if(inOtherCats(cat_id)){
			gebid('mcbut1').disabled=true;
			if(gebid('mcbut2')) { gebid('mcbut2').disabled=true; }
			jQuery('#mc_active_pathway').css('background-color','#f9f9f9');
			jQuery('#mc_active_pathway').css('color','#C0C0C0');
		}else{
			gebid('mcbut1').disabled=false;
			if(gebid('mcbut2')) { gebid('mcbut2').disabled=false; }
			jQuery('#mc_active_pathway').css('background-color','#FFF');
			jQuery('#mc_active_pathway').css('color','#000');
		}		
	}
}
function inOtherCats(target){
	if(target==document.adminForm.cat_id.value) {
		return true;
	}
	var other_cats = jQuery('#other_cats').val();
	if(other_cats != ''){
		other_cats = other_cats.split(',');
		for (var i=0; i < other_cats.length; i++) {
			if(other_cats[i] == target){
				return true;
			}
		}
	}
	return false;
}
function togglemc() {
	if(jQuery('#mc_con').css('display')=='none'){
		jQuery('#mc_con').slideDown('slow');
	} else {
		jQuery('#mc_con').slideUp('slow');
	}
}
function gebid(id){return document.getElementById(id);}
function clearList(id) {
	var clength = gebid(id).length;
	for(var i=(clength-1);i>=0;i--) {gebid(id).remove(i);}
}

