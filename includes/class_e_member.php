<?php
 class class_e_member extends class_manage
 {
    function check_login(){
        if(!isset($_COOKIE['emin_id'])){
            return 0;
        }else{
            //setcookie('user_id',$_COOKIE['user_id'],time()+3600);
            return $_COOKIE['emin_id'];
        }
    }
    ///////////////////////
    function login($conn,$username,$password,$remember){
        $check = $this->load('class_check');
        if(strlen($username)<4){
            return 0;
        }else{
            $info=mysqli_query($conn,"SELECT * FROM emin_info WHERE username='$username'");
            $total=mysqli_num_rows($info);
            if($total>0){
                $r_info=mysqli_fetch_assoc($info);
                $pass=md5($password);
                if($pass!=$r_info['password']){
                    return 2;
                }else{
                    if($remember=='on'){
                        //setcookie("emin_id",$r_info['id'],time() + 31536000);
                        setcookie("emin_id",$check->token_login($r_info['id'],$r_info['password']),time() + 2593000,'/');
                    }else{
                        //setcookie("emin_id",$r_info['id'],time() + 3600);
                        setcookie("user_id",$check->token_login($r_info['id'],$r_info['password']),time() + 3600,'/');
                    }
                    return 200;
                }
            }else{
                return 1;
            }
        }
    }
//////////////////////////////////////////////////////////
    function logout(){
        setcookie("emin_id",$_COOKIE['emin_id'],time() - 3600);
    }
///////////////////////////////////////////////////////////
    function user_info($conn,$user_id){
        $check = $this->load('class_check');
        $tach=json_decode($check->token_login_decode($user_id),true);
        $user_id=$tach['user_id'];
        $password=$tach['password'];
        $thongtin=mysqli_query($conn,"SELECT * FROM emin_info WHERE id='$user_id' AND password='$password'");   
        $total=mysqli_num_rows($thongtin);    
        if($total>0){
            $r_tt=mysqli_fetch_assoc($thongtin);
        }
        return $r_tt;
    }
///////////////////////////////////////////////////////////
    function acount_info($conn,$username){
        $username = addslashes($username);
        $thongtin=mysqli_query($conn,"SELECT * FROM emin_info WHERE username='$username'");   
        $total=mysqli_num_rows($thongtin);    
        if($total>0){
            $r_tt=mysqli_fetch_assoc($thongtin);
        }
        return $r_tt;
    }
/////////////////////////////////////////////////////////////
}
?>
