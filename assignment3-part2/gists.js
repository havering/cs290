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
	};
	var url = 'https://api.github.com/gists?per_page=';
	var perPage = pages * 30;

	req.open('GET', url + perPage, true);
	req.send();
}

window.onload = function() {
	displayFav();
};

function searchMe() {
	var pageField = document.getElementById('pageNum');
	var pageValue = pageField.value;

	if (pageValue < 1 || pageValue > 5) {
		alert("Enter a value between 1 and 5!");
	}
	else {
		getGists(pageValue);
	}
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
	url.innerHTML = '<a href="' +gistObject.html_url + '">' + gistObject.html_url + '</a>';

	var id = document.createElement('div');
	id.setAttribute('id', gistObject.id);

	var fbutton = document.createElement('button');
	fbutton.innerHTML = "+";
	fbutton.setAttribute('gistId', gistObject.id);

	fbutton.onclick = function() {

		var gistId = this.getAttribute('gistId'); 
		var toBeFavoredGist = findById(gistId, finding);
		var faveList = JSON.parse(localStorage.getItem('favList'));
		faveList.push(toBeFavoredGist);
		localStorage.setItem('favList', JSON.stringify(faveList));
		//localStorage.removeItem('gistList', JSON.stringify(toBeFavoredGist));
		displayFav();
		htmlGist.remove();
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

function displayFav() {
	var favSide = document.getElementById('faves');
	var faveList = localStorage.getItem('favList');

	if (faveList === null){
		faveList = [];
		localStorage.setItem('favList', faveList);
	} else {
		//otherwise there is an array of favorites already there and you have to display them one by one
		for(var i=0;i < faveList.length; i++){
			var posted = favHTML(faveList[i]);
			favSide.appendChild(posted);
		}
	}
}

function favHTML(favObject) {
	var finding = JSON.parse(localStorage.getItem('favList'));

	var desc = document.createElement('div');
	desc.setAttribute('id', 'desc');

	if (favObject.description === null || favObject.description.length === 0) {
		desc.innerHTML = "No description!";
	}
	else {
		desc.innerHTML = favObject.description;
	}
	
	var url = document.createElement('div');
	url.innerHTML = '<a href="' +favObject.html_url + '">' + favObject.html_url + '</a>';

	var rbutton = document.createElement('button');
	rbutton.innerHTML = "-";
	rbutton.setAttribute('gistId', favObject.id);

	rbutton.onclick = function() {

		var gistId = this.getAttribute('gistId'); 
		var toBeRemovedGist = findById(gistId, finding);
		localStorage.removeItem('favList', JSON.stringify(toBeRemovedGist));
		favGist.remove();
 	};

	var favGist = document.createElement('div');
	favGist.setAttribute('id', favObject.id);
	var spacer = document.createElement('p');

	favGist.appendChild(rbutton);
	favGist.appendChild(desc);
	favGist.appendChild(url);
	favGist.appendChild(spacer);

	return favGist;
}

function findById(gistId, finding) {

	for (var i = 0; i < finding.length; i++) {
		if (finding[i].id === gistId) {
			return finding[i];
		}
	}
}