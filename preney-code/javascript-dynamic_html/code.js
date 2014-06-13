/* */

var curMoveByWindow = null;
var curColour = "#777";
var curCounter = 0;

function init()
{
}

function findObjectID(evt)
{
  var objID = (evt.target) ? evt.target.id
      : ((evt.srcElement) ? evt.srcElement.id : null);
  return objID;
}

function updateCounter()
{
  var obj = document.getElementById('counter');
  for (var i = obj.childNodes.length; i > 0; --i)
  {
    obj.removeChild(obj.childNodes[i-1]);
  }
  
  ++curCounter;
  var pElem = document.createElement('p');
  
  var aElem = document.createElement('a');
  aElem.setAttribute('href', 'javascript:updateCounter()');
  var aElemText = document.createTextNode('Update');
  aElem.appendChild(aElemText);
  
  var t1Elem = document.createTextNode(curCounter+' [ ');
  var t2Elem = document.createTextNode(' ]');
  pElem.appendChild(t1Elem);
  pElem.appendChild(aElem);
  pElem.appendChild(t2Elem);
  
  obj.appendChild(pElem);
}

function chooseCol(colour)
{
  curColour = colour;
}

function enableMoveBy(evt)
{
  curMoveByWindow = findObjectID(evt);
  if (curMoveByWindow)
  {
    var obj = document.getElementById(curMoveByWindow);
    if (obj != null)
      obj.style.zIndex = 1;
    else
      curMoveByWindow = null;
  }
}

function disableMoveBy()
{
  if (curMoveByWindow)
  {
    var obj = document.getElementById(curMoveByWindow);
    obj.style.zIndex = 0;
  }
  curMoveByWindow = null;
}

function toggleMoveBy(evt)
{
  if (curMoveByWindow != null && curMoveByWindow == findObjectID(evt))
  {
    var obj = document.getElementById(curMoveByWindow);
    obj.style.zIndex = 0;
    curMoveByWindow = null;
  } 
  else
  {
    curMoveByWindow = findObjectID(evt);
    if (curMoveByWindow != null)
    {
      var obj = document.getElementById(curMoveByWindow);
      if (obj != null)
        obj.style.zIndex = 1;
    }
  }
}

function moveBy(evt)
{
  if (curMoveByWindow != null && curMoveByWindow == findObjectID(evt))
  {
    evt = (evt) ? evt : ((window.event) ? window.event : null);
    var obj = document.getElementById(curMoveByWindow);
    obj.style.left = evt.clientX - (obj.offsetWidth / 2) + 'px';
    obj.style.top = evt.clientY - (obj.offsetHeight / 2) + 'px';
  }
  return;
}

function setCol(objID)
{
  bgCol(objID, curColour);
}

function bgCol(objectID, colour)
{
  var obj = document.getElementById(objectID);
  if (obj != null)
    obj.style.backgroundColor = colour;
}

function toggleVis(objectID)
{
  var obj = document.getElementById(objectID);
  if (obj != null)
    obj.style.visibility = (obj.style.visibility == "hidden")
      ? "visible" : "hidden";
}
