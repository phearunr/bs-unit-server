<?php
namespace App\Helpers;
 
class NumberFormat {

    static function convertToKhmerNumber($number)
    {
		$english_number = ["0","1","2","3","4","5","6","7","8","9"];
		$khmer_number = ["០","១","២","៣","៤","៥","៦","៧","៨","៩"];

		return str_replace($english_number, $khmer_number, $number);
    }

    static function covertUsdToKhmerWord($number, $prefix_usd = true)
    {
    	if ( !is_numeric($number) ) {
    		return false;
    	}    

    	if ( strlen($number) > 10 ) {
    		return "ចំនួនខ្ទង់ទលើសការកំណត់";
    	}

    	$number = (int)round($number);
    	$number = strrev($number);
		$khmer_number = ["","មួយ​","ពីរ​","បី​","បួន​","ប្រាំ​","ប្រាំមួយ​","ប្រាំពីរ​","ប្រាំបី​","ប្រាំបួន​"];
		$digit_word = ["","","រយ​","ពាន់​","ម៉ឺន​","","លាន​","","រយ​","ពាន់​"];
		$second_digit = ["","ដប់​","ម្ភៃ​","សាមសិប​","សែសិប​","ហាសិប​","ហុកសិប​","ចិតសិប​","ប៉ែតសិប​","កៅសិប​"];

		$word = "";
		for ( $i = 0 ; $i <= strlen($number)-1; $i++ ) {
			$digit =  (int)$number[$i];
			if ( $digit == 0 ) {
				if ( $i == 4 && strlen($number) < 7){
					$word = $digit_word[$i].$word;
				}
				if ( $i == 6 ) {
					$word = $digit_word[$i].$word;
				}
				continue;
			}
			if ( $i == 1 || $i == 5 || $i == 7) {
				$word = $second_digit[$digit].$digit_word[$i].$word;
				continue;
			}
			$word = $khmer_number[$digit].$digit_word[$i].$word;
		}
		if ( $prefix_usd ) {
			return $word."ដុល្លារ​​សហរដ្ឋ​អាមេរិច";
		} else {
			return $word;
		}
		
    }

    static function covertUsdToKhmerWordFloat($number)
    {
    	if ( !is_numeric($number) ) {
    		return false;
    	}

    	$cent = round($number,2) - (int)$number;
    		
    	if ( strlen($number) > 10 ) {
    		return "ចំនួនខ្ទង់ទលើសការកំណត់";
    	}

    	$number = (int)$number;
    	$number = strrev($number);
		$khmer_number = ["","មួយ​","ពីរ​","បី​","បួន​","ប្រាំ​","ប្រាំមួយ​","ប្រាំពីរ​","ប្រាំបី​","ប្រាំបួន​"];
		$digit_word = ["","","រយ​","ពាន់​","ម៉ឺន​","","លាន​","","រយ​","ពាន់​"];
		$second_digit = ["","ដប់​","ម្ភៃ​","សាមសិប​​","សែសិប​","ហាសិប​","ហុកសិប​","ចិតសិប​","ប៉ែតសិប​","កៅសិប​"];

		$word = "";
		for ( $i = 0 ; $i <= strlen($number)-1; $i++ ) {
			$digit =  (int)$number[$i];
			if ( $digit == 0 ) {
				if ( $i == 0 ) {
					$word = "សូន្យ​";
				}
				if ( $i == 4 && strlen($number) < 7){
					$word = $digit_word[$i].$word;
				}
				if ( $i == 6 ) {
					$word = $digit_word[$i].$word;
				}
				continue;
			}
			if ( $i == 1 || $i == 5 || $i == 7) {
				$word = $second_digit[$digit].$digit_word[$i].$word;
				continue;
			}
			$word = $khmer_number[$digit].$digit_word[$i].$word;
		}

		if ( $cent > 0 ) {
			$cent =  number_format($cent,2);
			$cent_word = $second_digit[$cent[2]];
			if ($cent[3] != 0) {
				$cent_word = $cent_word.$khmer_number[$cent[3]];
			}
			$cent_word = $cent_word."សេន";	
			return $word."ដុល្លារ​​សហរដ្ឋ​អាមេរិចនិង".$cent_word;
		}

		return $word."ដុល្លារ​​សហរដ្ឋ​អាមេរិច";		
    }


    static function str_ordinal($value, $superscript = false)
    {
        $number = abs($value);
 
        $indicators = ['th','st','nd','rd','th','th','th','th','th','th'];
 
        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }
 
        return number_format($number) . $suffix;
    }
	
}