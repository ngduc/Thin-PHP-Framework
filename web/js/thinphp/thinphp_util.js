// other useful functions
function ele(elementId) {
	return document.getElementById(elementId);
}

function wopen(url) {
	return window.open(url);
}

function trim(st) {
	return st.replace(/^\s+|\s+$/g,"");
}

function ltrim(st) {
	return st.replace(/^\s+/,"");
}

function rtrim(st) {
	return st.replace(/\s+$/,"");
}

// dump Array/Hashes/Objects/JSON
function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			if (dumped_text.length > 5000) return dumped_text;
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}
