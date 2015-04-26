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

	for (var i = 0; i < parsed.length; i++) {
		var output = makeHTML(parsed[i]);

		gistSide.appendChild(output);
	}

}

function makeHTML(gistObject) {
	var counter = 0;
	var finding = JSON.parse(localStorage.getItem('gistList'));

	var desc = document.createElement('div');
	desc.setAttribute('id', 'desc');

	if (gistObject.description === null || gistObject.description.length === 0) {
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
	fbutton.setAttribute('gistId', gistObject.id);

	fbutton.onclick = function() {

		var gistId = this.getAttribute('gistId'); 
		var toBeFavoredGist = findById(gistId, finding);
		localStorage.setItem('favList', JSON.stringify(toBeFavoredGist));
		localStorage.removeItem('gistList', JSON.stringify(toBeFavoredGist));
		counter++;
		displayFav(counter);
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

function displayFav(counter) {

	var faveList = JSON.parse(localStorage.getItem('favList'));
	var favSide = document.getElementById('faves');

	for (var j = 0; j < counter; j++) {
		var posted = favHTML(faveList);

		favSide.appendChild(posted);
	}

}

function favHTML(favObject) {
	var desc = document.createElement('div');
	desc.setAttribute('id', 'desc');
	var finding = JSON.parse(localStorage.getItem('favList'));

	if (favObject.description === null) {
		desc.innerHTML = "No description!";
	}
	else {
		desc.innerHTML = favObject.description;
	}
	
	var url = document.createElement('div');
	url.innerHTML = '<a href="' +favObject.url + '">' + favObject.url + '</a>';

	var id = document.createElement('div');
	id.setAttribute('id', favObject.id);

	var rbutton = document.createElement('button');
	rbutton.innerHTML = "-";
	rbutton.setAttribute('gistId', favObject.id);

	rbutton.onclick = function() {
		var gistId = this.getAttribute('gistId'); 
		var toBeRemovedGist = findById(gistId, finding);
		localStorage.removeItem('favList', JSON.stringify(toBeRemovedGist));
		counter--;
		displayFav(counter);
 	};

	var htmlFav = document.createElement('div');
	var spacer = document.createElement('p');

	htmlFav.appendChild(desc);
	htmlFav.appendChild(url);
	htmlFav.appendChild(id);
	htmlFav.appendChild(spacer);


	return htmlFav;
}

function findById(gistId, finding) {

	for (var i = 0; i < finding.length; i++) {
		if (finding[i].id === gistId) {
			return finding[i];
		}
	}
}