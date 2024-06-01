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
    User_status VARCHAR(50) NOT NULL,
    last_heartbeat TIMESTAMP NULL DEFAULT NULL
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
('1', 'Central', ?, 'Cornejo', 'Karl', 'Chairperson', 'Inactive')";


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
    prty_ID INT PRIMARY KEY AUTO_INCREMENT,
    name_partylist VARCHAR(55) NOT NULL,
    num_members INT DEFAULT 0
)";

if ($conn->query($sqlListP) === TRUE) {
    echo "Table 'ListP' created successfully<br>";
} else {
    echo "Error creating table 'ListP': " . $conn->error . "<br>";
}

$sqlPrtyInsert = "INSERT IGNORE INTO List_Partylist (prty_ID, name_partylist) VALUES
('1', 'Independent')";

if ($conn->query($sqlPrtyInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}

$sqlListC = "CREATE TABLE IF NOT EXISTS List_Councils (
    council_ID INT UNIQUE KEY,
    council_name VARCHAR(55) NOT NULL,
    program VARCHAR(55) NOT NULL,
    Cnl_level INT
)";

if ($conn->query($sqlListC) === TRUE) {
    echo "Table 'ListC' created successfully<br>";
} else {
    echo "Error creating table 'ListC': " . $conn->error . "<br>";
}

$sqlCnlInsert = "INSERT IGNORE INTO List_Councils (council_ID, council_name, program, Cnl_level) VALUES
    ('1', 'SABES', 'BSABE', '2'),
    ('2', 'OFEE', 'BEED', '2'),
    ('3', 'AECES', 'BECED', '2'),
    ('4', 'OFSET', 'BSNED', '2'),
    ('5', 'AFSET', 'BSED', '2'),
    ('6', 'SITS', 'BSIT', '2'),
    ('7', 'FTVETTS', 'BTVTED', '2'),
    ('8', 'TSC', 'ALL PROGRAMS', '1');";

if ($conn->query($sqlCnlInsert) === TRUE) {
    echo "Data inserted into 'List_Councils' table successfully<br>";
} else {
    echo "Error inserting data into 'List_Councils' table: " . $conn->error . "<br>";
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
    yearLvl VARCHAR(50) NOT NULL,
    program VARCHAR(55) NOT NULL,
    council VARCHAR(55) NOT NULL,
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
    Email VARCHAR(255) NOT NULL,
    LName VARCHAR(255) NOT NULL,
    FName VARCHAR(255) NOT NULL,
    gender VARCHAR(50) NOT NULL,
    yearLvl VARCHAR(50) NOT NULL,
    program VARCHAR(55) NOT NULL,
    voted VARCHAR(55) NOT NULL,
    PRIMARY KEY(usep_ID)
)";

if ($conn->query($sqlVoters) === TRUE) {
    echo "Table 'Voters' created successfully<br>";
} else {
    echo "Error creating table 'Voters': " . $conn->error . "<br>";
}

$sqlVtrInsert = "INSERT IGNORE INTO Voters (usep_ID, Email, LName, FName, gender, yearLvl, program, voted) VALUES
('202200294','kocornejo00294@usep.edu.ph', 'Cornejo', 'Karl', 'Male', '2nd Year', 'BSIT', 'Not Voted')";

if ($conn->query($sqlVtrInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}

$sqlProgram = "CREATE TABLE IF NOT EXISTS Programs (
    prgramID INT,
    Program VARCHAR(255) NOT NULL,
    PRIMARY KEY(prgramID)
)";


if ($conn->query($sqlProgram) === TRUE) {
    echo "Table 'Program' created successfully<br>";
} else {
    echo "Error creating table 'Program': " . $conn->error . "<br>";
}

$sqlProgramInsert = "INSERT IGNORE INTO Programs(prgramID, Program) VALUES
    ('1', 'BSABE'),
    ('2', 'BEED'),
    ('3', 'BECED'),
    ('4', 'BSNED'),
    ('5', 'BSED'),
    ('6', 'BSIT'),
    ('7', 'BTVTED')
;";

if ($conn->query($sqlProgramInsert) === TRUE) {
    echo "Data inserted into 'Program' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}



$sqlLogs = "CREATE TABLE IF NOT EXISTS Activity_Logs(
    usep_ID INT,
    logs_date DATE,
    logs_time TIME,
    logs_action VARCHAR(50) NOT NULL,
    FOREIGN KEY (usep_ID) REFERENCES Users(usep_ID)
)";

if ($conn->query($sqlLogs) === TRUE) {
    echo "Data inserted into 'Activity Logs' table successfully<br>";
} else {
    echo "Error inserting data into 'Program' table: " . $conn->error . "<br>";
}

$sqlInsertLogs = "INSERT INTO Activity_Logs (usep_ID, logs_date, logs_time, logs_action) VALUES 
    ('1', '2024-05-30', '12:00:00','Login'),
    ('202200181', '2024-05-30', '12:10:00', 'Login')";

if ($conn->query($sqlInsertLogs) === TRUE) {
    echo "Sample data inserted into 'Activity_Logs' table successfully<br>";
} else {
    echo "Error inserting data into 'Activity_Logs' table: " . $conn->error . "<br>";
}


$sqlPos = "CREATE TABLE IF NOT EXISTS Positions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    council_id INT,
    council_name VARCHAR(55) NOT NULL,
    position_name VARCHAR(50) NOT NULL,
    FOREIGN KEY (council_id) REFERENCES List_Councils( council_ID)
)";
if ($conn->query($sqlPos) === TRUE) {
    echo "Sample data inserted into 'Positions' table successfully<br>";
} else {
    echo "Error inserting data into 'Positions' table: " . $conn->error . "<br>";
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

if ($conn->query($sql_AECES) === TRUE) {
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

// Positions
$insertPos = "INSERT IGNORE INTO Positions (council_id, council_name, position_name) VALUES 
    (1, 'SABES', 'Governor'),
    (1, 'SABES', 'Vice Governor'),
    (1, 'SABES', 'Secretary'),
    (1, 'SABES', 'Treasurer'),
    (1, 'SABES', 'Senator'),
    (1, 'SABES', 'Auditor'),
    (2, 'OFEE', 'Governor'),
    (2, 'OFEE', 'Vice Governor'),
    (2, 'OFEE', 'Secretary'),
    (2, 'OFEE', 'Treasurer'),
    (2, 'OFEE', 'Senator'),
    (2, 'OFEE', 'Auditor'),
    (3, 'AECES', 'Governor'),
    (3, 'AECES', 'Vice Governor'),
    (3, 'AECES', 'Secretary'),
    (3, 'AECES', 'Treasurer'),
    (3, 'AECES', 'Senator'),
    (3, 'AECES', 'Auditor'),
    (4, 'OFSET', 'Governor'),
    (4, 'OFSET', 'Vice Governor'),
    (4, 'OFSET', 'Secretary'),
    (4, 'OFSET', 'Treasurer'),
    (4, 'OFSET', 'Senator'),
    (4, 'OFSET', 'Auditor'),
    (5, 'AFSET', 'Governor'),
    (5, 'AFSET', 'Vice Governor'),
    (5, 'AFSET', 'Secretary'),
    (5, 'AFSET', 'Treasurer'),
    (5, 'AFSET', 'Senator'),
    (5, 'AFSET', 'Auditor'),
    (6, 'SITS', 'Governor'),
    (6, 'SITS', 'Vice Governor'),
    (6, 'SITS', 'Secretary'),
    (6, 'SITS', 'Treasurer'),
    (6, 'SITS', 'Senator'),
    (6, 'SITS', 'Auditor'),
    (7, 'FTVETTS', 'Governor'),
    (7, 'FTVETTS', 'Vice Governor'),
    (7, 'FTVETTS', 'Secretary'),
    (7, 'FTVETTS', 'Treasurer'),
    (7, 'FTVETTS', 'Senator'),
    (7, 'FTVETTS', 'Auditor'),
    (8, 'TSC', 'President'),
    (8, 'TSC', 'Vice President for Internal Affairs'),
    (8, 'TSC', 'Vice President for External Affairs'),
    (8, 'TSC', 'General Secretary'),
    (8, 'TSC', 'General Treasurer'),
    (8, 'TSC', 'General Auditor'),
    (8, 'TSC', 'Public Information Officer');
";

if ($conn->query($insertPos) === TRUE) {
    echo "Table inserted into 'Positions' table successfully<br>";
} else {
    echo "Error inserting table into 'Positions' table: " . $conn->error . "<br>";
}


$sqltscvote = "INSERT INTO TSC_VOTES (usep_ID, President, Vice_President_Internal_Affairs, Vice_President_External_Affairs, General_Secretary, General_Treasurer, General_Auditor, Public_Information_Officer) VALUES
('202200151', 'Candidate_A', 'Candidate_B', 'Candidate_C', 'Candidate_D', 'Candidate_E', 'Candidate_F', 'Candidate_G'),
('202200152', 'Candidate_H', 'Candidate_I', 'Candidate_J', 'Candidate_K', 'Candidate_L', 'Candidate_M', 'Candidate_N'),
('202200153', 'Candidate_A', 'Candidate_B', 'Candidate_C', 'Candidate_D', 'Candidate_E', 'Candidate_F', 'Candidate_G'),
('202200154', 'Candidate_O', 'Candidate_P', 'Candidate_Q', 'Candidate_R', 'Candidate_S', 'Candidate_T', 'Candidate_U'),
('202200155', 'Candidate_H', 'Candidate_I', 'Candidate_J', 'Candidate_K', 'Candidate_L', 'Candidate_M', 'Candidate_N'),
('202200156', 'Candidate_A', 'Candidate_B', 'Candidate_C', 'Candidate_D', 'Candidate_E', x`'Candidate_F', 'Candidate_G'),
('202200157', 'Candidate_V', 'Candidate_W', 'Candidate_X', 'Candidate_Y', 'Candidate_Z', 'Candidate_AA', 'Candidate_BB'),
('202200158', 'Candidate_H', 'Candidate_I', 'Candidate_J', 'Candidate_K', 'Candidate_L', 'Candidate_M', 'Candidate_N');
";

if ($conn->query($sqltscvote) === TRUE) {
    echo "Sample data inserted into 'votes' table successfully<br>";
} else {
    echo "Error inserting data into 'votes' table: " . $conn->error . "<br>";
}





$conn->close();

?>

