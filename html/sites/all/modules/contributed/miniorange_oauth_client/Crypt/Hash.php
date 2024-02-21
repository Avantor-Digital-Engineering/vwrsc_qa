<?php


define("\103\x52\x59\120\124\137\110\x41\x53\110\x5f\x4d\x4f\104\x45\137\x49\x4e\124\105\122\116\x41\x4c", 1);
define("\103\122\x59\x50\x54\x5f\110\x41\123\x48\137\x4d\x4f\104\x45\x5f\x4d\x48\x41\123\110", 2);
define("\103\122\131\120\x54\137\x48\101\123\x48\x5f\x4d\x4f\104\105\137\110\x41\x53\110", 3);
class Crypt_Hash
{
    var $hashParam;
    var $b;
    var $l = false;
    var $hash;
    var $key = false;
    var $opad;
    var $ipad;
    function __construct($hU = "\x73\150\141\61")
    {
        if (defined("\103\x52\131\x50\x54\x5f\110\101\x53\110\x5f\115\x4f\104\105")) {
            goto yf;
        }
        switch (true) {
            case extension_loaded("\x68\x61\163\x68"):
                define("\x43\x52\x59\x50\x54\137\110\101\x53\110\137\x4d\117\104\x45", CRYPT_HASH_MODE_HASH);
                goto wC;
            case extension_loaded("\155\x68\x61\x73\150"):
                define("\x43\122\131\120\124\137\110\101\123\x48\137\115\x4f\104\105", CRYPT_HASH_MODE_MHASH);
                goto wC;
            default:
                define("\103\122\131\120\x54\x5f\110\101\x53\110\x5f\115\117\104\105", CRYPT_HASH_MODE_INTERNAL);
        }
        cY:
        wC:
        yf:
        $this->setHash($hU);
    }
    function Crypt_Hash($hU = "\x73\150\141\x31")
    {
        $this->__construct($hU);
    }
    function setKey($aZ = false)
    {
        $this->key = $aZ;
    }
    function getHash()
    {
        return $this->hashParam;
    }
    function setHash($hU)
    {
        $this->hashParam = $hU = strtolower($hU);
        switch ($hU) {
            case "\155\x64\x35\55\71\66":
            case "\163\x68\x61\x31\x2d\71\x36":
            case "\163\150\x61\62\65\x36\55\71\66":
            case "\x73\150\x61\65\61\62\55\71\x36":
                $hU = substr($hU, 0, -3);
                $this->l = 12;
                goto Hu;
            case "\155\x64\62":
            case "\155\x64\65":
                $this->l = 16;
                goto Hu;
            case "\x73\x68\141\x31":
                $this->l = 20;
                goto Hu;
            case "\x73\x68\x61\x32\x35\x36":
                $this->l = 32;
                goto Hu;
            case "\x73\150\x61\63\70\x34":
                $this->l = 48;
                goto Hu;
            case "\x73\150\141\x35\61\x32":
                $this->l = 64;
        }
        jY:
        Hu:
        switch ($hU) {
            case "\x6d\x64\x32":
                $SG = CRYPT_HASH_MODE == CRYPT_HASH_MODE_HASH && in_array("\155\x64\x32", hash_algos()) ? CRYPT_HASH_MODE_HASH : CRYPT_HASH_MODE_INTERNAL;
                goto ln;
            case "\163\150\141\x33\70\x34":
            case "\163\x68\x61\x35\x31\x32":
                $SG = CRYPT_HASH_MODE == CRYPT_HASH_MODE_MHASH ? CRYPT_HASH_MODE_INTERNAL : CRYPT_HASH_MODE;
                goto ln;
            default:
                $SG = CRYPT_HASH_MODE;
        }
        kS:
        ln:
        switch ($SG) {
            case CRYPT_HASH_MODE_MHASH:
                switch ($hU) {
                    case "\x6d\x64\65":
                        $this->hash = MHASH_MD5;
                        goto MO;
                    case "\x73\150\141\x32\x35\66":
                        $this->hash = MHASH_SHA256;
                        goto MO;
                    case "\x73\x68\x61\61":
                    default:
                        $this->hash = MHASH_SHA1;
                }
                XW:
                MO:
                return;
            case CRYPT_HASH_MODE_HASH:
                switch ($hU) {
                    case "\155\x64\65":
                        $this->hash = "\x6d\144\x35";
                        return;
                    case "\155\144\x32":
                    case "\x73\150\x61\x32\x35\x36":
                    case "\163\x68\x61\63\70\x34":
                    case "\163\x68\x61\x35\61\x32":
                        $this->hash = $hU;
                        return;
                    case "\163\x68\x61\x31":
                    default:
                        $this->hash = "\163\150\141\61";
                }
                xh:
                E4:
                return;
        }
        nB:
        sW:
        switch ($hU) {
            case "\155\144\62":
                $this->b = 16;
                $this->hash = array($this, "\x5f\x6d\x64\62");
                goto ze;
            case "\155\x64\65":
                $this->b = 64;
                $this->hash = array($this, "\137\155\144\65");
                goto ze;
            case "\x73\x68\x61\x32\x35\x36":
                $this->b = 64;
                $this->hash = array($this, "\137\163\150\x61\62\65\x36");
                goto ze;
            case "\163\150\141\63\70\64":
            case "\163\150\x61\65\x31\62":
                $this->b = 128;
                $this->hash = array($this, "\x5f\x73\x68\141\x35\x31\x32");
                goto ze;
            case "\x73\150\x61\61":
            default:
                $this->b = 64;
                $this->hash = array($this, "\137\163\x68\141\x31");
        }
        Bu:
        ze:
        $this->ipad = str_repeat(chr(0x36), $this->b);
        $this->opad = str_repeat(chr(0x5c), $this->b);
    }
    function hash($VN)
    {
        $SG = is_array($this->hash) ? CRYPT_HASH_MODE_INTERNAL : CRYPT_HASH_MODE;
        if (!empty($this->key) || is_string($this->key)) {
            goto Ba;
        }
        switch ($SG) {
            case CRYPT_HASH_MODE_MHASH:
                $A4 = mhash($this->hash, $VN);
                goto E1;
            case CRYPT_HASH_MODE_HASH:
                $A4 = hash($this->hash, $VN, true);
                goto E1;
            case CRYPT_HASH_MODE_INTERNAL:
                $A4 = call_user_func($this->hash, $VN);
        }
        rB:
        E1:
        goto D3;
        Ba:
        switch ($SG) {
            case CRYPT_HASH_MODE_MHASH:
                $A4 = mhash($this->hash, $VN, $this->key);
                goto qy;
            case CRYPT_HASH_MODE_HASH:
                $A4 = hash_hmac($this->hash, $VN, $this->key, true);
                goto qy;
            case CRYPT_HASH_MODE_INTERNAL:
                $aZ = strlen($this->key) > $this->b ? call_user_func($this->hash, $this->key) : $this->key;
                $aZ = str_pad($aZ, $this->b, chr(0));
                $C3 = $this->ipad ^ $aZ;
                $C3 .= $VN;
                $C3 = call_user_func($this->hash, $C3);
                $A4 = $this->opad ^ $aZ;
                $A4 .= $C3;
                $A4 = call_user_func($this->hash, $A4);
        }
        w_:
        qy:
        D3:
        return substr($A4, 0, $this->l);
    }
    function getLength()
    {
        return $this->l;
    }
    function _md5($KJ)
    {
        return pack("\x48\52", md5($KJ));
    }
    function _sha1($KJ)
    {
        return pack("\110\x2a", sha1($KJ));
    }
    function _md2($KJ)
    {
        static $QI = array(41, 46, 67, 201, 162, 216, 124, 1, 61, 54, 84, 161, 236, 240, 6, 19, 98, 167, 5, 243, 192, 199, 115, 140, 152, 147, 43, 217, 188, 76, 130, 202, 30, 155, 87, 60, 253, 212, 224, 22, 103, 66, 111, 24, 138, 23, 229, 18, 190, 78, 196, 214, 218, 158, 222, 73, 160, 251, 245, 142, 187, 47, 238, 122, 169, 104, 121, 145, 21, 178, 7, 63, 148, 194, 16, 137, 11, 34, 95, 33, 128, 127, 93, 154, 90, 144, 50, 39, 53, 62, 204, 231, 191, 247, 151, 3, 255, 25, 48, 179, 72, 165, 181, 209, 215, 94, 146, 42, 172, 86, 170, 198, 79, 184, 56, 210, 150, 164, 125, 182, 118, 252, 107, 226, 156, 116, 4, 241, 69, 157, 112, 89, 100, 113, 135, 32, 134, 91, 207, 101, 230, 45, 168, 2, 27, 96, 37, 173, 174, 176, 185, 246, 28, 70, 97, 105, 52, 64, 126, 15, 85, 71, 163, 35, 221, 81, 175, 58, 195, 92, 249, 206, 186, 197, 234, 38, 44, 83, 13, 110, 133, 40, 132, 9, 211, 223, 205, 244, 65, 129, 77, 82, 106, 220, 55, 200, 108, 193, 171, 250, 36, 225, 123, 8, 12, 189, 177, 74, 120, 136, 149, 139, 227, 99, 232, 109, 233, 203, 213, 254, 59, 0, 29, 57, 242, 239, 183, 14, 102, 88, 208, 228, 166, 119, 114, 248, 235, 117, 75, 10, 49, 68, 80, 180, 143, 237, 31, 26, 219, 153, 141, 51, 159, 17, 131, 20);
        $l3 = 16 - (strlen($KJ) & 0xf);
        $KJ .= str_repeat(chr($l3), $l3);
        $gM = strlen($KJ);
        $cm = str_repeat(chr(0), 16);
        $qT = chr(0);
        $Bi = 0;
        fB:
        if (!($Bi < $gM)) {
            goto Oj;
        }
        $lQ = 0;
        sq:
        if (!($lQ < 16)) {
            goto fE;
        }
        $cm[$lQ] = chr($QI[ord($KJ[$Bi + $lQ] ^ $qT)] ^ ord($cm[$lQ]));
        $qT = $cm[$lQ];
        Mc:
        $lQ++;
        goto sq;
        fE:
        X1:
        $Bi += 16;
        goto fB;
        Oj:
        $KJ .= $cm;
        $gM += 16;
        $rk = str_repeat(chr(0), 48);
        $Bi = 0;
        W3:
        if (!($Bi < $gM)) {
            goto UG;
        }
        $lQ = 0;
        xt:
        if (!($lQ < 16)) {
            goto T0;
        }
        $rk[$lQ + 16] = $KJ[$Bi + $lQ];
        $rk[$lQ + 32] = $rk[$lQ + 16] ^ $rk[$lQ];
        Z9:
        $lQ++;
        goto xt;
        T0:
        $Gt = chr(0);
        $lQ = 0;
        s1:
        if (!($lQ < 18)) {
            goto dl;
        }
        $GC = 0;
        C2:
        if (!($GC < 48)) {
            goto bJ;
        }
        $rk[$GC] = $Gt = $rk[$GC] ^ chr($QI[ord($Gt)]);
        a_:
        $GC++;
        goto C2;
        bJ:
        $Gt = chr(ord($Gt) + $lQ);
        GX:
        $lQ++;
        goto s1;
        dl:
        gw:
        $Bi += 16;
        goto W3;
        UG:
        return substr($rk, 0, 16);
    }
    function _sha256($KJ)
    {
        if (!extension_loaded("\x73\165\x68\157\163\x69\x6e")) {
            goto ns;
        }
        return pack("\x48\x2a", sha256($KJ));
        ns:
        $hU = array(0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a, 0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19);
        static $GC = array(0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5, 0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174, 0xe49b69c1, 0xefbe4786, 0xfc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da, 0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x6ca6351, 0x14292967, 0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85, 0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070, 0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3, 0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2);
        $gM = strlen($KJ);
        $KJ .= str_repeat(chr(0), 64 - ($gM + 8 & 0x3f));
        $KJ[$gM] = chr(0x80);
        $KJ .= pack("\116\x32", 0, $gM << 3);
        $IK = str_split($KJ, 64);
        foreach ($IK as $hT) {
            $xP = array();
            $Bi = 0;
            Hi:
            if (!($Bi < 16)) {
                goto un;
            }
            extract(unpack("\116\164\x65\155\x70", $this->_string_shift($hT, 4)));
            $xP[] = $C3;
            Ko:
            $Bi++;
            goto Hi;
            un:
            $Bi = 16;
            r6:
            if (!($Bi < 64)) {
                goto lz;
            }
            $Tz = $this->_rightRotate($xP[$Bi - 15], 7) ^ $this->_rightRotate($xP[$Bi - 15], 18) ^ $this->_rightShift($xP[$Bi - 15], 3);
            $c0 = $this->_rightRotate($xP[$Bi - 2], 17) ^ $this->_rightRotate($xP[$Bi - 2], 19) ^ $this->_rightShift($xP[$Bi - 2], 10);
            $xP[$Bi] = $this->_add($xP[$Bi - 16], $Tz, $xP[$Bi - 7], $c0);
            DW:
            $Bi++;
            goto r6;
            lz:
            list($aN, $Ng, $cm, $ki, $iz, $kt, $KF, $Rb) = $hU;
            $Bi = 0;
            iK:
            if (!($Bi < 64)) {
                goto JC;
            }
            $Tz = $this->_rightRotate($aN, 2) ^ $this->_rightRotate($aN, 13) ^ $this->_rightRotate($aN, 22);
            $jk = $aN & $Ng ^ $aN & $cm ^ $Ng & $cm;
            $DL = $this->_add($Tz, $jk);
            $c0 = $this->_rightRotate($iz, 6) ^ $this->_rightRotate($iz, 11) ^ $this->_rightRotate($iz, 25);
            $Ka = $iz & $kt ^ $this->_not($iz) & $KF;
            $fa = $this->_add($Rb, $c0, $Ka, $GC[$Bi], $xP[$Bi]);
            $Rb = $KF;
            $KF = $kt;
            $kt = $iz;
            $iz = $this->_add($ki, $fa);
            $ki = $cm;
            $cm = $Ng;
            $Ng = $aN;
            $aN = $this->_add($fa, $DL);
            ph:
            $Bi++;
            goto iK;
            JC:
            $hU = array($this->_add($hU[0], $aN), $this->_add($hU[1], $Ng), $this->_add($hU[2], $cm), $this->_add($hU[3], $ki), $this->_add($hU[4], $iz), $this->_add($hU[5], $kt), $this->_add($hU[6], $KF), $this->_add($hU[7], $Rb));
            hh:
        }
        wx:
        return pack("\116\70", $hU[0], $hU[1], $hU[2], $hU[3], $hU[4], $hU[5], $hU[6], $hU[7]);
    }
    function _sha512($KJ)
    {
        if (class_exists("\x4d\x61\x74\150\x5f\102\x69\147\111\x6e\164\145\147\145\x72")) {
            goto vu;
        }
        include_once "\115\141\x74\x68\x2f\102\151\x67\111\156\164\x65\x67\145\x72\56\x70\150\x70";
        vu:
        static $eZ, $ja, $GC;
        if (isset($GC)) {
            goto QF;
        }
        $eZ = array("\x63\x62\142\142\71\144\x35\x64\x63\x31\60\x35\x39\x65\144\x38", "\x36\x32\71\141\x32\71\x32\141\x33\66\x37\x63\x64\65\60\67", "\x39\61\x35\x39\60\x31\x35\x61\x33\60\67\60\x64\144\61\x37", "\x31\x35\x32\146\x65\x63\144\x38\146\67\x30\145\x35\x39\x33\71", "\x36\x37\x33\x33\x32\x36\x36\67\x66\146\143\60\60\142\x33\x31", "\x38\145\x62\64\x34\141\x38\67\66\x38\65\x38\61\65\61\x31", "\x64\142\60\x63\x32\x65\60\144\66\x34\x66\x39\x38\x66\x61\x37", "\64\x37\x62\x35\64\70\61\x64\x62\x65\146\141\x34\x66\x61\64");
        $ja = array("\66\x61\x30\71\x65\66\x36\67\146\x33\x62\143\x63\x39\x30\x38", "\x62\x62\66\67\x61\x65\x38\65\70\x34\x63\141\141\67\63\142", "\63\143\66\x65\x66\x33\67\x32\146\x65\71\x34\x66\70\x32\142", "\141\x35\64\146\x66\x35\x33\141\x35\x66\x31\x64\63\66\x66\x31", "\65\61\60\145\x35\62\x37\146\x61\144\145\x36\70\62\144\x31", "\x39\142\x30\x35\x36\x38\x38\x63\62\142\x33\x65\x36\x63\61\146", "\x31\x66\x38\63\144\71\141\x62\x66\x62\x34\x31\142\144\x36\142", "\65\x62\145\x30\x63\144\61\71\61\63\x37\145\62\61\x37\x39");
        $Bi = 0;
        rt:
        if (!($Bi < 8)) {
            goto aT;
        }
        $eZ[$Bi] = new Math_BigInteger($eZ[$Bi], 16);
        $eZ[$Bi]->setPrecision(64);
        $ja[$Bi] = new Math_BigInteger($ja[$Bi], 16);
        $ja[$Bi]->setPrecision(64);
        gJ:
        $Bi++;
        goto rt;
        aT:
        $GC = array("\x34\62\70\x61\62\x66\x39\x38\x64\x37\62\x38\x61\x65\x32\62", "\x37\61\63\x37\64\x34\x39\61\62\63\x65\146\x36\x35\x63\144", "\142\65\143\x30\146\x62\x63\146\x65\143\64\x64\63\x62\x32\x66", "\145\x39\142\65\x64\142\141\x35\70\x31\x38\71\144\x62\x62\143", "\x33\x39\x35\x36\143\62\65\142\x66\x33\64\x38\142\x35\x33\x38", "\x35\x39\x66\x31\x31\61\x66\x31\x62\x36\60\x35\144\60\61\x39", "\x39\x32\x33\x66\70\x32\x61\64\x61\146\x31\x39\x34\x66\71\x62", "\x61\142\x31\x63\x35\x65\144\x35\x64\141\x36\x64\x38\61\x31\x38", "\x64\x38\60\67\x61\141\71\x38\x61\63\60\63\x30\62\x34\62", "\x31\x32\x38\63\65\x62\x30\61\64\65\67\60\x36\x66\142\145", "\x32\x34\63\x31\70\x35\x62\145\64\145\x65\64\142\x32\x38\143", "\65\x35\x30\x63\67\x64\x63\63\x64\65\x66\146\x62\64\145\x32", "\67\62\142\x65\x35\144\67\x34\x66\x32\x37\x62\70\71\x36\x66", "\70\x30\x64\x65\x62\x31\x66\145\63\x62\61\66\x39\x36\142\61", "\71\142\144\143\60\x36\x61\x37\62\65\143\x37\61\62\x33\x35", "\143\61\x39\x62\146\61\x37\64\x63\146\x36\71\x32\x36\x39\64", "\145\64\71\x62\x36\x39\143\61\x39\145\146\x31\x34\141\x64\62", "\145\146\x62\145\x34\x37\70\66\x33\70\64\x66\x32\x35\x65\63", "\60\x66\143\x31\71\x64\143\x36\x38\x62\x38\143\144\x35\x62\x35", "\x32\64\60\x63\x61\61\143\143\67\x37\141\143\x39\x63\x36\x35", "\x32\144\145\71\x32\143\66\146\x35\x39\x32\x62\60\x32\67\x35", "\64\x61\67\64\x38\x34\141\x61\x36\145\x61\x36\x65\64\x38\x33", "\65\143\x62\60\x61\71\144\143\x62\x64\x34\61\146\142\x64\x34", "\x37\x36\146\x39\70\x38\x64\141\70\63\x31\x31\x35\x33\142\65", "\x39\x38\63\x65\x35\x31\x35\62\x65\145\66\66\x64\x66\x61\x62", "\141\70\x33\61\143\x36\x36\x64\x32\144\142\64\x33\62\x31\60", "\x62\x30\60\x33\62\x37\x63\70\71\70\x66\x62\x32\61\x33\146", "\x62\146\65\71\67\x66\x63\67\142\x65\x65\146\x30\145\x65\x34", "\143\66\x65\x30\60\142\x66\63\63\x64\141\70\70\x66\x63\x32", "\144\x35\x61\67\x39\61\64\x37\71\63\60\141\x61\67\x32\x35", "\60\x36\143\x61\66\63\65\x31\x65\60\x30\63\70\62\x36\x66", "\61\64\62\71\x32\x39\66\x37\x30\141\60\145\66\x65\67\x30", "\x32\67\142\67\x30\141\x38\65\64\x36\x64\62\62\146\146\143", "\62\145\x31\142\62\x31\63\70\x35\143\62\66\143\x39\x32\x36", "\x34\x64\62\143\x36\144\146\x63\65\141\x63\x34\62\x61\x65\x64", "\x35\63\x33\70\x30\144\x31\63\x39\x64\x39\65\142\x33\x64\146", "\x36\x35\x30\141\67\x33\65\64\x38\142\x61\146\66\63\x64\x65", "\67\66\x36\141\60\x61\142\142\63\143\x37\x37\x62\x32\141\70", "\70\61\143\x32\143\x39\x32\145\64\x37\145\x64\141\145\145\x36", "\71\62\67\62\x32\143\x38\65\x31\64\x38\62\x33\65\x33\x62", "\141\62\x62\x66\145\x38\x61\61\x34\143\x66\x31\60\63\66\64", "\141\70\x31\x61\66\x36\x34\142\x62\x63\64\62\63\x30\60\61", "\143\x32\64\142\x38\x62\67\60\x64\60\146\70\71\67\x39\x31", "\143\x37\x36\x63\65\x31\141\x33\x30\x36\x35\64\x62\x65\63\x30", "\144\x31\x39\62\x65\x38\61\x39\x64\66\x65\x66\x35\x32\x31\x38", "\144\x36\71\x39\x30\66\x32\x34\65\65\x36\x35\x61\x39\x31\x30", "\146\64\x30\x65\x33\65\x38\65\x35\x37\x37\x31\x32\x30\62\x61", "\61\60\x36\141\x61\60\67\x30\x33\62\142\x62\x64\61\142\x38", "\x31\71\x61\64\143\61\x31\66\142\x38\144\x32\144\60\143\x38", "\x31\x65\63\x37\66\143\x30\x38\x35\x31\64\x31\141\142\x35\63", "\62\x37\x34\x38\x37\x37\x34\143\x64\x66\x38\145\145\142\x39\71", "\63\64\x62\x30\142\143\x62\65\x65\61\71\x62\x34\70\x61\x38", "\x33\x39\x31\143\x30\143\x62\x33\143\x35\143\x39\x35\x61\x36\63", "\x34\145\x64\70\141\x61\x34\141\145\x33\x34\x31\70\141\x63\142", "\x35\142\x39\x63\x63\x61\64\x66\x37\67\66\x33\145\63\67\63", "\x36\x38\62\145\x36\146\x66\63\x64\66\x62\x32\142\70\141\x33", "\67\64\70\x66\x38\62\145\x65\x35\x64\145\x66\x62\62\x66\143", "\x37\70\x61\x35\66\63\66\x66\64\63\61\67\x32\x66\x36\60", "\70\x34\143\70\x37\70\x31\64\141\61\x66\60\141\142\x37\x32", "\x38\143\143\67\60\62\60\x38\61\x61\x36\x34\63\x39\x65\x63", "\71\60\142\145\146\x66\146\x61\62\x33\66\63\x31\x65\62\x38", "\141\64\65\60\66\143\145\142\144\145\70\x32\142\144\x65\71", "\142\145\x66\71\141\63\146\x37\x62\x32\143\66\x37\x39\x31\x35", "\x63\66\67\x31\x37\70\x66\62\x65\63\67\x32\65\63\62\142", "\x63\141\62\67\x33\x65\x63\145\x65\x61\x32\66\x36\61\x39\x63", "\x64\61\x38\66\142\70\x63\x37\62\61\x63\x30\x63\x32\x30\x37", "\x65\141\144\x61\67\144\x64\66\x63\144\x65\60\145\142\x31\145", "\146\x35\x37\x64\64\146\x37\x66\145\x65\66\x65\144\61\67\70", "\60\66\x66\60\x36\x37\x61\x61\67\x32\61\67\x36\146\142\x61", "\60\141\66\x33\x37\144\143\65\x61\x32\143\x38\x39\x38\141\x36", "\x31\x31\x33\x66\x39\x38\60\64\142\x65\146\71\x30\x64\x61\x65", "\x31\142\x37\61\x30\x62\63\65\x31\x33\61\x63\x34\x37\61\x62", "\62\70\x64\142\67\67\x66\x35\x32\63\60\x34\67\144\70\64", "\x33\62\x63\x61\141\x62\67\142\x34\x30\143\x37\x32\x34\71\63", "\63\x63\x39\x65\142\x65\60\141\61\x35\x63\x39\142\145\142\143", "\64\x33\61\144\66\67\143\x34\71\143\x31\60\60\144\64\143", "\x34\143\x63\65\x64\64\x62\x65\143\142\x33\x65\64\x32\142\66", "\65\x39\67\x66\62\x39\x39\143\146\143\66\65\x37\x65\62\141", "\65\146\x63\x62\x36\146\x61\x62\x33\x61\x64\x36\146\141\145\143", "\66\x63\x34\x34\61\71\70\x63\64\141\64\x37\65\70\61\67");
        $Bi = 0;
        kJ:
        if (!($Bi < 80)) {
            goto eg;
        }
        $GC[$Bi] = new Math_BigInteger($GC[$Bi], 16);
        PX:
        $Bi++;
        goto kJ;
        eg:
        QF:
        $hU = $this->l == 48 ? $eZ : $ja;
        $gM = strlen($KJ);
        $KJ .= str_repeat(chr(0), 128 - ($gM + 16 & 0x7f));
        $KJ[$gM] = chr(0x80);
        $KJ .= pack("\116\64", 0, 0, 0, $gM << 3);
        $IK = str_split($KJ, 128);
        foreach ($IK as $hT) {
            $xP = array();
            $Bi = 0;
            uS:
            if (!($Bi < 16)) {
                goto KT;
            }
            $C3 = new Math_BigInteger($this->_string_shift($hT, 8), 256);
            $C3->setPrecision(64);
            $xP[] = $C3;
            rE:
            $Bi++;
            goto uS;
            KT:
            $Bi = 16;
            tI:
            if (!($Bi < 80)) {
                goto T6;
            }
            $C3 = array($xP[$Bi - 15]->bitwise_rightRotate(1), $xP[$Bi - 15]->bitwise_rightRotate(8), $xP[$Bi - 15]->bitwise_rightShift(7));
            $Tz = $C3[0]->bitwise_xor($C3[1]);
            $Tz = $Tz->bitwise_xor($C3[2]);
            $C3 = array($xP[$Bi - 2]->bitwise_rightRotate(19), $xP[$Bi - 2]->bitwise_rightRotate(61), $xP[$Bi - 2]->bitwise_rightShift(6));
            $c0 = $C3[0]->bitwise_xor($C3[1]);
            $c0 = $c0->bitwise_xor($C3[2]);
            $xP[$Bi] = $xP[$Bi - 16]->copy();
            $xP[$Bi] = $xP[$Bi]->add($Tz);
            $xP[$Bi] = $xP[$Bi]->add($xP[$Bi - 7]);
            $xP[$Bi] = $xP[$Bi]->add($c0);
            ki:
            $Bi++;
            goto tI;
            T6:
            $aN = $hU[0]->copy();
            $Ng = $hU[1]->copy();
            $cm = $hU[2]->copy();
            $ki = $hU[3]->copy();
            $iz = $hU[4]->copy();
            $kt = $hU[5]->copy();
            $KF = $hU[6]->copy();
            $Rb = $hU[7]->copy();
            $Bi = 0;
            CI:
            if (!($Bi < 80)) {
                goto AJ;
            }
            $C3 = array($aN->bitwise_rightRotate(28), $aN->bitwise_rightRotate(34), $aN->bitwise_rightRotate(39));
            $Tz = $C3[0]->bitwise_xor($C3[1]);
            $Tz = $Tz->bitwise_xor($C3[2]);
            $C3 = array($aN->bitwise_and($Ng), $aN->bitwise_and($cm), $Ng->bitwise_and($cm));
            $jk = $C3[0]->bitwise_xor($C3[1]);
            $jk = $jk->bitwise_xor($C3[2]);
            $DL = $Tz->add($jk);
            $C3 = array($iz->bitwise_rightRotate(14), $iz->bitwise_rightRotate(18), $iz->bitwise_rightRotate(41));
            $c0 = $C3[0]->bitwise_xor($C3[1]);
            $c0 = $c0->bitwise_xor($C3[2]);
            $C3 = array($iz->bitwise_and($kt), $KF->bitwise_and($iz->bitwise_not()));
            $Ka = $C3[0]->bitwise_xor($C3[1]);
            $fa = $Rb->add($c0);
            $fa = $fa->add($Ka);
            $fa = $fa->add($GC[$Bi]);
            $fa = $fa->add($xP[$Bi]);
            $Rb = $KF->copy();
            $KF = $kt->copy();
            $kt = $iz->copy();
            $iz = $ki->add($fa);
            $ki = $cm->copy();
            $cm = $Ng->copy();
            $Ng = $aN->copy();
            $aN = $fa->add($DL);
            gF:
            $Bi++;
            goto CI;
            AJ:
            $hU = array($hU[0]->add($aN), $hU[1]->add($Ng), $hU[2]->add($cm), $hU[3]->add($ki), $hU[4]->add($iz), $hU[5]->add($kt), $hU[6]->add($KF), $hU[7]->add($Rb));
            Bk:
        }
        wm:
        $C3 = $hU[0]->toBytes() . $hU[1]->toBytes() . $hU[2]->toBytes() . $hU[3]->toBytes() . $hU[4]->toBytes() . $hU[5]->toBytes();
        if (!($this->l != 48)) {
            goto LE;
        }
        $C3 .= $hU[6]->toBytes() . $hU[7]->toBytes();
        LE:
        return $C3;
    }
    function _rightRotate($E1, $t3)
    {
        $cn = 32 - $t3;
        $dZ = (1 << $cn) - 1;
        return $E1 << $cn & 0xffffffff | $E1 >> $t3 & $dZ;
    }
    function _rightShift($E1, $t3)
    {
        $dZ = (1 << 32 - $t3) - 1;
        return $E1 >> $t3 & $dZ;
    }
    function _not($E1)
    {
        return ~$E1 & 0xffffffff;
    }
    function _add()
    {
        static $Ex;
        if (isset($Ex)) {
            goto fj;
        }
        $Ex = pow(2, 32);
        fj:
        $Mn = 0;
        $wB = func_get_args();
        foreach ($wB as $hh) {
            $Mn += $hh < 0 ? ($hh & 0x7fffffff) + 0x80000000 : $hh;
            ug:
        }
        TL:
        switch (true) {
            case is_int($Mn):
            case version_compare(PHP_VERSION, "\65\x2e\x33\56\60") >= 0 && (php_uname("\155") & "\337\337\xdf") != "\x41\x52\x4d":
            case (PHP_OS & "\337\337\xdf") === "\x57\x49\x4e":
                return fmod($Mn, $Ex);
        }
        IS:
        DM:
        return fmod($Mn, 0x80000000) & 0x7fffffff | (fmod(floor($Mn / 0x80000000), 2) & 1) << 31;
    }
    function _string_shift(&$z8, $FX = 1)
    {
        $N2 = substr($z8, 0, $FX);
        $z8 = substr($z8, $FX);
        return $N2;
    }
}
