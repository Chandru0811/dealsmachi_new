<html>
</head> 
<body> 
<form name="sdklaunch" id="sdklaunch" 
action="{{ $href }}" method="POST"> 
<input type="hidden" id="bdorderid" name="bdorderid" value="{{ $bdorderid }}"> 
<input type="hidden" id="merchantid" name="merchantid" value="{{ $mercid }}"> 
<input type="hidden" id="rdata" name="rdata" value= 
"{{ $rdata }}"> 
<input name='submit' type='submit' value='Complete your Payment' />    
</form> 
<script> 
</script> 
</body> 
</html>