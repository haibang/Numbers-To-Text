<?php
function read_tens($number,$remain){
	$number_array = array('không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín');
	$numberstring = "";
	$tens = floor($number/10);
	$units = $number%10;
	if ($tens>1) {
		$numberstring = " " . $number_array[$tens] . " mươi";
		if ($units==1) {
			$numberstring .= " mốt";
		}
	} else if ($tens==1) {
		$numberstring = " mười";
		if ($units==1) {
			$numberstring .= " một";
		}
	} else if ($remain && $units>0) {
		$numberstring = " lẻ";
	}
	if ($units==5 && $tens>=1) {
		$numberstring .= " lăm";
	} else if ($units>1||($units==1&&$tens==0)) {
		$numberstring .= " " . $number_array[ $units ];
	}
	return $numberstring;
}

function read_block($number,$remain){
	$number_array = array('không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín');
	$numberstring = "";
	$hundreds = floor($number/100);
	$number = $number%100;
	if ($remain || $hundreds>0) {
		$numberstring = " " . $number_array[$hundreds] . " trăm";
		$numberstring .= read_tens($number,true);
	} else {
		$numberstring = read_tens($number,false);
	}
	return $numberstring;
}

function read_millions($number,$remain){
	$numberstring = "";
	$millions = floor($number/1000000);
	$number = $number%1000000;
	if ($millions>0) {
		$numberstring = read_block($millions,$remain) . " triệu";
		$remain = true;
	}
	$thousands = floor($number/1000);
	$number = $number%1000;
	if ($thousands>0) {
		$numberstring .= read_block($thousands,$remain) . " nghìn";
		$remain = true;
	}
	if ($number>0) {
		$numberstring .= read_block($number,$remain);
	}
	return $numberstring;
}

function read_numbers($number){
	$number = (int)$number;
	$number_array = array('không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín');
	if ($number<10) return $number_array[$number];
	$numberstring = "";
	$suffix = "";

	while ($number>0) {
		$billions = $number%1000000000;
		$number = floor($number/1000000000);
		if ($number>0) {
			$numberstring = read_millions($billions,true) . $suffix . $numberstring;
		} else {
			$numberstring = read_millions($billions,false) . $suffix . $numberstring;
		}
		$suffix = " tỷ";
	};
	return $numberstring;
}

function convert_number_to_vietnamese($number){
		//$number= replace(/,/g,"");
		if($number>PHP_INT_MAX){
		return 'Số phải bé hơn '.PHP_INT_MAX;
		}
		$str_to_num = trim(read_numbers($number));
		if ($number !="0" || $number !="")
		$str_to_num = strtoupper(substr($str_to_num,0,1)).substr($str_to_num,1,strlen($str_to_num))." đồng";
		else $str_to_num = "Không đồng";
		return $str_to_num;
}

//Ex:
$number = '100015';
echo $number.' = '.convert_number_to_vietnamese($number);
?>
