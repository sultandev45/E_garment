<?php
function extractSqlStatements($filePath, $createTableOutputPath, $insertDataOutputPath) {
    // Read the input SQL file
    $sqlContent = file_get_contents($filePath);
    if ($sqlContent === false) {
        die("Error reading the input file.");
    }

    // Use regular expressions to find all CREATE TABLE and INSERT INTO statements
    $createTablePattern = '/CREATE TABLE .*?;(\r\n|\r|\n)/s';
    $insertDataPattern = '/INSERT INTO .*?;(\r\n|\r|\n)/s';

    preg_match_all($createTablePattern, $sqlContent, $createTableMatches);
    preg_match_all($insertDataPattern, $sqlContent, $insertDataMatches);

    // Write the CREATE TABLE statements to the new SQL file
    if (!empty($createTableMatches[0])) {
        $createTableResult = file_put_contents($createTableOutputPath, implode("\n", $createTableMatches[0]));
        if ($createTableResult === false) {
            die("Error writing to the output file for CREATE TABLE statements.");
        }
    } else {
        die("No CREATE TABLE statements found in the input file.");
    }

    // Write the INSERT INTO statements to the new SQL file
    if (!empty($insertDataMatches[0])) {
        $insertDataResult = file_put_contents($insertDataOutputPath, implode("\n", $insertDataMatches[0]));
        if ($insertDataResult === false) {
            die("Error writing to the output file for INSERT INTO statements.");
        }
    }

    // Print the number of CREATE TABLE statements and the statements themselves on the screen
    $tableCount = count($createTableMatches[0]);
    echo "<h2>Extracted CREATE TABLE Statements</h2>";
    echo "<p>Number of tables: $tableCount</p>";
    foreach ($createTableMatches[0] as $createTableStatement) {
        echo "<pre>$createTableStatement</pre>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['sqlfile'])) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['sqlfile']['name']);

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($_FILES['sqlfile']['tmp_name'], $uploadFile)) {
        echo "File is valid, and was successfully uploaded.<br>";

        // Define the output file paths
        $createTableOutputFile = 'createtables.sql';
        $insertDataOutputFile = 'insertdata.sql';

        // Call the function to extract CREATE TABLE and INSERT INTO statements
        extractSqlStatements($uploadFile, $createTableOutputFile, $insertDataOutputFile);
    } else {
        echo "Possible file upload attack!<br>";
    }
} else {
    echo "No file uploaded or invalid request method.<br>";
}
?>
