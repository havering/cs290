function getGists(pages) {
	var req;
	if (window.XMLHttpRequest) {	// modern browsers
		req = new XMLHttpRequest();
	}
	else {
		req = new ActiveXObject("Microsoft.XMLHTTP");	// old versions of IE
	}

	req.onreadystatechange = function() {
		if (req.readyState == 4 && req.status == 200) {
			var response = req.responseText;
			localStorage.setItem('gistList', response);
			loadGists();
		}
	}
	var url = 'https://api.github.com/gists/public?per_page=';
	var perPage = pages * 30;

	req.open('GET', url + perPage, true);
	req.send();
}

function searchMe() {
	var pageField = document.getElementById('pageNum');
	var pageValue = pageField.value;
	getGists(pageValue);
}

function loadGists() {
	var parsed = JSON.parse(localStorage.getItem('gistList'));

	var currentDiv = document.getElementById('gists');

	var tbl = document.createElement("table");
	var tblBody = document.createElement("tbody");
	

	for (var i = 0; i < parsed.length; i++) {
		var row = document.createElement("tr");

		var gistContent1 = document.createTextNode("Description: " + parsed[i].description);
		var gistContent2 = document.createTextNode("URL: " + parsed[i].url);
		var spacer1 = document.createElement('br');
		var spacer2 = document.createElement('p');
		var spacer3 = document.createElement('br');
		var btn = document.createElement("button");
		var btnText = document.createTextNode("Add to Favorites");
		btn.appendChild(btnText);
		
		btn.onclick = function() {
			alert("Adding to faves");
		}

		for (var j = 0; j < 1; j++) {
			var cell = document.createElement("td");
			//cell.style.backgroundColor="#3399FF";

			cell.appendChild(gistContent1);
			cell.appendChild(spacer1);
			cell.appendChild(gistContent2);
			cell.appendChild(spacer3);
			cell.appendChild(btn);

			row.appendChild(cell);
		}
		tblBody.appendChild(row);
		tblBody.appendChild(spacer2);
	}
	tbl.appendChild(tblBody);

	currentDiv.appendChild(tbl);
}