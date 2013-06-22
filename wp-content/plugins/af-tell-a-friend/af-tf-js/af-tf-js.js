
function af_tellafriendpopupwin(afURL,af_xSize,af_ySize)
{
sendMessageWindow=window.open(afURL,"messageWindow","scrollbars=no,menubar=no,height="+af_xSize+",width="+af_ySize+",resizable=no,toolbar=no, menubar=no, location=no,status=no");
	
}



function validateForm()
{
	
var x=document.forms["af_tf_form"]["sendername"].value;
if (x==null || x=="")
  {
  alert("Please write your name");
  sendername.style.background="yellow";
  sendername.focus();
  return false;
  }
	
var x=document.forms["af_tf_form"]["friendemail"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Your friend's email is not a valid e-mail address");
  friendemail.style.background="yellow";
  friendemail.focus();
  return false;
  }
  
  var x=document.forms["af_tf_form"]["youremail"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Your email is not a valid e-mail address");
  youremail.style.background="yellow";
  youremail.focus();
  return false;
  }
}

