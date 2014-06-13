/* */

function getData(url, objID)
{
  var httpReq = null;

  if (window.XMLHttpRequest)
    httpReq = new XMLHttpRequest();
  else if (window.ActiveObject)
    httpReq = new ActiveXObject("Microsoft.XMLHTTP");
  else
    return false;

  httpReq.onreadystatechange = function()
  {
    var obj = document.getElementById(objID);
    obj.innerHTML = httpReq.responseText;
  }

  httpReq.open('GET',url,true);
  httpReq.send(null);
}

