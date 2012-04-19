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

// example: formatEngDate(new Date(), true) => Tue 12/20/2011
function formatEngDate(dt, padZeroes, showDayOfWeek) {    // Date dt
    var dow = '';
    if (showDayOfWeek) {
        var dowArr = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        dow = dowArr[dt.getDay()]+' ';
    }
    var mm = dt.getMonth()+1; if (padZeroes && mm < 10) mm = '0'+mm;
    var dd = dt.getDate(); if (padZeroes && dd < 10) dd = '0'+dd;
    return dow+mm+'/'+dd+'/'+dt.getFullYear();
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

// get current Website URL without params, hash, etc.
// return: URL without "/" - example: https://mydomain.com
function getWebsiteURL()
{
    var url = window.location.toString()+'/'; // example: http://mydomain.com/params/etc/
    var idx1 = url.indexOf('/');
    var idx2 = url.indexOf('/', idx1+3); // find the 3rd forward-slash
    url = url.substr(0, idx2);
    return url; // without "/" => http://mydomain.com
}