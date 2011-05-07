/*
	Paginator 3000
	- idea by ecto (fhn.ru)
	- coded by karaboz (futurico.ru)
*/

Paginator = function(id, pagesTotal, pagesSpan, currentPage, baseUrl){
	this.htmlBox = $(id);
	if(!this.htmlBox || !pagesTotal || !pagesSpan) return;

	this.pagesTable;
	this.pagesTr; 
	this.sliderTr;
	this.pagesCells;
	this.slider;

	this.pagesTotal = pagesTotal;
	if(pagesSpan < pagesTotal){
		this.pagesSpan = pagesSpan;
	} else {
		this.pagesSpan = pagesTotal;
		addClass(this.htmlBox, 'fullsize');
	}

	this.currentPage = currentPage;
	this.firstCellValue;

	if(baseUrl){
		this.baseUrl = baseUrl;
	} else {
		this.baseUrl = "/pages/";
	}

	this.initPages();
	this.initSlider();
	this.drawPages();
	this.initEvents();

	this.scrollToCurrentPage();
	this.setCurrentPagePoint();
} 

Paginator.prototype.initPages = function(){
	var html = "<table><tr>" 
	for (var i=1; i<=this.pagesSpan; i++){
		html += "<td></td>"
	}
	html += "</tr>" +
	"<tr><td colspan='" + this.pagesSpan + "'>" +
	"<div class='scrollbar'>" + 
		"<div class='line'></div>" + 
		"<div class='current_page_point'></div>" + 
		"<div class='slider'>" + 
			"<div class='slider_point'></div>" + 
		"</div>" + 
	"</div>" +
	"</td></tr></table>"
	this.htmlBox.innerHTML = html;

	this.pagesTable = this.htmlBox.getElementsByTagName('table')[0];
	this.pagesTr = this.pagesTable.getElementsByTagName('tr')[0]; 
	this.sliderTr = this.pagesTable.getElementsByTagName('tr')[1];
	this.pagesCells = this.pagesTr.getElementsByTagName('td');
	this.scrollbar = getElementsByClassName(this.pagesTable, 'div', 'scrollbar')[0];
	this.slider = getElementsByClassName(this.pagesTable, 'div', 'slider')[0];
	this.currentPagePoint = getElementsByClassName(this.pagesTable, 'div', 'current_page_point')[0];
}

Paginator.prototype.initSlider = function(){
	this.slider.xPos = 0;
	this.slider.style.width = this.pagesSpan/this.pagesTotal * 100 + "%";	
}

Paginator.prototype.initEvents = function(){
	var _this = this;

	this.slider.onmousedown = function(e){
		if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();

		this.dx = getMousePosition(e).x - this.xPos;
		document.onmousemove = function(e){
			if (!e) var e = window.event;
			_this.slider.xPos = getMousePosition(e).x - _this.slider.dx;
			_this.setSlider();
			_this.drawPages();
		}
		document.onmouseup = function(){
			document.onmousemove = null;
			_this.enableSelection();
		}
		_this.disableSelection();
	}

	this.scrollbar.onmousedown = function(e){
		if(matchClass(_this.paginatorBox, 'fullsize')) return;

		if (!e) var e = window.event;
		_this.slider.xPos = getMousePosition(e).x - getPageX(_this.scrollbar) - _this.slider.offsetWidth/2;
		_this.setSlider();
		_this.drawPages();
	}

	addEvent(window, 'resize', resizePaginator);
}

Paginator.prototype.setSlider = function(){
	this.slider.style.left = this.slider.xPos + "px";

}

Paginator.prototype.drawPages = function(){

	var percentFromLeft;
	if(this.pagesTable.offsetWidth){
		percentFromLeft = this.slider.xPos/(this.pagesTable.offsetWidth);
	} else {
		percentFromLeft = 0;
	}

	this.firstCellValue = Math.round(percentFromLeft * this.pagesTotal);
	var html = "";
	if(this.firstCellValue < 1){
		this.firstCellValue = 1;
		this.slider.xPos = 0;
		this.setSlider();
	} else if(this.firstCellValue >= this.pagesTotal - this.pagesSpan) {
		this.firstCellValue = this.pagesTotal - this.pagesSpan + 1;
		this.slider.xPos = this.pagesTable.offsetWidth - this.slider.offsetWidth;
		this.setSlider();
	}
	for(var i=0; i<this.pagesCells.length; i++){
		var currentCellValue = this.firstCellValue + i;
		var prefixLength = String(this.pagesTotal).length - String(currentCellValue).length;
		var prefix = this.makePrefix(prefixLength);
		if(currentCellValue == this.currentPage){
			html = "<span>" + "<em>" + String(currentCellValue) + "</em>" + String(prefix) + "</span>";
		} else {
			html = "<span>" + "<a href='" + this.baseUrl + currentCellValue + "'>" + String(currentCellValue) + "</a>" + String(prefix) + "</span>";
		}
		this.pagesCells[i].innerHTML = html;
	}
}

Paginator.prototype.scrollToCurrentPage = function(){
	this.slider.xPos = (this.currentPage - Math.round(this.pagesSpan/2))/this.pagesTotal * this.pagesTable.offsetWidth;
	this.setSlider();
	this.drawPages();
}

Paginator.prototype.setCurrentPagePoint = function(){
	if(this.currentPage == 1){
		this.currentPagePoint.style.left = 0;
	} else {
		this.currentPagePoint.style.left = this.currentPage/this.pagesTotal * this.pagesTable.offsetWidth + "px";	
	}
}

Paginator.prototype.makePrefix = function(prefixLength){
	var prefix = "";
	for (var i=0; i<prefixLength; i++){
		prefix += "_";
	}
	return prefix;
}

Paginator.prototype.disableSelection = function(){
	document.onselectstart = function(){
		return false;
	}
	this.slider.focus();	
}

Paginator.prototype.enableSelection = function(){
	document.onselectstart = function(){
		return true;
	}
	this.slider.blur();		
}

resizePaginator = function (){
	if(typeof pag == 'undefined') return;

	pag.setCurrentPagePoint();
	pag.scrollToCurrentPage();
}

/*****************************
**   Misc functions
******************************/
function $(id){
	return document.getElementById(id);	
}
function addStyleProperties(cssStr){
	var head = document.getElementsByTagName('head')[0];
	var styleSheets = head.getElementsByTagName('style');
	var styleSheet = null;
	if (styleSheets.length){
		styleSheet = styleSheets[styleSheets.length-1];
	} else {
		styleSheet = document.createElement("style");
		styleSheet.setAttribute("type", "text/css");
		head.appendChild(styleSheet);	
	}
	
	if(styleSheet.styleSheet){ // IE
		styleSheet.styleSheet.cssText += cssStr;
	} else { // w3c
		styleSheet.appendChild(document.createTextNode(cssStr));
	}
}	
/*****************************
**   Event listeners
******************************/

function checkEvent(oEvt){
	oEvt=(oEvt) ? oEvt : ( (window.event) ? window.event : null );
	if(oEvt && oEvt.srcElement && !window.opera)
		oEvt.target=oEvt.srcElement;
	return oEvt;
}

function addEvent(objElement, strEventType, ptrEventFunc) {
	if (objElement.addEventListener)
		objElement.addEventListener(strEventType, ptrEventFunc, false);
	else if (objElement.attachEvent)
		objElement.attachEvent('on' + strEventType, ptrEventFunc);
}

function removeEvent(objElement, strEventType, ptrEventFunc) {
	if (objElement.removeEventListener) objElement.removeEventListener(strEventType, ptrEventFunc, false);
		else if (objElement.detachEvent) objElement.detachEvent('on' + strEventType, ptrEventFunc);
}

/*****************************
**   Common class methods
******************************/

function switchClass( objNode, strCurrClass, strNewClass ) {
	if ( matchClass( objNode, strNewClass ) ) replaceClass( objNode, strCurrClass, strNewClass );
		else replaceClass( objNode, strNewClass, strCurrClass );
}

function removeClass( objNode, strCurrClass ) {
	replaceClass( objNode, '', strCurrClass );
}

function addClass( objNode, strNewClass ) {
	replaceClass( objNode, strNewClass, '' );
}

function replaceClass( objNode, strNewClass, strCurrClass ) {
	var strOldClass = strNewClass;
	if ( strCurrClass && strCurrClass.length ){
		strCurrClass = strCurrClass.replace( /\s+(\S)/g, '|$1' );
		if ( strOldClass.length ) strOldClass += '|';
		strOldClass += strCurrClass;
	}
	objNode.className = objNode.className.replace( new RegExp('(^|\\s+)(' + strOldClass + ')($|\\s+)', 'g'), '$1' );
	objNode.className += ( (objNode.className.length)? ' ' : '' ) + strNewClass;
}

function matchClass( objNode, strCurrClass ) {
	return ( objNode && objNode.className.length && objNode.className.match( new RegExp('(^|\\s+)(' + strCurrClass + ')($|\\s+)') ) );
}

function getAncestorByClassName( oCurrentElement, sClassName, sTagName ) {
	var oCurrent = oCurrentElement.parentNode;
	while ( oCurrent.parentNode ) {
		if ( matchClass( oCurrent, sClassName ) && ( !sTagName || oCurrent.tagName.toLowerCase() == sTagName.toLowerCase() ) ) return oCurrent;
		oCurrent = oCurrent.parentNode;
	}
}

function getElementsByClassName(objParentNode, strNodeName, strClassName){
	var nodes = objParentNode.getElementsByTagName(strNodeName);
	if(!strClassName){
		return nodes;	
	}
	var nodesWithClassName = [];
	for(var i=0; i<nodes.length; i++){
		if(matchClass( nodes[i], strClassName )){
			//nodesWithClassName.push(nodes[i]);
			nodesWithClassName[nodesWithClassName.length] = nodes[i];
		}	
	}
	return nodesWithClassName;
}

function getElementsByClassNameFirstLevel(objParentNode, strNodeName, strClassName){
	var nodes = objParentNode.getElementsByTagName(strNodeName);

	if(!strClassName){
		nodesFirstLevel = [];
		for(var i=0; i<nodes.length; i++){
			if(nodes[i].parentNode.parentNode == objParentNode){
				nodesFirstLevel.push(nodes[i]);
			}	
		}
		return nodesFirstLevel;	
	}
	var nodesWithClassNameFirstLevel = [];
	for(var i=0; i<nodes.length; i++){
		if(matchClass(nodes[i], strClassName) && nodes[i].parentNode.parentNode == objParentNode){
			nodesWithClassNameFirstLevel.push(nodes[i]);
		}	
	}
	return nodesWithClassNameFirstLevel;
}

/*****************************
**   Some other methods
******************************/

function getPageY( oElement ) {
	var iPosY = oElement.offsetTop;
	while ( oElement.offsetParent != null ) {
		oElement = oElement.offsetParent;
		iPosY += oElement.offsetTop;
		if (oElement.tagName == 'BODY') break;
	}
	return iPosY;
}

function getPageX( oElement ) {
	var iPosX = oElement.offsetLeft;
	while ( oElement.offsetParent != null ) {
		oElement = oElement.offsetParent;
		iPosX += oElement.offsetLeft;
		if (oElement.tagName == 'BODY') break;
	}
	return iPosX;
}

function getMousePosition(e) {
	if (e.pageX || e.pageY){
		var posX = e.pageX;
		var posY = e.pageY;
	}else if (e.clientX || e.clientY) 	{
		var posX = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
		var posY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	}
	return {x:posX, y:posY}	
}



/*****************************
**   AJAX
******************************/

/*
	url - откуда загружаем
	ajaxCallBackFunction - что вызываем по завершении загрузки
	callObject - методом какого объекта является ajaxCallBackFunction (если это метод, а не глобальная фунция)
	params - параметры в виде объекта или массива
	ajaxCallBackErrorFunction - необязательная функция, обрабатывающая ошибки соединения
*/

function ajaxLoad(url, ajaxCallBackFunction, callObject, params, ajaxCallBackErrorFunction) {
	// branch for native XMLHttpRequest object
	if (window.XMLHttpRequest) {
		var ajaxObject = new XMLHttpRequest();
		ajaxObject.onreadystatechange = function(){
			ajaxLoadHandler(ajaxObject, ajaxCallBackFunction, callObject, params, ajaxCallBackErrorFunction);
		}
		ajaxObject.open("GET", url, true);
		ajaxObject.send(null);
	// branch for IE/Windows ActiveX version
	} else if (window.ActiveXObject) {
		var ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
		if (ajaxObject) {
			ajaxObject.onreadystatechange = function(){
				ajaxLoadHandler(ajaxObject, ajaxCallBackFunction, callObject, params, ajaxCallBackErrorFunction);
			}
			ajaxObject.open("GET", url, true);
			ajaxObject.send();
		}
	}
}

function ajaxLoadHandler(ajaxObject, ajaxCallBackFunction, callObject, params, ajaxCallBackErrorFunction){
	// only if req shows "complete"
	if (ajaxObject.readyState == 4) {
		// only if "OK"
		if (ajaxObject.status == 200) {
			// ...processing statements go here...
			ajaxCallBackFunction.call(callObject, ajaxObject, params);
		} else {
			if(ajaxCallBackErrorFunction){
				ajaxCallBackErrorFunction.call(callObject, ajaxObject);	
			} else {
				alert("There was a problem retrieving the XML data:\n" + ajaxObject.statusText);
			}
		}
	}
}


function ajaxLoadPost(url, data, ajaxCallBackFunction, callObject, params, ajaxCallBackErrorFunction) {
	var ajaxObject = null;
	
	if (window.XMLHttpRequest) { // branch for native XMLHttpRequest object
		ajaxObject = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // branch for IE/Windows ActiveX version
		var ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(ajaxObject){
		ajaxObject.onreadystatechange = function(){
			ajaxLoadHandler(ajaxObject, ajaxCallBackFunction, callObject, params, ajaxCallBackErrorFunction);
		}
		ajaxObject.open("POST", url, true);
		ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxObject.setRequestHeader("Content-length", data.length);
		ajaxObject.setRequestHeader("Connection", "close");
		ajaxObject.send(data);	
	}
}



/* Class inheritance */
Function.prototype.inheritFrom = function(BaseClass) { // thanks to Kevin Lindsey for this idea
  var Inheritance = function() {};
  Inheritance.prototype = BaseClass.prototype;

  this.prototype = new Inheritance();
  this.prototype.constructor = this;
  this.baseConstructor = BaseClass;
  this.superClass = BaseClass.prototype;
}


if(!Function.prototype.call) { // emulating 'call' function for browsers not supporting it (IE5)
	Function.prototype.call = function() {
		var oObject = arguments[0];
		var aArguments = [];
		var oResult;       
		oObject.fFunction = this;
		for (var i = 1; i < arguments.length; i++) {
			aArguments[aArguments.length] = 'arguments[' + i + ']';         
		}
		eval('oResult = oObject.fFunction(' + aArguments.join(',') + ')');
		oObject.fFunction = null;
		return oResult;
	}
};

