function submitData() {
	var dataToTransfer;              
	var idData;
	var first = true;
	var regionval='';
	var inputElements = document.getElementsByTagName("input");				
	   for(count = 0; count < inputElements.length; count ++) {
		if(inputElements[count].name.match("child") || inputElements[count].name.match("parent")) {
			if(inputElements[count].checked == true) { 
				var value =  inputElements[count].value;							
				var checkbox_id = $(inputElements[count]).attr("id");
                regionval += value;			
				if(first) {
					first = false;
					dataToTransfer = value;
					idData = checkbox_id;
				}else {
					dataToTransfer = dataToTransfer +" , "+value;
					idData = idData +" , "+checkbox_id;
									
				}  
				
			}
		} 
	}
	if(idData==undefined){ idData = "";}
	document.parentForm.map_values.value = idData;
	if(dataToTransfer==undefined){ dataToTransfer = ""; }
	document.parentForm.myTextBox.value = dataToTransfer;
	//window.close();
	var datalength = dataToTransfer.split(","); 
	var lenthvalue=datalength.length;
	var pagesval=[];
	for(i=0;i < lenthvalue;i++)
	{
	 var str=datalength[i].substr((datalength[i].length-3),datalength[i].length);
	 str=str.replace(/^\s+|\s+$/g,'');
	 pagesval.push(str);
	}

	if(($.inArray("NA",pagesval)) != -1)
	{ 
	
	$("#NA").show();
	$("#EU").hide();
	}
	if(($.inArray("EU",pagesval)) != -1)
	{ 
	
	$("#EU").show();
	$("#NA").hide();
	}
	if(($.inArray("NA",pagesval)) != -1 && ($.inArray("EU",pagesval)) != -1)
	{ 
	
	$("#EU").show();
	$("#NA").show();
	}
	
	$(".simplemodal-close").click();
}

function checkParent() {
	checkAllParent(this);
}

function checkAllParent(child) {

	var parentCheckBox;
	var allChecked = true;
	var inputList = child.parentNode.parentNode.getElementsByTagName("input");
	//alert(inputList);
	var temp=0;
	for(var index = 0; index < inputList.length; index ++) {
		if(parentCheckBox == null && inputList[index].name.match("grand_parent")) {
			parentCheckBox = inputList[index];                 
			 parentCheckBox.checked = allChecked;   
		}
		if(inputList[index].name.match("child")) {
			if(inputList[index].checked == false) {
				allChecked = false;
			}    
		}
	}
   
	if(child.parentNode.className !="tree") {
		checkAllParent(child.parentNode.parentNode); 
	}
}

function markOrUnmark() {  
	
	//var get_check_one = $('input:checkbox[name=top_id]:checked').val(); 
	var checkBoxList = this.parentNode.getElementsByTagName("input");
	
	for(var index = 0; index < checkBoxList.length ; index ++) {				
		/*if(checkBoxList[index].name.match("child")  || checkBoxList[index].name.match("parent") ||  checkBoxList[index].name.match("grand_parent") ||  
		checkBoxList[index].name.match("parent_1")) {
			checkBoxList[index].checked = this.checked;
		}*/
	}
	
	//checkAllParent(this.parentNode);
}

function expandOrCloseChild(child) {
	if(child!=undefined){
		child.className = child.className == "child"?"childExpand":"child";
	}
}

function changeOperator(operator) {
	operator.innerHTML = operator.innerHTML == '+'? '-':'+';
}

function expandOrCollapse() {
	changeOperator(this);
	var childList = this.parentNode.getElementsByTagName("div");
	if(childList != null) {
		expandOrCloseChild(childList[0]);
	}
}

function attachEventForChild() {
	var childs = document.getElementsByName("child");  
	//alert(childs.length);
	for(var index=0; index < childs.length; index ++) {
//                  childs[index].onclick = checkParent;
	}
}

function attacheEventForGrandParent() {
	var parents = document.getElementsByName("grand_parent");
//				alert(parents.length);
	for(var index=0; index < parents.length; index ++) {
		parents[index].onclick= markOrUnmark;

	}
}

function attacheEventForParent() {
	var parents = document.getElementsByName("parent");
	//alert(parents.length);
	for(var index=0; index < parents.length; index ++) {
		parents[index].onclick= markOrUnmark;

	}
}

function attacheEventForParent_1() {
	var parents = document.getElementsByName("parent_1");
	//alert(parents.length);
	for(var index=0; index < parents.length; index ++) {
		parents[index].onclick= markOrUnmark;

	}
}

function attachEventForOperator() {                
	var spanElements = document.getElementsByTagName("span");
	for(var index=0; index < spanElements.length; index ++) {
		if(spanElements[index].className.match("operator")){
			spanElements[index].onclick= expandOrCollapse;
		}
	}
}

function attachEvents() {	
	attachEventForOperator();
	attacheEventForGrandParent();
	attacheEventForParent();
	attacheEventForParent_1();
	attachEventForChild();
}