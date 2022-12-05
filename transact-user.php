<?php
require_once 'conn.php';
require_once 'http.php';
if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'Login':
            if (isset($_POST['uname']) and isset($_POST['passwd'])) {
                $cnt = 0;
                $sql = "SELECT user_id,access_lvl,username " .
                "FROM login " .
                "WHERE username='" . $_POST['uname'] . "' " .
                "AND password='" . md5($_POST['passwd']) . "'";
                $result = mysqli_query($conn, $sql) or die('Could not look up member information; ' . mysqli_error());
                if ($row = mysqli_fetch_array($result)) {
                    session_start();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['access_lvl'] = $row['access_lvl'];
                    $_SESSION['name'] = $row['username'];

                    $tday = date('d');
                    $tyear = date('Y');
                    $tnow = date('m') . " " . date('Y');
                    $toda = date('Y-m-d');
                    $queryp = "SELECT  distinct `Account Number` FROM `transactions` WHERE `Remark`='Contribution Charge' and (day(`Date`)=" . $tday . ") order by `ID` desc";
                    $resultp = mysqli_query($conn, $queryp);

                    while (list($vacctno) = mysqli_fetch_row($resultp)) {
                        $querypp = "SELECT `ID`,`Date`,`Account Number`,`Withdrawal`,`Transaction Type` FROM `transactions` WHERE `Remark`='Contribution Charge' and (day(`Date`)=" . $tday . ") and `Account Number`='$vacctno' order by `ID` desc limit 0,1";
                        $resultpp = mysqli_query($conn, $querypp);
                        while (list($vid, $vdate, $vacctnod, $vamt, $vtrans) = mysqli_fetch_row($resultpp)) {

                            if ($vamt > 0 and $toda > $vdate) {
                                $query_insertC = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`)
                                       VALUES ('$vamt','Contribution Charge for $tnow','$toda','','$vacctno','Monthly Auto','Income')";
                                $result_insertC = mysqli_query($conn, $query_insertC);

                                $sqlC = "SELECT * FROM `transactions` WHERE `Account Number`='$vacctno' order by `ID` desc";
                                $resultC = mysqli_query($conn, $sqlC) or die('Could not look up user data; ' . mysqli_error());
                                $rowC = mysqli_fetch_array($resultC);

                                $balc = $rowC['Balance'];
                                $balC = $balc - $vamt;
                                $query_insertC1 = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`)
               VALUES ('$vacctno','$vamt','Auto Transaction','','Monthly Auto','$toda','Withdrawal','Contribution Charge','$balC')";
                                $result_insertC1 = mysqli_query($conn, $query_insertC1);
                            }
                        }
                    }
                    if (date('d') == 01) {
                        require_once 'monthlycharges.php';
                    }
                    #######
                    #            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
                    #            $result = mysqli_query($conn,$sql) or die('Could not fetch data; ' . mysqli_error());
                    #            $rows = mysql_fetch_array($result);
                    #
                    #            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`)
                    #                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Login','Logged In as: " . $_POST['uname'] . "')";
                    #
                    #            $result_insert_Log = mysqli_query($conn,$query_insert_Log) or die(mysqli_error());
                    #            ######
                    redirect('index.php');
                } else {
                    $tval = "Wrong Username or Password!";
                    redirect('index.php?tval=' . $tval);

                }
            }
            break;
        case 'Logout':
            session_start();
            session_unset();
            session_destroy();
            redirect('index.php');
            break;
        case 'Create Account':
            if ($_POST['name'] != ""
                and $_POST['e-mail'] != ""
                and $_POST['passwd'] != ""
                and $_POST['passwd2'] != ""
                and $_POST['passwd'] == $_POST['passwd2']) {
                $sql = "INSERT INTO login (email,username,password,access_lvl) " .
                "VALUES ('" . $_POST['e-mail'] . "','" .
                $_POST['name'] . "','" . md5($_POST['passwd']) . "','" . $_POST['accesslvl'] . "')";
                mysqli_query($conn, $sql);
                $tval = "New User Account Created!";
                header("location:index.php?tval=$tval&redirect=$redirect");
            } else {
                $tval = "Please fill in all parameters!";
                header("location:register.php?tval=$tval&redirect=$redirect");
            }
            break;
        case 'Modify Account':
            if ($_POST['name'] != ""
                and $_POST['e-mail'] != ""
                and $_POST['accesslvl'] != ""
                and $_POST['passwd'] != ""
                and $_POST['passwd2'] != ""
                and $_POST['passwd'] == $_POST['passwd2']
                and $_POST['user_id'] != "") {
                $sql = "UPDATE login " .
                "SET email='" . $_POST['e-mail'] .
                "', username='" . $_POST['name'] .
                "', password='" . md5($_POST['passwd']) .
                    "', access_lvl=" . $_POST['accesslvl'] . " " .
                    " WHERE user_id=" . $_POST['user_id'] . " and `username` not like 'control%'";
                mysqli_query($conn, $sql);
                $tval = "User Account Modified!";
                header("location:listing.php?tval=$tval&redirect=$redirect");
            } else {
                $tval = "Please fill in all parameters!";
                header("location:useraccount.php?UID=" . $_POST['user_id'] . "&tval=$tval&redirect=$redirect");
            }
            break;
        case 'Delete Account':
            if ($_POST['name'] != "") {
                $sql = "DELETE from login WHERE user_id=" . $_POST['user_id'] . " and `username` not like 'control%'";
                mysqli_query($conn, $sql);
                $tval = "User Account Deleted!";
                header("location:listing.php?tval=$tval&redirect=$redirect");
            } else {
                $tval = "Please fill in all parameters!";
                header("location:useraccount.php?UID=" . $_POST['user_id'] . "&tval=$tval&redirect=$redirect");
            }
            break;
        case 'Post':
            if ($_POST['dob_day'] != ""
                and $_POST['dob_month'] != ""
                and $_POST['dob_year'] != ""
                and $_POST['amount'] != ""
                and $_POST['command'] != ""
                and $_POST['bank'] != "") {
#$amount=number_format($amount,0);
                $sql = "INSERT INTO revenue (`DoB_Day`,`DoB_Month`,`DoB_Year`,Amount,Command,Bank,Location,`Amount Remitted`,`Date Remitted`,`Pending`) " .
                    "VALUES ('" . $_POST['dob_day'] . "','" . $_POST['dob_month'] . "','" . $_POST['dob_year'] . "'," .
                    $_POST['amount'] . ",'" . $_POST['command'] . "','" . $_POST['bank'] . "','" . $_POST['location'] . "'," . $_POST['amtremitted'] . ",'" . $_POST['dateremitted'] . "'," . $_POST['pending'] . ")";
                mysqli_query($conn, $sql);
                $tval = "New Record Posted!";
                header("location:cremit.php?tval=$tval&redirect=$redirect");
            } else {
                $tval = "Please fill in all parameters!";
                header("location:cremit.php?tval=$tval&redirect=$redirect");
            }
            break;
        case 'Modify':
            if ($_POST['dob_day'] != ""
                and $_POST['dob_month'] != ""
                and $_POST['dob_year'] != ""
                and $_POST['amount'] != ""
                and $_POST['command'] != ""
                and $_POST['bank'] != "") {
                $sql = "UPDATE revenue " .
                    "SET `DoB_Day`='" . $_POST['dob_day'] .
                    "', `DoB_Month`='" . $_POST['dob_month'] .
                    "', `DoB_Year`='" . $_POST['dob_year'] .
                    "', Amount='" . $_POST['amount'] .
                    "', Command='" . $_POST['command'] .
                    "', `Bank`='" . $_POST['bank'] .
                    "', `Pending`='" . $_POST['pending'] .
                    "', `Amount Remitted`='" . $_POST['amtremitted'] .
                    "', Location='" . $_POST['location'] .
                    "', `Amount Remitted`='" . $_POST['amtremitted'] . " " .
                    " WHERE ID=" . $_POST['id'];
                mysqli_query($conn, $sql);
                $tval = "Record Modified!";
                header("location:cremit.php?tval=$tval&redirect=$redirect");
            } else {
                $tval = "Please fill in all parameters!";
                header("location:cremit.php?ID=" . $_POST['id'] . "&tval=$tval&redirect=$redirect");
            }
            break;
        case 'Delete':
            if ($_POST['command'] != "") {
                $sql = "DELETE from `Revenue` WHERE ID=" . $_POST['id'];
                mysqli_query($conn, $sql);
                $tval = "Record Deleted!";
                header("location:cremit.php?tval=$tval&redirect=$redirect");
            } else {
                $tval = "Please fill in all parameters!";
                header("location:cremit.php?ID=" . $_POST['id'] . "&tval=$tval&redirect=$redirect");
            }
            break;
        case 'Register Me':
            $query_count = "SELECT * FROM `company info` WHERE `Company Name` = '" . $_POST['company'] . "' or `Email`='" . $_POST['e-mail'] . "' or `Phone`='" . $_POST['phone'] . "'";
            $result_count = mysqli_query($conn, $query_count);
            $tot = mysqli_num_rows($result_count);

            if ($tot > 0) {
                $tval = "DUPLICATE: A Similar Company info has been registered!";
                header("location:registerr.php?tval=$tval&redirect=$redirect");
            } else {

                if ($_POST['uname'] != ""
                    and $_POST['e-mail'] != ""
                    and $_POST['company'] != ""
                    and $_POST['passwd'] != ""
                    and $_POST['passwd2'] != ""
                    and $_POST['passwd'] == $_POST['passwd2']) {
                    $sql = "INSERT INTO login (email,username,password,access_lvl) " .
                    "VALUES ('" . $_POST['e-mail'] . "','" .
                    $_POST['uname'] . "','" . md5($_POST['passwd']) . "',5)";
                    mysqli_query($conn, $sql);

###############################################
                    $sqlt = "INSERT INTO `company info` (`Email`, `Company Name`, `Address`, `Phone`, `City`, `Country`)
VALUES ('" . $_POST['e-mail'] . "','" . $_POST['company'] . "','" . $_POST['address'] . "','" . $_POST['phone'] . "','" . $_POST['city'] . "','" . $_POST['country'] . "')";
                    mysqli_query($conn, $sqlt);

#######
                    if (!file_exists('images/')) {
                        mkdir('images/', 0777, true);
                    }

                    if (!empty($_FILES['image_filename']['name'])) {
                        if (file_exists("images/logo.jpg") == 1) {
                            $ImageNam = "images/logo.jpg";
                            $newfilenam = "images/" . date("Y-m-d") . "_logo.jpg";
                            rename($ImageNam, $newfilenam);
                        }
                        //make variables available
                        $image_userid = "logo";
                        $image_tempname = $_FILES['image_filename']['name'];
                        $today = date("Y-m-d");

                        //upload image and check for image type

                        $ImageDir = "images/";
                        $ImageName = $ImageDir . $image_tempname;
                        if (move_uploaded_file($_FILES['image_filename']['tmp_name'], $ImageName)) {
                            //get info about the image being uploaded
                            list($width, $height, $type, $attr) = getimagesize($ImageName);

                            $ext = ".jpg";

                            $newfilename = $ImageDir . "logo" . $ext;
                            rename($ImageName, $newfilename);
                        }
                    }
                    $tval = "Your User Account Has Been Created!";
                    header("location:index.php?tval=$tval&redirect=$redirect");
                } else {
                    $tval = "Please fill in all parameters!";
                    header("location:registerr.php?tval=$tval&redirect=$redirect");
                }

            }

            break;

        case 'Send my reminder!':
            if (isset($_POST['e-mail'])) {
                $sql = "SELECT password FROM tblMembers " .
                    "WHERE email='" . $_POST['e-mail'] . "'";
                $result = mysqli_query($conn, $sql)
                or die('Could not look up password; ' . mysqli_error());
                if (mysqli_num_rows($result)) {
                    $row = mysqli_fetch_array($result);
                    $subject = 'Password reminder';
                    $body = "Just a reminder, your password for the " .
                    " site is: " . $row['password'] .
                    "\n\nYou can use this to log in at http://" .
                    $_SERVER['HTTP_HOST'] .
                    dirname($_SERVER['PHP_SELF']) . '/';
                    mail($_POST['e-mail'], $subject, $body)
                    or die('Could not send reminder e-mail.');
                }
            }
            redirect('login.php');
            break;
        case 'Change my info':
            session_start();
            if ($_POST['name'] != ""
                and $_POST['e-mail'] != ""
                and isset($_SESSION['user_id'])) {
                $sql = "UPDATE login " .
                    "SET email='" . $_POST['e-mail'] .
                    "', username='" . $_POST['name'] . "' " .
                    "WHERE userid=" . $_SESSION['user_id'];
                mysqli_query($conn, $sql);
                redirect('cpanel.php');
            } else {
                $tval = "Please fill in all parameters!";
                header("location:cpanel.php?UID=" . $_SESSION['user_id'] . "&tval=$tval&redirect=$redirect");
            }
            break;
    }
}
