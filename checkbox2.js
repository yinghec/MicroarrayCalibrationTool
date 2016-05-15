"use strict";

var counter = 1;
window.onload = function start() {
	document.getElementById("count").disabled = true;
	var add = document.getElementById("add");
	//var minus = document.getElementById("minus");
	//var name = document.getElementById("name");
	//var file = document.getElementById("file");
	add.onclick = plus;
	document.getElementById("finish").onclick = set;
	//minus.onclick = remove;
	//var counter = 1;
}

function plus() {
	 counter++;
     var div = document.createElement('DIV');
     div.innerHTML = '<label for="file">Sample intensities:</label>' + '<input id="file' + counter + '" name = "file' + counter +
                     '" type="file" class = "fileData"/>' + '  Description: <input type="text" name="description' + counter +'" class="desData" style="width: 120px;"> ' + 
                     'Comment: <input type="text" name="comment' + counter +'" class="comData" style="width: 120px;"> '+'<img src="minus.png" alt="CalibrateIt" style="width:25px;height:25px" onclick = "minus(this)">'
     document.getElementById("FileUploadContainer").appendChild(div);
     console.log(counter);
     var change = document.getElementById("count");
     change.value = counter;
     change.innerHTML = counter;

}
function minus(div) {
	counter--;
	document.getElementById("FileUploadContainer").removeChild(div.parentNode);
	var change = document.getElementById("count")
	change.value = counter;
	change.innerHTML = counter;
}

function set() {
	document.getElementById("count").disabled = false;
}