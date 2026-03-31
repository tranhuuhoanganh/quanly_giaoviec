<?php
$list[1]['stt']=1;
$list[1]['time']=10;
$list[1]['tieu_de']='Phần thử thứ nhất';
$list[2]['stt']=3;
$list[2]['time']=5;
$list[2]['tieu_de']='Phần thử thứ thứ 2';
$list[3]['stt']=2;
$list[3]['time']=1;
$list[3]['tieu_de']='Phần thử thứ 3';

// Hàm sắp xếp
function sap_xep_theo_stt($a, $b) {
    return $a['stt'] - $b['stt'];
}

// Sắp xếp mảng
usort($list, 'sap_xep_theo_stt');

// In ra kết quả
print_r($list);
?>