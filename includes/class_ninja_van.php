<?php
class class_ninja_van extends class_manage {
	function connect_api() {
    $log_token = '../uploads/log_ninja/token_ninja_van.txt';
    $log_token_text = file_get_contents($log_token);
    $tach_token=json_decode($log_token_text,true);
    $expires=$tach_token['expires'];
    if($expires>time()){
      $access_token=$tach_token['access_token'];
      return $access_token;
    }else{
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, 'https://api.ninjavan.co/vn/2.0/oauth/access_token');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_ENCODING, '');
      curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
      curl_setopt($curl, CURLOPT_TIMEOUT, 0);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
      $headers = array(
          'Content-Type: application/json'
      );
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      $data = array(
          "client_id" => "b3b6efcf90a2442c8b763eebd5f261ea",
          "client_secret" => "5c33cf2ce1c84450a8024627ce1a1c9e",
          "grant_type" => "client_credentials"
      );
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return false;
      } else {
        $fh = fopen($log_token, "w");
        fwrite($fh, $response);
        fclose($fh);
        $tach_response=json_decode($response,true);
        return $tach_response['access_token'];
      }
    }
	}
  function tao_don($ma_don,$can_nang,$cod,$total_banle,$ten_sanpham,$nguoi_ban,$dienthoai_ban,$email_ban,$nguoi_mua,$dienthoai_mua,$diachi_mua,$huyen_mua,$tinh_mua,$ghi_chu){
    $accessToken = $this->connect_api();
    $ngay_dat=date('Y-m-d',time());
    $time_last=time() + 3600*24;
    $ngay_lay=date('Y-m-d',$time_last);
    if($total_banle>=1000000){
      $baohiem=$total_banle;
    }else{
      $baohiem=0;
    }
    // Dữ liệu đơn hàng
    $orderData = array(
        "service_type" => "Parcel",
        "service_level" => "NEXTDAY",
        "requested_tracking_number" => $ma_don,
        "reference" => array(
            "merchant_order_number" => "SHIP-".$ma_don
        ),
        "from" => array(
            "name" => $nguoi_ban,
            "phone_number" => $dienthoai_ban,
            "email" => "",
            "address" => array(
                "address1" => "Số 22, Liền kề 25 - Khu đô thị Vân Canh, Xã Vân Canh, Huyện Hoài Đức",
                "address2" => "",
                "area" => "",
                "city" => "Thành phố Hà Nội",
                "state" => "",
                "address_type" => "office",
                "country" => "VN",
                "postcode" => ""
            )
        ),
        "to" => array(
            "name" => $nguoi_mua,
            "phone_number" => $dienthoai_mua,
            "email" => "",
            "address" => array(
                "address1" => $diachi_mua,
                "address2" => "",
                "area" => "",
                "city" => $tinh_mua,
                "state" => "",
                "address_type" => "home",
                "country" => "VN",
                "postcode" => ""
            )
        ),
        "parcel_job" => array(
            "is_pickup_required" => true,
            "cash_on_delivery"=>intval($cod),
            "currency" => "VND",
            "insured_value"=>$baohiem,
            "pickup_service_type" => "Scheduled",
            "pickup_service_level" => "Standard",
            "pickup_address_id" => "98989012",
            "pickup_date" => $ngay_dat,
            "pickup_timeslot" => array(
                "start_time" => "09:00",
                "end_time" => "18:00",
                "timezone" => "Asia/Ho_Chi_Minh"
            ),
            "pickup_instructions" => "Pickup with care!",
            "delivery_instructions" => $ghi_chu,
            "delivery_start_date" => $ngay_dat,
            "delivery_timeslot" => array(
                "start_time" => "09:00",
                "end_time" => "18:00",
                "timezone" => "Asia/Ho_Chi_Minh"
            ),
            "dimensions" => array(
                "weight" => $can_nang
            ),
            "items" => array(
              array(
                  "item_description" => $ten_sanpham,
                  "quantity" => 1,
                  "is_dangerous_good" => false
              )
          )
        )
    );
    // Gửi yêu cầu tạo đơn hàng bằng cURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.ninjavan.co/vn/4.1/orders');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    $headers = array(
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($orderData));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }
  function huy_don($ma_don){
    $accessToken = $this->connect_api(); // Thay thế YOUR_ACCESS_TOKEN bằng Access Token của bạn
    $trackingNo = $ma_don; // Thay thế YOUR_TRACKING_NUMBER bằng số theo dõi (tracking number) thực tế
    $url = 'https://api.ninjavan.co/vn/2.2/orders/' . $trackingNo;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    $headers = array(
        'Authorization: Bearer ' . $accessToken
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }
}
?>
