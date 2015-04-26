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
	console.log(parsed);
	
}

function moveToFavs(gistObject) {
	var fave = document.getElementById('faves');
	
}