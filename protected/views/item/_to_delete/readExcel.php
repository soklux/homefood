

<form action="UploadFile" method="post" enctype="multipart/form-data">
    <input type='file' name='fileUpload'>
    <input type='submit' name="btnread" value="Upload">
</form>



<?php

// if(@$data){
// echo "<table>";
//     foreach( @$data as $row ) {
//        echo "<tr>";
//        foreach( $row as $column )
//            echo "<td>$column</td>";
//        echo "</tr>";
//     }
// echo "</table>";
// }
	echo @$message;

?>