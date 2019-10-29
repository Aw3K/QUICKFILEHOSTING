var lock = false;
/*$(function() {

    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var file = e.originalEvent.dataTransfer.files;
		var fd = new FormData();
        fd.append('file', file[0]);
		
		document.getElementById("upload_file").value = fd;
		lock = true;
		loop();
    });
});*/
var VIEW = 0;
function viewFILE() {
	var x = document.getElementById("viewConatiner");
	var y = document.getElementById("showFile");
	if (VIEW == 0) {
		x.style.display = "initial";
		y.style.height = "auto";
		VIEW++;
	} else {
		x.style.display = "none";
		y.style.height = "17px";
		VIEW--;
	}
}

function upload_image() 
{
	var bar = $('#bar1');
	var percent = $('#percent1');
	var file = document.getElementById("upload_file");
	var formm = document.getElementById("myForm");
	if (file.files.length != 0) {
		document.getElementById("progress_div").style.display = "block";
		var percentVal = '0%';
		bar.width(percentVal);
		percent.html(percentVal);
	} else {
		alert("File not selected.");
		$("#myForm").submit(function(e){
			return false;
		});
		document.getElementById("progress_div").style.display = "none";
		return;
	}
	$('#myForm').ajaxForm({
    beforeSubmit: function() {
		formm.style.display = 'none';
    },

    uploadProgress: function(event, position, total, percentComplete) {
		var percentVal = percentComplete + '%';
		bar.width(percentVal);
		percent.html(percentVal);
    },
    
	success: function() {
		var percentVal = '100%';
		bar.width(percentVal);
		percent.innerHTML = percentVal;
    },

    complete: function() {
		var file = document.getElementById("upload_file");
		file.value = "";
		setTimeout( function(){
			$('#out').load('success.php');
			document.getElementById("progress_div").style.display = "none";
			var formm = document.getElementById("myForm");
			formm.style.display = 'initial';
		}, 1000 );
    }
  }); 
}

function start() {
	var file = document.getElementById("upload_file");
	file.value = "";
	loop();
	lock = true;
}

function splitNum(x) {
	var y = x.split(".");
	var out = y[0] + "." + y[1].slice(0, 3);
	return out;
}

function loop() {
	if (lock == true) return;
	worker();
}

function worker() {
	var time = setTimeout( worker, 100 );
	var file = document.getElementById("upload_file");
	if (file.files.length != 0) {
		clearTimeout(time);
		//var element = document.createElement("div");
		var size = file.files[0].size/1048576;
		//element.appendChild(document.createTextNode(file.files[0].name + " - " + splitNum(size.toString()) + "MB"));
		//document.getElementById('LIST').appendChild(element);
		document.getElementById('out').innerHTML = "<div class='selected'>" + file.files[0].name + " - " + splitNum(size.toString()) + "MB</div>";
		lock = false;
	}
}

function openInNewTab(url) {
  var win = window.open(url, "_blank");
  win.focus();
}