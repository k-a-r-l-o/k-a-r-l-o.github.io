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
    last_heartbeat TIMESTAMP NULL DEFAULT NULL,
    logged_out TINYINT(1) DEFAULT 0
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
    name_partylist VARCHAR(55) NOT NULL
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
    prty_ID INT,
    PRIMARY KEY(usep_ID),
    FOREIGN KEY (prty_ID) REFERENCES list_partylist(prty_ID)
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
    ('1', '2024-05-30', '12:00:00','Login')";

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
    position_slot INT,
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
$insertPos = "INSERT IGNORE INTO Positions (council_id, council_name, position_name, position_slot) VALUES 
    (1, 'SABES', 'Governor', 1),
    (1, 'SABES', 'Vice Governor', 1),
    (1, 'SABES', 'Secretary', 1),
    (1, 'SABES', 'Treasurer', 1),
    (1, 'SABES', 'Senator', 3),
    (1, 'SABES', 'Auditor', 1),
    (2, 'OFEE', 'Governor', 1),
    (2, 'OFEE', 'Vice Governor', 1),
    (2, 'OFEE', 'Secretary', 1),
    (2, 'OFEE', 'Treasurer', 1),
    (2, 'OFEE', 'Senator', 3),
    (2, 'OFEE', 'Auditor', 1),
    (3, 'AECES', 'Governor', 1),
    (3, 'AECES', 'Vice Governor', 1),
    (3, 'AECES', 'Secretary', 1),
    (3, 'AECES', 'Treasurer', 1),
    (3, 'AECES', 'Senator', 3),
    (3, 'AECES', 'Auditor', 1),
    (4, 'OFSET', 'Governor', 1),
    (4, 'OFSET', 'Vice Governor', 1),
    (4, 'OFSET', 'Secretary', 1),
    (4, 'OFSET', 'Treasurer', 1),
    (4, 'OFSET', 'Senator', 3),
    (4, 'OFSET', 'Auditor', 1),
    (5, 'AFSET', 'Governor', 1),
    (5, 'AFSET', 'Vice Governor', 1),
    (5, 'AFSET', 'Secretary', 1),
    (5, 'AFSET', 'Treasurer', 1),
    (5, 'AFSET', 'Senator', 9),
    (5, 'AFSET', 'Auditor', 1),
    (6, 'SITS', 'Governor', 1),
    (6, 'SITS', 'Vice Governor', 1),
    (6, 'SITS', 'Secretary', 1),
    (6, 'SITS', 'Treasurer', 1),
    (6, 'SITS', 'Senator', 3),
    (6, 'SITS', 'Auditor', 1),
    (7, 'FTVETTS', 'Governor', 1),
    (7, 'FTVETTS', 'Vice Governor', 1),
    (7, 'FTVETTS', 'Secretary', 1),
    (7, 'FTVETTS', 'Treasurer', 1),
    (7, 'FTVETTS', 'Senator', 1),
    (7, 'FTVETTS', 'Auditor', 1),
    (8, 'TSC', 'President', 1),
    (8, 'TSC', 'Vice President for Internal Affairs', 1),
    (8, 'TSC', 'Vice President for External Affairs', 1),
    (8, 'TSC', 'General Secretary', 1),
    (8, 'TSC', 'General Treasurer', 1),
    (8, 'TSC', 'General Auditor', 1),
    (8, 'TSC', 'Public Information Officer', 1);
";

if ($conn->query($insertPos) === TRUE) {
    echo "Table inserted into 'Positions' table successfully<br>";
} else {
    echo "Error inserting table into 'Positions' table: " . $conn->error . "<br>";
}


$sqltscvote = "INSERT IGNORE INTO TSC_VOTES (usep_ID, President, Vice_President_Internal_Affairs, Vice_President_External_Affairs, General_Secretary, General_Treasurer, General_Auditor, Public_Information_Officer) VALUES
('111111', 'Candidate_A', 'Candidate_B', 'Candidate_C', 'Candidate_D', 'Candidate_E', 'Candidate_F', 'Candidate_G'),
('222222', 'Candidate_H', 'Candidate_I', 'Candidate_J', 'Candidate_K', 'Candidate_L', 'Candidate_M', 'Candidate_N'),
('333333', 'Candidate_A', 'Candidate_B', 'Candidate_C', 'Candidate_D', 'Candidate_E', 'Candidate_F', 'Candidate_G'),
('444444', 'Candidate_O', 'Candidate_P', 'Candidate_Q', 'Candidate_R', 'Candidate_S', 'Candidate_T', 'Candidate_U'),
('555555', 'Candidate_H', 'Candidate_I', 'Candidate_J', 'Candidate_K', 'Candidate_L', 'Candidate_M', 'Candidate_N'),
('666666', 'Candidate_A', 'Candidate_B', 'Candidate_C', 'Candidate_D', 'Candidate_E', 'Candidate_F', 'Candidate_G'),
('777777', 'Candidate_V', 'Candidate_W', 'Candidate_X', 'Candidate_Y', 'Candidate_Z', 'Candidate_AA', 'Candidate_BB'),
('888888', 'Candidate_H', 'Candidate_I', 'Candidate_J', 'Candidate_K', 'Candidate_L', 'Candidate_M', 'Candidate_N')
";

if ($conn->query($sqltscvote) === TRUE) {
    echo "Sample data inserted into 'votes' table successfully<br>";
} else {
    echo "Error inserting data into 'votes' table: " . $conn->error . "<br>";
}

$sqlSITSvote = "INSERT IGNORE INTO SITS_VOTES (usep_ID, LC_Governor, Vice_Governor, Secretary, Treasurer, Senator1, Senator2, Senator3, Auditor) VALUES
('111111', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida'),
('222222', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida'),
('333333', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida'),
('444444', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida'),
('555555', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida'),
('666666', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida'),
('777777', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida'),
('888888', 'Lorjohn Rana', 'Dave Angelo Labad', 'Sweet Frachette Ang', 'Jackilyn Furog', 'Howard Glen Gloria', 'Sydney Pelino', 'Kisaiah Grace Torrenueva', 'Michael Labastida')
";

if ($conn->query($sqlSITSvote) === TRUE) {
    echo "Sample data inserted into 'SITS_VOTES' table successfully<br>";
} else {
    echo "Error inserting data into 'SITS_VOTES' table: " . $conn->error . "<br>";
}


$sqlSITSvote = "INSERT IGNORE INTO OFSET_VOTES (usep_ID, LC_Governor, Vice_Governor, Secretary, Treasurer, Senator1, Senator2, Senator3, Auditor) VALUES
('111111', 'Candidate_A', 'Candidate_B', 'Candidate_C', 'Candidate_D', 'Candidate_E', 'Candidate_F', 'Candidate_G', 'Candidate_H'),
('222222', 'Candidate_I', 'Candidate_J', 'Candidate_K', 'Candidate_L', 'Candidate_M', 'Candidate_N', 'Candidate_O', 'Candidate_P'),
('333333', 'Candidate_Q', 'Candidate_R', 'Candidate_S', 'Candidate_T', 'Candidate_U', 'Candidate_V', 'Candidate_W', 'Candidate_X'),
('444444', 'Candidate_Y', 'Candidate_Z', 'Candidate_AA', 'Candidate_BB', 'Candidate_CC', 'Candidate_DD', 'Candidate_EE', 'Candidate_FF'),
('555555', 'Candidate_GG', 'Candidate_HH', 'Candidate_II', 'Candidate_JJ', 'Candidate_KK', 'Candidate_LL', 'Candidate_MM', 'Candidate_NN'),
('666666', 'Candidate_OO', 'Candidate_PP', 'Candidate_QQ', 'Candidate_RR', 'Candidate_SS', 'Candidate_TT', 'Candidate_UU', 'Candidate_VV'),
('777777', 'Candidate_WW', 'Candidate_XX', 'Candidate_YY', 'Candidate_ZZ', 'Candidate_AAA', 'Candidate_BBB', 'Candidate_CCC', 'Candidate_DDD'),
('888888', 'Candidate_EEE', 'Candidate_FFF', 'Candidate_GGG', 'Candidate_HHH', 'Candidate_III', 'Candidate_JJJ', 'Candidate_KKK', 'Candidate_LLL')
";

if ($conn->query($sqlSITSvote) === TRUE) {
    echo "Sample data inserted into 'OFSET_VOTES' table successfully<br>";
} else {
    echo "Error inserting data into 'OFSET_VOTES' table: " . $conn->error . "<br>";
}





$conn->close();

?>

