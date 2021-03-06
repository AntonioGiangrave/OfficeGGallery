<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utily extends Model
{
    //



    public function controllocf($list){

        $bad=  array();

        foreach ($list as $cf) {

            $cf= str_replace(array("\n","\r"), "", $cf);


            if($cf!="") {
                $res = $this->docheck($cf);

                if (!$res['valido'])
                    array_push($bad, $res);
            }
        }


        \Debugbar::log($bad, 'bad');

        return $bad;

    }


    public function docheck($cf)
    {
        $cf = strtoupper($cf);

        if( $cf === '' ) {
            $res['valido']= false;
            $res['msg'] = 'non è compilato';
            $res['cf'] = $cf;
            return $res;
        } ;
        if( strlen($cf) != 16 ){

            if(strlen($cf) == 15){
                $possibile = $this->try_resolve($cf);

                if($possibile) {
                    $res['valido'] = false;
                    $res['msg'] = "Dovrebbe essere cosi =>" . $possibile;
                    $res['cf'] = $cf;
                    return $res;
                }
            }


            $res['valido']= false;
            $res['msg'] = "ha una lunghezza non \n"
                ."corretta: il codice fiscale dovrebbe essere lungo\n"
                ."esattamente 16 caratteri";
            $res['cf'] = $cf;
            return $res;
        }

        if( preg_match("/^[A-Z0-9]+\$/", $cf) != 1 ){

            $res['valido']= false;
            $res['msg'] = "contiene dei caratteri non validi:\n"
                ."i soli caratteri validi sono le lettere e le cifre";
            $res['cf'] = $cf;
            return $res;

        }
        $s = 0;
        for( $i = 1; $i <= 13; $i += 2 ){
            $c = $cf[$i];
            if( strcmp($c, "0") >= 0 and strcmp($c, "9") <= 0 )
                $s += ord($c) - ord('0');
            else
                $s += ord($c) - ord('A');
        }
        for( $i = 0; $i <= 14; $i += 2 ){
            $c = $cf[$i];
            switch( $c ){
                case '0':  $s += 1;  break;
                case '1':  $s += 0;  break;
                case '2':  $s += 5;  break;
                case '3':  $s += 7;  break;
                case '4':  $s += 9;  break;
                case '5':  $s += 13;  break;
                case '6':  $s += 15;  break;
                case '7':  $s += 17;  break;
                case '8':  $s += 19;  break;
                case '9':  $s += 21;  break;
                case 'A':  $s += 1;  break;
                case 'B':  $s += 0;  break;
                case 'C':  $s += 5;  break;
                case 'D':  $s += 7;  break;
                case 'E':  $s += 9;  break;
                case 'F':  $s += 13;  break;
                case 'G':  $s += 15;  break;
                case 'H':  $s += 17;  break;
                case 'I':  $s += 19;  break;
                case 'J':  $s += 21;  break;
                case 'K':  $s += 2;  break;
                case 'L':  $s += 4;  break;
                case 'M':  $s += 18;  break;
                case 'N':  $s += 20;  break;
                case 'O':  $s += 11;  break;
                case 'P':  $s += 3;  break;
                case 'Q':  $s += 6;  break;
                case 'R':  $s += 8;  break;
                case 'S':  $s += 12;  break;
                case 'T':  $s += 14;  break;
                case 'U':  $s += 16;  break;
                case 'V':  $s += 10;  break;
                case 'W':  $s += 22;  break;
                case 'X':  $s += 25;  break;
                case 'Y':  $s += 24;  break;
                case 'Z':  $s += 23;  break;
                /*. missing_default: .*/
            }
        }
        if( chr($s%26 + ord('A')) != $cf[15] ){
            $res['valido']= false;
            $res['msg'] = "non &egrave; corretto:\n"
                ."il codice di controllo non corrisponde";
            $res['cf'] = $cf;
            return $res;
        }

        $res['valido']= true;
        $res['msg'] = '';
        $res['cf'] = $cf;
        return  $res;
    }


    public function try_resolve($cf){

        $alfabeto = array('a', 'b','c','d','e','g','h','i','l','m','n','o','p','q','r','s','t','u','v','z','w','y','k', 'j', 'f');

        foreach ($alfabeto as $lettera){

            $tmp = strtoupper($cf.$lettera);
            $check = $this->docheck($tmp);
            if($check['valido'])
                return $tmp;
        }

    }

}
