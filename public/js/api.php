<?php

/**
 * The API can live anywhere OUTSIDE Laravel (with pure PHP)
 */


######################
#   initial filter   #
######################
if (!isset($_POST['action'])) {
    flashResult(false, 'bad request');
}


####################################
#   possibly in 'settings' file    #
####################################
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_DATABASE', 'mycheck');
define('DB_USERNAME', 'guy');
define('DB_PASSWORD', 'Mysql789');


#################
#   Functions   #
#################
function dbConnect() {
    return mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
}

/**
 * Validate user params
 *
 * @param array $params
 * @return bool
 */
function validate($params) {
    foreach ($params as $param) {
        $value = $_POST[$param];
        $valueLength = strlen($value);

        switch ($param) {
            case 'name':
                if (empty($value) || !is_string($value) || $valueLength > 255) {
                    return false;
                }
                break;

            case 'email':
                if (empty($value) || !is_string($value) || !filter_var($value, FILTER_VALIDATE_EMAIL) || $valueLength > 255) {
                    return false;
                }
                break;

            case 'password':
                if (empty($value) || !is_string($value) || $valueLength < 6 || $valueLength > 255) {
                    return false;
                }
                break;

            case 'api_token':
                if (empty($value) || !is_string($value) || $valueLength != 32) {
                    return false;
                }
                break;

            // Just in case a wrong param was called. Another possibility - throw exception
            default:
                return false;
        }
    }
    return true; // default value
}

/**
 * Display the result in JSON format
 *
 * @param bool $isSuccess
 * @param string $message
 */
function flashResult($isSuccess, $message='') {
    $response = [
        'success' => $isSuccess,
        'message' => $message
    ];
    die(json_encode($response));
}

/**
 * Preparation to a different hash in the future
 *
 * @param $password
 * @return string
 */
function hashPassword($password) {
    return md5($password); // simple hash
}

/**
 * a simple way to create (and use) a token
 *
 * @param $email
 * @return string
 */
function createToken($email) {
    return md5('Some123Token456' . $email);
}


########################
#   Preparing params   #
########################
$dbConn = dbConnect();
$name = mysqli_real_escape_string($dbConn, $_POST['name']);
$email = mysqli_real_escape_string($dbConn, $_POST['email']);
$password = mysqli_real_escape_string($dbConn, $_POST['password']);
$hashedPassword = hashPassword(($password));


#####################
#   Commit action   #
#####################
switch ($_POST['action']) {
    case 'register':
        if (validate(['name', 'email', 'password'])) {
            // find duplicates
            $dupUsers = $dbConn->query("SELECT `id` FROM `users` WHERE `name`='{$name}' AND `email`='{$email}'");
            if ($dupUsers->num_rows > 0) {
                flashResult(false, 'User exists');
            }

            // add user to db
            $apiToken = createToken($email); // also change token when changing name/email
            if ($dbConn->query("INSERT INTO users (`name`, `email`, `password`, `api_token`) VALUES ('{$name}', '{$email}', '{$hashedPassword}', '{$apiToken}')")) {
                flashResult(true);
            }
            flashResult(false, 'User could not be inserted');
        }
        flashResult(false, 'Invalid Parameters');
        break;

    case 'login':
        if (validate(['email', 'password'])) {
            // find user and grab his token
            $result = $dbConn->query("SELECT `api_token` FROM `users` WHERE `email`='{$email}' AND `password`='{$hashedPassword}'");
            if ($result->num_rows == 0) {
                flashResult(false, 'User does not exist');
            }
            // grab token
            $row = mysqli_fetch_assoc($result);
            flashResult(true, $row['api_token']);
        }
        flashResult(false, 'Invalid Parameters');
        break;

    case 'user_data':
        if (validate(['api_token'])) {
            // find user and grab his token
            $apiToken = mysqli_real_escape_string($dbConn, $_POST['api_token']);
            $result = $dbConn->query("SELECT `name` FROM `users` WHERE `api_token`='{$apiToken}'");
            if ($result->num_rows == 0) {
                flashResult(false, 'Bad token');
            }
            // grab token
            $row = mysqli_fetch_assoc($result);
            flashResult(true, $row['name']);
        }
        flashResult(false, 'Bad Token');
        break;

    default:
        flashResult(false, 'unknown request');
}

// for the safe side (or just debugging)
flashResult(false, 'a problem has occurred');
