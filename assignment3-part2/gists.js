window.onload = function() {
	
	document.getElementById("searchButton").onclick = function() { 
		
		getGists("four.html"); 

	};

}


function getGists(url) {
	var req;

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

	req.onreadystatechange = displayResults;
	req.open('GET', 'https://api.github.com/gists', true);
	req.send(null);
}

function displayResults() {
		if (this.readyState === 4) {
			if (this.status === 200) {
				document.getElementById("results").innerHTML = "Results found";
			}
			else {
				console.log("Error on the server side. Request not completed.");
			}
		}
		else {
			console.log("Waiting for loading to complete.");
		}
	}


