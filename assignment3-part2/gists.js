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
	var url = 'https://api.github.com/gists?per_page=';
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
	// to store html coded gists
	var gistSide = document.getElementById('gists');
	var favSide = document.getElementById('faves');

	for (var i = 0; i < parsed.length; i++) {
		var output = makeHTML(parsed[i]);

		gistSide.appendChild(output);
	}

	var faveList = JSON.parse(localStorage.getItem('favList'));

	for (var j = 0; j < faveList.length; j++) {
		var posted = makeHTML(faveList[j]);

		favSide.appendChild(posted);
	}
}

function makeHTML(gistObject) {

	var desc = document.createElement('div');
	desc.setAttribute('id', 'desc');

	if (gistObject.description === null) {
		desc.innerHTML = "No description!";
	}
	else {
		desc.innerHTML = gistObject.description;
	}
	
	var url = document.createElement('div');
	url.innerHTML = '<a href="' +gistObject.url + '">' + gistObject.url + '</a>';

	var id = document.createElement('div');
	id.setAttribute('id', gistObject.id);

	var fbutton = document.createElement('button');
	fbutton.innerHTML = "+";
	fbutton.setAttribute("gistId", gistObject.id);

	fbutton.onclick = function() {
		var gistId = this.getAttribute("gistId"); //this is what you have saved before
		var toBeFavoredGist = findById(gistId);
		localStorage.setItem('favList', toBeFavoredGist);
		localStorage.removeItem('gistList', toBeFavoredGist);
	//here you add the gist to your favorite list in the localStorage and remove it from the gist list and add it to favorite list
	};

	var htmlGist = document.createElement('div');
	var spacer = document.createElement('p');

	htmlGist.appendChild(fbutton);
	htmlGist.appendChild(desc);
	htmlGist.appendChild(url);
	htmlGist.appendChild(id);
	htmlGist.appendChild(spacer);

	return htmlGist;
}

function findById(gistId) {
	var finding = JSON.parse(localStorage.getItem('gistList'));

	for (var i = 0; i < finding.length; i++) {
		if (finding[i].id === gistId) {
			return finding[i];
		}
	}
}