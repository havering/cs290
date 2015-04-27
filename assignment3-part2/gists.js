/**Primarily AJAX Request - loads gists once done**/

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


/**Displaying favs upon window load allows previously saved favs to populate**/
window.onload = function() {
	displayFav();
};

/**Error handling for invalid user input from html form**/
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

/**Traverses gists returned by AJAX call and outputs to screen via fxn**/
function loadGists() {
	var parsed = JSON.parse(localStorage.getItem('gistList'));
	// to store html coded gists
	var gistSide = document.getElementById('gists');

	for (var i = 0; i < parsed.length; i++) {
		var output = makeHTML(parsed[i]);

		gistSide.appendChild(output);
	}
}

/**Function to translate JSON objects into readable HTML**/
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
		var faveListObj = JSON.parse(localStorage.getItem('favList'));
		faveListObj.favList.push(toBeFavoredGist);
		localStorage.setItem('favList', JSON.stringify(faveListObj));
		addToFavList(toBeFavoredGist);
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

/**Displays previous stored list of favs**/
/**Previous version corrected by Prof Ghorashi**/
function displayFav() {
	var favSide = document.getElementById('faves');
	var faveListString = localStorage.getItem('favList'), faveListObj;

	if (faveListString === null){
		faveListObj = {"favList":[]};
		localStorage.setItem('favList', JSON.stringify(faveListObj));
	} else {
		favSide.innerHTML = "<h3>Favorites</h3>";
		faveListObj = JSON.parse(faveListString);
		for(var i=0;i < faveListObj.favList.length; i++){
			var posted = favHTML(faveListObj.favList[i]);
			favSide.appendChild(posted);
		}
	}
}

/**Separate function to add favorites to HTML output**/
function addToFavList(newGist) {
	var favSide = document.getElementById('faves');
	var posted = favHTML(newGist);
	favSide.appendChild(posted);
}

/**Same functionality as makeHTML, but with remove button instead of add**/
/**Previous version corrected by Prof Ghorashi**/

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
		var toBeRemovedGist = findById(gistId, finding.favList);
		var faveListObj = JSON.parse(localStorage.getItem("favList"));
		for(var i =0; i < faveListObj.favList.length; i++) {
			if(faveListObj.favList[i].id === toBeRemovedGist.id){
				faveListObj.favList.splice(i, 1);
				break;
			}
		}
		localStorage.setItem('favList', JSON.stringify(faveListObj));
		this.parentNode.remove();
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

/**Isolates fav to be added**/
/**Written per pseudocode suggested on Piazza by Prof Ghorashi**/
function findById(gistId, finding) {

	for (var i = 0; i < finding.length; i++) {
		if (finding[i].id === gistId) {
			return finding[i];
		}
	}
}
