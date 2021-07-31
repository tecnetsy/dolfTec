<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php


if (isset($userAdd)) {
  echo $userAdd;
}


 ?>


 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Add Bulk Users</h3>
        </div>
        <div class="cad-body">
            <div style="width:600px; margin:0px auto">
<b>Please Download template from <a href="./uploads/bulk_users_temp.csv">here</a> Fill it then upload it. </b>
            <table width="600">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

                <tr>
                <td width="20%">Select file</td>
                <td width="80%"><input class="form-control" type="file" name="file" id="file" /></td>
                </tr>

                    <tr>
                <td>Select user Role</td>
                <td>   
                    <select class="form-control" name="roleid" id="roleid">
                      <option value="1">Admin</option>
                      <option value="2">Editor</option>
                      <option value="3">User only</option>
                    </select>
                </td>
                </tr>
                <tr>
                <td></td>
                <td><input type="submit" name="import" value="Import" /></td>
                </tr>

                </form>
                </table>
          </div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['import'])) {
    if ( isset($_FILES["file"])) {

        //if there was an error uploading the file
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
    else {

         echo "Upload: " . $_FILES["file"]["name"] . "<br />";
         echo "Type: " . $_FILES["file"]["type"] . "<br />";
         echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
         echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

            $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
     if(in_array($_FILES['file']['type'],$mimes)){
        $temp = explode(".", $_FILES["file"]["name"]);
        $uploaded_file = round(microtime(true)) . '.' . end($temp);
        move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $uploaded_file);
        if ( isset($uploaded_file) && $file = fopen( "uploads/" . $uploaded_file , 'r' ) ) {

            echo "File opened.<br />";
        
            $firstline = fgets ($file, 4096 );
                //Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
            $num = strlen($firstline) - strlen(str_replace(",", "", $firstline));
        
                //save the different fields of the firstline in an array called fields
            $fields = array();
            $fields = explode( ",", $firstline, ($num+1) );
        
            $line = array();
            $i = 0;
        
                //CSV: one line is one record and the cells/fields are seperated by ";"
                //so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
            while ( $line[$i] = fgets ($file, 4096) ) {
        
                $dsatz[$i] = array();
                $dsatz[$i] = explode( ",", $line[$i], ($num+1) );
        
                $i++;
            }
        
                echo "<table>";
                echo "<tr>";
            for ( $k = 0; $k != ($num+1); $k++ ) {
                echo "<td>" . $fields[$k] . "</td>";
            }
                echo "</tr>";
        
            foreach ($dsatz as $key => $number) {
                        //new table row for every record
                    $data=array();
                    $data['name'] = $number[0];
                    $data['username'] = $number[1];
                    $data['email'] = $number[2];
                    $data['mobile'] = $number[4];
                    $data['password'] = $number[3];
                    $data['roleid'] = $_POST["roleid"];
                    //var_dump($data);
                    $userAdd = $users->addNewUserByAdmin($data);
                echo "<tr>";
                foreach ($number as $k => $content) {
                                //new table cell for every field of the record
                    echo "<td>" . $content . "</td>";
                }
                if($userAdd){
                    echo "<td> ".$userAdd." </td>";
                }
            }
        
            echo "</table>";
        }
            }else{
                echo "file type not CSV  <br />"; 
            }
        
    }
 } else {
         echo "No file selected <br />";
 }

}
?>

        </div>
      </div>

<?php
}else{

  header('Location:index.php');



}
 ?>

  <?php
  include 'inc/footer.php';

  ?>
