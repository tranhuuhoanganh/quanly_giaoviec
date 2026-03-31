 <?php
class class_viettel extends class_manage {
	function login_step_1() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://partner.viettelpost.vn/v2/user/Login',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{"USERNAME":"0943051818","PASSWORD":"0943051818"}',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          return false;
        } else {
          return $response;
        }

	}
    function login_step_2($token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://partner.viettelpost.vn/v2/user/ownerconnect',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{"USERNAME":"0943051818","PASSWORD":"0943051818"}',
          CURLOPT_HTTPHEADER => array(
            'Token: '.$token,
            'Content-Type: application/json',
            'Cookie: SERVERID=A'
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return false;
        } else {
          return $response;
        }

    }
    function get_token_client($token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://partner.viettelpost.vn/v2/user/ownerconnect',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{"USERNAME":"0943051818","PASSWORD":"0943051818"}',
          CURLOPT_HTTPHEADER => array(
            'Token: '.$token,
            'Content-Type: application/json',
            'Cookie: SERVERID=A'
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return false;
        } else {
          $tach=json_decode($response,true);
          return $tach['data']['token'];
        }

    }
    function get_tinh($tinh){
        $check = $this->load('class_check');
        return $check->getpage('https://partner.viettelpost.vn/v2/categories/listProvinceById?provinceId='.$tinh);
    }
    function option_tinh($tinh){
        $check = $this->load('class_check');
        $xxx=$check->getpage('https://partner.viettelpost.vn/v2/categories/listProvinceById?provinceId=');
        $tach=json_decode($xxx,true);
        foreach ($tach['data'] as $key => $value) {
          if($tinh==$value['PROVINCE_ID']){
            $list.='<option value="'.$value['PROVINCE_ID'].'" selected>'.$value['PROVINCE_NAME'].'</option>';
          }else{
            $list.='<option value="'.$value['PROVINCE_ID'].'">'.$value['PROVINCE_NAME'].'</option>';
          }
        }
        return $list;
    }
    function get_huyen($tinh){
        $check = $this->load('class_check');
        return $check->getpage('https://partner.viettelpost.vn/v2/categories/listDistrict?provinceId='.$tinh);
    }
    function option_huyen($tinh,$huyen){
        $check = $this->load('class_check');
        $xxx=$check->getpage('https://partner.viettelpost.vn/v2/categories/listDistrict?provinceId='.$tinh);
        $tach=json_decode($xxx,true);
        foreach ($tach['data'] as $key => $value) {
          if($huyen==$value['DISTRICT_ID']){
            $list.='<option value="'.$value['DISTRICT_ID'].'" selected>'.$value['DISTRICT_NAME'].'</option>';
          }else{
            $list.='<option value="'.$value['DISTRICT_ID'].'">'.$value['DISTRICT_NAME'].'</option>';
          }
        }
        return $list;
    }
    function get_xa($huyen){
        $check = $this->load('class_check');
        return $check->getpage('https://partner.viettelpost.vn/v2/categories/listWards?districtId='.$huyen);
    }
    function option_xa($huyen,$xa){
        $check = $this->load('class_check');
        $xxx=$check->getpage('https://partner.viettelpost.vn/v2/categories/listWards?districtId='.$huyen);
        $tach=json_decode($xxx,true);
        foreach ($tach['data'] as $key => $value) {
          if($xa==$value['WARDS_ID']){
            $list.='<option value="'.$value['WARDS_ID'].'" selected>'.$value['WARDS_NAME'].'</option>';
          }else{
            $list.='<option value="'.$value['WARDS_ID'].'">'.$value['WARDS_NAME'].'</option>';
          }
        }
        return $list;
    }
    function lay_dichvu($token,$trongluong,$tongtien,$tien_thu,$ma_dichvu,$huyen_gui,$tinh_gui,$huyen_nhan,$tinh_nhan){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://partner.viettelpost.vn/v2/order/getPriceAll',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{
            "SENDER_DISTRICT": '.$huyen_gui.',
            "SENDER_PROVINCE": '.$tinh_gui.',
            "RECEIVER_DISTRICT": '.$huyen_nhan.',
            "RECEIVER_PROVINCE": '.$tinh_nhan.',
            "PRODUCT_TYPE": "HH",
            "PRODUCT_WEIGHT": '.$trongluong.',
            "PRODUCT_PRICE": '.$tongtien.',
            "MONEY_COLLECTION": "'.$tien_thu.'",
            "TYPE": 1
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Token: '.$token,
            'Cookie: SERVERID=A'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $tach=json_decode($response,true);
        $ok=0;
        foreach ($tach as $key => $value) {
          if($value['MA_DV_CHINH']==$ma_dichvu){
            $ok=1;
            $gia_cuoc=$value['GIA_CUOC'];
            $ten_dichvu=$value['TEN_DICHVU'];
            $thoi_gian=$value['THOI_GIAN'];
          }
        }
        $info=array(
          'ok'=>$ok,
          'gia_cuoc'=>$gia_cuoc,
          'ten_dichvu'=>$ten_dichvu,
          'thoi_gian'=>$thoi_gian,
          'ma_dichvu'=>$ma_dichvu
        );
        return json_encode($info);
    }
    function option_dichvu($token,$trongluong,$tongtien,$tien_thu,$huyen_gui,$tinh_gui,$huyen_nhan,$tinh_nhan){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://partner.viettelpost.vn/v2/order/getPriceAll',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{
            "SENDER_DISTRICT": '.$huyen_gui.',
            "SENDER_PROVINCE": '.$tinh_gui.',
            "RECEIVER_DISTRICT": '.$huyen_nhan.',
            "RECEIVER_PROVINCE": '.$tinh_nhan.',
            "PRODUCT_TYPE": "HH",
            "PRODUCT_WEIGHT": '.$trongluong.',
            "PRODUCT_PRICE": '.$tongtien.',
            "MONEY_COLLECTION": "'.$tien_thu.'",
            "TYPE": 1
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Token: '.$token,
            'Cookie: SERVERID=A'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $tach=json_decode($response,true);
        foreach ($tach as $key => $value) {
          if($value['MA_DV_CHINH']!='VHT'){
            $list.='<option value="'.$value['MA_DV_CHINH'].'" phi_ship="'.$value['GIA_CUOC'].'" phi_ship_text="'.number_format($value['GIA_CUOC']).' đ">'.$value['TEN_DICHVU'].' - Phí: '.number_format($value['GIA_CUOC']).' - Thời gian: '.$value['THOI_GIAN'].'</option>';
          }
        }
        return $list;
    }
    function tinh_cuoc($token,$trongluong,$gia,$tien_thu,$ma_dichvu,$huyen_gui,$tinh_gui,$huyen_nhan,$tinh_nhan){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://partner.viettelpost.vn/v2/order/getPrice',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{
            "PRODUCT_WEIGHT": '.$trongluong.',
            "PRODUCT_PRICE": '.$gia.',
            "MONEY_COLLECTION": '.$tien_thu.',
            "ORDER_SERVICE_ADD": "",
            "ORDER_SERVICE": "'.$ma_dichvu.'",
            "SENDER_DISTRICT": '.$huyen_gui.',
            "SENDER_PROVINCE": '.$tinh_gui.',
            "RECEIVER_DISTRICT": '.$huyen_nhan.',
            "RECEIVER_PROVINCE": '.$tinh_nhan.',
            "PRODUCT_TYPE": "HH",
            "NATIONAL_TYPE": 1
        }',
          CURLOPT_HTTPHEADER => array(
            'Token: '.$token,
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function tao_don($token,$order,$nguoi_ban,$diachi_nguoiban,$dienthoai_ban,$nguoi_mua,$diachi_nguoimua,$dienthoai_mua,$ten_sanpham,$mota_sanpham,$tong_soluong,$tongtien,$trongluong,$dai,$rong,$cao,$loai_vanchuyen,$ma_dichvu,$ghi_chu,$tien_thu,$list_hang) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://partner.viettelpost.vn/v2/order/createOrderNlp',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Token: '.$token,
            'Content-Type: application/json',
            'Cookie: SERVERID=A'
          ),
          CURLOPT_POSTFIELDS => '{
                "ORDER_NUMBER": "'.$order.'",
                "SENDER_FULLNAME": "'.$nguoi_ban.'",
                "SENDER_ADDRESS": "'.$diachi_nguoiban.'",
                "SENDER_PHONE": "'.$dienthoai_ban.'",
                "RECEIVER_FULLNAME": "'.$nguoi_mua.'",
                "RECEIVER_ADDRESS": "'.$diachi_nguoimua.'",
                "RECEIVER_PHONE": "'.$dienthoai_mua.'",
                "PRODUCT_NAME": "'.$ten_sanpham.'",
                "PRODUCT_DESCRIPTION": "'.$mota_sanpham.'",
                "PRODUCT_QUANTITY": "'.$tong_soluong.'",
                "PRODUCT_PRICE": "'.$tongtien.'",
                "PRODUCT_WEIGHT": "'.$trongluong.'",
                "PRODUCT_LENGTH": "'.$dai.'",
                "PRODUCT_WIDTH": "'.$rong.'",
                "PRODUCT_HEIGHT": "'.$cao.'",
                "ORDER_PAYMENT": "'.$loai_vanchuyen.'",
                "ORDER_SERVICE": "'.$ma_dichvu.'",
                "ORDER_SERVICE_ADD": null,
                "ORDER_NOTE": "'.$ghi_chu.'",
                "MONEY_COLLECTION": "'.$tien_thu.'",  
                "LIST_ITEM": ['.$list_hang.']
            }'
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}
?>
