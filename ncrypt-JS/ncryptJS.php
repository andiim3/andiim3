<?php
/**
* Work in progress.. 
* Must convert from JS to PHP
*/

class ncrypt { // to be continued
    encrypt (key, txt){        
        console.clear();
        var hash=this.hashit(key);
        var b64key = btoa(hash);
        var base64txt=btoa(txt);
        base64txt = this.textencode(base64txt);
        return this.lzw_encode(hash+base64txt+b64key);
    }

    decrypt(key, txt){        
        var hash=this.hashit(key);
        var b64key = btoa(hash);
        var decrypted = this.lzw_decode(txt);
        var encryptedhash = decrypted.substring(0,32);        
        if(hash==encryptedhash){            
            decrypted=decrypted.replace(hash, "");
            decrypted=decrypted.replace(b64key, "");            
            decrypted=atob(this.textdecode(decrypted));   
            console.log(decrypted)
            return decrypted;
        }else{
            console.clear();
            return "Wrong Key!";
        }
    }

    hashit(key){
        return this.MD5(key);
    }

    textencode(txt){
        let enc = new TextEncoder();
        return enc.encode(txt).join("-");
    }
    textdecode(txt){
        var theTextSplit = txt.split("-");
        let utf8decoder = new TextDecoder();
        let u8arr = new Uint8Array(theTextSplit);
        return utf8decoder.decode(u8arr);
    }
}

class LZW
{
    function compress($unc) {
        $i;$c;$wc;
        $w = "";
        $dictionary = array();
        $result = array();
        $dictSize = 256;
        for ($i = 0; $i < 256; $i += 1) {
            $dictionary[chr($i)] = $i;
        }
        for ($i = 0; $i < strlen($unc); $i++) {
            $c = $unc[$i];
            $wc = $w.$c;
            if (array_key_exists($w.$c, $dictionary)) {
                $w = $w.$c;
            } else {
                array_push($result,$dictionary[$w]);
                $dictionary[$wc] = $dictSize++;
                $w = (string)$c;
            }
        }
        if ($w !== "") {
            array_push($result,$dictionary[$w]);
        }
        return implode(",",$result);
    }
 
    function decompress($com) {
        $com = explode(",",$com);
        $i;$w;$k;$result;
        $dictionary = array();
        $entry = "";
        $dictSize = 256;
        for ($i = 0; $i < 256; $i++) {
            $dictionary[$i] = chr($i);
        }
        $w = chr($com[0]);
        $result = $w;
        for ($i = 1; $i < count($com);$i++) {
            $k = $com[$i];
            if ($dictionary[$k]) {
                $entry = $dictionary[$k];
            } else {
                if ($k === $dictSize) {
                    $entry = $w.$w[0];
                } else {
                    return null;
                }
            }
            $result .= $entry;
            $dictionary[$dictSize++] = $w . $entry[0];
            $w = $entry;
        }
        return $result;
    }
}
?>
