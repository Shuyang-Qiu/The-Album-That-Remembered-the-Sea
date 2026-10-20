<html>
<head>

<title>Database Set Up</title>
</head>
<body>

<?php
//connect to mysql

$servername = "localhost";
$username = "root";
$password = "";
//disable mysqli error report
mysqli_report(MYSQLI_REPORT_OFF);
// Create connection
//i here means improved
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error){
    //Print a message and terminate the current script:
    die("Connection failed: ".$conn->connect_error);
}

$sql = "CREATE DATABASE story";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully"."<br>";
} 
else {
    echo "Error creating database: " . $conn->error."<br>";
}

$sql = "USE story;";

if ($conn->query($sql) === TRUE) {
    echo "Database changed successfully"."<br>";
} 
else {
    echo "Error changing database: " . $conn->error."<br>";
}

$sql = "CREATE TABLE items (ID INT NOT NULL PRIMARY KEY, item BOOLEAN, other VARCHAR(255));";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully"."<br>";
} 
else {
    echo "Error creating table: " . $conn->error."<br>";
}

for($i=1;$i<52;$i++)
{
    $sql = "INSERT INTO items(ID, item) VALUES ($i, false)";
    $result = $conn->query($sql);

    if ($result) {
        echo "New record for id $i created successfully"."<br>";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
    }
}

echo "Create Database and Table successfully"."<br>";
$conn->close(); 
?> 

</body>
</html>
