<head>

<title>ZFYL DEVELOPER ZIPPER</title>
<style>
.contain {
  display:block;
  background-color:#f0f0f0;
  padding:15px;
  width:50%;
  margin-left: 25%;
  max-width:800px;
}
.contain b{
  margin-top:20px;
  width:80%;
  display:block;
}
.contain b,.text,.select {
  margin-left:8%;
}
.text, .select {
margin-top:20px;
width: 80%;
background-color:#fafafa;
height: 50px;
font-size: 25px;
padding:5px;
}
.selecta {
margin-top:20px;
width:80%;
height:50px;
padding:5px;
font-size: 25px;
background-color:#fafafa;
}
.button {
  width:80%;
  height:50px;
  margin: 20px 0 0 10%;
}
textarea.text {
  height:150px;
}


</style>
</head>

<body>

<form action="zipper.php" method="GET" class="contain">
<b>Time from, to look for changes:</b>
<input class='text' name='from_date' value='2016-07-29 15:52:00' type="text"/><br/>
<b>Directories to skip(like cache or session):</b>
<textarea class='text' class='text' name='skip' placeholder="directory names enclosed with '/' and separated by ';'----leav blank for no skips" type="text"></textarea><br/>
<b>Directory to zip(current dir [<?php echo getcwd(); ?>]):</b><input class='text' value="<?php echo getcwd(); ?>" name='dir2zip' type="text"/><br/>
<select name="mode" class='select'>
<option value="default">Do ZIP AND SHOW ZIPPED</option>
<option value="show-only">JUST SHOW ZIPPABLE FILES LIST</option>
</select><br/>
<input name="key" type="password" placeholder="security_key" class="text"/><br/>

<input type="submit" class="button" value="ZIP EM' ALL!" />


</form>



</body>
