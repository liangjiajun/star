(function() {

	// 获取ID
	function $id(id) {
		return document.getElementById(id);
	}


	// 输出信息
	function Output(msg) {
		var m = $id("messages");
		m.innerHTML = msg + m.innerHTML;
	}


	//文件悬停拖放
	function dropAreaHover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.target.className = (e.type == "dragover" ? "hover" : "");
	}


	// 选择文件
	function FileSelectHandler(e) {

		// 取消事件和悬停
		dropAreaHover(e);

		// 获取文件列表
		var files = e.target.files || e.dataTransfer.files;

		// 处理所有的文件
		for (var i = 0, f; f = files[i]; i++) {
			ParseFile(f);
		}

	}


	//输出文件信息
	function ParseFile(file) {

		Output(
			"<p>File information: <strong>" + file.name +
			"</strong> type: <strong>" + file.type +
			"</strong> size: <strong>" + file.size +
			"</strong> bytes</p>"
		);

	}
	// 初始化
	function Init() {

		var fileselect = $id("fileselect"),
			dropArea = $id("dropArea"),
			submitbutton = $id("submitbutton");

		// 选择文件
		fileselect.addEventListener("change", FileSelectHandler, false);

		// 判断XHR2是否可用
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {

			//放置文件
			dropArea.addEventListener("dragover", dropAreaHover, false);
			dropArea.addEventListener("dragleave", dropAreaHover, false);
			dropArea.addEventListener("drop", FileSelectHandler, false);
			dropArea.style.display = "block";
		}

	}

	// 调用初始化文件
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}


})();