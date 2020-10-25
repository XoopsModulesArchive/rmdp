function rmdpShowInfo()
{
	if	(document.layers) {
		document.layers['downloadInfo'].visibility="visible";
		document.layers['downloadImage'].visibility="hidden";
	} else if (document.getElementById) {
		document.getElementById('downloadInfo').style.display="";
		document.getElementById('downloadInfo').style.visibility="visible";
		document.getElementById('downloadImage').style.display="none";
		document.getElementById('downloadImage').style.visibility="hidden";
	} else if (document.all) {
		document.all('downloadInfo').style.display="";
		document.all('downloadInfo').style.visibility="visible";	
		document.all('downloadImage').style.display="none";
		document.all('downloadImage').style.visibility="hidden";	
	}
	
}

function rmdpShowImage(){
	if	(document.layers) {
		document.layers['downloadInfo'].visibility="hidden";
		document.layers['downloadImage'].visibility="visible";
	} else if (document.getElementById) {
		document.getElementById('downloadInfo').style.display="none";
		document.getElementById('downloadInfo').style.visibility="hidden";
		document.getElementById('downloadImage').style.display="";
		document.getElementById('downloadImage').style.visibility="visible";
	} else if (document.all) {
		document.all('downloadInfo').style.display="none";
		document.all('downloadInfo').style.visibility="hidden";	
		document.all('downloadImage').style.display="";
		document.all('downloadImage').style.visibility="visible";	
	}
}