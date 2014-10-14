<?php 
    $dbh = new mysqli("localhost","root","","honeypot");
    $username = $_GET['Username'];
    //echo $username;
    
    if ($dbh->connect_errno) {
        die("Connection failed: (" . $dbh->connect_errno . ") " . $dbh->connect_error);
    } elseif (!($stmt = $dbh->prepare("SELECT * FROM tblusers WHERE UserName = ?"))) {
        die("Prepare failed: (" . $dbh->errno . ") " . $dbh->error);
    } elseif (!($stmt->bind_param('s', $username))) {
        die("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
    } elseif (!($stmt->execute())) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);   
    } elseif (!($result = $stmt->get_result())) {
        die("Fetching failed: (" . $stmt->errno . "( " . $stmt->error);
    } else {
        $data = $result->fetch_assoc();
        $result->close();
        $stmt->close();
    }
    
    
    
?>