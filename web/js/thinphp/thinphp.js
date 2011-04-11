	
// namespace: TPF
var TPF = {
	dump: function(obj)
	{
	    var out = '';
	    for (var i in obj) {
	        out += i + ": " + obj[i] + "\n";
	    }
	    alert(out);
	},
	countJSON: function(jsonArr)
	{
		if (jsonArr === undefined || jsonArr == null) return 0;
		total = 0;
		while(1) {
			if (jsonArr[total] === undefined) return total;
			total++;
		}
	},
	appendHead: function(o)
	{
		var count = 0;
		var scriptTag, linkTag;
		var scriptFiles = o.js;
		var cssFiles = o.css;
		var head = document.getElementsByTagName('head')[0];

		for (var k in cssFiles) {
			linkTag = document.createElement('link');			
			linkTag.type = 'text/css';
			linkTag.rel = 'stylesheet';
			linkTag.href = cssFiles[k];
			head.appendChild(linkTag);
		}
		for (var k in scriptFiles) {
			scriptTag = document.createElement('script');
			scriptTag.type = 'text/javascript';
			if (typeof o.callback == "function") {		
				if (scriptTag.readyState) {  //IE				
	            	scriptTag.onreadystatechange = function() {            		
		                if (scriptTag.readyState == "loaded" || scriptTag.readyState == "complete"){
		                    //scriptTag.onreadystatechange = null;
		                    count++;
							if (count == scriptFiles.length) o.callback.call();
		                }
	            	};
	            } else { // other browsers
					scriptTag.onload = function() {
						count++;
						if (count == scriptFiles.length) o.callback.call();			
					}
				}
			}
			scriptTag.src = scriptFiles[k];
			head.appendChild(scriptTag);
		}
	},
	enableForm: function(formId, b)
	{
		$(formId+' input,textarea').attr('disabled', !b);
	},
	setReadonlyForm: function(formId, b)
	{	
		$(formId+' input,textarea').attr('readonly', !b);
		$(formId+' input[type=submit]').attr('disabled', !b);
	},
	showLoading: function(formId)
	{
		$(formId+' input[type=submit]').next('span').html('<img src="/js/thinphp/loading.gif" />'); // loading animation
	},
	delaySubmit: function(formId, time)
	{
		this.setReadonlyForm(formId, false); // set form readonly to prevent resubmit
		this.showLoading(formId);		
		setTimeout("TPF.delaySubmitHelper('"+formId+"')", time);
	},
	delaySubmitHelper: function(formId)
	{		
		var s = formId.substring(1, formId.length); // remove '#'
		document.forms[s].submit();
	},
	setFormError: function(formId, fieldName, errMsg)
	{
		if (fieldName === undefined) return;
		if (fieldName.length == 0) {		
			$(formId+' :input').next('span').html(''); // clear all err
			$(formId+' :input').next('span').hide();		
			return;
		}
		$(formId+' :input[name='+fieldName+']').next('span').html(errMsg);	
		$(formId+' :input[name='+fieldName+']').next('span').fadeIn('slow');
	},
	focusField: function(formId, f) {
		setTimeout("TPF.focusFieldHelper('"+formId+"', '"+f+"')", 200);	
	},
	focusFieldHelper: function(formId, f) {	
		$(formId+' :input[name='+f+']').focus();
	}
}