function showPreviewArticle(){
		var titleValue = document.getElementById("title");
		var textAreaValue = document.getElementById("textAreaContent");
		if( titleValue.value.trim().lenght != 0 && textAreaValue.value.trim().lenght != 0){
			if( document.getElementById("titleArticle").firstChild == null ){
				document.getElementById("titleArticle").appendChild(  document.createTextNode(titleValue.value) );
			}
			else{
				document.getElementById("titleArticle").replaceChild(  document.createTextNode(titleValue.value), document.getElementById("titleEntryBlog").firstChild );	
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