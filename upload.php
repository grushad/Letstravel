<?php 

$servername = 'localhost';
    $username = 'root';
    $password = '';
    $db='Letstravel';
    $conn = mysqli_connect($servername,$username,$password,$db);
    
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }


if(isset($_POST['create'])){

	$startDate=$_POST['startDate'];
	$endDate=$_POST['endDate'];
	$basePrice=$_POST['basePrice'];
	$tgName=$_POST['tgName'];
	$tgCont=$_POST['tgCont'];
	$status=1;
	$createdBy="shivaneej02@gmail.com";

	$thumbnail=$_FILES['tn-uploaded'];
  $itinerary=$_FILES['it-uploaded'];

  $tripId=$thumbnail['name'];

  $tnName=$thumbnail['name'];
  $itName=$itinerary['name'];

  //echo $startDate." ".$endDate." ".$basePrice." ".$tgName." ".$tgCont." ".$status." ".$createdBy." ".$tripId;


	$sql="INSERT INTO trip (TripId,Image,BasePrice,Status,Itinerary,StartDate,EndDate,CreatedBy,GuideName,GuideContact) VALUES ('".$tripId."','".$tnName."',".$basePrice.",".$status.",'".$itName."','".$startDate."','".$endDate."','".$createdBy."','".$tgName."','".$tgCont."')";


  $tnExt=explode('.', $tnName);
  $tnActualExt=strtolower(end($tnExt));

  $itExt=explode('.', $itName);
  $itActualExt=strtolower(end($itExt));

  $allowedTn=array('jpg','jpeg','png');
  $allowedIt=array('pdf','txt');

  $itStatus=0;
  $tnStatus=0;

       if ($conn->query($sql) === TRUE) 
				{    				
                    //echo "inserted";
				} 
				else 
				{
    				echo "Error: " . $sql . "<br>" . $conn->error;
				}


  if(in_array($tnActualExt, $allowedTn)){
  	if($thumbnail['error']===0){

  		$fileDestTn='uploads/'.$thumbnail['name'];

  		move_uploaded_file($thumbnail['tmp_name'], $fileDestTn);
  		$tnStatus=1;
  	}else{
  		echo "Error uploading image file!";
  	}
  }else{
  	echo "You cannot upload files of this type!";
  }

  if(in_array($itActualExt, $allowedIt)){
  	if($itinerary['error']===0){
  		
  		$fileDestIt='uploads/'.$itinerary['name'];
  		
  		move_uploaded_file($itinerary['tmp_name'], $fileDestIt);
  		$itStatus=1;
  		
  	}else{
  		echo "Error uploading text file!";
  	}
  }else{
  	echo "You cannot upload files of this type!";
  }

  if($tnStatus==1 && $itStatus==1){
  	header("Location: admindashboard.html?uploadsuccess");
  }

}
?>