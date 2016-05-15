"use strict";

var counter = 1;
window.onload = function start() {
	document.getElementById("count").disabled = true;
	var add = document.getElementById("add");
	document.getElementById("finish").onclick = able;
	var change = document.getElementById("change");
	//var minus = document.getElementById("minus");
	//var name = document.getElementById("name");
	//var file = document.getElementById("file");
	add.onclick = plus;
	change.onclick = changeit;
	//minus.onclick = remove;
	//var counter = 1;
}
function changeit() {
	document.getElementById("add").disabled = true;
	document.getElementById("Dilution").disabled = true;
	var el = document.getElementById('FileUploadContainer');
	el.innerHTML = '<div>Print this after the script tag</div>';
}

function able() {
	document.getElementById("count").disabled = false;
}
function plus() {
	 counter++;
     var div = document.createElement('DIV');
     div.innerHTML = '<label for="file">Filename: </label>' + '<input id="file' + counter + '" name = "file' + counter +
                     '" type="file" class = "fileData"/>' + ' Dilution factor: <input type="text" name="concentration' + counter +'" class="numberData">' + '<img src="minus.png" alt="CalibrateIt" style="width:25px;height:25px" onclick = "minus(this)">'
     document.getElementById("FileUploadContainer").appendChild(div);
     console.log(counter);
     var change = document.getElementById("count");
     change.value = counter;

}
function minus(div) {
	counter--;
	document.getElementById("FileUploadContainer").removeChild(div.parentNode);
	var change = document.getElementById("count")
	change.value = counter;
	change.innerHTML = counter;
}