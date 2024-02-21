<?php


define("\x4d\101\x54\110\x5f\x42\111\107\111\116\x54\105\x47\105\122\x5f\115\117\116\x54\x47\117\x4d\x45\122\x59", 0);
define("\115\101\x54\x48\137\x42\x49\x47\x49\116\x54\x45\x47\105\x52\137\x42\x41\122\x52\105\x54\124", 1);
define("\x4d\x41\x54\x48\x5f\x42\111\x47\111\x4e\124\105\107\105\122\137\x50\x4f\127\105\x52\x4f\x46\62", 2);
define("\x4d\x41\124\x48\137\x42\111\107\111\x4e\x54\105\107\x45\122\x5f\x43\x4c\x41\x53\123\111\x43", 3);
define("\115\x41\124\x48\x5f\102\111\x47\x49\x4e\x54\105\107\105\x52\x5f\x4e\117\116\x45", 4);
define("\x4d\101\x54\110\x5f\x42\x49\x47\111\116\124\105\x47\105\x52\137\x56\x41\x4c\125\x45", 0);
define("\x4d\101\124\110\137\x42\x49\x47\111\x4e\124\105\107\x45\122\137\x53\111\x47\116", 1);
define("\x4d\101\124\x48\x5f\102\111\x47\x49\x4e\x54\105\x47\105\122\137\126\x41\x52\x49\101\102\114\x45", 0);
define("\115\x41\124\x48\x5f\102\111\x47\x49\x4e\124\105\x47\105\x52\137\104\x41\124\101", 1);
define("\115\x41\124\x48\x5f\x42\111\107\111\116\x54\x45\x47\x45\122\137\x4d\117\x44\105\137\111\x4e\x54\105\122\116\101\x4c", 1);
define("\115\x41\124\x48\x5f\102\x49\x47\111\116\124\x45\107\105\122\x5f\x4d\117\x44\105\137\x42\x43\115\101\x54\x48", 2);
define("\x4d\x41\x54\x48\x5f\102\111\x47\x49\x4e\x54\x45\x47\x45\x52\137\x4d\x4f\x44\x45\137\107\115\x50", 3);
define("\115\x41\x54\110\137\x42\111\107\x49\116\x54\x45\x47\x45\x52\x5f\113\x41\x52\x41\124\123\x55\102\101\137\103\x55\124\117\106\106", 25);
class Math_BigInteger
{
    var $value;
    var $is_negative = false;
    var $precision = -1;
    var $bitmask = false;
    var $hex;
    function __construct($rk = 0, $JP = 10)
    {
        if (defined("\115\x41\x54\110\x5f\102\x49\107\x49\116\124\105\x47\x45\x52\137\115\x4f\104\105")) {
            goto C7;
        }
        switch (true) {
            case extension_loaded("\147\155\x70"):
                define("\115\x41\124\110\137\102\111\107\111\116\124\105\107\105\x52\x5f\115\x4f\x44\105", MATH_BIGINTEGER_MODE_GMP);
                goto aX;
            case extension_loaded("\x62\x63\x6d\141\x74\x68"):
                define("\115\101\124\x48\x5f\102\111\107\111\x4e\124\105\107\105\x52\137\x4d\x4f\x44\x45", MATH_BIGINTEGER_MODE_BCMATH);
                goto aX;
            default:
                define("\115\101\124\110\x5f\102\x49\107\111\116\124\x45\107\x45\x52\x5f\115\x4f\x44\x45", MATH_BIGINTEGER_MODE_INTERNAL);
        }
        HW:
        aX:
        C7:
        if (!(extension_loaded("\157\x70\145\156\163\x73\154") && !defined("\x4d\101\x54\110\137\102\111\107\111\116\x54\105\x47\105\x52\137\x4f\120\x45\x4e\x53\123\114\137\104\x49\x53\x41\102\x4c\x45") && !defined("\115\x41\x54\110\137\102\x49\x47\111\116\x54\x45\107\105\x52\137\x4f\120\105\x4e\x53\123\114\x5f\105\116\x41\102\x4c\105\104"))) {
            goto ov;
        }
        ob_start();
        @phpinfo();
        $ON = ob_get_contents();
        ob_end_clean();
        preg_match_all("\x23\117\x70\145\x6e\x53\123\x4c\40\x28\x48\145\141\144\145\162\174\x4c\x69\142\x72\x61\162\x79\51\x20\x56\x65\162\x73\x69\157\x6e\50\56\52\x29\43\151\x6d", $ON, $vt);
        $oc = array();
        if (empty($vt[1])) {
            goto Hf;
        }
        $Bi = 0;
        xP:
        if (!($Bi < count($vt[1]))) {
            goto QI;
        }
        $wF = trim(str_replace("\x3d\76", '', strip_tags($vt[2][$Bi])));
        if (!preg_match("\57\x28\x5c\144\53\x5c\56\x5c\144\x2b\134\x2e\x5c\x64\x2b\x29\57\x69", $wF, $KJ)) {
            goto tO;
        }
        $oc[$vt[1][$Bi]] = $KJ[0];
        goto wT;
        tO:
        $oc[$vt[1][$Bi]] = $wF;
        wT:
        jN:
        $Bi++;
        goto xP;
        QI:
        Hf:
        switch (true) {
            case !isset($oc["\110\x65\x61\144\x65\x72"]):
            case !isset($oc["\x4c\151\x62\x72\141\162\x79"]):
            case $oc["\110\x65\141\x64\x65\x72"] == $oc["\114\x69\x62\162\141\x72\171"]:
            case version_compare($oc["\110\x65\x61\x64\x65\x72"], "\61\x2e\x30\56\60") >= 0 && version_compare($oc["\114\x69\142\x72\x61\162\171"], "\x31\x2e\60\56\x30") >= 0:
                define("\115\101\x54\110\x5f\102\x49\x47\x49\x4e\x54\105\107\105\122\137\117\x50\x45\116\x53\x53\114\137\x45\116\x41\102\x4c\105\x44", true);
                goto Uq;
            default:
                define("\115\x41\124\110\137\102\x49\107\111\116\124\105\107\x45\x52\137\x4f\x50\105\x4e\123\x53\114\x5f\104\x49\x53\x41\x42\x4c\x45", true);
        }
        k2:
        Uq:
        ov:
        if (defined("\x50\110\x50\x5f\x49\x4e\124\x5f\x53\111\132\x45")) {
            goto Kr;
        }
        define("\120\x48\120\x5f\111\x4e\124\137\123\x49\x5a\x45", 4);
        Kr:
        if (!(!defined("\115\101\x54\x48\137\x42\x49\x47\x49\x4e\124\x45\107\x45\x52\137\102\x41\x53\105") && MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_INTERNAL)) {
            goto hC;
        }
        switch (PHP_INT_SIZE) {
            case 8:
                define("\x4d\101\x54\110\x5f\x42\111\x47\111\116\x54\105\107\x45\122\137\102\101\x53\x45", 31);
                define("\115\x41\124\x48\x5f\x42\111\x47\111\116\124\x45\x47\105\122\x5f\x42\101\123\x45\x5f\x46\x55\114\114", 0x80000000);
                define("\x4d\101\x54\x48\x5f\102\x49\x47\111\116\124\x45\x47\105\x52\137\115\101\x58\137\104\x49\107\x49\x54", 0x7fffffff);
                define("\115\x41\x54\110\x5f\x42\111\107\x49\116\x54\x45\x47\105\122\137\x4d\123\x42", 0x40000000);
                define("\115\x41\x54\x48\137\x42\111\x47\111\x4e\x54\x45\107\105\x52\x5f\115\101\130\61\x30", 1000000000);
                define("\x4d\101\124\110\137\x42\111\107\x49\116\x54\x45\x47\x45\x52\137\x4d\101\130\61\x30\x5f\114\105\x4e", 9);
                define("\x4d\x41\124\110\137\x42\111\x47\x49\116\124\x45\x47\105\x52\137\x4d\x41\x58\137\104\x49\x47\x49\x54\62", pow(2, 62));
                goto Ca;
            default:
                define("\115\101\x54\x48\137\102\x49\107\x49\116\x54\x45\107\x45\122\x5f\x42\101\x53\x45", 26);
                define("\x4d\101\x54\x48\x5f\x42\111\107\111\x4e\x54\x45\x47\x45\x52\x5f\102\x41\x53\105\137\106\125\x4c\x4c", 0x4000000);
                define("\x4d\101\x54\x48\137\102\111\x47\111\116\x54\105\x47\x45\122\x5f\x4d\x41\130\x5f\x44\x49\107\x49\124", 0x3ffffff);
                define("\115\x41\124\x48\137\x42\111\107\x49\x4e\x54\x45\x47\x45\122\137\115\123\102", 0x2000000);
                define("\115\x41\124\x48\137\102\x49\107\x49\x4e\124\x45\x47\105\122\137\x4d\x41\130\61\x30", 10000000);
                define("\x4d\x41\124\110\137\102\x49\x47\111\x4e\124\x45\x47\x45\122\x5f\115\x41\130\61\x30\x5f\x4c\105\x4e", 7);
                define("\115\x41\124\110\x5f\102\x49\107\111\116\124\x45\107\105\122\x5f\x4d\x41\130\x5f\104\111\x47\x49\x54\62", pow(2, 52));
        }
        IK:
        Ca:
        hC:
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                switch (true) {
                    case is_resource($rk) && get_resource_type($rk) == "\107\115\120\40\151\x6e\164\145\147\145\x72":
                    case is_object($rk) && get_class($rk) == "\107\115\x50":
                        $this->value = $rk;
                        return;
                }
                oj:
                RR:
                $this->value = gmp_init(0);
                goto xA;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $this->value = "\x30";
                goto xA;
            default:
                $this->value = array();
        }
        Tx:
        xA:
        if (!(empty($rk) && (abs($JP) != 256 || $rk !== "\60"))) {
            goto q_;
        }
        return;
        q_:
        switch ($JP) {
            case -256:
                if (!(ord($rk[0]) & 0x80)) {
                    goto Bp;
                }
                $rk = ~$rk;
                $this->is_negative = true;
                Bp:
            case 256:
                switch (MATH_BIGINTEGER_MODE) {
                    case MATH_BIGINTEGER_MODE_GMP:
                        $this->value = function_exists("\x67\x6d\x70\x5f\x69\x6d\x70\x6f\162\x74") ? gmp_import($rk) : gmp_init("\60\170" . bin2hex($rk));
                        if (!$this->is_negative) {
                            goto zQ;
                        }
                        $this->value = gmp_neg($this->value);
                        zQ:
                        goto NQ;
                    case MATH_BIGINTEGER_MODE_BCMATH:
                        $cv = strlen($rk) + 3 & 0xfffffffc;
                        $rk = str_pad($rk, $cv, chr(0), STR_PAD_LEFT);
                        $Bi = 0;
                        J9:
                        if (!($Bi < $cv)) {
                            goto YM;
                        }
                        $this->value = bcmul($this->value, "\64\x32\71\x34\x39\x36\67\62\71\x36", 0);
                        $this->value = bcadd($this->value, 0x1000000 * ord($rk[$Bi]) + (ord($rk[$Bi + 1]) << 16 | ord($rk[$Bi + 2]) << 8 | ord($rk[$Bi + 3])), 0);
                        Pj:
                        $Bi += 4;
                        goto J9;
                        YM:
                        if (!$this->is_negative) {
                            goto ZX;
                        }
                        $this->value = "\x2d" . $this->value;
                        ZX:
                        goto NQ;
                    default:
                        yP:
                        if (!strlen($rk)) {
                            goto bQ;
                        }
                        $this->value[] = $this->_bytes2int($this->_base256_rshift($rk, MATH_BIGINTEGER_BASE));
                        goto yP;
                        bQ:
                }
                Ge:
                NQ:
                if (!$this->is_negative) {
                    goto nJ;
                }
                if (!(MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_INTERNAL)) {
                    goto la;
                }
                $this->is_negative = false;
                la:
                $C3 = $this->add(new Math_BigInteger("\x2d\x31"));
                $this->value = $C3->value;
                nJ:
                goto bT;
            case 16:
            case -16:
                if (!($JP > 0 && $rk[0] == "\x2d")) {
                    goto tt;
                }
                $this->is_negative = true;
                $rk = substr($rk, 1);
                tt:
                $rk = preg_replace("\x23\136\50\77\72\x30\170\x29\x3f\50\133\x41\55\x46\x61\x2d\x66\60\x2d\71\135\x2a\51\56\x2a\43", "\x24\61", $rk);
                $Qm = false;
                if (!($JP < 0 && hexdec($rk[0]) >= 8)) {
                    goto jB;
                }
                $this->is_negative = $Qm = true;
                $rk = bin2hex(~pack("\x48\52", $rk));
                jB:
                switch (MATH_BIGINTEGER_MODE) {
                    case MATH_BIGINTEGER_MODE_GMP:
                        $C3 = $this->is_negative ? "\55\x30\170" . $rk : "\60\170" . $rk;
                        $this->value = gmp_init($C3);
                        $this->is_negative = false;
                        goto Sa;
                    case MATH_BIGINTEGER_MODE_BCMATH:
                        $rk = strlen($rk) & 1 ? "\x30" . $rk : $rk;
                        $C3 = new Math_BigInteger(pack("\x48\52", $rk), 256);
                        $this->value = $this->is_negative ? "\x2d" . $C3->value : $C3->value;
                        $this->is_negative = false;
                        goto Sa;
                    default:
                        $rk = strlen($rk) & 1 ? "\x30" . $rk : $rk;
                        $C3 = new Math_BigInteger(pack("\x48\x2a", $rk), 256);
                        $this->value = $C3->value;
                }
                q8:
                Sa:
                if (!$Qm) {
                    goto Ck;
                }
                $C3 = $this->add(new Math_BigInteger("\55\61"));
                $this->value = $C3->value;
                Ck:
                goto bT;
            case 10:
            case -10:
                $rk = preg_replace("\43\50\x3f\74\41\x5e\x29\x28\77\72\x2d\x29\x2e\x2a\x7c\50\x3f\x3c\x3d\x5e\174\x2d\51\60\x2a\174\x5b\x5e\x2d\x30\x2d\71\x5d\x2e\x2a\43", '', $rk);
                switch (MATH_BIGINTEGER_MODE) {
                    case MATH_BIGINTEGER_MODE_GMP:
                        $this->value = gmp_init($rk);
                        goto J0;
                    case MATH_BIGINTEGER_MODE_BCMATH:
                        $this->value = $rk === "\55" ? "\60" : (string) $rk;
                        goto J0;
                    default:
                        $C3 = new Math_BigInteger();
                        $dr = new Math_BigInteger();
                        $dr->value = array(MATH_BIGINTEGER_MAX10);
                        if (!($rk[0] == "\55")) {
                            goto oz;
                        }
                        $this->is_negative = true;
                        $rk = substr($rk, 1);
                        oz:
                        $rk = str_pad($rk, strlen($rk) + (MATH_BIGINTEGER_MAX10_LEN - 1) * strlen($rk) % MATH_BIGINTEGER_MAX10_LEN, 0, STR_PAD_LEFT);
                        kl:
                        if (!strlen($rk)) {
                            goto VB;
                        }
                        $C3 = $C3->multiply($dr);
                        $C3 = $C3->add(new Math_BigInteger($this->_int2bytes(substr($rk, 0, MATH_BIGINTEGER_MAX10_LEN)), 256));
                        $rk = substr($rk, MATH_BIGINTEGER_MAX10_LEN);
                        goto kl;
                        VB:
                        $this->value = $C3->value;
                }
                ij:
                J0:
                goto bT;
            case 2:
            case -2:
                if (!($JP > 0 && $rk[0] == "\55")) {
                    goto JD;
                }
                $this->is_negative = true;
                $rk = substr($rk, 1);
                JD:
                $rk = preg_replace("\43\x5e\50\x5b\60\61\x5d\x2a\51\x2e\52\43", "\44\x31", $rk);
                $rk = str_pad($rk, strlen($rk) + 3 * strlen($rk) % 4, 0, STR_PAD_LEFT);
                $wM = "\x30\170";
                A1:
                if (!strlen($rk)) {
                    goto sJ;
                }
                $hm = substr($rk, 0, 4);
                $wM .= dechex(bindec($hm));
                $rk = substr($rk, 4);
                goto A1;
                sJ:
                if (!$this->is_negative) {
                    goto Og;
                }
                $wM = "\55" . $wM;
                Og:
                $C3 = new Math_BigInteger($wM, 8 * $JP);
                $this->value = $C3->value;
                $this->is_negative = $C3->is_negative;
                goto bT;
            default:
        }
        HS:
        bT:
    }
    function Math_BigInteger($rk = 0, $JP = 10)
    {
        $this->__construct($rk, $JP);
    }
    function toBytes($yU = false)
    {
        if (!$yU) {
            goto rA;
        }
        $DO = $this->compare(new Math_BigInteger());
        if (!($DO == 0)) {
            goto MR;
        }
        return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
        MR:
        $C3 = $DO < 0 ? $this->add(new Math_BigInteger(1)) : $this->copy();
        $gx = $C3->toBytes();
        if (!empty($gx)) {
            goto cG;
        }
        $gx = chr(0);
        cG:
        if (!(ord($gx[0]) & 0x80)) {
            goto Vx;
        }
        $gx = chr(0) . $gx;
        Vx:
        return $DO < 0 ? ~$gx : $gx;
        rA:
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                if (!(gmp_cmp($this->value, gmp_init(0)) == 0)) {
                    goto yN;
                }
                return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
                yN:
                if (function_exists("\x67\x6d\160\x5f\145\x78\160\x6f\162\164")) {
                    goto b_;
                }
                $C3 = gmp_strval(gmp_abs($this->value), 16);
                $C3 = strlen($C3) & 1 ? "\x30" . $C3 : $C3;
                $C3 = pack("\x48\x2a", $C3);
                goto PJ;
                b_:
                $C3 = gmp_export($this->value);
                PJ:
                return $this->precision > 0 ? substr(str_pad($C3, $this->precision >> 3, chr(0), STR_PAD_LEFT), -($this->precision >> 3)) : ltrim($C3, chr(0));
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value === "\x30")) {
                    goto R7;
                }
                return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
                R7:
                $sh = '';
                $XI = $this->value;
                if (!($XI[0] == "\x2d")) {
                    goto NY;
                }
                $XI = substr($XI, 1);
                NY:
                wB:
                if (!(bccomp($XI, "\x30", 0) > 0)) {
                    goto IT;
                }
                $C3 = bcmod($XI, "\61\x36\67\x37\67\62\x31\x36");
                $sh = chr($C3 >> 16) . chr($C3 >> 8) . chr($C3) . $sh;
                $XI = bcdiv($XI, "\x31\66\x37\67\x37\62\61\x36", 0);
                goto wB;
                IT:
                return $this->precision > 0 ? substr(str_pad($sh, $this->precision >> 3, chr(0), STR_PAD_LEFT), -($this->precision >> 3)) : ltrim($sh, chr(0));
        }
        Ec:
        uH:
        if (count($this->value)) {
            goto Y2;
        }
        return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
        Y2:
        $Mn = $this->_int2bytes($this->value[count($this->value) - 1]);
        $C3 = $this->copy();
        $Bi = count($C3->value) - 2;
        SU:
        if (!($Bi >= 0)) {
            goto yA;
        }
        $C3->_base256_lshift($Mn, MATH_BIGINTEGER_BASE);
        $Mn = $Mn | str_pad($C3->_int2bytes($C3->value[$Bi]), strlen($Mn), chr(0), STR_PAD_LEFT);
        tS:
        --$Bi;
        goto SU;
        yA:
        return $this->precision > 0 ? str_pad(substr($Mn, -($this->precision + 7 >> 3)), $this->precision + 7 >> 3, chr(0), STR_PAD_LEFT) : $Mn;
    }
    function toHex($yU = false)
    {
        return bin2hex($this->toBytes($yU));
    }
    function toBits($yU = false)
    {
        $XU = $this->toHex($yU);
        $AJ = '';
        $Bi = strlen($XU) - 8;
        $ee = strlen($XU) & 7;
        Le:
        if (!($Bi >= $ee)) {
            goto v_;
        }
        $AJ = str_pad(decbin(hexdec(substr($XU, $Bi, 8))), 32, "\60", STR_PAD_LEFT) . $AJ;
        UY:
        $Bi -= 8;
        goto Le;
        v_:
        if (!$ee) {
            goto po;
        }
        $AJ = str_pad(decbin(hexdec(substr($XU, 0, $ee))), 8, "\60", STR_PAD_LEFT) . $AJ;
        po:
        $Mn = $this->precision > 0 ? substr($AJ, -$this->precision) : ltrim($AJ, "\x30");
        if (!($yU && $this->compare(new Math_BigInteger()) > 0 && $this->precision <= 0)) {
            goto Va;
        }
        return "\60" . $Mn;
        Va:
        return $Mn;
    }
    function toString()
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_strval($this->value);
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value === "\x30")) {
                    goto di;
                }
                return "\x30";
                di:
                return ltrim($this->value, "\x30");
        }
        L0:
        Aw:
        if (count($this->value)) {
            goto o0;
        }
        return "\x30";
        o0:
        $C3 = $this->copy();
        $C3->is_negative = false;
        $qz = new Math_BigInteger();
        $qz->value = array(MATH_BIGINTEGER_MAX10);
        $Mn = '';
        vk:
        if (!count($C3->value)) {
            goto VP;
        }
        list($C3, $Ex) = $C3->divide($qz);
        $Mn = str_pad(isset($Ex->value[0]) ? $Ex->value[0] : '', MATH_BIGINTEGER_MAX10_LEN, "\60", STR_PAD_LEFT) . $Mn;
        goto vk;
        VP:
        $Mn = ltrim($Mn, "\60");
        if (!empty($Mn)) {
            goto U_;
        }
        $Mn = "\60";
        U_:
        if (!$this->is_negative) {
            goto zB;
        }
        $Mn = "\x2d" . $Mn;
        zB:
        return $Mn;
    }
    function copy()
    {
        $C3 = new Math_BigInteger();
        $C3->value = $this->value;
        $C3->is_negative = $this->is_negative;
        $C3->precision = $this->precision;
        $C3->bitmask = $this->bitmask;
        return $C3;
    }
    function __toString()
    {
        return $this->toString();
    }
    function __clone()
    {
        return $this->copy();
    }
    function __sleep()
    {
        $this->hex = $this->toHex(true);
        $HC = array("\150\x65\170");
        if (!($this->precision > 0)) {
            goto J3;
        }
        $HC[] = "\160\x72\x65\x63\x69\163\x69\x6f\156";
        J3:
        return $HC;
    }
    function __wakeup()
    {
        $C3 = new Math_BigInteger($this->hex, -16);
        $this->value = $C3->value;
        $this->is_negative = $C3->is_negative;
        if (!($this->precision > 0)) {
            goto w9;
        }
        $this->setPrecision($this->precision);
        w9:
    }
    function __debugInfo()
    {
        $d9 = array();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $Si = "\x67\x6d\160";
                goto p1;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Si = "\x62\x63\155\x61\x74\150";
                goto p1;
            case MATH_BIGINTEGER_MODE_INTERNAL:
                $Si = "\x69\x6e\x74\x65\x72\x6e\x61\x6c";
                $d9[] = PHP_INT_SIZE == 8 ? "\x36\x34\55\x62\x69\x74" : "\x33\x32\x2d\142\151\x74";
        }
        SW:
        p1:
        if (!(MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_GMP && defined("\115\101\x54\x48\x5f\x42\x49\107\111\116\x54\x45\x47\x45\122\x5f\x4f\120\x45\x4e\123\123\114\137\x45\116\101\102\x4c\105\x44"))) {
            goto cn;
        }
        $d9[] = "\x4f\x70\145\156\123\x53\x4c";
        cn:
        if (empty($d9)) {
            goto EA;
        }
        $Si .= "\x20\x28" . implode($d9, "\x2c\40") . "\x29";
        EA:
        return array("\166\141\154\x75\145" => "\x30\170" . $this->toHex(true), "\x65\x6e\147\x69\x6e\x65" => $Si);
    }
    function add($wQ)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3 = new Math_BigInteger();
                $C3->value = gmp_add($this->value, $wQ->value);
                return $this->_normalize($C3);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $C3 = new Math_BigInteger();
                $C3->value = bcadd($this->value, $wQ->value, 0);
                return $this->_normalize($C3);
        }
        Rc:
        Db:
        $C3 = $this->_add($this->value, $this->is_negative, $wQ->value, $wQ->is_negative);
        $Mn = new Math_BigInteger();
        $Mn->value = $C3[MATH_BIGINTEGER_VALUE];
        $Mn->is_negative = $C3[MATH_BIGINTEGER_SIGN];
        return $this->_normalize($Mn);
    }
    function _add($fo, $uw, $XX, $U8)
    {
        $k8 = count($fo);
        $mt = count($XX);
        if ($k8 == 0) {
            goto cO;
        }
        if ($mt == 0) {
            goto ZD;
        }
        goto u2;
        cO:
        return array(MATH_BIGINTEGER_VALUE => $XX, MATH_BIGINTEGER_SIGN => $U8);
        goto u2;
        ZD:
        return array(MATH_BIGINTEGER_VALUE => $fo, MATH_BIGINTEGER_SIGN => $uw);
        u2:
        if (!($uw != $U8)) {
            goto GV;
        }
        if (!($fo == $XX)) {
            goto pc;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        pc:
        $C3 = $this->_subtract($fo, false, $XX, false);
        $C3[MATH_BIGINTEGER_SIGN] = $this->_compare($fo, false, $XX, false) > 0 ? $uw : $U8;
        return $C3;
        GV:
        if ($k8 < $mt) {
            goto ch;
        }
        $Sh = $mt;
        $sh = $fo;
        goto li;
        ch:
        $Sh = $k8;
        $sh = $XX;
        li:
        $sh[count($sh)] = 0;
        $WH = 0;
        $Bi = 0;
        $lQ = 1;
        BY:
        if (!($lQ < $Sh)) {
            goto Ic;
        }
        $pu = $fo[$lQ] * MATH_BIGINTEGER_BASE_FULL + $fo[$Bi] + $XX[$lQ] * MATH_BIGINTEGER_BASE_FULL + $XX[$Bi] + $WH;
        $WH = $pu >= MATH_BIGINTEGER_MAX_DIGIT2;
        $pu = $WH ? $pu - MATH_BIGINTEGER_MAX_DIGIT2 : $pu;
        $C3 = MATH_BIGINTEGER_BASE === 26 ? intval($pu / 0x4000000) : $pu >> 31;
        $sh[$Bi] = (int) ($pu - MATH_BIGINTEGER_BASE_FULL * $C3);
        $sh[$lQ] = $C3;
        Ch:
        $Bi += 2;
        $lQ += 2;
        goto BY;
        Ic:
        if (!($lQ == $Sh)) {
            goto Mf;
        }
        $pu = $fo[$Bi] + $XX[$Bi] + $WH;
        $WH = $pu >= MATH_BIGINTEGER_BASE_FULL;
        $sh[$Bi] = $WH ? $pu - MATH_BIGINTEGER_BASE_FULL : $pu;
        ++$Bi;
        Mf:
        if (!$WH) {
            goto eH;
        }
        nE:
        if (!($sh[$Bi] == MATH_BIGINTEGER_MAX_DIGIT)) {
            goto Ov;
        }
        $sh[$Bi] = 0;
        s5:
        ++$Bi;
        goto nE;
        Ov:
        ++$sh[$Bi];
        eH:
        return array(MATH_BIGINTEGER_VALUE => $this->_trim($sh), MATH_BIGINTEGER_SIGN => $uw);
    }
    function subtract($wQ)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3 = new Math_BigInteger();
                $C3->value = gmp_sub($this->value, $wQ->value);
                return $this->_normalize($C3);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $C3 = new Math_BigInteger();
                $C3->value = bcsub($this->value, $wQ->value, 0);
                return $this->_normalize($C3);
        }
        cm:
        SY:
        $C3 = $this->_subtract($this->value, $this->is_negative, $wQ->value, $wQ->is_negative);
        $Mn = new Math_BigInteger();
        $Mn->value = $C3[MATH_BIGINTEGER_VALUE];
        $Mn->is_negative = $C3[MATH_BIGINTEGER_SIGN];
        return $this->_normalize($Mn);
    }
    function _subtract($fo, $uw, $XX, $U8)
    {
        $k8 = count($fo);
        $mt = count($XX);
        if ($k8 == 0) {
            goto aY;
        }
        if ($mt == 0) {
            goto KZ;
        }
        goto YC;
        aY:
        return array(MATH_BIGINTEGER_VALUE => $XX, MATH_BIGINTEGER_SIGN => !$U8);
        goto YC;
        KZ:
        return array(MATH_BIGINTEGER_VALUE => $fo, MATH_BIGINTEGER_SIGN => $uw);
        YC:
        if (!($uw != $U8)) {
            goto jF;
        }
        $C3 = $this->_add($fo, false, $XX, false);
        $C3[MATH_BIGINTEGER_SIGN] = $uw;
        return $C3;
        jF:
        $yT = $this->_compare($fo, $uw, $XX, $U8);
        if ($yT) {
            goto gB;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        gB:
        if (!(!$uw && $yT < 0 || $uw && $yT > 0)) {
            goto pY;
        }
        $C3 = $fo;
        $fo = $XX;
        $XX = $C3;
        $uw = !$uw;
        $k8 = count($fo);
        $mt = count($XX);
        pY:
        $WH = 0;
        $Bi = 0;
        $lQ = 1;
        h6:
        if (!($lQ < $mt)) {
            goto jk;
        }
        $pu = $fo[$lQ] * MATH_BIGINTEGER_BASE_FULL + $fo[$Bi] - $XX[$lQ] * MATH_BIGINTEGER_BASE_FULL - $XX[$Bi] - $WH;
        $WH = $pu < 0;
        $pu = $WH ? $pu + MATH_BIGINTEGER_MAX_DIGIT2 : $pu;
        $C3 = MATH_BIGINTEGER_BASE === 26 ? intval($pu / 0x4000000) : $pu >> 31;
        $fo[$Bi] = (int) ($pu - MATH_BIGINTEGER_BASE_FULL * $C3);
        $fo[$lQ] = $C3;
        Sb:
        $Bi += 2;
        $lQ += 2;
        goto h6;
        jk:
        if (!($lQ == $mt)) {
            goto ba;
        }
        $pu = $fo[$Bi] - $XX[$Bi] - $WH;
        $WH = $pu < 0;
        $fo[$Bi] = $WH ? $pu + MATH_BIGINTEGER_BASE_FULL : $pu;
        ++$Bi;
        ba:
        if (!$WH) {
            goto q2;
        }
        Nk:
        if ($fo[$Bi]) {
            goto ED;
        }
        $fo[$Bi] = MATH_BIGINTEGER_MAX_DIGIT;
        N_:
        ++$Bi;
        goto Nk;
        ED:
        --$fo[$Bi];
        q2:
        return array(MATH_BIGINTEGER_VALUE => $this->_trim($fo), MATH_BIGINTEGER_SIGN => $uw);
    }
    function multiply($rk)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3 = new Math_BigInteger();
                $C3->value = gmp_mul($this->value, $rk->value);
                return $this->_normalize($C3);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $C3 = new Math_BigInteger();
                $C3->value = bcmul($this->value, $rk->value, 0);
                return $this->_normalize($C3);
        }
        C5:
        X5:
        $C3 = $this->_multiply($this->value, $this->is_negative, $rk->value, $rk->is_negative);
        $CQ = new Math_BigInteger();
        $CQ->value = $C3[MATH_BIGINTEGER_VALUE];
        $CQ->is_negative = $C3[MATH_BIGINTEGER_SIGN];
        return $this->_normalize($CQ);
    }
    function _multiply($fo, $uw, $XX, $U8)
    {
        $G0 = count($fo);
        $EJ = count($XX);
        if (!(!$G0 || !$EJ)) {
            goto ml;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        ml:
        return array(MATH_BIGINTEGER_VALUE => min($G0, $EJ) < 2 * MATH_BIGINTEGER_KARATSUBA_CUTOFF ? $this->_trim($this->_regularMultiply($fo, $XX)) : $this->_trim($this->_karatsuba($fo, $XX)), MATH_BIGINTEGER_SIGN => $uw != $U8);
    }
    function _regularMultiply($fo, $XX)
    {
        $G0 = count($fo);
        $EJ = count($XX);
        if (!(!$G0 || !$EJ)) {
            goto cV;
        }
        return array();
        cV:
        if (!($G0 < $EJ)) {
            goto Qo;
        }
        $C3 = $fo;
        $fo = $XX;
        $XX = $C3;
        $G0 = count($fo);
        $EJ = count($XX);
        Qo:
        $zV = $this->_array_repeat(0, $G0 + $EJ);
        $WH = 0;
        $lQ = 0;
        V2:
        if (!($lQ < $G0)) {
            goto Ns;
        }
        $C3 = $fo[$lQ] * $XX[0] + $WH;
        $WH = MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31;
        $zV[$lQ] = (int) ($C3 - MATH_BIGINTEGER_BASE_FULL * $WH);
        cI:
        ++$lQ;
        goto V2;
        Ns:
        $zV[$lQ] = $WH;
        $Bi = 1;
        iv:
        if (!($Bi < $EJ)) {
            goto y2;
        }
        $WH = 0;
        $lQ = 0;
        $GC = $Bi;
        Tw:
        if (!($lQ < $G0)) {
            goto so;
        }
        $C3 = $zV[$GC] + $fo[$lQ] * $XX[$Bi] + $WH;
        $WH = MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31;
        $zV[$GC] = (int) ($C3 - MATH_BIGINTEGER_BASE_FULL * $WH);
        vi:
        ++$lQ;
        ++$GC;
        goto Tw;
        so:
        $zV[$GC] = $WH;
        C0:
        ++$Bi;
        goto iv;
        y2:
        return $zV;
    }
    function _karatsuba($fo, $XX)
    {
        $KJ = min(count($fo) >> 1, count($XX) >> 1);
        if (!($KJ < MATH_BIGINTEGER_KARATSUBA_CUTOFF)) {
            goto fe;
        }
        return $this->_regularMultiply($fo, $XX);
        fe:
        $j9 = array_slice($fo, $KJ);
        $LL = array_slice($fo, 0, $KJ);
        $Yz = array_slice($XX, $KJ);
        $UO = array_slice($XX, 0, $KJ);
        $ml = $this->_karatsuba($j9, $Yz);
        $TT = $this->_karatsuba($LL, $UO);
        $z1 = $this->_add($j9, false, $LL, false);
        $C3 = $this->_add($Yz, false, $UO, false);
        $z1 = $this->_karatsuba($z1[MATH_BIGINTEGER_VALUE], $C3[MATH_BIGINTEGER_VALUE]);
        $C3 = $this->_add($ml, false, $TT, false);
        $z1 = $this->_subtract($z1, false, $C3[MATH_BIGINTEGER_VALUE], false);
        $ml = array_merge(array_fill(0, 2 * $KJ, 0), $ml);
        $z1[MATH_BIGINTEGER_VALUE] = array_merge(array_fill(0, $KJ, 0), $z1[MATH_BIGINTEGER_VALUE]);
        $Q0 = $this->_add($ml, false, $z1[MATH_BIGINTEGER_VALUE], $z1[MATH_BIGINTEGER_SIGN]);
        $Q0 = $this->_add($Q0[MATH_BIGINTEGER_VALUE], $Q0[MATH_BIGINTEGER_SIGN], $TT, false);
        return $Q0[MATH_BIGINTEGER_VALUE];
    }
    function _square($rk = false)
    {
        return count($rk) < 2 * MATH_BIGINTEGER_KARATSUBA_CUTOFF ? $this->_trim($this->_baseSquare($rk)) : $this->_trim($this->_karatsubaSquare($rk));
    }
    function _baseSquare($sh)
    {
        if (!empty($sh)) {
            goto mB;
        }
        return array();
        mB:
        $k5 = $this->_array_repeat(0, 2 * count($sh));
        $Bi = 0;
        $NT = count($sh) - 1;
        hI:
        if (!($Bi <= $NT)) {
            goto Se;
        }
        $jp = $Bi << 1;
        $C3 = $k5[$jp] + $sh[$Bi] * $sh[$Bi];
        $WH = MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31;
        $k5[$jp] = (int) ($C3 - MATH_BIGINTEGER_BASE_FULL * $WH);
        $lQ = $Bi + 1;
        $GC = $jp + 1;
        Si:
        if (!($lQ <= $NT)) {
            goto Ys;
        }
        $C3 = $k5[$GC] + 2 * $sh[$lQ] * $sh[$Bi] + $WH;
        $WH = MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31;
        $k5[$GC] = (int) ($C3 - MATH_BIGINTEGER_BASE_FULL * $WH);
        fl:
        ++$lQ;
        ++$GC;
        goto Si;
        Ys:
        $k5[$Bi + $NT + 1] = $WH;
        ou:
        ++$Bi;
        goto hI;
        Se:
        return $k5;
    }
    function _karatsubaSquare($sh)
    {
        $KJ = count($sh) >> 1;
        if (!($KJ < MATH_BIGINTEGER_KARATSUBA_CUTOFF)) {
            goto xz;
        }
        return $this->_baseSquare($sh);
        xz:
        $j9 = array_slice($sh, $KJ);
        $LL = array_slice($sh, 0, $KJ);
        $ml = $this->_karatsubaSquare($j9);
        $TT = $this->_karatsubaSquare($LL);
        $z1 = $this->_add($j9, false, $LL, false);
        $z1 = $this->_karatsubaSquare($z1[MATH_BIGINTEGER_VALUE]);
        $C3 = $this->_add($ml, false, $TT, false);
        $z1 = $this->_subtract($z1, false, $C3[MATH_BIGINTEGER_VALUE], false);
        $ml = array_merge(array_fill(0, 2 * $KJ, 0), $ml);
        $z1[MATH_BIGINTEGER_VALUE] = array_merge(array_fill(0, $KJ, 0), $z1[MATH_BIGINTEGER_VALUE]);
        $bH = $this->_add($ml, false, $z1[MATH_BIGINTEGER_VALUE], $z1[MATH_BIGINTEGER_SIGN]);
        $bH = $this->_add($bH[MATH_BIGINTEGER_VALUE], $bH[MATH_BIGINTEGER_SIGN], $TT, false);
        return $bH[MATH_BIGINTEGER_VALUE];
    }
    function divide($wQ)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $a_ = new Math_BigInteger();
                $fl = new Math_BigInteger();
                list($a_->value, $fl->value) = gmp_div_qr($this->value, $wQ->value);
                if (!(gmp_sign($fl->value) < 0)) {
                    goto zf;
                }
                $fl->value = gmp_add($fl->value, gmp_abs($wQ->value));
                zf:
                return array($this->_normalize($a_), $this->_normalize($fl));
            case MATH_BIGINTEGER_MODE_BCMATH:
                $a_ = new Math_BigInteger();
                $fl = new Math_BigInteger();
                $a_->value = bcdiv($this->value, $wQ->value, 0);
                $fl->value = bcmod($this->value, $wQ->value);
                if (!($fl->value[0] == "\55")) {
                    goto ZB;
                }
                $fl->value = bcadd($fl->value, $wQ->value[0] == "\55" ? substr($wQ->value, 1) : $wQ->value, 0);
                ZB:
                return array($this->_normalize($a_), $this->_normalize($fl));
        }
        aZ:
        Wx:
        if (!(count($wQ->value) == 1)) {
            goto KE;
        }
        list($Hz, $Xg) = $this->_divide_digit($this->value, $wQ->value[0]);
        $a_ = new Math_BigInteger();
        $fl = new Math_BigInteger();
        $a_->value = $Hz;
        $fl->value = array($Xg);
        $a_->is_negative = $this->is_negative != $wQ->is_negative;
        return array($this->_normalize($a_), $this->_normalize($fl));
        KE:
        static $bs;
        if (isset($bs)) {
            goto QB;
        }
        $bs = new Math_BigInteger();
        QB:
        $rk = $this->copy();
        $wQ = $wQ->copy();
        $F1 = $rk->is_negative;
        $zz = $wQ->is_negative;
        $rk->is_negative = $wQ->is_negative = false;
        $yT = $rk->compare($wQ);
        if ($yT) {
            goto yq;
        }
        $C3 = new Math_BigInteger();
        $C3->value = array(1);
        $C3->is_negative = $F1 != $zz;
        return array($this->_normalize($C3), $this->_normalize(new Math_BigInteger()));
        yq:
        if (!($yT < 0)) {
            goto DI;
        }
        if (!$F1) {
            goto hr;
        }
        $rk = $wQ->subtract($rk);
        hr:
        return array($this->_normalize(new Math_BigInteger()), $this->_normalize($rk));
        DI:
        $a5 = $wQ->value[count($wQ->value) - 1];
        $ly = 0;
        ie:
        if ($a5 & MATH_BIGINTEGER_MSB) {
            goto Cu;
        }
        $a5 <<= 1;
        Lp:
        ++$ly;
        goto ie;
        Cu:
        $rk->_lshift($ly);
        $wQ->_lshift($ly);
        $XX =& $wQ->value;
        $Uy = count($rk->value) - 1;
        $pS = count($wQ->value) - 1;
        $a_ = new Math_BigInteger();
        $gr =& $a_->value;
        $gr = $this->_array_repeat(0, $Uy - $pS + 1);
        static $C3, $Nv, $Wo;
        if (isset($C3)) {
            goto uT;
        }
        $C3 = new Math_BigInteger();
        $Nv = new Math_BigInteger();
        $Wo = new Math_BigInteger();
        uT:
        $fj =& $C3->value;
        $o0 =& $Wo->value;
        $fj = array_merge($this->_array_repeat(0, $Uy - $pS), $XX);
        dA:
        if (!($rk->compare($C3) >= 0)) {
            goto t7;
        }
        ++$gr[$Uy - $pS];
        $rk = $rk->subtract($C3);
        $Uy = count($rk->value) - 1;
        goto dA;
        t7:
        $Bi = $Uy;
        wM:
        if (!($Bi >= $pS + 1)) {
            goto Dn;
        }
        $fo =& $rk->value;
        $B0 = array(isset($fo[$Bi]) ? $fo[$Bi] : 0, isset($fo[$Bi - 1]) ? $fo[$Bi - 1] : 0, isset($fo[$Bi - 2]) ? $fo[$Bi - 2] : 0);
        $Zy = array($XX[$pS], $pS > 0 ? $XX[$pS - 1] : 0);
        $nw = $Bi - $pS - 1;
        if ($B0[0] == $Zy[0]) {
            goto ZI;
        }
        $gr[$nw] = $this->_safe_divide($B0[0] * MATH_BIGINTEGER_BASE_FULL + $B0[1], $Zy[0]);
        goto Ld;
        ZI:
        $gr[$nw] = MATH_BIGINTEGER_MAX_DIGIT;
        Ld:
        $fj = array($Zy[1], $Zy[0]);
        $Nv->value = array($gr[$nw]);
        $Nv = $Nv->multiply($C3);
        $o0 = array($B0[2], $B0[1], $B0[0]);
        WP:
        if (!($Nv->compare($Wo) > 0)) {
            goto ML;
        }
        --$gr[$nw];
        $Nv->value = array($gr[$nw]);
        $Nv = $Nv->multiply($C3);
        goto WP;
        ML:
        $AS = $this->_array_repeat(0, $nw);
        $fj = array($gr[$nw]);
        $C3 = $C3->multiply($wQ);
        $fj =& $C3->value;
        $fj = array_merge($AS, $fj);
        $rk = $rk->subtract($C3);
        if (!($rk->compare($bs) < 0)) {
            goto bx;
        }
        $fj = array_merge($AS, $XX);
        $rk = $rk->add($C3);
        --$gr[$nw];
        bx:
        $Uy = count($fo) - 1;
        YN:
        --$Bi;
        goto wM;
        Dn:
        $rk->_rshift($ly);
        $a_->is_negative = $F1 != $zz;
        if (!$F1) {
            goto x8;
        }
        $wQ->_rshift($ly);
        $rk = $wQ->subtract($rk);
        x8:
        return array($this->_normalize($a_), $this->_normalize($rk));
    }
    function _divide_digit($C2, $qz)
    {
        $WH = 0;
        $Mn = array();
        $Bi = count($C2) - 1;
        jm:
        if (!($Bi >= 0)) {
            goto nm;
        }
        $C3 = MATH_BIGINTEGER_BASE_FULL * $WH + $C2[$Bi];
        $Mn[$Bi] = $this->_safe_divide($C3, $qz);
        $WH = (int) ($C3 - $qz * $Mn[$Bi]);
        n3:
        --$Bi;
        goto jm;
        nm:
        return array($Mn, $WH);
    }
    function modPow($iz, $mO)
    {
        $mO = $this->bitmask !== false && $this->bitmask->compare($mO) < 0 ? $this->bitmask : $mO->abs();
        if (!($iz->compare(new Math_BigInteger()) < 0)) {
            goto ok;
        }
        $iz = $iz->abs();
        $C3 = $this->modInverse($mO);
        if (!($C3 === false)) {
            goto Sr;
        }
        return false;
        Sr:
        return $this->_normalize($C3->modPow($iz, $mO));
        ok:
        if (!(MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_GMP)) {
            goto Cy;
        }
        $C3 = new Math_BigInteger();
        $C3->value = gmp_powm($this->value, $iz->value, $mO->value);
        return $this->_normalize($C3);
        Cy:
        if (!($this->compare(new Math_BigInteger()) < 0 || $this->compare($mO) > 0)) {
            goto I2;
        }
        list(, $C3) = $this->divide($mO);
        return $C3->modPow($iz, $mO);
        I2:
        if (!defined("\115\x41\x54\110\137\102\111\x47\x49\116\124\x45\107\x45\122\137\117\120\105\116\x53\123\x4c\x5f\105\x4e\x41\x42\x4c\105\104")) {
            goto ve;
        }
        $Lw = array("\x6d\x6f\x64\x75\x6c\165\163" => $mO->toBytes(true), "\160\165\x62\154\x69\x63\105\x78\160\157\x6e\145\x6e\x74" => $iz->toBytes(true));
        $Lw = array("\155\x6f\144\165\x6c\x75\163" => pack("\x43\141\x2a\x61\x2a", 2, $this->_encodeASN1Length(strlen($Lw["\155\157\144\165\x6c\165\163"])), $Lw["\x6d\157\144\165\x6c\x75\163"]), "\160\165\142\x6c\x69\143\x45\x78\160\157\156\x65\156\164" => pack("\103\141\x2a\141\x2a", 2, $this->_encodeASN1Length(strlen($Lw["\160\x75\x62\x6c\x69\x63\x45\x78\160\x6f\x6e\145\156\164"])), $Lw["\160\165\x62\154\x69\x63\105\x78\x70\157\156\x65\x6e\x74"]));
        $J6 = pack("\x43\x61\52\141\x2a\141\x2a", 48, $this->_encodeASN1Length(strlen($Lw["\155\x6f\x64\x75\x6c\165\x73"]) + strlen($Lw["\x70\x75\142\154\x69\x63\x45\170\x70\x6f\156\x65\156\x74"])), $Lw["\x6d\157\144\x75\x6c\x75\x73"], $Lw["\x70\x75\142\154\151\x63\105\x78\160\157\156\145\x6e\164"]);
        $Vr = pack("\x48\52", "\63\x30\x30\144\60\x36\60\x39\x32\141\x38\x36\x34\x38\x38\x36\x66\67\x30\144\x30\x31\60\x31\60\61\60\65\x30\60");
        $J6 = chr(0) . $J6;
        $J6 = chr(3) . $this->_encodeASN1Length(strlen($J6)) . $J6;
        $i3 = pack("\x43\x61\x2a\141\52", 48, $this->_encodeASN1Length(strlen($Vr . $J6)), $Vr . $J6);
        $J6 = "\x2d\55\55\x2d\x2d\102\105\107\111\116\40\120\x55\102\114\x49\x43\x20\113\105\131\x2d\x2d\x2d\x2d\x2d\15\xa" . chunk_split(base64_encode($i3)) . "\55\55\x2d\x2d\55\105\116\x44\x20\x50\125\102\x4c\x49\x43\x20\x4b\x45\131\55\x2d\x2d\55\x2d";
        $Ar = str_pad($this->toBytes(), strlen($mO->toBytes(true)) - 1, "\x0", STR_PAD_LEFT);
        if (!openssl_public_encrypt($Ar, $Mn, $J6, OPENSSL_NO_PADDING)) {
            goto VI;
        }
        return new Math_BigInteger($Mn, 256);
        VI:
        ve:
        if (!(MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_BCMATH)) {
            goto Dq;
        }
        $C3 = new Math_BigInteger();
        $C3->value = bcpowmod($this->value, $iz->value, $mO->value, 0);
        return $this->_normalize($C3);
        Dq:
        if (!empty($iz->value)) {
            goto sR;
        }
        $C3 = new Math_BigInteger();
        $C3->value = array(1);
        return $this->_normalize($C3);
        sR:
        if (!($iz->value == array(1))) {
            goto gn;
        }
        list(, $C3) = $this->divide($mO);
        return $this->_normalize($C3);
        gn:
        if (!($iz->value == array(2))) {
            goto Fr;
        }
        $C3 = new Math_BigInteger();
        $C3->value = $this->_square($this->value);
        list(, $C3) = $C3->divide($mO);
        return $this->_normalize($C3);
        Fr:
        return $this->_normalize($this->_slidingWindow($iz, $mO, MATH_BIGINTEGER_BARRETT));
        if (!($mO->value[0] & 1)) {
            goto Ji;
        }
        return $this->_normalize($this->_slidingWindow($iz, $mO, MATH_BIGINTEGER_MONTGOMERY));
        Ji:
        $Bi = 0;
        Cg:
        if (!($Bi < count($mO->value))) {
            goto ID;
        }
        if (!$mO->value[$Bi]) {
            goto PF;
        }
        $C3 = decbin($mO->value[$Bi]);
        $lQ = strlen($C3) - strrpos($C3, "\61") - 1;
        $lQ += 26 * $Bi;
        goto ID;
        PF:
        r1:
        ++$Bi;
        goto Cg;
        ID:
        $yn = $mO->copy();
        $yn->_rshift($lQ);
        $K9 = new Math_BigInteger();
        $K9->value = array(1);
        $K9->_lshift($lQ);
        $Ff = $yn->value != array(1) ? $this->_slidingWindow($iz, $yn, MATH_BIGINTEGER_MONTGOMERY) : new Math_BigInteger();
        $Xz = $this->_slidingWindow($iz, $K9, MATH_BIGINTEGER_POWEROF2);
        $Yz = $K9->modInverse($yn);
        $vl = $yn->modInverse($K9);
        $Mn = $Ff->multiply($K9);
        $Mn = $Mn->multiply($Yz);
        $C3 = $Xz->multiply($yn);
        $C3 = $C3->multiply($vl);
        $Mn = $Mn->add($C3);
        list(, $Mn) = $Mn->divide($mO);
        return $this->_normalize($Mn);
    }
    function powMod($iz, $mO)
    {
        return $this->modPow($iz, $mO);
    }
    function _slidingWindow($iz, $mO, $SG)
    {
        static $YC = array(7, 25, 81, 241, 673, 1793);
        $zc = $iz->value;
        $Wk = count($zc) - 1;
        $Om = decbin($zc[$Wk]);
        $Bi = $Wk - 1;
        Qi:
        if (!($Bi >= 0)) {
            goto xk;
        }
        $Om .= str_pad(decbin($zc[$Bi]), MATH_BIGINTEGER_BASE, "\x30", STR_PAD_LEFT);
        XN:
        --$Bi;
        goto Qi;
        xk:
        $Wk = strlen($Om);
        $Bi = 0;
        $Kh = 1;
        gt:
        if (!($Bi < count($YC) && $Wk > $YC[$Bi])) {
            goto PW;
        }
        yF:
        ++$Kh;
        ++$Bi;
        goto gt;
        PW:
        $aa = $mO->value;
        $aG = array();
        $aG[1] = $this->_prepareReduce($this->value, $aa, $SG);
        $aG[2] = $this->_squareReduce($aG[1], $aa, $SG);
        $C3 = 1 << $Kh - 1;
        $Bi = 1;
        Cf:
        if (!($Bi < $C3)) {
            goto fO;
        }
        $jp = $Bi << 1;
        $aG[$jp + 1] = $this->_multiplyReduce($aG[$jp - 1], $aG[2], $aa, $SG);
        wF:
        ++$Bi;
        goto Cf;
        fO:
        $Mn = array(1);
        $Mn = $this->_prepareReduce($Mn, $aa, $SG);
        $Bi = 0;
        D1:
        if (!($Bi < $Wk)) {
            goto SN;
        }
        if (!$Om[$Bi]) {
            goto RU;
        }
        $lQ = $Kh - 1;
        aO:
        if (!($lQ > 0)) {
            goto Nh;
        }
        if (empty($Om[$Bi + $lQ])) {
            goto zh;
        }
        goto Nh;
        zh:
        ar:
        --$lQ;
        goto aO;
        Nh:
        $GC = 0;
        L5:
        if (!($GC <= $lQ)) {
            goto FO;
        }
        $Mn = $this->_squareReduce($Mn, $aa, $SG);
        xq:
        ++$GC;
        goto L5;
        FO:
        $Mn = $this->_multiplyReduce($Mn, $aG[bindec(substr($Om, $Bi, $lQ + 1))], $aa, $SG);
        $Bi += $lQ + 1;
        goto sl;
        RU:
        $Mn = $this->_squareReduce($Mn, $aa, $SG);
        ++$Bi;
        sl:
        zy:
        goto D1;
        SN:
        $C3 = new Math_BigInteger();
        $C3->value = $this->_reduce($Mn, $aa, $SG);
        return $C3;
    }
    function _reduce($rk, $mO, $SG)
    {
        switch ($SG) {
            case MATH_BIGINTEGER_MONTGOMERY:
                return $this->_montgomery($rk, $mO);
            case MATH_BIGINTEGER_BARRETT:
                return $this->_barrett($rk, $mO);
            case MATH_BIGINTEGER_POWEROF2:
                $Nv = new Math_BigInteger();
                $Nv->value = $rk;
                $Wo = new Math_BigInteger();
                $Wo->value = $mO;
                return $rk->_mod2($mO);
            case MATH_BIGINTEGER_CLASSIC:
                $Nv = new Math_BigInteger();
                $Nv->value = $rk;
                $Wo = new Math_BigInteger();
                $Wo->value = $mO;
                list(, $C3) = $Nv->divide($Wo);
                return $C3->value;
            case MATH_BIGINTEGER_NONE:
                return $rk;
            default:
        }
        RI:
        qD:
    }
    function _prepareReduce($rk, $mO, $SG)
    {
        if (!($SG == MATH_BIGINTEGER_MONTGOMERY)) {
            goto XR;
        }
        return $this->_prepMontgomery($rk, $mO);
        XR:
        return $this->_reduce($rk, $mO, $SG);
    }
    function _multiplyReduce($rk, $wQ, $mO, $SG)
    {
        if (!($SG == MATH_BIGINTEGER_MONTGOMERY)) {
            goto Bc;
        }
        return $this->_montgomeryMultiply($rk, $wQ, $mO);
        Bc:
        $C3 = $this->_multiply($rk, false, $wQ, false);
        return $this->_reduce($C3[MATH_BIGINTEGER_VALUE], $mO, $SG);
    }
    function _squareReduce($rk, $mO, $SG)
    {
        if (!($SG == MATH_BIGINTEGER_MONTGOMERY)) {
            goto wr;
        }
        return $this->_montgomeryMultiply($rk, $rk, $mO);
        wr:
        return $this->_reduce($this->_square($rk), $mO, $SG);
    }
    function _mod2($mO)
    {
        $C3 = new Math_BigInteger();
        $C3->value = array(1);
        return $this->bitwise_and($mO->subtract($C3));
    }
    function _barrett($mO, $KJ)
    {
        static $Z4 = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        $nc = count($KJ);
        if (!(count($mO) > 2 * $nc)) {
            goto qn;
        }
        $Nv = new Math_BigInteger();
        $Wo = new Math_BigInteger();
        $Nv->value = $mO;
        $Wo->value = $KJ;
        list(, $C3) = $Nv->divide($Wo);
        return $C3->value;
        qn:
        if (!($nc < 5)) {
            goto CW;
        }
        return $this->_regularBarrett($mO, $KJ);
        CW:
        if (($aZ = array_search($KJ, $Z4[MATH_BIGINTEGER_VARIABLE])) === false) {
            goto Zc;
        }
        extract($Z4[MATH_BIGINTEGER_DATA][$aZ]);
        goto Qq;
        Zc:
        $aZ = count($Z4[MATH_BIGINTEGER_VARIABLE]);
        $Z4[MATH_BIGINTEGER_VARIABLE][] = $KJ;
        $Nv = new Math_BigInteger();
        $JY =& $Nv->value;
        $JY = $this->_array_repeat(0, $nc + ($nc >> 1));
        $JY[] = 1;
        $Wo = new Math_BigInteger();
        $Wo->value = $KJ;
        list($Ry, $RT) = $Nv->divide($Wo);
        $Ry = $Ry->value;
        $RT = $RT->value;
        $Z4[MATH_BIGINTEGER_DATA][] = array("\x75" => $Ry, "\155\x31" => $RT);
        Qq:
        $GD = $nc + ($nc >> 1);
        $dV = array_slice($mO, 0, $GD);
        $I7 = array_slice($mO, $GD);
        $dV = $this->_trim($dV);
        $C3 = $this->_multiply($I7, false, $RT, false);
        $mO = $this->_add($dV, false, $C3[MATH_BIGINTEGER_VALUE], false);
        if (!($nc & 1)) {
            goto v6;
        }
        return $this->_regularBarrett($mO[MATH_BIGINTEGER_VALUE], $KJ);
        v6:
        $C3 = array_slice($mO[MATH_BIGINTEGER_VALUE], $nc - 1);
        $C3 = $this->_multiply($C3, false, $Ry, false);
        $C3 = array_slice($C3[MATH_BIGINTEGER_VALUE], ($nc >> 1) + 1);
        $C3 = $this->_multiply($C3, false, $KJ, false);
        $Mn = $this->_subtract($mO[MATH_BIGINTEGER_VALUE], false, $C3[MATH_BIGINTEGER_VALUE], false);
        CG:
        if (!($this->_compare($Mn[MATH_BIGINTEGER_VALUE], $Mn[MATH_BIGINTEGER_SIGN], $KJ, false) >= 0)) {
            goto M1;
        }
        $Mn = $this->_subtract($Mn[MATH_BIGINTEGER_VALUE], $Mn[MATH_BIGINTEGER_SIGN], $KJ, false);
        goto CG;
        M1:
        return $Mn[MATH_BIGINTEGER_VALUE];
    }
    function _regularBarrett($rk, $mO)
    {
        static $Z4 = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        $tf = count($mO);
        if (!(count($rk) > 2 * $tf)) {
            goto gG;
        }
        $Nv = new Math_BigInteger();
        $Wo = new Math_BigInteger();
        $Nv->value = $rk;
        $Wo->value = $mO;
        list(, $C3) = $Nv->divide($Wo);
        return $C3->value;
        gG:
        if (!(($aZ = array_search($mO, $Z4[MATH_BIGINTEGER_VARIABLE])) === false)) {
            goto LP;
        }
        $aZ = count($Z4[MATH_BIGINTEGER_VARIABLE]);
        $Z4[MATH_BIGINTEGER_VARIABLE][] = $mO;
        $Nv = new Math_BigInteger();
        $JY =& $Nv->value;
        $JY = $this->_array_repeat(0, 2 * $tf);
        $JY[] = 1;
        $Wo = new Math_BigInteger();
        $Wo->value = $mO;
        list($C3, ) = $Nv->divide($Wo);
        $Z4[MATH_BIGINTEGER_DATA][] = $C3->value;
        LP:
        $C3 = array_slice($rk, $tf - 1);
        $C3 = $this->_multiply($C3, false, $Z4[MATH_BIGINTEGER_DATA][$aZ], false);
        $C3 = array_slice($C3[MATH_BIGINTEGER_VALUE], $tf + 1);
        $Mn = array_slice($rk, 0, $tf + 1);
        $C3 = $this->_multiplyLower($C3, false, $mO, false, $tf + 1);
        if (!($this->_compare($Mn, false, $C3[MATH_BIGINTEGER_VALUE], $C3[MATH_BIGINTEGER_SIGN]) < 0)) {
            goto np;
        }
        $gf = $this->_array_repeat(0, $tf + 1);
        $gf[count($gf)] = 1;
        $Mn = $this->_add($Mn, false, $gf, false);
        $Mn = $Mn[MATH_BIGINTEGER_VALUE];
        np:
        $Mn = $this->_subtract($Mn, false, $C3[MATH_BIGINTEGER_VALUE], $C3[MATH_BIGINTEGER_SIGN]);
        vy:
        if (!($this->_compare($Mn[MATH_BIGINTEGER_VALUE], $Mn[MATH_BIGINTEGER_SIGN], $mO, false) > 0)) {
            goto iS;
        }
        $Mn = $this->_subtract($Mn[MATH_BIGINTEGER_VALUE], $Mn[MATH_BIGINTEGER_SIGN], $mO, false);
        goto vy;
        iS:
        return $Mn[MATH_BIGINTEGER_VALUE];
    }
    function _multiplyLower($fo, $uw, $XX, $U8, $es)
    {
        $G0 = count($fo);
        $EJ = count($XX);
        if (!(!$G0 || !$EJ)) {
            goto Sk;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        Sk:
        if (!($G0 < $EJ)) {
            goto ru;
        }
        $C3 = $fo;
        $fo = $XX;
        $XX = $C3;
        $G0 = count($fo);
        $EJ = count($XX);
        ru:
        $zV = $this->_array_repeat(0, $G0 + $EJ);
        $WH = 0;
        $lQ = 0;
        er:
        if (!($lQ < $G0)) {
            goto sc;
        }
        $C3 = $fo[$lQ] * $XX[0] + $WH;
        $WH = MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31;
        $zV[$lQ] = (int) ($C3 - MATH_BIGINTEGER_BASE_FULL * $WH);
        zX:
        ++$lQ;
        goto er;
        sc:
        if (!($lQ < $es)) {
            goto HF;
        }
        $zV[$lQ] = $WH;
        HF:
        $Bi = 1;
        pZ:
        if (!($Bi < $EJ)) {
            goto sw;
        }
        $WH = 0;
        $lQ = 0;
        $GC = $Bi;
        Nc:
        if (!($lQ < $G0 && $GC < $es)) {
            goto H9;
        }
        $C3 = $zV[$GC] + $fo[$lQ] * $XX[$Bi] + $WH;
        $WH = MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31;
        $zV[$GC] = (int) ($C3 - MATH_BIGINTEGER_BASE_FULL * $WH);
        p5:
        ++$lQ;
        ++$GC;
        goto Nc;
        H9:
        if (!($GC < $es)) {
            goto s9;
        }
        $zV[$GC] = $WH;
        s9:
        re:
        ++$Bi;
        goto pZ;
        sw:
        return array(MATH_BIGINTEGER_VALUE => $this->_trim($zV), MATH_BIGINTEGER_SIGN => $uw != $U8);
    }
    function _montgomery($rk, $mO)
    {
        static $Z4 = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        if (!(($aZ = array_search($mO, $Z4[MATH_BIGINTEGER_VARIABLE])) === false)) {
            goto AV;
        }
        $aZ = count($Z4[MATH_BIGINTEGER_VARIABLE]);
        $Z4[MATH_BIGINTEGER_VARIABLE][] = $rk;
        $Z4[MATH_BIGINTEGER_DATA][] = $this->_modInverse67108864($mO);
        AV:
        $GC = count($mO);
        $Mn = array(MATH_BIGINTEGER_VALUE => $rk);
        $Bi = 0;
        R5:
        if (!($Bi < $GC)) {
            goto B6;
        }
        $C3 = $Mn[MATH_BIGINTEGER_VALUE][$Bi] * $Z4[MATH_BIGINTEGER_DATA][$aZ];
        $C3 = $C3 - MATH_BIGINTEGER_BASE_FULL * (MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31);
        $C3 = $this->_regularMultiply(array($C3), $mO);
        $C3 = array_merge($this->_array_repeat(0, $Bi), $C3);
        $Mn = $this->_add($Mn[MATH_BIGINTEGER_VALUE], false, $C3, false);
        wH:
        ++$Bi;
        goto R5;
        B6:
        $Mn[MATH_BIGINTEGER_VALUE] = array_slice($Mn[MATH_BIGINTEGER_VALUE], $GC);
        if (!($this->_compare($Mn, false, $mO, false) >= 0)) {
            goto hf;
        }
        $Mn = $this->_subtract($Mn[MATH_BIGINTEGER_VALUE], false, $mO, false);
        hf:
        return $Mn[MATH_BIGINTEGER_VALUE];
    }
    function _montgomeryMultiply($rk, $wQ, $KJ)
    {
        $C3 = $this->_multiply($rk, false, $wQ, false);
        return $this->_montgomery($C3[MATH_BIGINTEGER_VALUE], $KJ);
        static $Z4 = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        if (!(($aZ = array_search($KJ, $Z4[MATH_BIGINTEGER_VARIABLE])) === false)) {
            goto aR;
        }
        $aZ = count($Z4[MATH_BIGINTEGER_VARIABLE]);
        $Z4[MATH_BIGINTEGER_VARIABLE][] = $KJ;
        $Z4[MATH_BIGINTEGER_DATA][] = $this->_modInverse67108864($KJ);
        aR:
        $mO = max(count($rk), count($wQ), count($KJ));
        $rk = array_pad($rk, $mO, 0);
        $wQ = array_pad($wQ, $mO, 0);
        $KJ = array_pad($KJ, $mO, 0);
        $aN = array(MATH_BIGINTEGER_VALUE => $this->_array_repeat(0, $mO + 1));
        $Bi = 0;
        Pt:
        if (!($Bi < $mO)) {
            goto j6;
        }
        $C3 = $aN[MATH_BIGINTEGER_VALUE][0] + $rk[$Bi] * $wQ[0];
        $C3 = $C3 - MATH_BIGINTEGER_BASE_FULL * (MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31);
        $C3 = $C3 * $Z4[MATH_BIGINTEGER_DATA][$aZ];
        $C3 = $C3 - MATH_BIGINTEGER_BASE_FULL * (MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31);
        $C3 = $this->_add($this->_regularMultiply(array($rk[$Bi]), $wQ), false, $this->_regularMultiply(array($C3), $KJ), false);
        $aN = $this->_add($aN[MATH_BIGINTEGER_VALUE], false, $C3[MATH_BIGINTEGER_VALUE], false);
        $aN[MATH_BIGINTEGER_VALUE] = array_slice($aN[MATH_BIGINTEGER_VALUE], 1);
        hJ:
        ++$Bi;
        goto Pt;
        j6:
        if (!($this->_compare($aN[MATH_BIGINTEGER_VALUE], false, $KJ, false) >= 0)) {
            goto Ow;
        }
        $aN = $this->_subtract($aN[MATH_BIGINTEGER_VALUE], false, $KJ, false);
        Ow:
        return $aN[MATH_BIGINTEGER_VALUE];
    }
    function _prepMontgomery($rk, $mO)
    {
        $Nv = new Math_BigInteger();
        $Nv->value = array_merge($this->_array_repeat(0, count($mO)), $rk);
        $Wo = new Math_BigInteger();
        $Wo->value = $mO;
        list(, $C3) = $Nv->divide($Wo);
        return $C3->value;
    }
    function _modInverse67108864($rk)
    {
        $rk = -$rk[0];
        $Mn = $rk & 0x3;
        $Mn = $Mn * (2 - $rk * $Mn) & 0xf;
        $Mn = $Mn * (2 - ($rk & 0xff) * $Mn) & 0xff;
        $Mn = $Mn * (2 - ($rk & 0xffff) * $Mn & 0xffff) & 0xffff;
        $Mn = fmod($Mn * (2 - fmod($rk * $Mn, MATH_BIGINTEGER_BASE_FULL)), MATH_BIGINTEGER_BASE_FULL);
        return $Mn & MATH_BIGINTEGER_MAX_DIGIT;
    }
    function modInverse($mO)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3 = new Math_BigInteger();
                $C3->value = gmp_invert($this->value, $mO->value);
                return $C3->value === false ? false : $this->_normalize($C3);
        }
        be:
        Bb:
        static $bs, $kC;
        if (isset($bs)) {
            goto N1;
        }
        $bs = new Math_BigInteger();
        $kC = new Math_BigInteger(1);
        N1:
        $mO = $mO->abs();
        if (!($this->compare($bs) < 0)) {
            goto ow;
        }
        $C3 = $this->abs();
        $C3 = $C3->modInverse($mO);
        return $this->_normalize($mO->subtract($C3));
        ow:
        extract($this->extendedGCD($mO));
        if ($CV->equals($kC)) {
            goto l_;
        }
        return false;
        l_:
        $rk = $rk->compare($bs) < 0 ? $rk->add($mO) : $rk;
        return $this->compare($bs) < 0 ? $this->_normalize($mO->subtract($rk)) : $this->_normalize($rk);
    }
    function extendedGCD($mO)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                extract(gmp_gcdext($this->value, $mO->value));
                return array("\x67\x63\x64" => $this->_normalize(new Math_BigInteger($KF)), "\x78" => $this->_normalize(new Math_BigInteger($QI)), "\171" => $this->_normalize(new Math_BigInteger($Gt)));
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Ry = $this->value;
                $Bh = $mO->value;
                $aN = "\61";
                $Ng = "\x30";
                $cm = "\60";
                $ki = "\61";
                ZR:
                if (!(bccomp($Bh, "\60", 0) != 0)) {
                    goto VS;
                }
                $Hz = bcdiv($Ry, $Bh, 0);
                $C3 = $Ry;
                $Ry = $Bh;
                $Bh = bcsub($C3, bcmul($Bh, $Hz, 0), 0);
                $C3 = $aN;
                $aN = $cm;
                $cm = bcsub($C3, bcmul($aN, $Hz, 0), 0);
                $C3 = $Ng;
                $Ng = $ki;
                $ki = bcsub($C3, bcmul($Ng, $Hz, 0), 0);
                goto ZR;
                VS:
                return array("\x67\143\x64" => $this->_normalize(new Math_BigInteger($Ry)), "\x78" => $this->_normalize(new Math_BigInteger($aN)), "\x79" => $this->_normalize(new Math_BigInteger($Ng)));
        }
        No:
        Lk:
        $wQ = $mO->copy();
        $rk = $this->copy();
        $KF = new Math_BigInteger();
        $KF->value = array(1);
        sB:
        if ($rk->value[0] & 1 || $wQ->value[0] & 1) {
            goto GE;
        }
        $rk->_rshift(1);
        $wQ->_rshift(1);
        $KF->_lshift(1);
        goto sB;
        GE:
        $Ry = $rk->copy();
        $Bh = $wQ->copy();
        $aN = new Math_BigInteger();
        $Ng = new Math_BigInteger();
        $cm = new Math_BigInteger();
        $ki = new Math_BigInteger();
        $aN->value = $ki->value = $KF->value = array(1);
        $Ng->value = $cm->value = array();
        LB:
        if (empty($Ry->value)) {
            goto j0;
        }
        Gu:
        if ($Ry->value[0] & 1) {
            goto bu;
        }
        $Ry->_rshift(1);
        if (!(!empty($aN->value) && $aN->value[0] & 1 || !empty($Ng->value) && $Ng->value[0] & 1)) {
            goto tn;
        }
        $aN = $aN->add($wQ);
        $Ng = $Ng->subtract($rk);
        tn:
        $aN->_rshift(1);
        $Ng->_rshift(1);
        goto Gu;
        bu:
        dY:
        if ($Bh->value[0] & 1) {
            goto WG;
        }
        $Bh->_rshift(1);
        if (!(!empty($ki->value) && $ki->value[0] & 1 || !empty($cm->value) && $cm->value[0] & 1)) {
            goto mZ;
        }
        $cm = $cm->add($wQ);
        $ki = $ki->subtract($rk);
        mZ:
        $cm->_rshift(1);
        $ki->_rshift(1);
        goto dY;
        WG:
        if ($Ry->compare($Bh) >= 0) {
            goto bR;
        }
        $Bh = $Bh->subtract($Ry);
        $cm = $cm->subtract($aN);
        $ki = $ki->subtract($Ng);
        goto k6;
        bR:
        $Ry = $Ry->subtract($Bh);
        $aN = $aN->subtract($cm);
        $Ng = $Ng->subtract($ki);
        k6:
        goto LB;
        j0:
        return array("\x67\143\144" => $this->_normalize($KF->multiply($Bh)), "\170" => $this->_normalize($cm), "\x79" => $this->_normalize($ki));
    }
    function gcd($mO)
    {
        extract($this->extendedGCD($mO));
        return $CV;
    }
    function abs()
    {
        $C3 = new Math_BigInteger();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3->value = gmp_abs($this->value);
                goto bo;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $C3->value = bccomp($this->value, "\x30", 0) < 0 ? substr($this->value, 1) : $this->value;
                goto bo;
            default:
                $C3->value = $this->value;
        }
        ei:
        bo:
        return $C3;
    }
    function compare($wQ)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_cmp($this->value, $wQ->value);
            case MATH_BIGINTEGER_MODE_BCMATH:
                return bccomp($this->value, $wQ->value, 0);
        }
        PE:
        xU:
        return $this->_compare($this->value, $this->is_negative, $wQ->value, $wQ->is_negative);
    }
    function _compare($fo, $uw, $XX, $U8)
    {
        if (!($uw != $U8)) {
            goto Gl;
        }
        return !$uw && $U8 ? 1 : -1;
        Gl:
        $Mn = $uw ? -1 : 1;
        if (!(count($fo) != count($XX))) {
            goto DG;
        }
        return count($fo) > count($XX) ? $Mn : -$Mn;
        DG:
        $Sh = max(count($fo), count($XX));
        $fo = array_pad($fo, $Sh, 0);
        $XX = array_pad($XX, $Sh, 0);
        $Bi = count($fo) - 1;
        KM:
        if (!($Bi >= 0)) {
            goto x3;
        }
        if (!($fo[$Bi] != $XX[$Bi])) {
            goto E7;
        }
        return $fo[$Bi] > $XX[$Bi] ? $Mn : -$Mn;
        E7:
        AP:
        --$Bi;
        goto KM;
        x3:
        return 0;
    }
    function equals($rk)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_cmp($this->value, $rk->value) == 0;
            default:
                return $this->value === $rk->value && $this->is_negative == $rk->is_negative;
        }
        oD:
        ye:
    }
    function setPrecision($AJ)
    {
        $this->precision = $AJ;
        if (MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_BCMATH) {
            goto W0;
        }
        $this->bitmask = new Math_BigInteger(bcpow("\62", $AJ, 0));
        goto gv;
        W0:
        $this->bitmask = new Math_BigInteger(chr((1 << ($AJ & 0x7)) - 1) . str_repeat(chr(0xff), $AJ >> 3), 256);
        gv:
        $C3 = $this->_normalize($this);
        $this->value = $C3->value;
    }
    function bitwise_and($rk)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3 = new Math_BigInteger();
                $C3->value = gmp_and($this->value, $rk->value);
                return $this->_normalize($C3);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Ln = $this->toBytes();
                $IZ = $rk->toBytes();
                $gM = max(strlen($Ln), strlen($IZ));
                $Ln = str_pad($Ln, $gM, chr(0), STR_PAD_LEFT);
                $IZ = str_pad($IZ, $gM, chr(0), STR_PAD_LEFT);
                return $this->_normalize(new Math_BigInteger($Ln & $IZ, 256));
        }
        X8:
        hz:
        $Mn = $this->copy();
        $gM = min(count($rk->value), count($this->value));
        $Mn->value = array_slice($Mn->value, 0, $gM);
        $Bi = 0;
        te:
        if (!($Bi < $gM)) {
            goto SE;
        }
        $Mn->value[$Bi] &= $rk->value[$Bi];
        rq:
        ++$Bi;
        goto te;
        SE:
        return $this->_normalize($Mn);
    }
    function bitwise_or($rk)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3 = new Math_BigInteger();
                $C3->value = gmp_or($this->value, $rk->value);
                return $this->_normalize($C3);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Ln = $this->toBytes();
                $IZ = $rk->toBytes();
                $gM = max(strlen($Ln), strlen($IZ));
                $Ln = str_pad($Ln, $gM, chr(0), STR_PAD_LEFT);
                $IZ = str_pad($IZ, $gM, chr(0), STR_PAD_LEFT);
                return $this->_normalize(new Math_BigInteger($Ln | $IZ, 256));
        }
        JM:
        SR:
        $gM = max(count($this->value), count($rk->value));
        $Mn = $this->copy();
        $Mn->value = array_pad($Mn->value, $gM, 0);
        $rk->value = array_pad($rk->value, $gM, 0);
        $Bi = 0;
        kN:
        if (!($Bi < $gM)) {
            goto W4;
        }
        $Mn->value[$Bi] |= $rk->value[$Bi];
        PM:
        ++$Bi;
        goto kN;
        W4:
        return $this->_normalize($Mn);
    }
    function bitwise_xor($rk)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $C3 = new Math_BigInteger();
                $C3->value = gmp_xor(gmp_abs($this->value), gmp_abs($rk->value));
                return $this->_normalize($C3);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Ln = $this->toBytes();
                $IZ = $rk->toBytes();
                $gM = max(strlen($Ln), strlen($IZ));
                $Ln = str_pad($Ln, $gM, chr(0), STR_PAD_LEFT);
                $IZ = str_pad($IZ, $gM, chr(0), STR_PAD_LEFT);
                return $this->_normalize(new Math_BigInteger($Ln ^ $IZ, 256));
        }
        KA:
        zn:
        $gM = max(count($this->value), count($rk->value));
        $Mn = $this->copy();
        $Mn->is_negative = false;
        $Mn->value = array_pad($Mn->value, $gM, 0);
        $rk->value = array_pad($rk->value, $gM, 0);
        $Bi = 0;
        qC:
        if (!($Bi < $gM)) {
            goto Pa;
        }
        $Mn->value[$Bi] ^= $rk->value[$Bi];
        Jp:
        ++$Bi;
        goto qC;
        Pa:
        return $this->_normalize($Mn);
    }
    function bitwise_not()
    {
        $C3 = $this->toBytes();
        if (!($C3 == '')) {
            goto Ve;
        }
        return $this->_normalize(new Math_BigInteger());
        Ve:
        $EC = decbin(ord($C3[0]));
        $C3 = ~$C3;
        $a5 = decbin(ord($C3[0]));
        if (!(strlen($a5) == 8)) {
            goto Od;
        }
        $a5 = substr($a5, strpos($a5, "\x30"));
        Od:
        $C3[0] = chr(bindec($a5));
        $W_ = strlen($EC) + 8 * strlen($C3) - 8;
        $aC = $this->precision - $W_;
        if (!($aC <= 0)) {
            goto FL;
        }
        return $this->_normalize(new Math_BigInteger($C3, 256));
        FL:
        $tV = chr((1 << ($aC & 0x7)) - 1) . str_repeat(chr(0xff), $aC >> 3);
        $this->_base256_lshift($tV, $W_);
        $C3 = str_pad($C3, strlen($tV), chr(0), STR_PAD_LEFT);
        return $this->_normalize(new Math_BigInteger($tV | $C3, 256));
    }
    function bitwise_rightShift($ly)
    {
        $C3 = new Math_BigInteger();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                static $Of;
                if (isset($Of)) {
                    goto tM;
                }
                $Of = gmp_init("\62");
                tM:
                $C3->value = gmp_div_q($this->value, gmp_pow($Of, $ly));
                goto c9;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $C3->value = bcdiv($this->value, bcpow("\62", $ly, 0), 0);
                goto c9;
            default:
                $C3->value = $this->value;
                $C3->_rshift($ly);
        }
        xB:
        c9:
        return $this->_normalize($C3);
    }
    function bitwise_leftShift($ly)
    {
        $C3 = new Math_BigInteger();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                static $Of;
                if (isset($Of)) {
                    goto hD;
                }
                $Of = gmp_init("\x32");
                hD:
                $C3->value = gmp_mul($this->value, gmp_pow($Of, $ly));
                goto MW;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $C3->value = bcmul($this->value, bcpow("\x32", $ly, 0), 0);
                goto MW;
            default:
                $C3->value = $this->value;
                $C3->_lshift($ly);
        }
        Sl:
        MW:
        return $this->_normalize($C3);
    }
    function bitwise_leftRotate($ly)
    {
        $AJ = $this->toBytes();
        if ($this->precision > 0) {
            goto Sp;
        }
        $C3 = ord($AJ[0]);
        $Bi = 0;
        rj:
        if (!($C3 >> $Bi)) {
            goto tx;
        }
        v1:
        ++$Bi;
        goto rj;
        tx:
        $V8 = 8 * strlen($AJ) - 8 + $Bi;
        $dZ = chr((1 << ($V8 & 0x7)) - 1) . str_repeat(chr(0xff), $V8 >> 3);
        goto SI;
        Sp:
        $V8 = $this->precision;
        if (MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_BCMATH) {
            goto Sc;
        }
        $dZ = $this->bitmask->toBytes();
        goto rk;
        Sc:
        $dZ = $this->bitmask->subtract(new Math_BigInteger(1));
        $dZ = $dZ->toBytes();
        rk:
        SI:
        if (!($ly < 0)) {
            goto pM;
        }
        $ly += $V8;
        pM:
        $ly %= $V8;
        if ($ly) {
            goto QT;
        }
        return $this->copy();
        QT:
        $Ln = $this->bitwise_leftShift($ly);
        $Ln = $Ln->bitwise_and(new Math_BigInteger($dZ, 256));
        $IZ = $this->bitwise_rightShift($V8 - $ly);
        $Mn = MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_BCMATH ? $Ln->bitwise_or($IZ) : $Ln->add($IZ);
        return $this->_normalize($Mn);
    }
    function bitwise_rightRotate($ly)
    {
        return $this->bitwise_leftRotate(-$ly);
    }
    function setRandomGenerator($YW)
    {
    }
    function _random_number_helper($Sh)
    {
        if (function_exists("\x63\162\x79\x70\164\x5f\x72\141\x6e\144\x6f\155\137\x73\x74\x72\x69\156\147")) {
            goto f5;
        }
        $ga = '';
        if (!($Sh & 1)) {
            goto dP;
        }
        $ga .= chr(mt_rand(0, 255));
        dP:
        $G6 = $Sh >> 1;
        $Bi = 0;
        fh:
        if (!($Bi < $G6)) {
            goto OQ;
        }
        $ga .= pack("\156", mt_rand(0, 0xffff));
        aI:
        ++$Bi;
        goto fh;
        OQ:
        goto eE;
        f5:
        $ga = crypt_random_string($Sh);
        eE:
        return new Math_BigInteger($ga, 256);
    }
    function random($sn, $Oz = false)
    {
        if (!($sn === false)) {
            goto Zu;
        }
        return false;
        Zu:
        if ($Oz === false) {
            goto Oa;
        }
        $wl = $sn;
        $gF = $Oz;
        goto BM;
        Oa:
        $gF = $sn;
        $wl = $this;
        BM:
        $R3 = $gF->compare($wl);
        if (!$R3) {
            goto NA;
        }
        if ($R3 < 0) {
            goto gq;
        }
        goto J7;
        NA:
        return $this->_normalize($wl);
        goto J7;
        gq:
        $C3 = $gF;
        $gF = $wl;
        $wl = $C3;
        J7:
        static $kC;
        if (isset($kC)) {
            goto Q7;
        }
        $kC = new Math_BigInteger(1);
        Q7:
        $gF = $gF->subtract($wl->subtract($kC));
        $Sh = strlen(ltrim($gF->toBytes(), chr(0)));
        $bO = new Math_BigInteger(chr(1) . str_repeat("\0", $Sh), 256);
        $ga = $this->_random_number_helper($Sh);
        list($CZ) = $bO->divide($gF);
        $CZ = $CZ->multiply($gF);
        N6:
        if (!($ga->compare($CZ) >= 0)) {
            goto Cz;
        }
        $ga = $ga->subtract($CZ);
        $bO = $bO->subtract($CZ);
        $ga = $ga->bitwise_leftShift(8);
        $ga = $ga->add($this->_random_number_helper(1));
        $bO = $bO->bitwise_leftShift(8);
        list($CZ) = $bO->divide($gF);
        $CZ = $CZ->multiply($gF);
        goto N6;
        Cz:
        list(, $ga) = $ga->divide($gF);
        return $this->_normalize($ga->add($wl));
    }
    function randomPrime($sn, $Oz = false, $IO = false)
    {
        if (!($sn === false)) {
            goto Ur;
        }
        return false;
        Ur:
        if ($Oz === false) {
            goto CK;
        }
        $wl = $sn;
        $gF = $Oz;
        goto ew;
        CK:
        $gF = $sn;
        $wl = $this;
        ew:
        $R3 = $gF->compare($wl);
        if (!$R3) {
            goto L3;
        }
        if ($R3 < 0) {
            goto jy;
        }
        goto tf;
        L3:
        return $wl->isPrime() ? $wl : false;
        goto tf;
        jy:
        $C3 = $gF;
        $gF = $wl;
        $wl = $C3;
        tf:
        static $kC, $Of;
        if (isset($kC)) {
            goto sU;
        }
        $kC = new Math_BigInteger(1);
        $Of = new Math_BigInteger(2);
        sU:
        $ee = time();
        $rk = $this->random($wl, $gF);
        if (!(MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_GMP && extension_loaded("\x67\x6d\x70") && version_compare(PHP_VERSION, "\65\x2e\x32\x2e\x30", "\76\75"))) {
            goto Oe;
        }
        $ah = new Math_BigInteger();
        $ah->value = gmp_nextprime($rk->value);
        if (!($ah->compare($gF) <= 0)) {
            goto ST;
        }
        return $ah;
        ST:
        if ($wl->equals($rk)) {
            goto V_;
        }
        $rk = $rk->subtract($kC);
        V_:
        return $rk->randomPrime($wl, $rk);
        Oe:
        if (!$rk->equals($Of)) {
            goto fD;
        }
        return $rk;
        fD:
        $rk->_make_odd();
        if (!($rk->compare($gF) > 0)) {
            goto uc;
        }
        if (!$wl->equals($gF)) {
            goto Dg;
        }
        return false;
        Dg:
        $rk = $wl->copy();
        $rk->_make_odd();
        uc:
        $g3 = $rk->copy();
        TR:
        if (!true) {
            goto lc;
        }
        if (!($IO !== false && time() - $ee > $IO)) {
            goto Md;
        }
        return false;
        Md:
        if (!$rk->isPrime()) {
            goto f8;
        }
        return $rk;
        f8:
        $rk = $rk->add($Of);
        if (!($rk->compare($gF) > 0)) {
            goto ag;
        }
        $rk = $wl->copy();
        if (!$rk->equals($Of)) {
            goto Ga;
        }
        return $rk;
        Ga:
        $rk->_make_odd();
        ag:
        if (!$rk->equals($g3)) {
            goto L2;
        }
        return false;
        L2:
        goto TR;
        lc:
    }
    function _make_odd()
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                gmp_setbit($this->value, 0);
                goto Lo;
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value[strlen($this->value) - 1] % 2 == 0)) {
                    goto Dc;
                }
                $this->value = bcadd($this->value, "\61");
                Dc:
                goto Lo;
            default:
                $this->value[0] |= 1;
        }
        gd:
        Lo:
    }
    function isPrime($Gt = false)
    {
        $gM = strlen($this->toBytes());
        if ($Gt) {
            goto pG;
        }
        if ($gM >= 163) {
            goto tD;
        }
        if ($gM >= 106) {
            goto ww;
        }
        if ($gM >= 81) {
            goto sg;
        }
        if ($gM >= 68) {
            goto lm;
        }
        if ($gM >= 56) {
            goto YR;
        }
        if ($gM >= 50) {
            goto Q9;
        }
        if ($gM >= 43) {
            goto lO;
        }
        if ($gM >= 37) {
            goto O6;
        }
        if ($gM >= 31) {
            goto dk;
        }
        if ($gM >= 25) {
            goto zs;
        }
        if ($gM >= 18) {
            goto m7;
        }
        $Gt = 27;
        goto hB;
        m7:
        $Gt = 18;
        hB:
        goto kg;
        zs:
        $Gt = 15;
        kg:
        goto uV;
        dk:
        $Gt = 12;
        uV:
        goto hY;
        O6:
        $Gt = 9;
        hY:
        goto fI;
        lO:
        $Gt = 8;
        fI:
        goto f1;
        Q9:
        $Gt = 7;
        f1:
        goto YK;
        YR:
        $Gt = 6;
        YK:
        goto A8;
        lm:
        $Gt = 5;
        A8:
        goto s8;
        sg:
        $Gt = 4;
        s8:
        goto sb;
        ww:
        $Gt = 3;
        sb:
        goto Q3;
        tD:
        $Gt = 2;
        Q3:
        pG:
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_prob_prime($this->value, $Gt) != 0;
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value === "\62")) {
                    goto Bq;
                }
                return true;
                Bq:
                if (!($this->value[strlen($this->value) - 1] % 2 == 0)) {
                    goto Mo;
                }
                return false;
                Mo:
                goto rl;
            default:
                if (!($this->value == array(2))) {
                    goto K5;
                }
                return true;
                K5:
                if (!(~$this->value[0] & 1)) {
                    goto JW;
                }
                return false;
                JW:
        }
        Kv:
        rl:
        static $MX, $bs, $kC, $Of;
        if (isset($MX)) {
            goto e2;
        }
        $MX = array(3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499, 503, 509, 521, 523, 541, 547, 557, 563, 569, 571, 577, 587, 593, 599, 601, 607, 613, 617, 619, 631, 641, 643, 647, 653, 659, 661, 673, 677, 683, 691, 701, 709, 719, 727, 733, 739, 743, 751, 757, 761, 769, 773, 787, 797, 809, 811, 821, 823, 827, 829, 839, 853, 857, 859, 863, 877, 881, 883, 887, 907, 911, 919, 929, 937, 941, 947, 953, 967, 971, 977, 983, 991, 997);
        if (!(MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_INTERNAL)) {
            goto rS;
        }
        $Bi = 0;
        fb:
        if (!($Bi < count($MX))) {
            goto Yy;
        }
        $MX[$Bi] = new Math_BigInteger($MX[$Bi]);
        tm:
        ++$Bi;
        goto fb;
        Yy:
        rS:
        $bs = new Math_BigInteger();
        $kC = new Math_BigInteger(1);
        $Of = new Math_BigInteger(2);
        e2:
        if (!$this->equals($kC)) {
            goto zx;
        }
        return false;
        zx:
        if (MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_INTERNAL) {
            goto KD;
        }
        $sh = $this->value;
        foreach ($MX as $HL) {
            list(, $Xg) = $this->_divide_digit($sh, $HL);
            if ($Xg) {
                goto Vd;
            }
            return count($sh) == 1 && $sh[0] == $HL;
            Vd:
            dx:
        }
        WC:
        goto Pm;
        KD:
        foreach ($MX as $HL) {
            list(, $Xg) = $this->divide($HL);
            if (!$Xg->equals($bs)) {
                goto Bf;
            }
            return $this->equals($HL);
            Bf:
            RA:
        }
        AE:
        Pm:
        $mO = $this->copy();
        $IA = $mO->subtract($kC);
        $Q3 = $mO->subtract($Of);
        $Xg = $IA->copy();
        $dI = $Xg->value;
        if (MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_BCMATH) {
            goto lP;
        }
        $Bi = 0;
        $uQ = count($dI);
        Jz:
        if (!($Bi < $uQ)) {
            goto mv;
        }
        $C3 = ~$dI[$Bi] & 0xffffff;
        $lQ = 1;
        zv:
        if (!($C3 >> $lQ & 1)) {
            goto xK;
        }
        nd:
        ++$lQ;
        goto zv;
        xK:
        if (!($lQ != 25)) {
            goto i9;
        }
        goto mv;
        i9:
        b6:
        ++$Bi;
        goto Jz;
        mv:
        $QI = 26 * $Bi + $lQ;
        $Xg->_rshift($QI);
        goto Gf;
        lP:
        $QI = 0;
        RK:
        if (!($Xg->value[strlen($Xg->value) - 1] % 2 == 0)) {
            goto iw;
        }
        $Xg->value = bcdiv($Xg->value, "\x32", 0);
        ++$QI;
        goto RK;
        iw:
        Gf:
        $Bi = 0;
        hn:
        if (!($Bi < $Gt)) {
            goto rw;
        }
        $aN = $this->random($Of, $Q3);
        $wQ = $aN->modPow($Xg, $mO);
        if (!(!$wQ->equals($kC) && !$wQ->equals($IA))) {
            goto Wz;
        }
        $lQ = 1;
        Sf:
        if (!($lQ < $QI && !$wQ->equals($IA))) {
            goto rr;
        }
        $wQ = $wQ->modPow($Of, $mO);
        if (!$wQ->equals($kC)) {
            goto P0;
        }
        return false;
        P0:
        xJ:
        ++$lQ;
        goto Sf;
        rr:
        if ($wQ->equals($IA)) {
            goto rO;
        }
        return false;
        rO:
        Wz:
        q1:
        ++$Bi;
        goto hn;
        rw:
        return true;
    }
    function _lshift($ly)
    {
        if (!($ly == 0)) {
            goto WM;
        }
        return;
        WM:
        $Ls = (int) ($ly / MATH_BIGINTEGER_BASE);
        $ly %= MATH_BIGINTEGER_BASE;
        $ly = 1 << $ly;
        $WH = 0;
        $Bi = 0;
        W1:
        if (!($Bi < count($this->value))) {
            goto EJ;
        }
        $C3 = $this->value[$Bi] * $ly + $WH;
        $WH = MATH_BIGINTEGER_BASE === 26 ? intval($C3 / 0x4000000) : $C3 >> 31;
        $this->value[$Bi] = (int) ($C3 - $WH * MATH_BIGINTEGER_BASE_FULL);
        uA:
        ++$Bi;
        goto W1;
        EJ:
        if (!$WH) {
            goto V0;
        }
        $this->value[count($this->value)] = $WH;
        V0:
        rK:
        if (!$Ls--) {
            goto b9;
        }
        array_unshift($this->value, 0);
        goto rK;
        b9:
    }
    function _rshift($ly)
    {
        if (!($ly == 0)) {
            goto tc;
        }
        return;
        tc:
        $Ls = (int) ($ly / MATH_BIGINTEGER_BASE);
        $ly %= MATH_BIGINTEGER_BASE;
        $M7 = MATH_BIGINTEGER_BASE - $ly;
        $UK = (1 << $ly) - 1;
        if (!$Ls) {
            goto FF;
        }
        $this->value = array_slice($this->value, $Ls);
        FF:
        $WH = 0;
        $Bi = count($this->value) - 1;
        Hj:
        if (!($Bi >= 0)) {
            goto oy;
        }
        $C3 = $this->value[$Bi] >> $ly | $WH;
        $WH = ($this->value[$Bi] & $UK) << $M7;
        $this->value[$Bi] = $C3;
        tV:
        --$Bi;
        goto Hj;
        oy:
        $this->value = $this->_trim($this->value);
    }
    function _normalize($Mn)
    {
        $Mn->precision = $this->precision;
        $Mn->bitmask = $this->bitmask;
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                if (!($this->bitmask !== false)) {
                    goto R6;
                }
                $Mn->value = gmp_and($Mn->value, $Mn->bitmask->value);
                R6:
                return $Mn;
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (empty($Mn->bitmask->value)) {
                    goto GT;
                }
                $Mn->value = bcmod($Mn->value, $Mn->bitmask->value);
                GT:
                return $Mn;
        }
        SC:
        HA:
        $sh =& $Mn->value;
        if (count($sh)) {
            goto W2;
        }
        return $Mn;
        W2:
        $sh = $this->_trim($sh);
        if (empty($Mn->bitmask->value)) {
            goto Po;
        }
        $gM = min(count($sh), count($this->bitmask->value));
        $sh = array_slice($sh, 0, $gM);
        $Bi = 0;
        xd:
        if (!($Bi < $gM)) {
            goto oL;
        }
        $sh[$Bi] = $sh[$Bi] & $this->bitmask->value[$Bi];
        JJ:
        ++$Bi;
        goto xd;
        oL:
        Po:
        return $Mn;
    }
    function _trim($sh)
    {
        $Bi = count($sh) - 1;
        QL:
        if (!($Bi >= 0)) {
            goto m0;
        }
        if (!$sh[$Bi]) {
            goto fS;
        }
        goto m0;
        fS:
        unset($sh[$Bi]);
        rn:
        --$Bi;
        goto QL;
        m0:
        return $sh;
    }
    function _array_repeat($yY, $dr)
    {
        return $dr ? array_fill(0, $dr, $yY) : array();
    }
    function _base256_lshift(&$rk, $ly)
    {
        if (!($ly == 0)) {
            goto rf;
        }
        return;
        rf:
        $qw = $ly >> 3;
        $ly &= 7;
        $WH = 0;
        $Bi = strlen($rk) - 1;
        aq:
        if (!($Bi >= 0)) {
            goto qs;
        }
        $C3 = ord($rk[$Bi]) << $ly | $WH;
        $rk[$Bi] = chr($C3);
        $WH = $C3 >> 8;
        Sd:
        --$Bi;
        goto aq;
        qs:
        $WH = $WH != 0 ? chr($WH) : '';
        $rk = $WH . $rk . str_repeat(chr(0), $qw);
    }
    function _base256_rshift(&$rk, $ly)
    {
        if (!($ly == 0)) {
            goto d0;
        }
        $rk = ltrim($rk, chr(0));
        return '';
        d0:
        $qw = $ly >> 3;
        $ly &= 7;
        $fl = '';
        if (!$qw) {
            goto eW;
        }
        $ee = $qw > strlen($rk) ? -strlen($rk) : -$qw;
        $fl = substr($rk, $ee);
        $rk = substr($rk, 0, -$qw);
        eW:
        $WH = 0;
        $M7 = 8 - $ly;
        $Bi = 0;
        Jg:
        if (!($Bi < strlen($rk))) {
            goto zF;
        }
        $C3 = ord($rk[$Bi]) >> $ly | $WH;
        $WH = ord($rk[$Bi]) << $M7 & 0xff;
        $rk[$Bi] = chr($C3);
        bU:
        ++$Bi;
        goto Jg;
        zF:
        $rk = ltrim($rk, chr(0));
        $fl = chr($WH >> $M7) . $fl;
        return ltrim($fl, chr(0));
    }
    function _int2bytes($rk)
    {
        return ltrim(pack("\x4e", $rk), chr(0));
    }
    function _bytes2int($rk)
    {
        $C3 = unpack("\x4e\151\x6e\164", str_pad($rk, 4, chr(0), STR_PAD_LEFT));
        return $C3["\151\x6e\x74"];
    }
    function _encodeASN1Length($gM)
    {
        if (!($gM <= 0x7f)) {
            goto FJ;
        }
        return chr($gM);
        FJ:
        $C3 = ltrim(pack("\x4e", $gM), chr(0));
        return pack("\103\x61\x2a", 0x80 | strlen($C3), $C3);
    }
    function _safe_divide($rk, $wQ)
    {
        if (!(MATH_BIGINTEGER_BASE === 26)) {
            goto q3;
        }
        return (int) ($rk / $wQ);
        q3:
        return ($rk - $rk % $wQ) / $wQ;
    }
}
