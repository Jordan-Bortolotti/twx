


function toggleHide(cb)
{
	var box;
	
	switch (cb.id) {
    case "chkCardName":
        box = "cardNameCheckbox";
        break;
    case "chkCardSet":
        box = "cardSetCheckbox";
        break;
	case "chkCardCondition":
        box = "cardConditionCheckbox";
        break;
	case "chkExchangeType":
        box = "exchangeTypeCheckbox";
        break;		
	}
	if(cb.checked){
		document.getElementById(box).style.display = 'block';
	}
	else{
		document.getElementById(box).style.display = 'none';
	}
}

/*Listens for a click event and sets tags innerHTML to the referenced script output*
  Used in the About page to display legal_block.php output*/
function showhideXML(url, objID)
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
 httpReq.open('GET', url, true);
 httpReq.send(null);
}
