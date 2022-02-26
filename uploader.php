<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div>
<strong style="color:white;margin-left:4vh;"><?php if(isset($_GET['Rmessage'])) {echo $_GET['Rmessage'];} ?></strong>
<br>
<style>
table {
border: 1px solid;
margin-left:4vh;
width:95%;
}
td, tr {
border: 1px solid;
text-align: center;
}
</style>
<table>
<tr>
<td style="background-color: crimson;font-weight: bold;color:white;border:1px solid black;width:auto;">Name</td>
<td style="background-color: crimson;font-weight: bold;color:white;border:1px solid black;width:10%;">Choose Path</td>
<td style="background-color: crimson;font-weight: bold;color:white;border:1px solid black;width:10%;">View</td>
<td style="background-color: crimson;font-weight: bold;color:white;border:1px solid black;width:10%;">Delete</td>
</tr>
<?php
if (isset($_GET['DeleteFile'])) {
$file_DEL=$_GET['DeleteFile'];
unlink($file_DEL);
$RM_STR = str_replace("/Files","",$file_DEL);
$Returnmessage="The File : ".$RM_STR." has been deleted !";
header("Refresh:0; url=uploader.php?Rmessage=".$Returnmessage."");
}
else if (isset($_GET['DeleteFolder'])) {
$dir=$_GET['DeleteFolder'];
if (is_dir($dir)) {
$objects = scandir($dir);
foreach ($objects as $object) {
if ($object != "." && $object != "..") {
if (filetype($dir."/".$object) == "dir")
rmdir($dir."/".$object);
else unlink ($dir."/".$object);
}
}
reset($objects);
rmdir($dir);
}
$RM_STR = str_replace("/Files","",$dir);
$Returnmessage="The Folder : ".$RM_STR." has been deleted !";
header("Refresh:0; url=uploader.php?Rmessage=".$Returnmessage."");
}
else{
}
?>
<?php
$SPACEFORROW=0;
$iColor=1;
$files = array_diff(scandir(__DIR__ . "/Files/"), array('..', '.'));
foreach($files as $file)
{
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
if($SPACEFORROW>0)
{
$SPACEROW=str_repeat('&nbsp;', 2);
echo"<tr style='background-color:crimson;'><td >$SPACEROW</td><td>$SPACEROW</td><td>$SPACEROW</td><td>$SPACEROW</td></tr>";
}
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 1vh;font-weight:bold;'>$file</div></td><td><a style='color: crimson;font-weight: bold;' href='uploader.php?DIRSELECTOR=$file'>Upload Here</a></td><td></td><td><a style='color:blue' href='uploader.php?DeleteFolder=Files/$file'>Delete Folder</a></td></tr>";
$iColor++;
$SPACEFORROW++;

$files2 = array_diff(scandir(__DIR__ . "/Files/$file"), array('..', '.'));
foreach($files2 as $file2)
{
if(strpos($file2, ".pdf") || strpos($file2, ".PDF") || strpos($file2, ".jpg") || strpos($file2, ".txt") || strpos($file2, ".mp4"))
{
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 5vh;color:red;'> - $file2</div></td><td></td><td><a style='color: crimson;font-weight: bold;' href='/Tree-Library/Files/$file/$file2' target='_blank'>View Here</a></td><td><a style='color:blue' href='uploader.php?DeleteFile=Files/$file/$file2'>Delete File</a></td></tr>";
$iColor++;
}
else if (!strpos($file2, ".pdf") || !strpos($file2, ".PDF")|| !strpos($file2, ".jpg") || !strpos($file2, ".txt") || !strpos($file2, ".mp4"))
{
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 5vh;color:black;'> - $file2</div></td><td><a style='color: crimson;font-weight: bold;' href='uploader.php?DIRSELECTOR=$file&DIRSELECTOR2=$file2'>Upload Here</a></td><td></td><td><a style='color:blue' href='uploader.php?DeleteFolder=Files/$file/$file2'>Delete Folder</a></td></tr>";
$iColor++;
$files3 = array_diff(scandir(__DIR__ . "/Files/$file/$file2"), array('..', '.'));
foreach($files3 as $file3)
{
if(strpos($file3, ".pdf") || strpos($file3, ".PDF") || strpos($file3, ".jpg") || strpos($file3, ".txt") || strpos($file3, ".mp4"))
{
$SPACE=str_repeat('&nbsp;', 5);
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 5vh;color:blue;'> $SPACE + $file3</div></td><td></td><td><a style='color: crimson;font-weight: bold;' href='/Tree-Library/Files/$file/$file2/$file3' target='_blank'>View Here</a></td><td><a style='color:blue' href='uploader.php?DeleteFile=Files/$file/$file2/$file3'>Delete File</a></td></tr>";
$iColor++;
}
else if (!strpos($file3, ".pdf") || !strpos($file3, ".PDF")|| !strpos($file3, ".jpg") || !strpos($file3, ".txt") || !strpos($file3, ".mp4"))
{
$SPACE=str_repeat('&nbsp;', 5);
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 5vh;color:black;'> $SPACE - $file3</div></td><td><a style='color: crimson;font-weight: bold;' href='uploader.php?DIRSELECTOR=$file&DIRSELECTOR2=$file2&DIRSELECTOR3=$file3'>Upload Here</a></td><td></td><td><a style='color:blue' href='uploader.php?DeleteFolder=Files/$file/$file2/$file3'>Delete Folder</a></td></tr>";
$iColor++;
$files4 = array_diff(scandir(__DIR__ . "/LibraryFiles/$file/$file2/$file3"), array('..', '.'));
foreach($files4 as $file4)
{
	if(strpos($file4, ".pdf") || strpos($file4, ".PDF") || strpos($file4, ".jpg") || strpos($file4, ".txt") || strpos($file4, ".mp4"))
{
$SPACE=str_repeat('&nbsp;', 5);
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 5vh;color:blue;'> $SPACE  $SPACE + $file4</div></td><td></td><td><a style='color: crimson;font-weight: bold;' href='/Tree-Library/Files/$file/$file2/$file3/$file4' target='_blank'>View Here</a></td><td><a style='color:blue' href='uploader.php?DeleteFile=Files/$file/$file2/$file3/$file4'>Delete File</a></td></tr>";
$iColor++;
}
else if (!strpos($file4, ".pdf") || !strpos($file4, ".PDF")|| !strpos($file4, ".jpg") || !strpos($file4, ".txt") || !strpos($file4, ".mp4"))
{
$SPACE=str_repeat('&nbsp;', 5);
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 5vh;color:blue;'> $SPACE  $SPACE + $file4</div></td><td></td><td></td><td><a style='color:blue' href='uploader.php?DeleteFolder=Files/$file/$file2/$file3/$file4'>Delete Folder</a></td></tr>";
$iColor++;
}
}
}
}
}
else {
$bg_color = $iColor % 2 === 0 ? "#e1e6ed" : "white";
echo "<tr style='background-color: ". $bg_color .";'><td><div style='text-align:left;margin-left: 5vh;'> - $file2</div></td><td></td><td></td><td><a style='color:blue' href='uploader.php?DeleteFile=Files/$file/$file2'>Delete File</a></td></tr>";
$iColor++;
}
}
}
?>
</table>
</div>
<br>
<div class="modal fadeIn" id="myModal" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button style="margin-top: 1vh !important;margin-right: -1.5vh !important;" type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Uploader</h4>
</div>
<div class="modal-body">
<br>
<form name="form" method="post" action="upload.php" enctype="multipart/form-data" >
<input required type="file" name="fileToUpload" /><br /><br />
<input style="width:45vh;"readonly required type="text" value="<?php
if (isset($_GET['DIRSELECTOR3'])) {
echo $_GET['DIRSELECTOR'];
echo '/';
echo $_GET['DIRSELECTOR2'];
echo '/';
echo $_GET['DIRSELECTOR3'];
}
else if (isset($_GET['DIRSELECTOR2'])) {
echo $_GET['DIRSELECTOR'];
echo '/';
echo $_GET['DIRSELECTOR2'];
}
else if (isset($_GET['DIRSELECTOR'])) {
echo $_GET['DIRSELECTOR'];
}
else {
echo '';
}
?>" id="MYCUSTOMPATH" name="MYCUSTOMPATH" />
<br>
<input type="checkbox" id="CUSTOM" name="CUSTOM" onclick="checkCUSTOM();">
<label for="CUSTOM">Enable Custom Folder</label>
<br />
<input type="submit"/>
</form>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>

</div>
</div>
</div>

<?php if(isset($_GET['DIRSELECTOR2']) || isset($_GET['DIRSELECTOR'])) { ?>
<script>
jQuery(document).ready(function($){
$('#myModal').modal('show')
});
</script>
<?php } ?>
<script>
function checkCUSTOM()
{
if (document.getElementById('CUSTOM').checked)
{
document.getElementById('MYCUSTOMPATH').readOnly = false;
} else {
document.getElementById('MYCUSTOMPATH').readOnly = true;
}
}
</script>
</body>
</html>