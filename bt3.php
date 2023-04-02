<!DOCTYPE html>
<html>
<head>
<style>
		table {
			margin: 0 auto;
		}
		body {
			/* display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh; */
      text-align: center;
      font-size: 16pt;
		}
    td {
      text-align: left;
      padding: 5px;
      font-weight: bold;
      font-family: Roboto, Arial, Helvetica, sans-serif;
    }

    input, button {
      padding: 2px;
      font-size: 16pt;
      width: 300px;
    }

    .dob {
      width: 50px;
      text-align: center;
    }
    
	</style>
</head>
<body>
<form action ="bt3.php" method = "POST">
<table border = "1" cellspacing="0" cellpadding="0">
<tr><td>Họ tên</td><td colspan="3"><input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"></td></tr>
<tr><td>Mật khẩu</td><td colspan="3"><input type="text" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>"></td></tr>
<tr><td>Nhập lại mật khẩu</td><td colspan="3"><input type="text" name="retypedPassword" value="<?php echo isset($_POST['retypedPassword']) ? $_POST['retypedPassword'] : ''; ?>"></td></tr>
<tr>
  <td>Ngày sinh</td>
  <td style="text-align: center;"><input class="dob" type="text" name="dd-dob" placeholder="dd" value="<?php echo isset($_POST['dd-dob']) ? $_POST['dd-dob'] : ''; ?>"></td>
  <td style="text-align: center;"><input class="dob" type="text" name="mm-dob" placeholder="mm" value="<?php echo isset($_POST['mm-dob']) ? $_POST['mm-dob'] : ''; ?>"></td>
  <td style="text-align: center;"><input class="dob" type="text" name="yyyy-dob" placeholder="yyyy" value="<?php echo isset($_POST['yyyy-dob']) ? $_POST['yyyy-dob'] : ''; ?>"></td>
</tr>

<tr><td>Email</td><td colspan="3"><input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"></td></tr>
<tr>
  <td colspan="4" style="text-align: center;">
  <input style="width: 200px; color: green; font-weight: bold;" type="submit" name = "submit">
  <!-- <button style="width: 200px; color: red; font-weight: bold;" type="reset" name = "reset">Clear form</button> -->
  </td>
</tr>
</table>
</form>

<?php

function checkInputOnlySpaces($input) {
  for ($i = 0; $i < strlen($input); $i++) {
    if ($input[$i] != ' ') {
      return false;
    }
  }
  return true;
}

function validateInput($input) {
  $isValid = true;
  
  // Check if input contains only alphabetic characters and spaces
  for ($i = 0; $i < strlen($input); $i++) {
    if (!ctype_alpha($input[$i]) && !ctype_space($input[$i])) {
      $isValid = false;
      break;
    }
  }
  
  return $isValid;
}

function checkMinLength($input) {
  if (strlen(trim($input)) < 6 ) {
    return false;
  } else {
    return true;
  }
}

function checkInputName($hoTen) {
  if (empty($hoTen) || checkInputOnlySpaces($hoTen)) {
    echo "<p style='color: red;'> Họ tên không được để trống!</p>";
  }else if (!validateInput(trim($hoTen))) {
    echo "<p style='color: red;'> Họ tên chỉ được chứa chữ (không dấu) và khoảng trống!</p>";
  }else {
    echo "<p style='color: green;'> Họ tên đã nhập hợp lệ! </p>";
  }
}


function checkInputPassword($password, $retypedPass) {
  $passwordPassed = true;
  if (empty($password) || checkInputOnlySpaces($password)) {
    echo "<p style='color: red;'> Mật khẩu không được để trống!</p>";
    $passwordPassed = false;
  }else {
    if (!checkMinLength(trim($password))) {
      echo "<p style='color: red;'> Mật khẩu phải có độ dài ít nhất 6 kí tự!</p>";
      $passwordPassed = false;
    }
    
    $numberCount = 0;
    $alphaCount = 0;
    $specialCharCount = 0;

    for($i = 0; $i < strlen(trim($password)); $i++) {
      if (is_numeric(trim($password)[$i])) {
        $numberCount++;
      }
      if (ctype_alpha(trim($password)[$i])) {
        $alphaCount++;
      }
      if (!ctype_alnum(trim($password)[$i])) {
        $specialCharCount++;
      }
    }
    if ($numberCount == 0) {
      echo "<p style='color: red;'> Mật khẩu phải bao gồm ít nhất 1 chữ số!</p>";
      $passwordPassed = false;
    }
    if ($alphaCount == 0) {
      echo "<p style='color: red;'> Mật khẩu phải bao gồm ít nhất 1 chữ cái!</p>";
      $passwordPassed = false;
    }
    if ($specialCharCount == 0) {
      echo "<p style='color: red;'> Mật khẩu phải bao gồm ít nhất 1 kí tự đặc biệt!</p>";
      $passwordPassed = false;
    }
  }

  if($passwordPassed) {
    echo "<p style='color: green;'> Mật khẩu đã nhập hợp lệ!</p>";

    if (empty($retypedPass)) {
      echo "<p style='color: red;'> Mật khẩu nhập lại không được để trống!</p>";
    }
    if (!empty($retypedPass) && !(trim($password) === trim($retypedPass))) {
      echo "<p style='color: red;'> Hai mật khẩu đã nhập không khớp!</p>";
    }
    if (!empty($retypedPass) && (trim($password) === trim($retypedPass))) {
      echo "<p style='color: green;'> Mật khẩu nhập lại hợp lệ!</p>";
    }
  }
}

// function checkRetypedPassword($password, $retypedPass) {

//   if (!empty($password)) {
//     if (empty($retypedPass)) {
//       echo "<br> Mật khẩu nhập lại không được để trống!";
//     }
//     if (!empty($retypedPass) && !($password === $retypedPass)) {
//       echo "<br> Hai mật khẩu đã nhập không khớp!";
//     }
//     if (!empty($retypedPass) && ($password === $retypedPass)) {
//       echo "<br> Mật khẩu nhập lại hợp lệ!";
//     }
//   }

// }

function checkInputDOB ($dd, $mm, $yyyy) {
  $fieldsAreNums = true;
  $allPassed = true;

  if (empty($dd) && empty($mm) &&empty($yyyy)) {
    echo "<p style='color: red;'> Thông tin ngày sinh không được để trống!</p>";
    $fieldsAreNums = $allPassed = false;
  }else {
    if (empty($dd)) {
      echo "<p style='color: red;'> Ngày sinh không được để trống!</p>";
      $fieldsAreNums = $allPassed = false;
    }else if (!is_numeric($dd)) {
      echo "<p style='color: red;'> Ngày sinh không hợp lệ!</p>";
      $fieldsAreNums = $allPassed = false;
    }

    if (empty($mm)) {
      echo "<p style='color: red;'> Tháng sinh không được để trống!</p>";
      $fieldsAreNums = $allPassed = false;
    }else if (!is_numeric($mm)) {
      echo "<p style='color: red;'> Tháng sinh không hợp lệ!</p>";
      $fieldsAreNums = $allPassed = false;
    }

    if (empty($yyyy)) {
      echo "<p style='color: red;'> Năm sinh không được để trống!</p>";
      $fieldsAreNums = $allPassed = false;
    }else if (!is_numeric($yyyy)) {
      echo "<p style='color: red;'> Tháng sinh không hợp lệ!</p>";
      $fieldsAreNums = $allPassed = false;
    }
  }

 $month_30days = array (4, 6, 9, 11);
 $month_31days = array (1, 3, 5, 7, 8, 10, 12);

  if ($fieldsAreNums) {
    // if (!is_numeric($dd)) {
    //   echo "<p style='color: red;'> Ngày sinh không hợp lệ!</p>"; 
    // }
    // if (!is_numeric($dd)) {
    //   echo "<p style='color: red;'> Tháng sinh không hợp lệ!</p>"; 
    // }
    // if (!is_numeric($yyyy)) {
    //   echo "<p style='color: red;'> Năm sinh không hợp lệ!</p>"; 
    // }

    if (in_array($mm, $month_30days)) {
      if ($dd < 1 || $dd > 30) {
        echo "<p style='color: red;'> Ngày sinh không hợp lệ!</p>";
        $allPassed = false;
      }
    }else if (in_array($mm, $month_31days)) {
      if ($dd < 1 || $dd > 31) {
        echo "<p style='color: red;'> Ngày sinh không hợp lệ!</p>";
        $allPassed = false; 
      }
    }else if ($mm == 2) {
      if ( ($dd < 1 || $dd > 28) && $yyyy % 4 != 0) {
        echo "<p style='color: red;'> Ngày sinh không hợp lệ!</p>";
        $allPassed = false;
      }else {
        if ( ($dd < 1 || $dd > 29)) {
          echo "<p style='color: red;'> Ngày sinh không hợp lệ!</p>";
          $allPassed = false;
        }
      }
    }else {
        echo "<p style='color: red;'> Tháng sinh không hợp lệ!</p>";
        $allPassed = false;
    }
    if ($allPassed) {
      if (date("Y") - $yyyy > 120) {
        echo "<p style='color: green;'> Thông tin ngày sinh hợp lệ!</p>" . (date("Y") - $yyyy) . " tuổi?";
      } else {
        echo "<p style='color: green;'> Thông tin ngày sinh hợp lệ!</p>";
      }
    }
  }
}

function checkInputEmail ($email) {
  if (empty($email)) {
    echo "<p style='color: red;'> Email không được để trống!</p>";
  } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p style='color: green;'> Email hợp lệ!</p>";
  } else {
    echo "<p style='color: red;'> Email không hợp lệ!</p>";
  }
}

if( $_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST['name'];
  $password = $_POST['password'];
  $retypedPassword = $_POST['retypedPassword'];
  $ddDOB = $_POST['dd-dob'];
  $mmDOB = $_POST['mm-dob'];
  $yyyyDOB = $_POST['yyyy-dob'];
  $email = $_POST['email'];
  
  checkInputName($name);
  checkInputPassword($password, $retypedPassword);
  checkInputDOB($ddDOB, $mmDOB, $yyyyDOB);
  checkInputEmail($email);
}
?>

</body>
</html>
