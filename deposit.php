<?php
session_start();
include('conDB/server.php');

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>deposit</title>
    <link rel="stylesheet" href="style/style_deposit.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sriracha&display=swap" rel="stylesheet">
</head>

<body>
    <form method="post" action="deposit_db.php">
        <div class="section_area_grid">

            <body onLoad="initClock()">
                <div id="timedate">
                    <a id="h">12</a>:
                    <a id="m">00</a>:
                    <a id="s">00</a><br>
                    <a id="mon">January</a>
                    <a id="d">1</a>
                    <a id="y">0</a>
                </div>
                <h2>deposit</h2>
                <div class="dropdown" style="float: right; margin: 0 20px;">
                    <p id="dropbtn">username: <strong style="margin-right: 5px;"><?php echo $_SESSION['username']; ?></strong></p>
                </div>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a>
                <li><a href="deposit.php">deposit</a>
                <li><a href="withdraw.php">withdraw</a>
                <li><a href="listbank.php">list</a>
                <li><a href="index.php?logout='1'" style="color: red; text-decoration:none;">Logout</a>
            </ul>
        </nav>
        <div class="column">
            <div class="bon">
                <label for="deposit">กรอกจำนวนเงินฝาก</label>
                <div class="balance">$ <strong>
                        <?php
                        $errors = array();
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT * FROM users ";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($_SESSION['username'] == $row["username"]) {
                                    echo $row["money"];
                                }
                            }
                        }
                        mysqli_close($conn);
                        ?>
                    </strong></div>
                <input type="number" name="deposit" placeholder="">
                <div class="input-group">
                    <button type="submit" name="dps_bb" class="btn" onclick="<?php echo "return confirmdeposit()" ?>">deposit</button>
                    <script>
                        function confirmdeposit() {
                            let cancel = confirm("ยันยืนเพื่อทำการฝากไหม?")
                            if (cancel) {
                                alert("ได้ยันยืนการฝากเข้าระบบเเล้ว");
                            } else {
                                alert("ได้ยกเลิกการฝากเเล้ว!");
                            } return cancel
                        }
                    </script>
                </div>
            </div>
            <div>
            </div>
            <footer>
                <p class="main">
                    2023 © jaturaphum.s@ku.th | jaturaphum Suaprakhon | develop by <a href="https://github.com/Jaturaphum" target="_blank">Jaturaphum</a>
                </p>
            </footer>
    </form>
</body>
<script src="js/index.js"></script>
<script>
    Number.prototype.pad = function(n) {
        for (var r = this.toString(); r.length < n; r = 0 + r);
        return r;
    };

    function updateClock() {
        var now = new Date();
        var sec = now.getSeconds(),
            min = now.getMinutes(),
            hou = now.getHours(),
            mo = now.getMonth(),
            dy = now.getDate(),
            yr = now.getFullYear();
        var months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];
        var tags = ["mon", "d", "y", "h", "m", "s", ],
            corr = [months[mo], dy, yr, hou.pad(2), min.pad(2), sec.pad(2), ];
        for (var i = 0; i < tags.length; i++)
            document.getElementById(tags[i]).firstChild.nodeValue = corr[i];
    }

    function initClock() {
        updateClock();
        window.setInterval("updateClock()", 1);
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
</html>