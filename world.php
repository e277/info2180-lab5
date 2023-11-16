<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);


$lookup = false;
$country = '';

if (isset($_GET['country'])) {
    $country = $_GET['country'];
    $country = filter_var($country, FILTER_SANITIZE_SPECIAL_CHARS);
}

if (isset($_GET['lookup'])) {
    $lookup = true;
}

try {
    if ($country == '' && $lookup != true) {
        $stmt = $conn->query("SELECT * FROM countries");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Continent</th>";
        echo "<th>Independence</th>";
        echo "<th>Head of State</th>";
        echo "</tr>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['continent'] . "</td>";
            echo "<td>" . $row['independence_year'] . "</td>";
            echo "<td>" . $row['head_of_state'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else if ($country != '' && $lookup != true) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(["country" => "%" . $country . "%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table>";
        echo "<tr>";
        echo "<th>Country Name</th>";
        echo "<th>Continent</th>";
        echo "<th>Independence</th>";
        echo "<th>Head of State</th>";
        echo "</tr>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['continent'] . "</td>";
            echo "<td>" . $row['independence_year'] . "</td>";
            echo "<td>" . $row['head_of_state'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else if ($country != '' && $lookup == true) {
        $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population FROM cities JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE :country");
        $stmt->execute(["country" => "%" . $country . "%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table>";
        echo "<tr>";
        echo "<th>City Name</th>";
        echo "<th>District</th>";
        echo "<th>Population</th>";
        echo "</tr>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['district'] . "</td>";
            echo "<td>" . $row['population'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        $lookup = false;

    } else {
        echo '<p style="color: red; font-weight: bold;">Enter Country to see cities!!!</p>';
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

