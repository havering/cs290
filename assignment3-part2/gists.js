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

	createOutput(parsed);
	};

	var perPage = pageNum * 30;

	// array holds a max of 100 objects
	// FIX THIS need to break apart into multiple arrays for more than 100 objects??
	req.open('GET', 'https://api.github.com/gists/public?per_page=' + perPage, true);
	
	req.send(null);

}

function createOutput(parsed) {

	var currentDiv = document.getElementById('gists');
	

	for (var i = 0; i < parsed.length; i++) {
		var gistContent1 = document.createTextNode("Description: " + parsed[i].description);
		var gistContent2 = document.createTextNode("URL: " + parsed[i].url + "\r\n");
		var spacer1 = document.createElement('br');
		var spacer2 = document.createElement('p');

		currentDiv.appendChild(spacer2);
		currentDiv.appendChild(gistContent1);
		currentDiv.appendChild(spacer1);
		currentDiv.appendChild(gistContent2);

	}

}


};


