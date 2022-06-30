function edit_fild(val){
	document.getElementById('id_fild').value=val;
	document.getElementById('hides').submit();
}

function go_to_main_click(http) {
	//alert(http);
	window.open(http, "_self");
	//history.go(-1);
}

function add_click(){
	//var dialog = document.querySelector('#user_dialog');
	//dialog.showModal();
	$( "#add_dialog" ).dialog( "open" );
}