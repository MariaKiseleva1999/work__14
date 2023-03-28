
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">


<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Work__14</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="all">
</head>

<body style="display: flex;justify-content: end; background-image:url(../img/medusa-1.jpg);background-size:50%;background-repeat:no-repeat;background-attachment:fixed;background-position:left;">


	<div style="border: 1px solid black;display: flex;flex-direction: column;width:30%;top: 50%;margin:20%; ">


		<?php
		function getUsersList()
		{
			return include __DIR__ . '/data.php';
		};

		function existsUser($login)
		{
			$users = getUsersList();
			foreach ($users as $user) {
				if ($user['login'] === $login) {
					return true;
				}
			}
			return false;
		}

		function checkPassword($login, $password)
		{
			if (true === existsUser($login)) {
				$users = getUsersList();
				foreach ($users as $user) {
					if ($user['login'] === $login) {
						if (password_verify($password, $user['password'])) {
							return true;
						}
					}
				}
			}
		
			return false;
		}
		assert(true === checkPassword('Katya', '234'));
		assert(true === checkPassword('Tanya', '123'));
		assert(false === checkPassword('Vasya1', '123'));
		assert(false === checkPassword('Vasya', '12345'));
		assert(false === checkPassword('Vasya1', '12345'));


		function getCurrentUser()
		{
			if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
				return $_SESSION['user'];
			} else {
				
				return null;
			}
		}

		if (isset($_POST['user']) && isset($_POST['password'])) {
			if (checkPassword($_POST['user'], $_POST['password'])) {
				$_SESSION['user'] = $_POST['user'];
			}
			else{
				$_SESSION['message'] = 'Не верный логин или пароль';
			}
			
		}

		function getDateBirthday()
		{
			$_SESSION['day'] = (int) $_POST['day'];
			$_SESSION['month'] = (int) $_POST['month'];
			$_SESSION['year'] = (int) $_POST['year'];

			if ($_SESSION['day'] == 0 || $_SESSION['month'] == 0 || $_SESSION['year'] == 0) { 
				echo ("<font class=regEr>&nbsp<p>Вы не ввели дату рождения</p>.</font>");
			} else {
				echo ("<p>Ваш день рождения:</p> " . $_SESSION['day'] . "." . $_SESSION['month'] . "." . $_SESSION['year']);
			}
		}


		if (null !== getCurrentUser()) {
		} else {
			header('Location: ../login.php');
		}

		if (null !== getCurrentUser()) { ?>
			<h1>Здравствуйте, <?php
									echo (getCurrentUser());
								} ?></h1>


			<?php
			if (null !== getDateBirthday()) {
				echo (getDateBirthday());
			}


			$birthday = $_SESSION['day'] . "." . $_SESSION['month'] . "." . $_SESSION['year'];
			$today = date('d.m'); 
			$birthdayDate = $_SESSION['day'] . "." . $_SESSION['month']; 
			$cd = new \DateTime('today'); 
			$bd = new \DateTime($birthday); 
			$bd->setDate($cd->format('Y'), $bd->format('m'), $bd->format('d')); 
			$tmp = $cd->diff($bd); 
			if ($tmp->invert) { 
				$bd->modify('+1 year'); 
				$tmp = $cd->diff($bd); 
			}
			echo ("<p style = color:red; font-size: 40px;>Дней до вашего дня роджения осталось: <p>" . $tmp->days . "<br>"); 
			if ($today == $birthdayDate) { 
				echo ("<p style = color:red;>С днем рождения! Для вас сегодня действует скидка 5% на все услуги!<p>" . "<br>");
			}

			$last = isset($_COOKIE['last']) ? $_COOKIE['last'] : 'никогда';

			setcookie('last', date('H:i:s'), time() + 3600 * 24 * 31, '/');
			?>
			<p>Последний раз вы заходили: </p> <?php echo $last . "<br><p></p>"; ?>



			<div class="sale">
				<h3>Акция! Скидка на окрашивание "totalblond" - 30%</h3>


				<?php
				$datetime3 = new DateTime(date("H:i:s")); 
				$datetime4 = new DateTime('23:59:59'); 
				$interval2 = $datetime3->diff($datetime4); 
				echo ("<p>До конца акции осталось:</p> " . $interval2->format(' %h ч. %i мин. %s сек.') . "<br><p></p>");
				?>

			</div>

			<a href="logout.php" class="logout">Выход</a><br>

	</div>
</body>

</html>