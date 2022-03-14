<?php

$user = new User();

class User extends Controller
{

    public function exists($data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `email` = :email OR `username` = :username");
        $SQL->execute(array(":email" => $data, ":username" => $data));
        if($SQL->rowCount() == 1){
            return true;
        } else {
            return false;
        }
    }

    public function getState($data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `email` = :email OR `username` = :username");
        $SQL->execute(array(":email" => $data, ":username" => $data));
        $data = $SQL->fetch(PDO::FETCH_ASSOC);

        return $data['state'];
    }

    public function getRole($data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `email` = :email OR `username` = :username");
        $SQL->execute(array(":email" => $data, ":username" => $data));
        $data = $SQL->fetch(PDO::FETCH_ASSOC);

        if($data['role'] == 'user'){
            return 'User';
        }

        if($data['role'] == 'mod'){
            return 'Moderator';
        }

        if($data['role'] == 'admin'){
            return 'Administrator';
        }
    }

    public function verifyLogin($data, $password)
    {
        $SQL = self::db()->prepare('SELECT * FROM `users` WHERE `email` = :email OR `username` = :username');
        $SQL->execute(array(":email" => $data, ":username" => $data));
        $data = $SQL->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password, $data['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function generateSessionToken($data)
    {
        $session_token = System::generateRandomString(30);

        $SQL = self::db()->prepare("UPDATE `users` SET `session_token` = :session_token WHERE `email` = :email OR `username` = :username");
        $SQL->execute(array(":session_token" => $session_token, ":email" => $data, ":username" => $data));

        return $session_token;
    }

    public function create($username, $email, $password, $state = 'active', $role = 'user')
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $db = self::db();
        $SQL = $db->prepare("INSERT INTO `users`(`username`, `email`, `password`, `state`, `role`) VALUES (?,?,?,?,?)");
        $SQL->execute(array($username, $email, $hash, $state, $role));
        return $db->lastInsertId();
    }

    public function sessionExists($session_token)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `session_token` = :session_token");
        $SQL->execute(array(":session_token" => $session_token));
        if($SQL->rowCount() == 1){
            return true;
        } else {
            return false;
        }
    }

    public function loggedIn($session_token = null)
    {
        if(is_null($session_token)){
            return false;
        } else {
            return $this->sessionExists($session_token);
        }
    }

    public function getDataBySession($session_token, $data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `session_token` = :session_token");
        $SQL->execute(array(":session_token" => $session_token));
        $response = $SQL->fetch(PDO::FETCH_ASSOC);

        return $response[$data];
    }

    public function getDataById($id, $data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(":id" => $id));
        $response = $SQL->fetch(PDO::FETCH_ASSOC);

        return $response[$data];
    }

    public function getDataByUsername($username, $data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $SQL->execute(array(":username" => $username));
        $response = $SQL->fetch(PDO::FETCH_ASSOC);

        return $response[$data];
    }

    public function getDataByEmail($email, $data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $SQL->execute(array(":email" => $email));
        $response = $SQL->fetch(PDO::FETCH_ASSOC);

        return $response[$data];
    }

    public function isInTeam($session_token)
    {
        $role = User::getDataBySession($session_token,'role');

        if($role == 'admin'){
            return true;
        } elseif($role == 'mod'){
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin($session_token)
    {
        $role = User::getDataBySession($session_token,'role');

        if($role == 'admin'){
            return true;
        } else {
            return false;
        }
    }

    public function getOS($user_agent)
    {
        $os_platform  = "Unknow";

        $os_array = array(
            '/windows nt 11/i'      =>  'Windows 11',
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;

        return $os_platform;
    }

    public function getIP()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }

    public function getAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function logLogin($user_id, $user_addr, $user_agent)
    {
        $SQL = self::db()->prepare("INSERT INTO `login_logs`(`user_id`, `user_addr`, `user_agent`) VALUES (?,?,?)");
        $SQL->execute(array($user_id, $user_addr, $user_agent));
    }

    public function renewSupportPin($userid, $token = null)
    {
        if(is_null($token)){
            $token = Helper::generateRandomString(5,'1234567890');
        }

        $SQL = self::db()->prepare("UPDATE `users` SET `s_pin` = :s_pin WHERE `id` = :id");
        $SQL->execute(array(":id" => $userid, ":s_pin" => $token));

        return $token;
    }

}