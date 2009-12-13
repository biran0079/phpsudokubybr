var block_idx=new Array(
		new Array(0,1,2,9,10,11,18,19,20),
		new Array(3,4,5,12,13,14,21,22,23),
		new Array(6,7,8,15,16,17,24,25,26),
		new Array(27,28,29,36,37,38,45,46,47),
		new Array(30,31,32,39,40,41,48,49,50),
		new Array(33,34,35,42,43,44,51,52,53),
		new Array(54,55,56,63,64,65,72,73,74),
		new Array(57,58,59,66,67,68,75,76,77),
		new Array(60,61,62,69,70,71,78,79,80));

function div(a,b){
	return (a-a%b)/b;
}
function highlight(id,color){
	document.getElementById(id).style.backgroundColor=color;
}
function highlight_related(idx){
	var rn=div(idx,9),cn=idx%9;
	var bn=div(rn,3)*3+div(cn,3);
	var t;
	var color='rgb(192,192,192)';
	for(var i=0;i<9;i++){
		t=rn*9+i;
		highlight('cell'+t,color);
		t=9*i+cn;
		highlight('cell'+t,color);
		t=block_idx[bn][i];
		highlight('cell'+t,color);
	}
}
function un_highlight_related(idx){
	var rn=div(idx,9),cn=idx%9;
	var bn=div(rn,3)*3+div(cn,3);
	var t;
	for(var i=0;i<9;i++){
		t=rn*9+i;
		highlight('cell'+t,'');
		t=9*i+cn;
		highlight('cell'+t,'');
		t=block_idx[bn][i];
		highlight('cell'+t,'');
	}
}
