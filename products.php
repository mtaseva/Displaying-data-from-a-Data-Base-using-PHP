<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Working with Data Base</title>

    <style>

        table {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        th, td {
            border: 1px solid black;
            text-align: center;
        }

    </style>

</head>
<body>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "product";

    // Kreirame konekcija
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Ispituvame dali konekcijata e uspesna
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $podnesenaForma = false;

    // echo "Connected successfully";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = mysqli_real_escape_string($conn, $_POST['ime']);
        $price = mysqli_real_escape_string($conn, $_POST['cena']);
        $manufacturer = mysqli_real_escape_string($conn, $_POST['mr']);
        $country_of_origin = mysqli_real_escape_string($conn, $_POST['co']);

        $sql = "INSERT INTO product (name, price, manufacturer, country_of_origin) VALUES ('$name', '$price', '$manufacturer', '$country_of_origin')";

        if(mysqli_query($conn, $sql)) {
            // echo "<p>Noviot produkt e uspesno dodaden!</p>";
            // $podnesenaForma = true;
            header("Location: " . $_SERVER['PHP_SELF']);    // po kliknuvanje na reload ne se pravi povtorno dodavanje na zapis vo tabelata vo bazata na podatoci
            exit;   // so ova se osiguruvame deka nema da se izvrsi ostanatiot del od kodot i so toa da ne se dobie neocekuvan izlez vo formata
        } else {
            echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }

        // mysqli_query($conn, $sql);
    }

    // if($podnesenaForma) {

        $sql = "SELECT * FROM product";
        $result = mysqli_query($conn, $sql);

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Manufacturer</th>
                    <th>Country_of_origin</th>
                </tr>";
            
        if(mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {

                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['manufacturer']}</td>
                        <td>{$row['country_of_origin']}</td>
                    </tr>";

            }

        } else {
                echo "<tr><td colspan='5'>No products found.</td></tr>";
        }

        echo "</table>";

    // }

    mysqli_close($conn);

    ?>

       <form action="" method="post">
    
        <p><b>Add a new product:</b></p>

        <p>Name:
            <input type="text" name="ime" required>
        </p>

        <p>Price:
            <input type="number" step="0.01" name="cena" required>
        </p>

        <p>Manufacturer:
            <input type="text" name="mr" required>
        </p>

        <p>Country of origin:
            <input type="text" name="co" required>
        </p>

        <p><input type="submit" value="Add new"></p>
        
    </form>

</body>
</html>