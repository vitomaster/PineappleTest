<!-- This file contains admin web page. Here admin can check what data is in database. -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="admin.php" method="post" >
    <input type="text" name="search">
    <input type="checkbox" name="DB[]" id="" value="fullMail"> Full e-mail name
    <input type="checkbox" name="DB[]" id="" value="mailName"> Only mail name
    <input type="checkbox" name="DB[]" id="" value="mailDomain"> Only mail domain
    <input type="checkbox" name="DB[]" id="" value="currentTime"> Show Time
    <select name="select" id="">
        <option name='up' value="up"></option>
        <option name='' value="down"></option>
    </select>
    <br>
    <button name="submit" type="submit" style="width: 50px; height:25px">search</button>
    <?php 

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $DB = "mails";
        

        function searchDB($servername,$username,$password,$DB,$getData,$getSearch){
            $connection = new mysqli($servername,$username,$password,$DB);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
             }
       
            $sql = "SELECT $getData FROM subs";
            
            $result = $connection->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<br>'.
                    '<form action="admin.php" method="post">'.
                    $getData.": ".$row[$getData]." ".'<button name="delete" type="submit" style="width: 50px; height:25px">delete</button>'.
                    '</form>';
                }
            }
                $connection->close();
        }
        
        function deleteDB($servername,$username,$password,$DB,$setDelete,$getData){
            $connection = new mysqli($servername,$username,$password,$DB);
            
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql = "DELETE FROM $getData WHERE subs = '$setDelete'";

            if($connection->query($sql)){
                echo "Record deleted successfully";
                } else {
                echo "Error deleting record: " . $connection->error;
                }
        }

        if(isset($_POST['submit'])){
            if (!empty($_POST['search'])){
                $getSearch = $_POST['search'];
            }
            if(!empty($_POST['DB'])){
                foreach($_POST['DB'] as $getData){
                    searchDB($servername,$username,$password,$DB,$getData,$getSearch);
                }
                // $getData = $_POST['DB'];
            }
            if(isset($_POST['delete'])){
                $setDelete = $_POST['delete'];
                deleteDB($servername,$username,$password,$DB,$setDelete,$getData);
            }
        } else {
            echo 'sorry';
        }
        ?>
    </form>

</body>
</html>
