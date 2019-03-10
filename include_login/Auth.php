<?php
require_once "DBController.php";
require_once "Util.php";
class Auth {

    function getIDByEmail($email) {
        $pdo = new DBController();
        $query = "SELECT id FROM brukere WHERE epost = :email LIMIT 1";
        $param_value_array = array(':email' => $email);
        $result = $pdo->runQuery($query, $param_value_array);
        return $result;
    }

    function getUserByID($id) {
        $pdo = new DBController();
        $query = "SELECT id, epost FROM brukere WHERE id = :id LIMIT 1";
        $param_value_array = array(':id' => $id);
        $result = $pdo->runQuery($query, $param_value_array);
        return $result;
    }

    function getPasswordByID($id) {
        $pdo = new DBController();
        $query = "SELECT passord, salt FROM brukere WHERE id = :id LIMIT 1";
        $param_value_array = array(':id' => $id);
        $result = $pdo->runQuery($query, $param_value_array);
        return $result;
    }

    function getHashByID($user_id) {
        $pdo = new DBController();
        $query = "SELECT hash FROM cookie_logginn_autentisering WHERE bruker_id = :user_id LIMIT 1";
        $param_value_array = array(':user_id' => $user_id);
        $result = $pdo->runQuery($query, $param_value_array);
        return $result;
    }
    
	function getTokenByID($user_id, $is_expired) {
        $pdo = new DBController();
	    $query = "SELECT bruker_id, passord_hash, valg_hash, utløpt_dato FROM pollett_logginn_autentisering WHERE bruker_id = :user_id AND utløpt = :is_expired";
        $param_value_array = array(':user_id' => $user_id, ':is_expired' => $is_expired);
	    $result = $pdo->runQuery($query, $param_value_array);
	    return $result;
    }
    
    /*function markAsExpired($user_id) {
        $pdo = new DBController();
        $query = "UPDATE pollett_logginn_autentisering SET utløpt = :is_expired WHERE bruker_id = :user_id";
        $expired = 1;
        $param_value_array = array(':user_id' => $user_id);
        $result = $pdo->update($query, 'ii', array($expired, $tokenID));
        return $result;
    }*/

    function insertHash($user_id, $hash) {
        $pdo = new DBController();
        $query = "INSERT INTO cookie_logginn_autentisering (bruker_id, hash) values (:user_id, :hash)";
        $param_value_array = array(':user_id' => $user_id, ':hash' => $hash);
        $pdo->insert($query, $param_value_array);

    }
    
    function insertToken($user_id, $random_password_hash, $random_selector_hash, $is_expired, $expiry_date) {
        $pdo = new DBController();
        $query = "INSERT INTO pollett_logginn_autentisering (bruker_id, passord_hash, valg_hash, utløpt, utløpt_dato) values (:user_id, :random_password_hash, :random_selector_hash, :is_expired, :expiry_date)";
        $param_value_array = array(':user_id' => $user_id, ':random_password_hash' => $random_password_hash, ':random_selector_hash' => $random_selector_hash, ':is_expired' => $is_expired, ':expiry_date' => $expiry_date);
        $pdo->insert($query, $param_value_array);

    }

    function deleteHash($user_id){
        $pdo = new DBController();
        $query = "DELETE FROM cookie_logginn_autentisering WHERE bruker_id = :user_id";
        $param_value_array = array(':user_id' => $user_id);
        $pdo->update($query, $param_value_array);
    }

    function deleteToken($user_id){
        $pdo = new DBController();
        $query = "DELETE FROM pollett_logginn_autentisering WHERE bruker_id = :user_id";
        $param_value_array = array(':user_id' => $user_id);
        $pdo->update($query, $param_value_array);
    }

    function insertLoginAttempt($user_id, $ip){
        $pdo = new DBController();
        $now = time();
        $query = "INSERT INTO logginn_forsok(bruker_id, ip, tid) VALUES (:user_id, :ip, :now)";
        $param_value_array = array(':user_id' => $user_id, ':ip' => $ip, ':now' => $now);
        $pdo->insert($query, $param_value_array);
    }
    
    function update($query) {
        mysqli_query($this->conn,$query);
    }

    function authenticate_login($email, $password) {
        $util = new Util();
        $user = $this->getIDByEmail($email);

        $user_id = $user[0]['id'];
        $user_credentials = $this->getPasswordByID($user_id);

        if ($user_credentials != NULL && $user != NULL) {

            $user_password = $user_credentials[0]['passord'];
            $user_salt = $user_credentials[0]['salt'];

            // hash the password with the unique salt.
            $password = hash('sha512', $password . $user_salt);

            // get ip from user.
            $ip = $util->getRealIpAddr();


            // If the user exists we check if the account is locked
            // from too many login attempts
            if ($util->checkbrute($user_id) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                /*die(var_dump($db_password == $password));*/
                /*die(var_dump($password));*/

                if ($user_password == $password) {
                    // Password is correct!
                    // Delete attempts from users ip
                    $util->delete_rows($user_id, $ip);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $this->insertLoginAttempt($user_id, $ip);
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}
?>