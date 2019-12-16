<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Withdraw</title>
    </head>
    <body>
        <?php

        function getBalance() {
            //https://www.w3schools.com/php/php_mysql_select.asp
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "online_bank";

// Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT balance FROM accounts where id = 167 ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $ret = $row["balance"];
                }
            } else {
                $ret = "0 results";
            }

            $conn->close();

            return $ret;
        }

        function setBalance($balance) {
            require_once('Db.php');
            Db::connect('127.0.0.1', 'online_bank', 'root', '');

            Db::query('
                UPDATE accounts SET balance = ( ? ) where id = 167', $balance);
        }

        function withdraw($amount) {
            $balance = getBalance();
            if ($amount <= $balance) {
                $balance = $balance - $amount;
                echo "You have withdrawn: $amount";
                setBalance($balance);
            } else {
                echo "Insufficient funds.";
            }
        }

        function withdraw_sem($amount) {
            $balance = getBalance();
            $sem = sem_get(1234, 1);
            if (sem_acquire($sem)) {
                $balance = getBalance();
                if ($amount <= $balance) {
                    $balance = $balance - $amount;
                    echo "You have withdrawn: $amount";
                    setBalance($balance);
                } else {
                    echo "Insufficient funds.";
                }
                sem_release($sem);
            }
        }

//         timing 1-10 secs
//        $nanoseconds = rand(5000000, 20000000);
//        $seconds = rand(1, 10);
//        time_nanosleep( $seconds, $nanoseconds);
//
//        withdraw($_GET['balance']);
        
        withdraw_sem($_GET['balance']);
        ?>
    </body>
</html>

