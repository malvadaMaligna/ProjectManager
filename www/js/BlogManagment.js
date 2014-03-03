	function showPreview(){
		var titleValue = document.getElementById("Blogtitle");
		var textAreaValue = document.getElementById("textAreaContent");
		if( titleValue.value.trim().lenght != 0 && textAreaValue.value.trim().lenght != 0){
			if( document.getElementById("titleEntryBlog").firstChild == null ){
				document.getElementById("titleEntryBlog").appendChild(  document.createTextNode(titleValue.value) );
			}
			else{
				document.getElementById("titleEntryBlog").replaceChild(  document.createTextNode(titleValue.value), document.getElementById("titleEntryBlog").firstChild );	
			}
			var aux = document.getElementById("auxContent");
			var x = document.getElementById("textAreaContent").value;
			if( x != 0 ){
				
				var x = x.replace( /<script>/gi, "<p>");
				var x = x.replace( /<\/script>/gi, "</p>");
			}
			aux.innerHTML = x;
		}
	}
	
	
	