function check_input(name){
	var id='cell'+name;
	var o=document.getElementById(id);
	var t=o.value;
	if(t.length>1)t=t.substring(0,1);
	if(isNaN(t))t='';
	o.value=t;
}
