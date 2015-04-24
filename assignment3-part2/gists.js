window.onload = function() {
	
	document.getElementById("searchButton").onclick = function() { 
		var pages = document.getElementsByName("pages");
		var pageNum;

		// get number of pages to show
		for (var i = 0; i < pages.length; i++) {
			if (pages[i].checked) {
				pageNum = pages[i].value;
				// no need to search the rest, only one can be selected
				break;
			}
		}

		// get languages user wants to see
		var language = document.getElementsByName("language");
		var langs = [];

		for (var j = 0; j < language.length; j++) {
			if (language[j].checked) {
				langs.push(language[j].value);
			}
		}
	
		getGists(pageNum, langs); 

		

	};

	function getGists(pageNum, langs) {
	var req;
	var parsed = [];

	if (window.XMLHttpRequest) {  // modern browsers
		req = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {  // old versions of IE
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}

	if (!req) {
		alert("Could not create XMLHttpRequest!");
		return false;
	}

	req.onreadystatechange = function() {
		if (this.readyState === 4) {
			if (this.status === 200) {
				document.getElementById("results").innerHTML = "Results found";
				
				parsed = JSON.parse(req.responseText);
				
				console.log(parsed);
								
		}
			else {
				console.log("Error on the server side. Request not completed.");
			}
		}
		else {
			console.log("Waiting for loading to complete.");
		}

		// don't worry about this right now
		// extra credit if you get there
		/*var sortedGists = [];
		
		if (langs !== null) {
			for (var j = 0; j < langs.length; j++) {
			// then loop through parsed to compare languages selected with languages offered
			for (var i = 0; i < parsed.length; i++) {
					for (language in parsed[i]) {
						console.log("Parsed[i]: " + parsed[i].language);
						console.log("Langs[j]:" + langs[j]);
						if (parsed[i].language == langs[j]) {
							// if the language matches, push to new array

							sortedGists.push(parsed[i]);
						}
					}
				}
			}
		}
			
		else {
			console.log("Lang is null");
		}
		
		var size = sortedGists.length;
		console.log("Size of sorted: " + size);
		createOutput(sortedGists);
	*/

	createOutput(parsed);
	};
	
	req.open('GET', 'https://api.github.com/gists/public?page=' + pageNum, true);
	req.send(null);

}

	function createOutput(parsed) {
	var creation = document.createElement("div");
	var spacer = document.createElement("br");

	for (var i = 0; i < parsed.length; i++) {
		var gistContent1 = document.createTextNode("Description: " + parsed[i].description);
		var gistContent2 = document.createTextNode("URL: " + parsed[i].url + "\r\n");
	
		creation.appendChild(gistContent1);
		creation.appendChild(gistContent2);

	}

	var currentDiv = document.getElementById("gists");
	document.body.insertBefore(creation, currentDiv);

}


};


