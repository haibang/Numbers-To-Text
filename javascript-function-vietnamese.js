var number_array = new Array('không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín');
function read_tens(number,remain)
{
	var numberstring = "";
	tens = Math.floor(number/10);
	units = number%10;
	if (tens>1) {
		numberstring = " " + number_array[tens] + " mươi";
		if (units==1) {
			numberstring += " mốt";
		}
	} else if (tens==1) {
		numberstring = " mười";
		if (units==1) {
			numberstring += " một";
		}
	} else if (remain && units>0) {
		numberstring = " lẻ";
	}
	if (units==5 && tens>=1) {
		numberstring += " lăm";
	} else if (units>1||(units==1&&tens==0)) {
		numberstring += " " + number_array[units];
	}
	return numberstring;
}
function read_block(number,remain)
{
	var numberstring = "";
	hundreds = Math.floor(number/100);
	number = number%100;
	if (remain || hundreds>0) {
		numberstring = " " + number_array[hundreds] + " trăm";
		numberstring += read_tens(number,true);
	} else {
		numberstring = read_tens(number,false);
	}
	return numberstring;
}
function read_millions(number,remain)
{
	var numberstring = "";
	millions = Math.floor(number/1000000);
	number = number%1000000;
	if (millions>0) {
		numberstring = read_block(millions,remain) + " triệu";
		remain = true;
	}
	thousands = Math.floor(number/1000);
	number = number%1000;
	if (thousands>0) {
		numberstring += read_block(thousands,remain) + " nghìn";
		remain = true;
	}
	if (number>0) {
		numberstring += read_block(number,remain);
	}
	return numberstring;
}
function read_numbers(number)
{
    if (number==0) return " "+number_array['0'];// check ben ngoai
	var numberstring = "", hauto = "";
	do {
		billions = number%1000000000;
		number = Math.floor(number/1000000000);
		if (number>0) {
			numberstring = read_millions(billions,true) + hauto + numberstring;
		} else {
			numberstring = read_millions(billions,false) + hauto + numberstring;
		}
		hauto = " tỷ";
	} while (number>0);
	return numberstring;
}

function formatCurrency(num) {
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
		num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	num = num.substring(0,num.length-(4*i+3))+','+
	num.substring(num.length-(4*i+3));
	//return (((sign)?'':'-') + '$' + num + '.' + cents);
	return (((sign)?'':'-') + num );
}

