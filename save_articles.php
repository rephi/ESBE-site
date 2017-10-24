<?php 
session_start();
print_r($_POST);
$code=$_POST['code'];
$name=$_POST['name'];
$descr=$_POST['descr'];
$oldprice=$_POST['oldprice'];
$promoprice=$_POST['promoprice'];
$qty=$_POST['qty'];
$weight=$_POST['weight'];
//$datecrea=$_POST['datecrea'];
$datecrea=date("Y-m-d");
$datestrt=$_POST['datestrt'];
$datefin=$_POST['datefin'];
if (isset($_POST['charity'])) {
	$charity=$_POST['charity'];
	$charityvalue=$_POST['charityvalue'];
} else {
	$charity=0;
	$charityvalue=0;
}	
$img_nbr=$_POST['img_nbr'];

//print_r($_FILES);
$filename=array();
$filesize=array();
$filetype=array();
for ($i=1;$i<=$img_nbr;$i++) {
	$filename[$i-1]=$_FILES['file'.$i]['name'];
	$filesize[$i-1]=$_FILES['file'.$i]['size'];
	$filetype[$i-1]=$_FILES['file'.$i]['type'];
}
print_r($filename);
print_r($filesize);
print_r($filetype);
/*
 $filename=$_FILES['file']['name'];
$filetype=$_FILES['file']['type'];
$filesize=$_FILES['file']['size']; 
*/
$_SESSION['CLOUDANT_DB']=$code;

?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="public/antixss.js" type="text/javascript"></script>

    <script>
    	//Submit data when enter key is pressed
        	var code = "<?php echo($code)?>"; 
        	var name = "<?php echo($name)?>";
        	var descr = "<?php echo($descr)?>";
        	var oldprice = parseFloat("<?php echo($oldprice)?>");
        	var promoprice = parseFloat("<?php echo($promoprice)?>");
        	var qty = parseInt("<?php echo($qty)?>"); 
        	var weight = parseFloat("<?php echo($weight)?>");
	       	var datecrpromo = "<?php echo($datecrea)?>";
        	var datestrt = "<?php echo($datestrt)?>";
        	var datefin = "<?php echo($datefin)?>";
        	var charity = parseInt("<?php echo($charity)?>");
            var charityvalue = parseFloat("<?php echo($charityvalue)?>");
			var filename=<?php echo json_encode($filename) ; ?>;
			var filetype=<?php echo json_encode($filetype); ?>;
			var filesize=<?php echo json_encode($filesize,JSON_NUMERIC_CHECK); ?>;
            var data="";
			var data_attachment="";
//console.log (filename + " "+ filetype +" "+ filesize);            
        	

         //   if (e.which == 13 && dateend.length > 0) {  //catch Enter key
            	//POST request to API to create a new visitor entry in the database

 				data=  JSON.stringify({_id: code, code: code, name: name, descr: descr, oldprice: oldprice, 
					  promoprice: promoprice, qty: qty, weight: weight, datecrpromo: datecrpromo, datestrt: datestrt, datefin: datefin, charity: charity, charityvalue: charityvalue})  
					//   _attachments: {filename : {content_type: filetype, revpos: 2, digest: "", length: filesize, stub: true} } });
				console.log(data);
				var file_name=filename[0];
				var file_size=filesize[0];
				var file_type=filetype[0];
				data_attachment=JSON.stringify({_id: code, _attachments: { file_name:{content_type: file_type, revpos: 2, digest: "", length: file_size, stub: true} } });
				console.log(data_attachment);
				  
                $.ajax({
				  method: "POST",
				  url: "./api/visitors",
				  datatype : "application/json",
				  data: data
				});

				var url="./"+code+"/"+code;
				$.ajax({
					method: "PUT",
					url:"",
					datatype: "application/json",
					data: data_attachment
				});

    </script>
