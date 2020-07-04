<?php

    $email=base64_encode("koikidamilare@gmail.com");
    $activation=base64_encode("3374738485c5ed1d29995d");


?>

<a href="activation.php?email=<?php echo $email?>&activation=<?php echo $activation?>">Confirm your email</a>
<br>
<a href="password_reset.php?email=<?php echo $email?>&activation=<?php echo $activation?>">Reset your password</a>
