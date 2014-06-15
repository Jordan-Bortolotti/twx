


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


