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

if ($conn->query($sqlUser) === TRUE) {
    echo "Table 'User' created successfully<br>";
} else {
    echo "Error creating table 'User': " . $conn->error . "<br>";
}

// Hash the password before inserting into the database
$input_password = 'Central1234'; // Define the password
$hashed_password = password_hash($input_password, PASSWORD_DEFAULT);

$sqlUserInsert = "INSERT IGNORE INTO Users (usep_id, username, userpass, LName, FName, usertype, User_status) VALUES
('1', 'Central', ?, 'Cornejo', 'Karl', 'Chairperson', 'Active')";


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

if ($conn->query($sqlListP) === TRUE) {
    echo "Table 'ListP' created successfully<br>";
} else {
    echo "Error creating table 'ListP': " . $conn->error . "<br>";
}

$sqlPrtyInsert = "INSERT IGNORE INTO List_Partylist (name_partylist) VALUES
('YANO')";

if ($conn->query($sqlPrtyInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}

$sqlListC = "CREATE TABLE IF NOT EXISTS List_Councils (
    council_ID INT UNIQUE KEY AUTO_INCREMENT,
    council_name VARCHAR(55) NOT NULL,
    program VARCHAR(55) NOT NULL,
    Cnl_level INT
)";

if ($conn->query($sqlListC) === TRUE) {
    echo "Table 'ListC' created successfully<br>";
} else {
    echo "Error creating table 'ListC': " . $conn->error . "<br>";
}

$sqlCnlInsert = "INSERT IGNORE INTO List_Councils (council_name, program, Cnl_level) VALUES
('TSC','All Programs', '1'),
('SABES','BSABE', '2'),
('OFEE','BEED', '2'),
('AECES','BECED', '2'),
('OFSET','BSNED', '2'),
('AFSET','BSED', '2'),
('SITS','BSIT', '2'),
('FTVETTS','BTVTED', '2')";

if ($conn->query($sqlCnlInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}


$sqlVotScd = "CREATE TABLE IF NOT EXISTS Voting_Schedule (
    startDate DATE,
    startTime TIME,
    endDate DATE,
    endTime TIME
)";

if ($conn->query($sqlVotScd) === TRUE) {
    echo "Table 'VotScd' created successfully<br>";
} else {
    echo "Error creating table 'VotScd': " . $conn->error . "<br>";
}


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

if ($conn->query($sqlCand) === TRUE) {
    echo "Table 'Cand' created successfully<br>";
} else {
    echo "Error creating table 'Cand': " . $conn->error . "<br>";
}


$sqlVoters = "CREATE TABLE IF NOT EXISTS Voters (
    usep_ID INT,
    LName VARCHAR(255) NOT NULL,
    FName VARCHAR(255) NOT NULL,
    gender VARCHAR(50) NOT NULL,
    yearLvl INT,
    program VARCHAR(55) NOT NULL,
    PRIMARY KEY(usep_ID)
)";

if ($conn->query($sqlVoters) === TRUE) {
    echo "Table 'Voters' created successfully<br>";
} else {
    echo "Error creating table 'Voters': " . $conn->error . "<br>";
}

$sqlVtrInsert = "INSERT IGNORE INTO Voters (usep_ID, LName, FName, gender, yearLvl, program) VALUES
('2022002', 'Cornejo', 'Karl', 'Male', '2nd Year', 'BSIT')";

if ($conn->query($sqlVtrInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}

$sqlProgram = "CREATE TABLE IF NOT EXISTS Programs (
    prgramID INT AUTO_INCREMENT,
    Program VARCHAR(255) NOT NULL,
    PRIMARY KEY(prgramID)
)";


if ($conn->query($sqlProgram) === TRUE) {
    echo "Table 'Program' created successfully<br>";
} else {
    echo "Error creating table 'Program': " . $conn->error . "<br>";
}

$sqlProgramInsert = "INSERT IGNORE INTO Programs(Program) VALUES
    ('BSABE'),
    ('BEED'),
    ('BECED'),
    ('BSNED'),
    ('BSED'),
    ('BSIT'),
    ('BTVTED')
;";

if ($conn->query($sqlProgramInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}


//Councils
$sql_TSC = "CREATE TABLE IF NOT EXISTS TSC_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    President VARCHAR(255) NOT NULL,
    Vice_President_Internal_Affairs VARCHAR(255) NOT NULL,
    Vice_President_External_Affairs VARCHAR(255) NOT NULL,
    General_Secretary VARCHAR(255) NOT NULL,
    General_Treasurer VARCHAR(255) NOT NULL,
    General_Auditor VARCHAR(255) NOT NULL,
    Public_Information_Officer VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_TSC) === TRUE) {
    echo "Table inserted into 'TSC' table successfully<br>";
} else {
    echo "Error inserting table into 'TSC' table: " . $conn->error . "<br>";
}

$sql_FTVETTS = "CREATE TABLE IF NOT EXISTS FTVETTS_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    LC_Governor VARCHAR(255) NOT NULL,
    Vice_Governor VARCHAR(255) NOT NULL,
    Secretary VARCHAR(255) NOT NULL,
    Treasurer VARCHAR(255) NOT NULL,
    Senator1 VARCHAR(255) NOT NULL,
    Senator2 VARCHAR(255) NOT NULL,
    Senator3 VARCHAR(255) NOT NULL,
    Auditor VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_FTVETTS) === TRUE) {
    echo "Table inserted into 'FTVETTS' table successfully<br>";
} else {
    echo "Error inserting table into 'FTVETTS' table: " . $conn->error . "<br>";
}

$sql_AECES = "CREATE TABLE IF NOT EXISTS AECES_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    LC_Governor VARCHAR(255) NOT NULL,
    Vice_Governor VARCHAR(255) NOT NULL,
    Secretary VARCHAR(255) NOT NULL,
    Treasurer VARCHAR(255) NOT NULL,
    Senator1 VARCHAR(255) NOT NULL,
    Senator2 VARCHAR(255) NOT NULL,
    Senator3 VARCHAR(255) NOT NULL,
    Auditor VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_FTVETTS) === TRUE) {
    echo "Table inserted into 'AECES' table successfully<br>";
} else {
    echo "Error inserting table into 'AECES' table: " . $conn->error . "<br>";
}


$sql_OFEE = "CREATE TABLE IF NOT EXISTS OFEE_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    LC_Governor VARCHAR(255) NOT NULL,
    Vice_Governor VARCHAR(255) NOT NULL,
    Secretary VARCHAR(255) NOT NULL,
    Treasurer VARCHAR(255) NOT NULL,
    Senator1 VARCHAR(255) NOT NULL,
    Senator2 VARCHAR(255) NOT NULL,
    Senator3 VARCHAR(255) NOT NULL,
    Auditor VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_OFEE) === TRUE) {
    echo "Table inserted into 'OFEE' table successfully<br>";
} else {
    echo "Error inserting table into 'OFEE' table: " . $conn->error . "<br>";
}

$sql_SITS = "CREATE TABLE IF NOT EXISTS SITS_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    LC_Governor VARCHAR(255) NOT NULL,
    Vice_Governor VARCHAR(255) NOT NULL,
    Secretary VARCHAR(255) NOT NULL,
    Treasurer VARCHAR(255) NOT NULL,
    Senator1 VARCHAR(255) NOT NULL,
    Senator2 VARCHAR(255) NOT NULL,
    Senator3 VARCHAR(255) NOT NULL,
    Auditor VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_SITS) === TRUE) {
    echo "Table inserted into 'SITS' table successfully<br>";
} else {
    echo "Error inserting table into 'SITS' table: " . $conn->error . "<br>";
}

$sql_AFSET = "CREATE TABLE IF NOT EXISTS AFSET_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    Major VARCHAR(255) NOT NULL,
    LC_Governor VARCHAR(255) NOT NULL,
    Vice_Governor VARCHAR(255) NOT NULL,
    Secretary VARCHAR(255) NOT NULL,
    Treasurer VARCHAR(255) NOT NULL,
    Senator1 VARCHAR(255) NOT NULL,
    Senator2 VARCHAR(255) NOT NULL,
    Senator3 VARCHAR(255) NOT NULL,
    Auditor VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_AFSET) === TRUE) {
    echo "Table inserted into 'AFSET' table successfully<br>";
} else {
    echo "Error inserting table into 'AFSET' table: " . $conn->error . "<br>";
}

$sql_OFSET = "CREATE TABLE IF NOT EXISTS OFSET_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    LC_Governor VARCHAR(255) NOT NULL,
    Vice_Governor VARCHAR(255) NOT NULL,
    Secretary VARCHAR(255) NOT NULL,
    Treasurer VARCHAR(255) NOT NULL,
    Senator1 VARCHAR(255) NOT NULL,
    Senator2 VARCHAR(255) NOT NULL,
    Senator3 VARCHAR(255) NOT NULL,
    Auditor VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_OFSET) === TRUE) {
    echo "Table inserted into 'OFSET_VOTES' table successfully<br>";
} else {
    echo "Error inserting table into 'OFSET_VOTES' table: " . $conn->error . "<br>";
}

$sql_SABES = "CREATE TABLE IF NOT EXISTS SABES_VOTES (
    vote_ID INT AUTO_INCREMENT,
    usep_ID INT,
    LC_Governor VARCHAR(255) NOT NULL,
    Vice_Governor VARCHAR(255) NOT NULL,
    Secretary VARCHAR(255) NOT NULL,
    Treasurer VARCHAR(255) NOT NULL,
    Senator1 VARCHAR(255) NOT NULL,
    Senator2 VARCHAR(255) NOT NULL,
    Senator3 VARCHAR(255) NOT NULL,
    Auditor VARCHAR(255) NOT NULL,
    PRIMARY KEY(vote_ID, usep_ID),
    FOREIGN KEY (usep_ID) REFERENCES Voters (usep_ID)
)";

if ($conn->query($sql_SABES) === TRUE) {
    echo "Table inserted into 'SABES_VOTES' table successfully<br>";
} else {
    echo "Error inserting table into 'SABES_VOTES' table: " . $conn->error . "<br>";
}


$conn->close();

?>

