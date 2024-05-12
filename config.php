<?php
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "CREATE DATABASE IF NOT EXISTS Voting_System";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully <br>";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn);
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "Voting_System";

$conn = new mysqli($servername, $username, $password, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlUser = "CREATE TABLE IF NOT EXISTS Users (
    usep_ID INT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    userpass VARCHAR(255) NOT NULL,
    LName VARCHAR(255) NOT NULL,
    FName VARCHAR(255) NOT NULL,
    usertype VARCHAR(50) NOT NULL,
    User_status VARCHAR(50) NOT NULL
)";

// Hash the password before inserting into the database
$input_password = 'Central1234'; // Define the password
$hashed_password = password_hash($input_password, PASSWORD_DEFAULT);

$sqlUserInsert = "INSERT INTO Users (usep_id, username, userpass, LName, FName, usertype, User_status) VALUES
('1', 'Central', ?, 'Cornejo', 'Karl', 'Chairperson', 'Active')";

if ($conn->query($sqlUser) === TRUE) {
    echo "Table 'User' created successfully<br>";
} else {
    echo "Error creating table 'User': " . $conn->error . "<br>";
}

// Prepare the insert statement
$stmtInsert = $conn->prepare($sqlUserInsert);

// Bind parameters and execute the insert statement
$stmtInsert->bind_param("s", $hashed_password);
if ($stmtInsert->execute()) {
    echo "Central Admin Account inserted into 'User' table successfully<br>";
    echo "Username: Central<br>";
    echo "Password: Central1234<br>";
    echo "User Type: Chairperson<br>";
} else {
    echo "Error inserting data into 'User' table: " . $conn->error . "<br>";
}

$sqlListP = "CREATE TABLE IF NOT EXISTS List_Partylist (
    prty_ID INT UNIQUE KEY AUTO_INCREMENT,
    name_partylist VARCHAR(55) NOT NULL,
    num_members INT DEFAULT 0
)";

$sqlPrtyInsert = "INSERT INTO List_Partylist (name_partylist) VALUES
('YANO')";

$sqlListC = "CREATE TABLE IF NOT EXISTS List_Councils (
    council_ID INT UNIQUE KEY AUTO_INCREMENT,
    council_name VARCHAR(55) NOT NULL,
    program VARCHAR(55) NOT NULL,
    Cnl_level INT
)";

$sqlCnlInsert = "INSERT INTO List_Councils (council_name, program, Cnl_level) VALUES
('SITS','BSIT', '2')";

$sqlVotScd = "CREATE TABLE IF NOT EXISTS Voting_Schedule (
    startDate DATE,
    startTime TIME,
    endDate DATE,
    endTime TIME
)";

$sqlCand = "CREATE TABLE IF NOT EXISTS Candidates (
    usep_ID INT,
    candPic VARCHAR(255) NOT NULL,
    LName VARCHAR(255) NOT NULL,
    FName VARCHAR(255) NOT NULL,
    gender VARCHAR(50) NOT NULL,
    yearLvl INT,
    program VARCHAR(55) NOT NULL,
    position VARCHAR(55) NOT NULL,
    partylist VARCHAR(55) NOT NULL,
    PRIMARY KEY(usep_ID)
)";

$sqlVoters = "CREATE TABLE IF NOT EXISTS Voters (
    usep_ID INT,
    LName VARCHAR(255) NOT NULL,
    FName VARCHAR(255) NOT NULL,
    gender VARCHAR(50) NOT NULL,
    yearLvl INT,
    program VARCHAR(55) NOT NULL,
    PRIMARY KEY(usep_ID)
)";

$sqlVtrInsert = "INSERT INTO Voters (usep_ID, LName, FName, gender, yearLvl, program) VALUES
('2022002', 'Cornejo', 'Karl', 'Male', '2nd Year', 'BSIT')";

$sqlProgram = "CREATE TABLE IF NOT EXISTS Programs (
    prgramID INT AUTO_INCREMENT,
    Program VARCHAR(255) NOT NULL,
    PRIMARY KEY(prgramID)
)";

$sqlProgramInsert = "INSERT INTO Programs(Program) VALUES
    ('BSABE'),
    ('BEED'),
    ('BECED'),
    ('BSNED'),
    ('BSED'),
    ('BSIT'),
    ('BTVTED')
;";



if ($conn->query($sqlUser) === TRUE) {
    echo "Table 'User' created successfully<br>";
} else {
    echo "Error creating table 'User': " . $conn->error . "<br>";
}

if ($conn->query($sqlListP) === TRUE) {
    echo "Table 'ListP' created successfully<br>";
} else {
    echo "Error creating table 'ListP': " . $conn->error . "<br>";
}

if ($conn->query($sqlListC) === TRUE) {
    echo "Table 'ListC' created successfully<br>";
} else {
    echo "Error creating table 'ListC': " . $conn->error . "<br>";
}

if ($conn->query($sqlVotScd) === TRUE) {
    echo "Table 'VotScd' created successfully<br>";
} else {
    echo "Error creating table 'VotScd': " . $conn->error . "<br>";
}

if ($conn->query($sqlCand) === TRUE) {
    echo "Table 'Cand' created successfully<br>";
} else {
    echo "Error creating table 'Cand': " . $conn->error . "<br>";
}

if ($conn->query($sqlVoters) === TRUE) {
    echo "Table 'Voters' created successfully<br>";
} else {
    echo "Error creating table 'Voters': " . $conn->error . "<br>";
}

if ($conn->query($sqlProgram) === TRUE) {
    echo "Table 'Program' created successfully<br>";
} else {
    echo "Error creating table 'Program': " . $conn->error . "<br>";
}

if ($conn->query($sqlProgramInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}

if ($conn->query($sqlPrtyInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}
if ($conn->query($sqlCnlInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}

if ($conn->query($sqlVtrInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}



$conn->close();

?>

