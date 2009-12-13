var CHOSEN_CELL;
function hidepop(){
	document.getElementById("pop").style.visibility="hidden";
	CHOSEN_CELL=null;
}
function choose(n){
	CHOSEN_CELL.value=n;
	hidepop();
}
function popout(idx){
	var pop=document.getElementById('pop');
	var cell=document.getElementById('cell'+idx);
	if(CHOSEN_CELL===cell){
		hidepop();
	}else{
		CHOSEN_CELL=cell;
		var a=getY(CHOSEN_CELL),b=getX(CHOSEN_CELL);
		pop.style.visibility="visible";
		pop.style.top=(a+15)+'px';
		pop.style.left=(b+15)+'px';
	}
}
function getX(elem){
	var x = 0;
	while(elem){
		x = x + elem.offsetLeft;
		elem = elem.offsetParent;
	}
	return x;
}
function getY(elem){
	var y = 0;
	while(elem){
		y = y + elem.offsetTop;
		elem = elem.offsetParent;
	}
	return y;
}
