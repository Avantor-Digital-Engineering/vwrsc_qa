<?php


if (!function_exists("\x63\x72\x79\160\x74\137\162\141\x6e\x64\x6f\x6d\137\163\x74\x72\151\156\x67")) {
    include_once "\122\141\x6e\144\x6f\155\x2e\x70\150\160";
}
if (class_exists("\103\162\x79\160\x74\x5f\110\x61\x73\x68")) {
    goto WK;
}
include_once "\110\141\x73\x68\x2e\160\150\160";
WK:
define("\103\122\131\120\124\137\122\x53\x41\x5f\105\x4e\x43\x52\x59\x50\x54\x49\x4f\116\x5f\x4f\101\105\x50", 1);
define("\x43\x52\x59\120\x54\137\122\x53\101\137\x45\x4e\x43\x52\x59\x50\x54\111\x4f\x4e\137\x50\113\x43\x53\x31", 2);
define("\x43\122\x59\x50\x54\137\x52\x53\101\137\105\x4e\x43\x52\131\x50\124\x49\117\116\x5f\x4e\117\x4e\x45", 3);
define("\103\x52\x59\120\124\x5f\x52\123\x41\137\123\111\x47\x4e\101\x54\125\122\x45\x5f\x50\123\x53", 1);
define("\103\122\131\120\124\137\122\123\101\137\123\111\x47\x4e\101\124\x55\122\x45\137\x50\x4b\x43\123\x31", 2);
define("\x43\x52\x59\120\x54\x5f\x52\x53\101\x5f\101\123\x4e\61\137\111\116\124\105\107\105\x52", 2);
define("\x43\x52\131\120\x54\x5f\x52\x53\x41\x5f\101\123\x4e\x31\137\102\111\124\123\x54\x52\x49\x4e\107", 3);
define("\103\x52\131\120\124\137\122\x53\x41\137\x41\x53\116\61\x5f\x4f\x43\124\x45\x54\123\124\122\111\116\x47", 4);
define("\x43\122\x59\x50\x54\137\122\123\x41\137\101\123\116\61\x5f\x4f\102\112\105\x43\124", 6);
define("\103\122\131\120\124\137\122\x53\101\x5f\101\123\x4e\61\x5f\123\x45\121\x55\x45\x4e\x43\105", 48);
define("\103\x52\x59\x50\124\137\122\x53\x41\137\115\x4f\104\x45\x5f\111\116\124\105\122\x4e\x41\114", 1);
define("\x43\x52\x59\x50\x54\x5f\122\x53\x41\137\115\117\104\105\137\x4f\x50\105\x4e\x53\123\x4c", 2);
define("\x43\122\x59\x50\124\137\122\x53\101\x5f\x4f\x50\105\116\123\x53\114\x5f\103\117\x4e\106\111\107", dirname(__FILE__) . "\57\x2e\56\x2f\157\x70\x65\x6e\x73\163\154\56\143\x6e\146");
define("\x43\x52\x59\x50\x54\137\122\x53\101\x5f\120\122\111\126\x41\124\105\137\106\x4f\x52\115\x41\124\x5f\120\x4b\x43\123\x31", 0);
define("\x43\122\131\120\x54\x5f\x52\x53\x41\137\120\x52\111\126\x41\124\105\x5f\x46\x4f\x52\x4d\x41\x54\137\120\x55\x54\124\x59", 1);
define("\103\x52\x59\120\124\137\x52\123\101\137\x50\x52\111\x56\101\124\105\137\106\x4f\x52\x4d\x41\124\x5f\130\115\x4c", 2);
define("\x43\x52\131\x50\x54\x5f\122\123\x41\137\x50\122\111\126\101\124\105\x5f\x46\x4f\x52\115\101\x54\137\120\113\x43\123\x38", 8);
define("\103\x52\x59\x50\x54\137\x52\x53\x41\137\120\x55\102\114\x49\x43\137\x46\117\x52\115\101\x54\137\122\101\x57", 3);
define("\103\x52\x59\120\x54\137\122\123\x41\137\x50\x55\102\x4c\111\103\137\106\x4f\x52\x4d\101\x54\x5f\120\113\x43\123\x31", 4);
define("\103\122\131\120\x54\137\x52\x53\x41\x5f\120\125\102\x4c\111\x43\x5f\x46\x4f\122\x4d\x41\x54\x5f\120\x4b\x43\x53\x31\x5f\122\101\x57", 4);
define("\x43\x52\131\x50\x54\x5f\x52\123\101\x5f\120\x55\102\114\111\x43\x5f\x46\x4f\x52\x4d\x41\124\x5f\130\x4d\114", 5);
define("\x43\122\x59\x50\x54\x5f\x52\123\x41\x5f\120\x55\x42\114\111\103\137\106\117\x52\x4d\101\x54\x5f\117\120\x45\x4e\x53\123\110", 6);
define("\x43\122\x59\x50\124\137\122\123\x41\x5f\120\x55\x42\114\x49\x43\x5f\x46\x4f\122\115\101\x54\137\120\x4b\x43\123\70", 7);
class Crypt_RSA
{
    var $zero;
    var $one;
    var $privateKeyFormat = CRYPT_RSA_PRIVATE_FORMAT_PKCS1;
    var $publicKeyFormat = CRYPT_RSA_PUBLIC_FORMAT_PKCS8;
    var $modulus;
    var $k;
    var $exponent;
    var $primes;
    var $exponents;
    var $coefficients;
    var $hashName;
    var $hash;
    var $hLen;
    var $sLen;
    var $mgfHash;
    var $mgfHLen;
    var $encryptionMode = CRYPT_RSA_ENCRYPTION_OAEP;
    var $signatureMode = CRYPT_RSA_SIGNATURE_PSS;
    var $publicExponent = false;
    var $password = false;
    var $components = array();
    var $current;
    var $configFile;
    var $comment = "\x70\x68\x70\x73\x65\x63\154\x69\142\x2d\x67\x65\156\x65\x72\x61\164\145\x64\x2d\x6b\145\171";
    function __construct()
    {
        if (class_exists("\x4d\x61\x74\150\137\102\x69\147\111\156\x74\145\147\x65\x72")) {
            goto ga;
        }
        include_once dirname(__FILE__) . "\x5c\x2e\x2e\134\x4d\x61\164\x68\x5c\102\151\x67\111\x6e\164\x65\147\x65\x72\56\x70\150\160";
        ga:
        $this->configFile = CRYPT_RSA_OPENSSL_CONFIG;
        if (defined("\103\x52\x59\120\124\x5f\x52\x53\101\137\115\x4f\x44\105")) {
            goto fH;
        }
        switch (true) {
            case defined("\115\101\124\110\x5f\102\x49\107\x49\116\124\x45\107\x45\122\x5f\x4f\120\105\116\123\123\114\137\x44\x49\x53\x41\102\x4c\105"):
                define("\x43\122\131\120\124\x5f\x52\x53\101\137\x4d\117\x44\x45", CRYPT_RSA_MODE_INTERNAL);
                goto Mi;
            case !function_exists("\157\160\x65\x6e\x73\x73\x6c\137\x70\153\x65\171\x5f\147\145\164\x5f\x64\145\164\x61\151\154\163"):
                define("\x43\x52\x59\120\124\x5f\122\123\101\x5f\x4d\117\104\x45", CRYPT_RSA_MODE_INTERNAL);
                goto Mi;
            case extension_loaded("\x6f\x70\x65\156\x73\163\154") && version_compare(PHP_VERSION, "\64\56\x32\x2e\x30", "\x3e\x3d") && file_exists($this->configFile):
                ob_start();
                @phpinfo();
                $ON = ob_get_contents();
                ob_end_clean();
                preg_match_all("\43\117\x70\x65\x6e\123\123\114\x20\50\110\x65\141\x64\145\x72\174\x4c\x69\x62\162\141\x72\171\51\40\126\x65\x72\163\x69\157\x6e\x28\x2e\x2a\51\43\x69\x6d", $ON, $vt);
                $oc = array();
                if (empty($vt[1])) {
                    goto UF;
                }
                $Bi = 0;
                G1:
                if (!($Bi < count($vt[1]))) {
                    goto qi;
                }
                $wF = trim(str_replace("\x3d\76", '', strip_tags($vt[2][$Bi])));
                if (!preg_match("\x2f\x28\x5c\144\53\134\56\134\144\x2b\x5c\56\134\144\53\x29\57\151", $wF, $KJ)) {
                    goto AM;
                }
                $oc[$vt[1][$Bi]] = $KJ[0];
                goto y9;
                AM:
                $oc[$vt[1][$Bi]] = $wF;
                y9:
                vI:
                $Bi++;
                goto G1;
                qi:
                UF:
                switch (true) {
                    case !isset($oc["\110\145\141\144\145\162"]):
                    case !isset($oc["\x4c\x69\x62\162\141\162\x79"]):
                    case $oc["\x48\145\141\144\x65\x72"] == $oc["\114\151\142\162\x61\162\x79"]:
                    case version_compare($oc["\110\x65\x61\x64\145\162"], "\61\56\x30\x2e\60") >= 0 && version_compare($oc["\x4c\151\142\162\141\x72\171"], "\61\x2e\60\56\x30") >= 0:
                        define("\x43\x52\x59\120\x54\137\122\123\x41\137\115\x4f\104\x45", CRYPT_RSA_MODE_OPENSSL);
                        goto Hh;
                    default:
                        define("\103\122\131\120\124\x5f\122\x53\101\137\115\x4f\x44\x45", CRYPT_RSA_MODE_INTERNAL);
                        define("\x4d\x41\x54\x48\x5f\102\111\107\x49\116\x54\105\107\x45\122\x5f\x4f\x50\105\x4e\123\x53\x4c\137\104\111\x53\101\102\114\105", true);
                }
                R2:
                Hh:
                goto Mi;
            default:
                define("\x43\x52\131\x50\124\x5f\x52\123\101\137\115\x4f\104\x45", CRYPT_RSA_MODE_INTERNAL);
        }
        Zq:
        Mi:
        fH:
        $this->zero = new Math_BigInteger();
        $this->one = new Math_BigInteger(1);
        $this->hash = new Crypt_Hash("\163\x68\x61\61");
        $this->hLen = $this->hash->getLength();
        $this->hashName = "\x73\x68\x61\x31";
        $this->mgfHash = new Crypt_Hash("\x73\x68\x61\61");
        $this->mgfHLen = $this->mgfHash->getLength();
    }
    function Crypt_RSA()
    {
        $this->__construct();
    }
    function createKey($AJ = 1024, $IO = false, $fT = array())
    {
        if (defined("\x43\x52\131\x50\124\137\122\x53\x41\x5f\105\130\120\117\116\x45\116\x54")) {
            goto s4;
        }
        define("\x43\122\x59\x50\x54\x5f\x52\123\101\x5f\105\130\x50\x4f\116\105\x4e\x54", "\66\65\x35\x33\67");
        s4:
        if (defined("\x43\122\x59\120\124\137\122\x53\x41\x5f\x53\x4d\x41\x4c\x4c\105\123\124\x5f\x50\x52\111\115\x45")) {
            goto Xl;
        }
        define("\x43\122\x59\x50\x54\137\x52\x53\101\137\x53\115\101\x4c\x4c\105\123\124\x5f\x50\122\x49\x4d\105", 4096);
        Xl:
        if (!(CRYPT_RSA_MODE == CRYPT_RSA_MODE_OPENSSL && $AJ >= 384 && CRYPT_RSA_EXPONENT == 65537)) {
            goto WA;
        }
        $P7 = array();
        if (!isset($this->configFile)) {
            goto jH;
        }
        $P7["\143\157\156\x66\151\x67"] = $this->configFile;
        jH:
        $Jw = openssl_pkey_new(array("\160\162\x69\166\141\x74\x65\137\x6b\x65\x79\137\x62\151\x74\163" => $AJ) + $P7);
        openssl_pkey_export($Jw, $zC, null, $P7);
        $LE = openssl_pkey_get_details($Jw);
        $LE = $LE["\x6b\145\x79"];
        $zC = call_user_func_array(array($this, "\x5f\143\157\156\x76\145\x72\x74\120\162\151\166\141\x74\145\113\145\171"), array_values($this->_parseKey($zC, CRYPT_RSA_PRIVATE_FORMAT_PKCS1)));
        $LE = call_user_func_array(array($this, "\137\x63\157\x6e\166\x65\x72\x74\120\165\142\154\x69\143\x4b\x65\x79"), array_values($this->_parseKey($LE, CRYPT_RSA_PUBLIC_FORMAT_PKCS1)));
        CC:
        if (!(openssl_error_string() !== false)) {
            goto Bj;
        }
        goto CC;
        Bj:
        return array("\x70\x72\151\x76\x61\164\145\153\x65\x79" => $zC, "\x70\x75\142\154\151\x63\x6b\x65\171" => $LE, "\x70\x61\x72\x74\x69\141\x6c\153\145\x79" => false);
        WA:
        static $iz;
        if (isset($iz)) {
            goto pj;
        }
        $iz = new Math_BigInteger(CRYPT_RSA_EXPONENT);
        pj:
        extract($this->_generateMinMax($AJ));
        $O_ = $wl;
        $C3 = $AJ >> 1;
        if ($C3 > CRYPT_RSA_SMALLEST_PRIME) {
            goto nc;
        }
        $gd = 2;
        goto jZ;
        nc:
        $gd = floor($AJ / CRYPT_RSA_SMALLEST_PRIME);
        $C3 = CRYPT_RSA_SMALLEST_PRIME;
        jZ:
        extract($this->_generateMinMax($C3 + $AJ % $C3));
        $a1 = $gF;
        extract($this->_generateMinMax($C3));
        $YW = new Math_BigInteger();
        $mO = $this->one->copy();
        if (!empty($fT)) {
            goto zM;
        }
        $g9 = $VP = $MX = array();
        $AR = array("\x74\x6f\160" => $this->one->copy(), "\142\x6f\x74\x74\x6f\155" => false);
        goto J4;
        zM:
        extract(unserialize($fT));
        J4:
        $ee = time();
        $mQ = count($MX) + 1;
        U9:
        $Bi = $mQ;
        K6:
        if (!($Bi <= $gd)) {
            goto bf;
        }
        if (!($IO !== false)) {
            goto y6;
        }
        $IO -= time() - $ee;
        $ee = time();
        if (!($IO <= 0)) {
            goto yh;
        }
        return array("\x70\x72\x69\166\141\x74\x65\x6b\145\171" => '', "\x70\165\142\154\x69\143\153\145\171" => '', "\160\x61\x72\x74\x69\x61\x6c\153\x65\171" => serialize(array("\160\x72\x69\155\145\163" => $MX, "\143\x6f\145\146\146\x69\x63\x69\x65\156\x74\x73" => $VP, "\x6c\143\155" => $AR, "\145\170\x70\x6f\x6e\x65\x6e\x74\163" => $g9)));
        yh:
        y6:
        if ($Bi == $gd) {
            goto i0;
        }
        $MX[$Bi] = $YW->randomPrime($wl, $gF, $IO);
        goto M7;
        i0:
        list($wl, $C3) = $O_->divide($mO);
        if ($C3->equals($this->zero)) {
            goto Fd;
        }
        $wl = $wl->add($this->one);
        Fd:
        $MX[$Bi] = $YW->randomPrime($wl, $a1, $IO);
        M7:
        if (!($MX[$Bi] === false)) {
            goto iH;
        }
        if (count($MX) > 1) {
            goto sN;
        }
        array_pop($MX);
        $LQ = serialize(array("\x70\162\151\x6d\x65\x73" => $MX, "\x63\x6f\145\x66\x66\151\x63\x69\x65\156\164\163" => $VP, "\x6c\x63\x6d" => $AR, "\145\x78\x70\157\156\145\x6e\164\x73" => $g9));
        goto XL;
        sN:
        $LQ = '';
        XL:
        return array("\160\x72\x69\166\x61\x74\x65\x6b\x65\171" => '', "\160\x75\142\x6c\151\x63\153\x65\x79" => '', "\160\141\x72\x74\x69\x61\154\x6b\x65\x79" => $LQ);
        iH:
        if (!($Bi > 2)) {
            goto tq;
        }
        $VP[$Bi] = $mO->modInverse($MX[$Bi]);
        tq:
        $mO = $mO->multiply($MX[$Bi]);
        $C3 = $MX[$Bi]->subtract($this->one);
        $AR["\164\157\x70"] = $AR["\164\157\160"]->multiply($C3);
        $AR["\x62\157\164\x74\157\x6d"] = $AR["\142\x6f\164\164\x6f\155"] === false ? $C3 : $AR["\x62\157\x74\x74\x6f\155"]->gcd($C3);
        $g9[$Bi] = $iz->modInverse($C3);
        Qj:
        $Bi++;
        goto K6;
        bf:
        list($C3) = $AR["\x74\x6f\160"]->divide($AR["\x62\x6f\164\164\157\155"]);
        $CV = $C3->gcd($iz);
        $mQ = 1;
        if (!$CV->equals($this->one)) {
            goto U9;
        }
        tW:
        $ki = $iz->modInverse($C3);
        $VP[2] = $MX[2]->modInverse($MX[1]);
        return array("\160\162\x69\166\141\x74\145\153\x65\171" => $this->_convertPrivateKey($mO, $iz, $ki, $MX, $g9, $VP), "\160\x75\142\x6c\x69\143\x6b\x65\171" => $this->_convertPublicKey($mO, $iz), "\160\141\x72\164\x69\141\154\153\145\171" => false);
    }
    function _convertPrivateKey($mO, $iz, $ki, $MX, $g9, $VP)
    {
        $mC = $this->privateKeyFormat != CRYPT_RSA_PRIVATE_FORMAT_XML;
        $gd = count($MX);
        $c_ = array("\166\145\x72\x73\x69\x6f\156" => $gd == 2 ? chr(0) : chr(1), "\155\157\144\165\x6c\165\x73" => $mO->toBytes($mC), "\x70\x75\x62\x6c\151\x63\105\x78\x70\x6f\156\x65\x6e\164" => $iz->toBytes($mC), "\160\x72\x69\x76\x61\x74\145\x45\170\160\x6f\x6e\145\x6e\x74" => $ki->toBytes($mC), "\x70\162\x69\155\145\x31" => $MX[1]->toBytes($mC), "\160\x72\x69\x6d\x65\x32" => $MX[2]->toBytes($mC), "\x65\x78\160\157\x6e\145\156\x74\x31" => $g9[1]->toBytes($mC), "\145\170\x70\x6f\156\x65\156\164\62" => $g9[2]->toBytes($mC), "\x63\157\145\146\x66\x69\x63\151\x65\x6e\x74" => $VP[2]->toBytes($mC));
        switch ($this->privateKeyFormat) {
            case CRYPT_RSA_PRIVATE_FORMAT_XML:
                if (!($gd != 2)) {
                    goto Ey;
                }
                return false;
                Ey:
                return "\x3c\x52\x53\101\113\x65\171\126\x61\154\165\x65\x3e\15\12" . "\40\x20\74\115\157\x64\165\154\165\x73\76" . base64_encode($c_["\155\x6f\144\165\x6c\165\x73"]) . "\x3c\57\x4d\157\144\165\x6c\x75\x73\x3e\xd\12" . "\x20\x20\74\105\170\x70\157\156\x65\156\164\76" . base64_encode($c_["\x70\165\142\154\151\143\105\170\160\157\x6e\x65\156\x74"]) . "\x3c\57\105\170\160\157\x6e\145\x6e\x74\76\xd\12" . "\x20\x20\74\x50\x3e" . base64_encode($c_["\x70\x72\x69\155\145\61"]) . "\74\x2f\120\76\15\xa" . "\x20\40\74\121\x3e" . base64_encode($c_["\x70\x72\151\155\x65\x32"]) . "\74\x2f\121\x3e\xd\xa" . "\x20\40\x3c\104\120\x3e" . base64_encode($c_["\145\x78\160\x6f\x6e\x65\x6e\x74\x31"]) . "\74\57\x44\120\76\xd\12" . "\x20\40\x3c\104\121\76" . base64_encode($c_["\x65\x78\160\x6f\x6e\145\156\164\62"]) . "\74\x2f\x44\x51\76\15\12" . "\x20\40\74\x49\156\x76\x65\x72\x73\x65\121\x3e" . base64_encode($c_["\x63\x6f\x65\x66\x66\x69\143\x69\x65\x6e\164"]) . "\x3c\x2f\111\x6e\x76\x65\162\163\145\121\76\15\xa" . "\x20\40\x3c\x44\x3e" . base64_encode($c_["\160\x72\151\166\x61\164\145\105\x78\x70\x6f\156\x65\156\164"]) . "\x3c\x2f\x44\76\15\xa" . "\74\x2f\x52\x53\x41\113\x65\171\x56\x61\154\x75\x65\x3e";
                goto HI;
            case CRYPT_RSA_PRIVATE_FORMAT_PUTTY:
                if (!($gd != 2)) {
                    goto TZ;
                }
                return false;
                TZ:
                $aZ = "\x50\x75\x54\x54\x59\55\x55\x73\x65\x72\x2d\113\145\171\x2d\106\151\x6c\x65\x2d\x32\72\40\163\x73\x68\x2d\162\x73\x61\15\12\105\x6e\143\162\171\x70\164\x69\157\156\x3a\x20";
                $hg = !empty($this->password) || is_string($this->password) ? "\141\145\x73\62\65\x36\x2d\143\142\143" : "\156\157\x6e\x65";
                $aZ .= $hg;
                $aZ .= "\xd\12\x43\x6f\x6d\x6d\145\x6e\x74\72\40" . $this->comment . "\15\xa";
                $E2 = pack("\116\x61\x2a\x4e\x61\x2a\x4e\141\52", strlen("\x73\163\x68\x2d\x72\163\x61"), "\x73\x73\150\x2d\162\163\141", strlen($c_["\x70\165\x62\154\x69\x63\x45\x78\160\157\x6e\x65\x6e\164"]), $c_["\x70\165\x62\x6c\x69\143\x45\170\x70\157\156\145\x6e\x74"], strlen($c_["\155\157\x64\165\x6c\x75\163"]), $c_["\x6d\157\x64\x75\x6c\165\163"]);
                $mB = pack("\116\x61\52\116\141\52\x4e\x61\52\x4e\141\x2a", strlen("\x73\163\x68\x2d\x72\x73\141"), "\x73\163\150\x2d\162\163\141", strlen($hg), $hg, strlen($this->comment), $this->comment, strlen($E2), $E2);
                $E2 = base64_encode($E2);
                $aZ .= "\120\x75\x62\x6c\x69\143\55\114\151\156\145\163\x3a\40" . (strlen($E2) + 63 >> 6) . "\xd\xa";
                $aZ .= chunk_split($E2, 64);
                $fU = pack("\x4e\x61\52\116\141\x2a\x4e\141\52\x4e\141\52", strlen($c_["\x70\162\x69\x76\x61\164\x65\105\x78\x70\157\x6e\145\156\x74"]), $c_["\x70\162\151\166\141\x74\145\x45\170\x70\x6f\x6e\x65\x6e\164"], strlen($c_["\160\162\x69\x6d\x65\61"]), $c_["\160\162\x69\x6d\x65\x31"], strlen($c_["\160\x72\151\155\145\x32"]), $c_["\x70\x72\151\x6d\x65\x32"], strlen($c_["\x63\x6f\145\146\x66\x69\x63\151\145\x6e\x74"]), $c_["\x63\x6f\x65\x66\x66\x69\x63\x69\145\x6e\164"]);
                if (empty($this->password) && !is_string($this->password)) {
                    goto xO;
                }
                $fU .= crypt_random_string(16 - (strlen($fU) & 15));
                $mB .= pack("\116\141\x2a", strlen($fU), $fU);
                if (class_exists("\103\x72\x79\160\164\x5f\x41\105\123")) {
                    goto WH;
                }
                include_once "\x43\162\x79\160\x74\57\101\105\x53\x2e\x70\150\x70";
                WH:
                $Rf = 0;
                $iK = '';
                nz:
                if (!(strlen($iK) < 32)) {
                    goto cH;
                }
                $C3 = pack("\x4e\x61\52", $Rf++, $this->password);
                $iK .= pack("\x48\52", sha1($C3));
                goto nz;
                cH:
                $iK = substr($iK, 0, 32);
                $dc = new Crypt_AES();
                $dc->setKey($iK);
                $dc->disablePadding();
                $fU = $dc->encrypt($fU);
                $LG = "\x70\x75\x74\164\x79\55\160\162\151\x76\141\x74\x65\55\x6b\145\171\x2d\x66\x69\x6c\145\x2d\x6d\141\x63\x2d\153\145\x79" . $this->password;
                goto PS;
                xO:
                $mB .= pack("\116\x61\x2a", strlen($fU), $fU);
                $LG = "\x70\165\x74\164\x79\55\x70\162\151\166\141\x74\x65\x2d\x6b\145\x79\55\146\x69\154\145\x2d\155\x61\143\55\x6b\145\x79";
                PS:
                $fU = base64_encode($fU);
                $aZ .= "\x50\x72\151\166\141\164\x65\x2d\114\x69\156\x65\x73\x3a\40" . (strlen($fU) + 63 >> 6) . "\15\xa";
                $aZ .= chunk_split($fU, 64);
                if (class_exists("\x43\x72\171\160\x74\x5f\x48\141\x73\150")) {
                    goto rF;
                }
                include_once "\x43\162\x79\160\x74\x2f\110\x61\163\150\x2e\x70\150\160";
                rF:
                $hU = new Crypt_Hash("\x73\x68\x61\x31");
                $hU->setKey(pack("\x48\52", sha1($LG)));
                $aZ .= "\120\162\x69\166\x61\164\145\55\115\101\x43\x3a\x20" . bin2hex($hU->hash($mB)) . "\15\12";
                return $aZ;
            default:
                $Lw = array();
                foreach ($c_ as $C_ => $sh) {
                    $Lw[$C_] = pack("\x43\x61\52\141\x2a", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($sh)), $sh);
                    pp:
                }
                ks:
                $QH = implode('', $Lw);
                if (!($gd > 2)) {
                    goto Ig;
                }
                $V3 = '';
                $Bi = 3;
                VJ:
                if (!($Bi <= $gd)) {
                    goto ht;
                }
                $nJ = pack("\x43\x61\x2a\x61\x2a", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($MX[$Bi]->toBytes(true))), $MX[$Bi]->toBytes(true));
                $nJ .= pack("\103\x61\x2a\141\x2a", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($g9[$Bi]->toBytes(true))), $g9[$Bi]->toBytes(true));
                $nJ .= pack("\103\141\52\x61\x2a", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($VP[$Bi]->toBytes(true))), $VP[$Bi]->toBytes(true));
                $V3 .= pack("\103\x61\52\141\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($nJ)), $nJ);
                QS:
                $Bi++;
                goto VJ;
                ht:
                $QH .= pack("\103\141\52\141\x2a", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($V3)), $V3);
                Ig:
                $QH = pack("\103\141\x2a\x61\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($QH)), $QH);
                if (!($this->privateKeyFormat == CRYPT_RSA_PRIVATE_FORMAT_PKCS8)) {
                    goto Zf;
                }
                $Vr = pack("\110\52", "\x33\x30\x30\144\60\x36\x30\x39\62\x61\x38\x36\64\70\x38\66\x66\x37\x30\144\x30\x31\x30\x31\60\x31\x30\65\x30\x30");
                $QH = pack("\103\x61\x2a\141\52\x43\x61\52\141\x2a", CRYPT_RSA_ASN1_INTEGER, "\x1\x0", $Vr, 4, $this->_encodeLength(strlen($QH)), $QH);
                $QH = pack("\103\141\x2a\x61\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($QH)), $QH);
                if (!empty($this->password) || is_string($this->password)) {
                    goto Wy;
                }
                $QH = "\55\x2d\x2d\55\x2d\102\x45\x47\111\x4e\40\120\122\111\126\101\124\x45\40\x4b\105\x59\x2d\55\x2d\x2d\x2d\xd\12" . chunk_split(base64_encode($QH), 64) . "\55\x2d\55\55\x2d\x45\116\x44\x20\x50\122\111\x56\x41\124\x45\40\113\x45\131\55\x2d\x2d\55\x2d";
                goto cb;
                Wy:
                $X8 = crypt_random_string(8);
                $Y1 = 2048;
                if (class_exists("\103\x72\x79\160\164\137\104\105\x53")) {
                    goto nn;
                }
                include_once "\x43\x72\x79\x70\x74\57\104\105\123\56\x70\x68\x70";
                nn:
                $dc = new Crypt_DES();
                $dc->setPassword($this->password, "\x70\x62\x6b\144\146\x31", "\x6d\144\65", $X8, $Y1);
                $QH = $dc->encrypt($QH);
                $Ja = pack("\103\141\x2a\141\x2a\x43\141\52\x4e", CRYPT_RSA_ASN1_OCTETSTRING, $this->_encodeLength(strlen($X8)), $X8, CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(4), $Y1);
                $m1 = "\x2a\206\110\206\xf7\xd\x1\5\x3";
                $Kv = pack("\x43\141\x2a\x61\52\103\141\52\x61\52", CRYPT_RSA_ASN1_OBJECT, $this->_encodeLength(strlen($m1)), $m1, CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($Ja)), $Ja);
                $QH = pack("\x43\141\52\141\x2a\x43\x61\x2a\x61\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($Kv)), $Kv, CRYPT_RSA_ASN1_OCTETSTRING, $this->_encodeLength(strlen($QH)), $QH);
                $QH = pack("\103\141\52\141\x2a", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($QH)), $QH);
                $QH = "\55\x2d\x2d\x2d\55\x42\105\x47\x49\x4e\x20\105\x4e\103\122\131\x50\x54\x45\104\40\120\x52\x49\x56\x41\124\105\x20\113\105\131\x2d\55\55\x2d\x2d\15\xa" . chunk_split(base64_encode($QH), 64) . "\55\55\55\x2d\55\105\116\104\40\105\x4e\x43\x52\131\x50\x54\105\104\x20\x50\x52\111\126\101\124\x45\x20\x4b\x45\131\55\55\55\x2d\x2d";
                cb:
                return $QH;
                Zf:
                if (!empty($this->password) || is_string($this->password)) {
                    goto NL;
                }
                $QH = "\55\55\55\x2d\55\x42\x45\107\111\116\40\x52\123\x41\40\120\x52\x49\x56\101\124\x45\x20\113\x45\131\x2d\55\55\55\x2d\15\12" . chunk_split(base64_encode($QH), 64) . "\55\55\x2d\x2d\x2d\x45\116\x44\x20\x52\123\x41\40\120\122\111\x56\x41\x54\105\x20\x4b\x45\131\55\55\x2d\x2d\x2d";
                goto uf;
                NL:
                $ZE = crypt_random_string(8);
                $iK = pack("\110\x2a", md5($this->password . $ZE));
                $iK .= substr(pack("\x48\x2a", md5($iK . $this->password . $ZE)), 0, 8);
                if (class_exists("\103\162\x79\x70\x74\137\x54\162\151\x70\154\145\104\105\123")) {
                    goto ZU;
                }
                include_once "\103\x72\171\160\x74\57\x54\162\x69\x70\154\x65\104\x45\123\56\160\150\160";
                ZU:
                $w6 = new Crypt_TripleDES();
                $w6->setKey($iK);
                $w6->setIV($ZE);
                $ZE = strtoupper(bin2hex($ZE));
                $QH = "\55\x2d\55\x2d\55\102\x45\107\111\116\x20\122\123\x41\x20\x50\122\111\x56\101\124\105\x20\113\x45\x59\55\x2d\x2d\55\x2d\xd\12" . "\x50\162\157\x63\x2d\x54\x79\x70\x65\72\x20\64\x2c\105\116\x43\122\x59\x50\x54\x45\104\15\12" . "\104\105\113\x2d\x49\x6e\x66\x6f\72\40\x44\105\123\x2d\x45\x44\x45\x33\55\x43\x42\103\x2c{$ZE}\15\xa" . "\15\12" . chunk_split(base64_encode($w6->encrypt($QH)), 64) . "\55\55\x2d\55\x2d\105\116\x44\40\x52\x53\x41\x20\120\122\111\x56\101\124\x45\x20\x4b\105\x59\55\x2d\x2d\55\55";
                uf:
                return $QH;
        }
        au:
        HI:
    }
    function _convertPublicKey($mO, $iz)
    {
        $mC = $this->publicKeyFormat != CRYPT_RSA_PUBLIC_FORMAT_XML;
        $k4 = $mO->toBytes($mC);
        $SA = $iz->toBytes($mC);
        switch ($this->publicKeyFormat) {
            case CRYPT_RSA_PUBLIC_FORMAT_RAW:
                return array("\145" => $iz->copy(), "\156" => $mO->copy());
            case CRYPT_RSA_PUBLIC_FORMAT_XML:
                return "\x3c\x52\x53\101\x4b\x65\x79\126\x61\154\165\x65\x3e\xd\xa" . "\x20\x20\x3c\x4d\157\x64\165\154\x75\x73\76" . base64_encode($k4) . "\74\57\115\157\x64\x75\x6c\x75\x73\x3e\15\xa" . "\40\x20\74\x45\170\160\157\156\x65\x6e\164\x3e" . base64_encode($SA) . "\x3c\57\105\x78\x70\157\156\x65\x6e\x74\76\15\xa" . "\x3c\x2f\x52\x53\101\113\x65\171\126\x61\x6c\165\145\76";
                goto iZ;
            case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
                $J6 = pack("\x4e\141\52\116\x61\x2a\116\141\x2a", strlen("\163\x73\x68\x2d\x72\x73\141"), "\x73\163\x68\x2d\x72\163\141", strlen($SA), $SA, strlen($k4), $k4);
                $J6 = "\x73\x73\150\55\x72\x73\x61\40" . base64_encode($J6) . "\40" . $this->comment;
                return $J6;
            default:
                $Lw = array("\155\157\144\x75\x6c\x75\x73" => pack("\x43\x61\x2a\x61\52", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($k4)), $k4), "\160\x75\x62\154\151\143\105\170\x70\x6f\x6e\x65\x6e\x74" => pack("\x43\141\52\141\52", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($SA)), $SA));
                $J6 = pack("\x43\x61\52\141\52\x61\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($Lw["\x6d\157\144\165\x6c\x75\163"]) + strlen($Lw["\160\x75\x62\x6c\151\143\105\x78\160\x6f\x6e\145\x6e\164"])), $Lw["\x6d\157\144\x75\154\165\x73"], $Lw["\x70\165\142\154\x69\x63\105\170\x70\x6f\156\145\x6e\x74"]);
                if ($this->publicKeyFormat == CRYPT_RSA_PUBLIC_FORMAT_PKCS1_RAW) {
                    goto Nz;
                }
                $Vr = pack("\x48\52", "\x33\60\60\x64\x30\66\x30\x39\x32\141\70\x36\64\70\70\66\146\67\x30\144\x30\61\x30\x31\60\x31\x30\65\60\60");
                $J6 = chr(0) . $J6;
                $J6 = chr(3) . $this->_encodeLength(strlen($J6)) . $J6;
                $J6 = pack("\103\x61\52\x61\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($Vr . $J6)), $Vr . $J6);
                $J6 = "\x2d\55\x2d\55\x2d\x42\x45\107\111\x4e\x20\x50\125\x42\114\x49\x43\x20\x4b\105\131\x2d\55\55\x2d\x2d\xd\12" . chunk_split(base64_encode($J6), 64) . "\x2d\55\55\x2d\55\x45\116\x44\40\x50\125\102\x4c\111\x43\x20\113\105\x59\x2d\x2d\x2d\x2d\55";
                goto Kz;
                Nz:
                $J6 = "\x2d\55\55\55\x2d\x42\105\107\111\116\40\122\x53\x41\40\x50\x55\x42\x4c\x49\103\40\x4b\105\x59\55\55\x2d\55\x2d\15\12" . chunk_split(base64_encode($J6), 64) . "\55\55\55\x2d\x2d\105\116\x44\40\x52\123\101\40\120\125\x42\x4c\111\103\40\x4b\105\131\55\55\55\55\x2d";
                Kz:
                return $J6;
        }
        X_:
        iZ:
    }
    function _parseKey($aZ, $w1)
    {
        if (!($w1 != CRYPT_RSA_PUBLIC_FORMAT_RAW && !is_string($aZ))) {
            goto Gg;
        }
        return false;
        Gg:
        switch ($w1) {
            case CRYPT_RSA_PUBLIC_FORMAT_RAW:
                if (is_array($aZ)) {
                    goto ET;
                }
                return false;
                ET:
                $Lw = array();
                switch (true) {
                    case isset($aZ["\145"]):
                        $Lw["\x70\165\142\154\x69\x63\105\170\x70\x6f\156\145\x6e\x74"] = $aZ["\x65"]->copy();
                        goto O4;
                    case isset($aZ["\145\170\x70\x6f\156\145\156\164"]):
                        $Lw["\160\x75\142\x6c\x69\x63\x45\170\x70\157\156\145\156\164"] = $aZ["\145\170\160\157\x6e\145\156\x74"]->copy();
                        goto O4;
                    case isset($aZ["\160\x75\x62\x6c\151\x63\105\x78\x70\x6f\156\145\x6e\x74"]):
                        $Lw["\x70\165\142\x6c\x69\143\105\170\160\x6f\x6e\145\156\x74"] = $aZ["\160\165\142\x6c\x69\143\105\x78\160\x6f\x6e\145\156\164"]->copy();
                        goto O4;
                    case isset($aZ[0]):
                        $Lw["\x70\x75\142\154\x69\143\105\x78\x70\x6f\x6e\x65\x6e\164"] = $aZ[0]->copy();
                }
                N2:
                O4:
                switch (true) {
                    case isset($aZ["\x6e"]):
                        $Lw["\155\157\x64\x75\x6c\165\x73"] = $aZ["\x6e"]->copy();
                        goto MY;
                    case isset($aZ["\x6d\157\144\x75\x6c\157"]):
                        $Lw["\155\157\x64\165\154\165\163"] = $aZ["\155\157\x64\165\154\157"]->copy();
                        goto MY;
                    case isset($aZ["\155\x6f\144\x75\154\x75\163"]):
                        $Lw["\155\157\144\165\x6c\165\x73"] = $aZ["\155\157\144\165\x6c\x75\163"]->copy();
                        goto MY;
                    case isset($aZ[1]):
                        $Lw["\x6d\157\144\165\154\165\163"] = $aZ[1]->copy();
                }
                o8:
                MY:
                return isset($Lw["\x6d\x6f\x64\165\x6c\165\163"]) && isset($Lw["\160\x75\142\x6c\151\143\105\x78\x70\x6f\156\x65\156\x74"]) ? $Lw : false;
            case CRYPT_RSA_PRIVATE_FORMAT_PKCS1:
            case CRYPT_RSA_PRIVATE_FORMAT_PKCS8:
            case CRYPT_RSA_PUBLIC_FORMAT_PKCS1:
                if (preg_match("\43\104\105\113\55\x49\156\x66\x6f\72\x20\50\56\x2b\51\x2c\50\x2e\x2b\51\43", $aZ, $vt)) {
                    goto e7;
                }
                $ba = $this->_extractBER($aZ);
                goto j2;
                e7:
                $ZE = pack("\110\52", trim($vt[2]));
                $iK = pack("\110\52", md5($this->password . substr($ZE, 0, 8)));
                $iK .= pack("\x48\x2a", md5($iK . $this->password . substr($ZE, 0, 8)));
                $aZ = preg_replace("\43\136\x28\77\x3a\x50\x72\157\143\x2d\x54\x79\160\x65\174\x44\105\113\x2d\111\x6e\146\157\51\x3a\x20\56\52\x23\x6d", '', $aZ);
                $e7 = $this->_extractBER($aZ);
                if (!($e7 === false)) {
                    goto Go;
                }
                $e7 = $aZ;
                Go:
                switch ($vt[1]) {
                    case "\x41\x45\x53\x2d\62\65\x36\x2d\x43\x42\x43":
                        if (class_exists("\103\162\171\x70\x74\x5f\101\x45\123")) {
                            goto I8;
                        }
                        include_once "\x43\162\x79\160\x74\x2f\101\105\123\56\160\150\160";
                        I8:
                        $dc = new Crypt_AES();
                        goto Lv;
                    case "\101\105\123\55\61\x32\x38\55\x43\x42\103":
                        if (class_exists("\x43\162\x79\160\x74\137\101\x45\x53")) {
                            goto NR;
                        }
                        include_once "\103\x72\171\160\164\x2f\x41\x45\x53\56\160\150\160";
                        NR:
                        $iK = substr($iK, 0, 16);
                        $dc = new Crypt_AES();
                        goto Lv;
                    case "\x44\x45\x53\x2d\x45\x44\x45\x33\55\103\106\x42":
                        if (class_exists("\x43\162\171\x70\x74\x5f\x54\162\151\x70\x6c\145\104\105\123")) {
                            goto sI;
                        }
                        include_once "\103\162\171\160\x74\x2f\x54\162\151\160\x6c\x65\x44\x45\x53\56\x70\x68\160";
                        sI:
                        $dc = new Crypt_TripleDES(CRYPT_DES_MODE_CFB);
                        goto Lv;
                    case "\104\105\x53\55\105\x44\105\x33\x2d\103\102\103":
                        if (class_exists("\103\x72\x79\x70\x74\137\124\x72\151\x70\154\x65\104\x45\x53")) {
                            goto KS;
                        }
                        include_once "\103\162\x79\x70\x74\57\x54\x72\x69\160\x6c\x65\x44\x45\x53\56\160\x68\x70";
                        KS:
                        $iK = substr($iK, 0, 24);
                        $dc = new Crypt_TripleDES();
                        goto Lv;
                    case "\104\x45\x53\55\x43\102\x43":
                        if (class_exists("\x43\162\x79\x70\164\x5f\x44\x45\123")) {
                            goto QA;
                        }
                        include_once "\103\162\x79\x70\164\x2f\104\105\x53\x2e\x70\150\160";
                        QA:
                        $dc = new Crypt_DES();
                        goto Lv;
                    default:
                        return false;
                }
                YZ:
                Lv:
                $dc->setKey($iK);
                $dc->setIV($ZE);
                $ba = $dc->decrypt($e7);
                j2:
                if (!($ba !== false)) {
                    goto ni;
                }
                $aZ = $ba;
                ni:
                $Lw = array();
                if (!(ord($this->_string_shift($aZ)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto jn;
                }
                return false;
                jn:
                if (!($this->_decodeLength($aZ) != strlen($aZ))) {
                    goto l6;
                }
                return false;
                l6:
                $Bn = ord($this->_string_shift($aZ));
                if (!($Bn == CRYPT_RSA_ASN1_INTEGER && substr($aZ, 0, 3) == "\1\x0\60")) {
                    goto py;
                }
                $this->_string_shift($aZ, 3);
                $Bn = CRYPT_RSA_ASN1_SEQUENCE;
                py:
                if (!($Bn == CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto yS;
                }
                $C3 = $this->_string_shift($aZ, $this->_decodeLength($aZ));
                if (!(ord($this->_string_shift($C3)) != CRYPT_RSA_ASN1_OBJECT)) {
                    goto Mn;
                }
                return false;
                Mn:
                $gM = $this->_decodeLength($C3);
                switch ($this->_string_shift($C3, $gM)) {
                    case "\x2a\x86\x48\x86\367\xd\1\x1\x1":
                        goto no;
                    case "\52\206\x48\206\xf7\15\1\5\x3":
                        if (!(ord($this->_string_shift($C3)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                            goto wN;
                        }
                        return false;
                        wN:
                        if (!($this->_decodeLength($C3) != strlen($C3))) {
                            goto HE;
                        }
                        return false;
                        HE:
                        $this->_string_shift($C3);
                        $X8 = $this->_string_shift($C3, $this->_decodeLength($C3));
                        if (!(ord($this->_string_shift($C3)) != CRYPT_RSA_ASN1_INTEGER)) {
                            goto Fw;
                        }
                        return false;
                        Fw:
                        $this->_decodeLength($C3);
                        list(, $Y1) = unpack("\x4e", str_pad($C3, 4, chr(0), STR_PAD_LEFT));
                        $this->_string_shift($aZ);
                        $gM = $this->_decodeLength($aZ);
                        if (!(strlen($aZ) != $gM)) {
                            goto Xv;
                        }
                        return false;
                        Xv:
                        if (class_exists("\x43\x72\x79\160\164\x5f\x44\x45\x53")) {
                            goto hP;
                        }
                        include_once "\103\x72\x79\160\x74\57\104\x45\123\56\160\150\160";
                        hP:
                        $dc = new Crypt_DES();
                        $dc->setPassword($this->password, "\160\x62\153\144\x66\61", "\155\144\65", $X8, $Y1);
                        $aZ = $dc->decrypt($aZ);
                        if (!($aZ === false)) {
                            goto d2;
                        }
                        return false;
                        d2:
                        return $this->_parseKey($aZ, CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
                    default:
                        return false;
                }
                A3:
                no:
                $Bn = ord($this->_string_shift($aZ));
                $this->_decodeLength($aZ);
                if (!($Bn == CRYPT_RSA_ASN1_BITSTRING)) {
                    goto qF;
                }
                $this->_string_shift($aZ);
                qF:
                if (!(ord($this->_string_shift($aZ)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto dq;
                }
                return false;
                dq:
                if (!($this->_decodeLength($aZ) != strlen($aZ))) {
                    goto j4;
                }
                return false;
                j4:
                $Bn = ord($this->_string_shift($aZ));
                yS:
                if (!($Bn != CRYPT_RSA_ASN1_INTEGER)) {
                    goto hv;
                }
                return false;
                hv:
                $gM = $this->_decodeLength($aZ);
                $C3 = $this->_string_shift($aZ, $gM);
                if (!(strlen($C3) != 1 || ord($C3) > 2)) {
                    goto j8;
                }
                $Lw["\155\157\x64\x75\x6c\165\163"] = new Math_BigInteger($C3, 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw[$w1 == CRYPT_RSA_PUBLIC_FORMAT_PKCS1 ? "\x70\x75\142\x6c\x69\x63\105\x78\x70\157\156\x65\x6e\164" : "\160\x72\x69\166\141\x74\145\x45\x78\160\157\156\x65\156\x74"] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                return $Lw;
                j8:
                if (!(ord($this->_string_shift($aZ)) != CRYPT_RSA_ASN1_INTEGER)) {
                    goto Fg;
                }
                return false;
                Fg:
                $gM = $this->_decodeLength($aZ);
                $Lw["\x6d\157\144\x75\x6c\165\x73"] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\160\165\x62\154\151\x63\x45\x78\x70\157\156\145\x6e\164"] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\x70\162\x69\x76\x61\164\x65\105\170\160\157\x6e\145\156\x74"] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\160\162\x69\x6d\145\x73"] = array(1 => new Math_BigInteger($this->_string_shift($aZ, $gM), 256));
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\160\162\x69\155\145\x73"][] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\x65\x78\x70\x6f\156\145\x6e\164\x73"] = array(1 => new Math_BigInteger($this->_string_shift($aZ, $gM), 256));
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\145\x78\160\x6f\x6e\x65\156\x74\x73"][] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\x63\x6f\x65\146\x66\x69\143\151\x65\156\x74\163"] = array(2 => new Math_BigInteger($this->_string_shift($aZ, $gM), 256));
                if (empty($aZ)) {
                    goto L1;
                }
                if (!(ord($this->_string_shift($aZ)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto I0;
                }
                return false;
                I0:
                $this->_decodeLength($aZ);
                cC:
                if (empty($aZ)) {
                    goto E6;
                }
                if (!(ord($this->_string_shift($aZ)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto vp;
                }
                return false;
                vp:
                $this->_decodeLength($aZ);
                $aZ = substr($aZ, 1);
                $gM = $this->_decodeLength($aZ);
                $Lw["\160\x72\x69\x6d\x65\x73"][] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\x65\170\160\x6f\x6e\x65\x6e\164\x73"][] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                $this->_string_shift($aZ);
                $gM = $this->_decodeLength($aZ);
                $Lw["\143\157\x65\146\x66\151\x63\x69\145\156\164\163"][] = new Math_BigInteger($this->_string_shift($aZ, $gM), 256);
                goto cC;
                E6:
                L1:
                return $Lw;
            case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
                $O1 = explode("\x20", $aZ, 3);
                $aZ = isset($O1[1]) ? base64_decode($O1[1]) : false;
                if (!($aZ === false)) {
                    goto RF;
                }
                return false;
                RF:
                $JG = isset($O1[2]) ? $O1[2] : false;
                $sF = substr($aZ, 0, 11) == "\0\0\x0\7\x73\163\150\x2d\162\x73\x61";
                if (!(strlen($aZ) <= 4)) {
                    goto kp;
                }
                return false;
                kp:
                extract(unpack("\x4e\x6c\145\156\x67\x74\150", $this->_string_shift($aZ, 4)));
                $SA = new Math_BigInteger($this->_string_shift($aZ, $gM), -256);
                if (!(strlen($aZ) <= 4)) {
                    goto wl;
                }
                return false;
                wl:
                extract(unpack("\116\154\145\x6e\x67\164\150", $this->_string_shift($aZ, 4)));
                $k4 = new Math_BigInteger($this->_string_shift($aZ, $gM), -256);
                if ($sF && strlen($aZ)) {
                    goto Kf;
                }
                return strlen($aZ) ? false : array("\x6d\x6f\144\165\154\x75\x73" => $k4, "\x70\165\x62\154\x69\x63\105\170\x70\x6f\x6e\145\156\164" => $SA, "\143\x6f\155\155\145\156\x74" => $JG);
                goto fX;
                Kf:
                if (!(strlen($aZ) <= 4)) {
                    goto a6;
                }
                return false;
                a6:
                extract(unpack("\x4e\154\145\156\147\164\150", $this->_string_shift($aZ, 4)));
                $Q9 = new Math_BigInteger($this->_string_shift($aZ, $gM), -256);
                return strlen($aZ) ? false : array("\x6d\157\x64\165\x6c\x75\163" => $Q9, "\x70\x75\142\154\x69\x63\x45\x78\x70\157\x6e\145\156\x74" => $k4, "\x63\x6f\155\155\145\x6e\164" => $JG);
                fX:
            case CRYPT_RSA_PRIVATE_FORMAT_XML:
            case CRYPT_RSA_PUBLIC_FORMAT_XML:
                $this->components = array();
                $UR = xml_parser_create("\x55\124\x46\x2d\x38");
                xml_set_object($UR, $this);
                xml_set_element_handler($UR, "\137\x73\x74\141\x72\x74\137\145\154\145\x6d\145\156\164\x5f\150\141\156\144\x6c\145\x72", "\137\163\x74\157\x70\x5f\x65\154\x65\x6d\x65\156\x74\x5f\x68\x61\x6e\144\154\145\162");
                xml_set_character_data_handler($UR, "\x5f\144\x61\164\141\x5f\x68\141\x6e\x64\x6c\x65\162");
                if (xml_parse($UR, "\74\x78\x6d\x6c\x3e" . $aZ . "\74\x2f\170\x6d\x6c\x3e")) {
                    goto mx;
                }
                return false;
                mx:
                return isset($this->components["\155\157\x64\165\x6c\165\163"]) && isset($this->components["\x70\165\142\x6c\151\x63\x45\170\160\157\x6e\x65\156\x74"]) ? $this->components : false;
            case CRYPT_RSA_PRIVATE_FORMAT_PUTTY:
                $Lw = array();
                $aZ = preg_split("\43\x5c\162\x5c\156\x7c\134\x72\x7c\x5c\156\43", $aZ);
                $w1 = trim(preg_replace("\43\120\x75\124\124\x59\55\x55\x73\x65\x72\x2d\x4b\x65\x79\x2d\106\151\154\x65\55\x32\x3a\x20\50\x2e\53\51\43", "\x24\61", $aZ[0]));
                if (!($w1 != "\x73\x73\150\x2d\x72\x73\x61")) {
                    goto SZ;
                }
                return false;
                SZ:
                $hg = trim(preg_replace("\x23\x45\156\x63\x72\171\160\164\151\x6f\156\72\40\50\x2e\x2b\51\43", "\x24\61", $aZ[1]));
                $JG = trim(preg_replace("\x23\103\157\x6d\155\x65\156\164\x3a\x20\x28\x2e\x2b\x29\43", "\44\61", $aZ[2]));
                $M_ = trim(preg_replace("\43\120\165\x62\x6c\x69\x63\55\114\151\x6e\x65\163\x3a\x20\x28\x5c\x64\x2b\x29\x23", "\x24\61", $aZ[3]));
                $E2 = base64_decode(implode('', array_map("\x74\162\x69\x6d", array_slice($aZ, 4, $M_))));
                $E2 = substr($E2, 11);
                extract(unpack("\116\154\145\x6e\147\x74\150", $this->_string_shift($E2, 4)));
                $Lw["\x70\x75\142\154\x69\x63\105\170\x70\157\156\x65\156\164"] = new Math_BigInteger($this->_string_shift($E2, $gM), -256);
                extract(unpack("\116\154\145\156\x67\x74\150", $this->_string_shift($E2, 4)));
                $Lw["\x6d\157\x64\165\x6c\x75\x73"] = new Math_BigInteger($this->_string_shift($E2, $gM), -256);
                $Wu = trim(preg_replace("\43\120\162\x69\x76\x61\x74\x65\x2d\x4c\x69\156\145\x73\x3a\x20\50\x5c\144\x2b\51\43", "\x24\x31", $aZ[$M_ + 4]));
                $fU = base64_decode(implode('', array_map("\x74\162\151\x6d", array_slice($aZ, $M_ + 5, $Wu))));
                switch ($hg) {
                    case "\141\x65\163\62\65\x36\x2d\143\142\x63":
                        if (class_exists("\x43\162\x79\160\x74\137\101\x45\x53")) {
                            goto P7;
                        }
                        include_once "\x43\162\x79\x70\x74\x2f\x41\x45\x53\x2e\x70\150\x70";
                        P7:
                        $iK = '';
                        $Rf = 0;
                        Xf:
                        if (!(strlen($iK) < 32)) {
                            goto LL;
                        }
                        $C3 = pack("\116\x61\52", $Rf++, $this->password);
                        $iK .= pack("\110\52", sha1($C3));
                        goto Xf;
                        LL:
                        $iK = substr($iK, 0, 32);
                        $dc = new Crypt_AES();
                }
                sE:
                ZV:
                if (!($hg != "\156\157\x6e\x65")) {
                    goto ty;
                }
                $dc->setKey($iK);
                $dc->disablePadding();
                $fU = $dc->decrypt($fU);
                if (!($fU === false)) {
                    goto Iu;
                }
                return false;
                Iu:
                ty:
                extract(unpack("\x4e\154\145\156\147\x74\150", $this->_string_shift($fU, 4)));
                if (!(strlen($fU) < $gM)) {
                    goto d3;
                }
                return false;
                d3:
                $Lw["\160\x72\x69\x76\x61\x74\x65\x45\170\x70\x6f\x6e\145\x6e\164"] = new Math_BigInteger($this->_string_shift($fU, $gM), -256);
                extract(unpack("\116\x6c\145\156\x67\x74\x68", $this->_string_shift($fU, 4)));
                if (!(strlen($fU) < $gM)) {
                    goto ZA;
                }
                return false;
                ZA:
                $Lw["\160\x72\151\155\x65\163"] = array(1 => new Math_BigInteger($this->_string_shift($fU, $gM), -256));
                extract(unpack("\x4e\154\145\156\x67\x74\150", $this->_string_shift($fU, 4)));
                if (!(strlen($fU) < $gM)) {
                    goto Vc;
                }
                return false;
                Vc:
                $Lw["\x70\162\151\x6d\x65\x73"][] = new Math_BigInteger($this->_string_shift($fU, $gM), -256);
                $C3 = $Lw["\x70\162\151\155\145\163"][1]->subtract($this->one);
                $Lw["\x65\x78\x70\157\156\145\156\164\x73"] = array(1 => $Lw["\x70\165\x62\154\151\x63\x45\x78\160\x6f\156\x65\156\x74"]->modInverse($C3));
                $C3 = $Lw["\160\162\151\155\x65\x73"][2]->subtract($this->one);
                $Lw["\145\x78\x70\157\156\x65\156\164\x73"][] = $Lw["\160\165\x62\x6c\x69\143\x45\x78\x70\157\156\145\156\x74"]->modInverse($C3);
                extract(unpack("\116\x6c\x65\x6e\147\x74\x68", $this->_string_shift($fU, 4)));
                if (!(strlen($fU) < $gM)) {
                    goto kL;
                }
                return false;
                kL:
                $Lw["\x63\x6f\145\x66\x66\x69\x63\x69\145\x6e\164\x73"] = array(2 => new Math_BigInteger($this->_string_shift($fU, $gM), -256));
                return $Lw;
        }
        OE:
        vW:
    }
    function getSize()
    {
        return !isset($this->modulus) ? 0 : strlen($this->modulus->toBits());
    }
    function _start_element_handler($ni, $C_, $e1)
    {
        switch ($C_) {
            case "\x4d\117\x44\125\114\125\x53":
                $this->current =& $this->components["\x6d\157\x64\x75\x6c\165\x73"];
                goto x1;
            case "\x45\x58\120\117\116\x45\116\x54":
                $this->current =& $this->components["\160\165\x62\x6c\151\143\x45\x78\160\157\156\x65\x6e\164"];
                goto x1;
            case "\x50":
                $this->current =& $this->components["\160\162\x69\x6d\145\x73"][1];
                goto x1;
            case "\x51":
                $this->current =& $this->components["\160\x72\151\155\145\163"][2];
                goto x1;
            case "\104\x50":
                $this->current =& $this->components["\145\170\x70\x6f\156\145\x6e\164\163"][1];
                goto x1;
            case "\x44\121":
                $this->current =& $this->components["\145\x78\x70\157\x6e\x65\156\x74\163"][2];
                goto x1;
            case "\111\116\x56\x45\122\123\x45\121":
                $this->current =& $this->components["\143\x6f\145\146\x66\x69\143\151\145\x6e\x74\x73"][2];
                goto x1;
            case "\104":
                $this->current =& $this->components["\x70\162\151\x76\141\164\x65\105\170\x70\157\156\145\x6e\164"];
        }
        qW:
        x1:
        $this->current = '';
    }
    function _stop_element_handler($ni, $C_)
    {
        if (!isset($this->current)) {
            goto am;
        }
        $this->current = new Math_BigInteger(base64_decode($this->current), 256);
        unset($this->current);
        am:
    }
    function _data_handler($ni, $D9)
    {
        if (!(!isset($this->current) || is_object($this->current))) {
            goto CX;
        }
        return;
        CX:
        $this->current .= trim($D9);
    }
    function loadKey($aZ, $w1 = false)
    {
        if (!(is_object($aZ) && strtolower(get_class($aZ)) == "\143\x72\x79\x70\164\x5f\x72\163\x61")) {
            goto V9;
        }
        $this->privateKeyFormat = $aZ->privateKeyFormat;
        $this->publicKeyFormat = $aZ->publicKeyFormat;
        $this->k = $aZ->k;
        $this->hLen = $aZ->hLen;
        $this->sLen = $aZ->sLen;
        $this->mgfHLen = $aZ->mgfHLen;
        $this->encryptionMode = $aZ->encryptionMode;
        $this->signatureMode = $aZ->signatureMode;
        $this->password = $aZ->password;
        $this->configFile = $aZ->configFile;
        $this->comment = $aZ->comment;
        if (!is_object($aZ->hash)) {
            goto JQ;
        }
        $this->hash = new Crypt_Hash($aZ->hash->getHash());
        JQ:
        if (!is_object($aZ->mgfHash)) {
            goto DZ;
        }
        $this->mgfHash = new Crypt_Hash($aZ->mgfHash->getHash());
        DZ:
        if (!is_object($aZ->modulus)) {
            goto wq;
        }
        $this->modulus = $aZ->modulus->copy();
        wq:
        if (!is_object($aZ->exponent)) {
            goto iy;
        }
        $this->exponent = $aZ->exponent->copy();
        iy:
        if (!is_object($aZ->publicExponent)) {
            goto Ew;
        }
        $this->publicExponent = $aZ->publicExponent->copy();
        Ew:
        $this->primes = array();
        $this->exponents = array();
        $this->coefficients = array();
        foreach ($this->primes as $HL) {
            $this->primes[] = $HL->copy();
            B7:
        }
        IV:
        foreach ($this->exponents as $Ph) {
            $this->exponents[] = $Ph->copy();
            Wd:
        }
        l2:
        foreach ($this->coefficients as $Zk) {
            $this->coefficients[] = $Zk->copy();
            SD:
        }
        kI:
        return true;
        V9:
        if ($w1 === false) {
            goto Ad;
        }
        $Lw = $this->_parseKey($aZ, $w1);
        goto wQ;
        Ad:
        $aY = array(CRYPT_RSA_PUBLIC_FORMAT_RAW, CRYPT_RSA_PRIVATE_FORMAT_PKCS1, CRYPT_RSA_PRIVATE_FORMAT_XML, CRYPT_RSA_PRIVATE_FORMAT_PUTTY, CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);
        foreach ($aY as $w1) {
            $Lw = $this->_parseKey($aZ, $w1);
            if (!($Lw !== false)) {
                goto jV;
            }
            goto kK;
            jV:
            mK:
        }
        kK:
        wQ:
        if (!($Lw === false)) {
            goto se;
        }
        $this->comment = null;
        $this->modulus = null;
        $this->k = null;
        $this->exponent = null;
        $this->primes = null;
        $this->exponents = null;
        $this->coefficients = null;
        $this->publicExponent = null;
        return false;
        se:
        if (!(isset($Lw["\x63\157\155\x6d\145\x6e\x74"]) && $Lw["\143\157\155\155\145\156\x74"] !== false)) {
            goto Oz;
        }
        $this->comment = $Lw["\x63\x6f\155\x6d\145\156\x74"];
        Oz:
        $this->modulus = $Lw["\x6d\157\x64\165\x6c\x75\163"];
        $this->k = strlen($this->modulus->toBytes());
        $this->exponent = isset($Lw["\160\x72\151\166\141\164\x65\x45\x78\x70\x6f\156\145\x6e\164"]) ? $Lw["\x70\162\151\x76\x61\164\x65\x45\x78\x70\x6f\x6e\145\156\164"] : $Lw["\160\x75\x62\154\x69\x63\105\x78\x70\x6f\x6e\x65\156\x74"];
        if (isset($Lw["\160\x72\151\x6d\145\x73"])) {
            goto Zi;
        }
        $this->primes = array();
        $this->exponents = array();
        $this->coefficients = array();
        $this->publicExponent = false;
        goto ws;
        Zi:
        $this->primes = $Lw["\160\x72\151\x6d\145\x73"];
        $this->exponents = $Lw["\145\x78\160\157\x6e\x65\156\x74\163"];
        $this->coefficients = $Lw["\143\x6f\145\x66\146\x69\x63\x69\145\x6e\x74\163"];
        $this->publicExponent = $Lw["\160\x75\142\154\151\143\x45\x78\160\x6f\x6e\x65\156\164"];
        ws:
        switch ($w1) {
            case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
            case CRYPT_RSA_PUBLIC_FORMAT_RAW:
                $this->setPublicKey();
                goto MF;
            case CRYPT_RSA_PRIVATE_FORMAT_PKCS1:
                switch (true) {
                    case strpos($aZ, "\55\102\105\x47\111\116\40\120\125\102\x4c\111\x43\x20\113\105\x59\x2d") !== false:
                    case strpos($aZ, "\55\x42\x45\107\111\116\x20\x52\123\101\x20\x50\x55\x42\x4c\111\103\x20\113\105\131\55") !== false:
                        $this->setPublicKey();
                }
                ND:
                Rl:
        }
        QN:
        MF:
        return true;
    }
    function setPassword($lw = false)
    {
        $this->password = $lw;
    }
    function setPublicKey($aZ = false, $w1 = false)
    {
        if (empty($this->publicExponent)) {
            goto D7;
        }
        return false;
        D7:
        if (!($aZ === false && !empty($this->modulus))) {
            goto S2;
        }
        $this->publicExponent = $this->exponent;
        return true;
        S2:
        if ($w1 === false) {
            goto yj;
        }
        $Lw = $this->_parseKey($aZ, $w1);
        goto Wj;
        yj:
        $aY = array(CRYPT_RSA_PUBLIC_FORMAT_RAW, CRYPT_RSA_PUBLIC_FORMAT_PKCS1, CRYPT_RSA_PUBLIC_FORMAT_XML, CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);
        foreach ($aY as $w1) {
            $Lw = $this->_parseKey($aZ, $w1);
            if (!($Lw !== false)) {
                goto Iy;
            }
            goto RD;
            Iy:
            qk:
        }
        RD:
        Wj:
        if (!($Lw === false)) {
            goto Mr;
        }
        return false;
        Mr:
        if (!(empty($this->modulus) || !$this->modulus->equals($Lw["\x6d\x6f\144\x75\x6c\x75\163"]))) {
            goto T8;
        }
        $this->modulus = $Lw["\x6d\x6f\x64\165\x6c\x75\163"];
        $this->exponent = $this->publicExponent = $Lw["\x70\x75\142\x6c\x69\143\105\x78\160\157\x6e\x65\156\x74"];
        return true;
        T8:
        $this->publicExponent = $Lw["\160\x75\x62\x6c\x69\x63\x45\x78\160\x6f\x6e\x65\156\x74"];
        return true;
    }
    function setPrivateKey($aZ = false, $w1 = false)
    {
        if (!($aZ === false && !empty($this->publicExponent))) {
            goto OZ;
        }
        $this->publicExponent = false;
        return true;
        OZ:
        $Jw = new Crypt_RSA();
        if ($Jw->loadKey($aZ, $w1)) {
            goto BB;
        }
        return false;
        BB:
        $Jw->publicExponent = false;
        $this->loadKey($Jw);
        return true;
    }
    function getPublicKey($w1 = CRYPT_RSA_PUBLIC_FORMAT_PKCS8)
    {
        if (!(empty($this->modulus) || empty($this->publicExponent))) {
            goto GU;
        }
        return false;
        GU:
        $Zh = $this->publicKeyFormat;
        $this->publicKeyFormat = $w1;
        $C3 = $this->_convertPublicKey($this->modulus, $this->publicExponent);
        $this->publicKeyFormat = $Zh;
        return $C3;
    }
    function getPublicKeyFingerprint($Mf = "\155\144\x35")
    {
        if (!(empty($this->modulus) || empty($this->publicExponent))) {
            goto k3;
        }
        return false;
        k3:
        $k4 = $this->modulus->toBytes(true);
        $SA = $this->publicExponent->toBytes(true);
        $J6 = pack("\x4e\141\52\x4e\x61\x2a\116\x61\x2a", strlen("\163\163\x68\x2d\x72\163\141"), "\x73\163\150\x2d\162\x73\x61", strlen($SA), $SA, strlen($k4), $k4);
        switch ($Mf) {
            case "\163\150\x61\62\x35\66":
                $hU = new Crypt_Hash("\163\150\141\62\65\66");
                $JP = base64_encode($hU->hash($J6));
                return substr($JP, 0, strlen($JP) - 1);
            case "\x6d\x64\65":
                return substr(chunk_split(md5($J6), 2, "\72"), 0, -1);
            default:
                return false;
        }
        C1:
        F8:
    }
    function getPrivateKey($w1 = CRYPT_RSA_PUBLIC_FORMAT_PKCS1)
    {
        if (!empty($this->primes)) {
            goto jO;
        }
        return false;
        jO:
        $Zh = $this->privateKeyFormat;
        $this->privateKeyFormat = $w1;
        $C3 = $this->_convertPrivateKey($this->modulus, $this->publicExponent, $this->exponent, $this->primes, $this->exponents, $this->coefficients);
        $this->privateKeyFormat = $Zh;
        return $C3;
    }
    function _getPrivatePublicKey($SG = CRYPT_RSA_PUBLIC_FORMAT_PKCS8)
    {
        if (!(empty($this->modulus) || empty($this->exponent))) {
            goto Ud;
        }
        return false;
        Ud:
        $Zh = $this->publicKeyFormat;
        $this->publicKeyFormat = $SG;
        $C3 = $this->_convertPublicKey($this->modulus, $this->exponent);
        $this->publicKeyFormat = $Zh;
        return $C3;
    }
    function __toString()
    {
        $aZ = $this->getPrivateKey($this->privateKeyFormat);
        if (!($aZ !== false)) {
            goto Mt;
        }
        return $aZ;
        Mt:
        $aZ = $this->_getPrivatePublicKey($this->publicKeyFormat);
        return $aZ !== false ? $aZ : '';
    }
    function __clone()
    {
        $aZ = new Crypt_RSA();
        $aZ->loadKey($this);
        return $aZ;
    }
    function _generateMinMax($AJ)
    {
        $gx = $AJ >> 3;
        $wl = str_repeat(chr(0), $gx);
        $gF = str_repeat(chr(0xff), $gx);
        $a5 = $AJ & 7;
        if ($a5) {
            goto UB;
        }
        $wl[0] = chr(0x80);
        goto o4;
        UB:
        $wl = chr(1 << $a5 - 1) . $wl;
        $gF = chr((1 << $a5) - 1) . $gF;
        o4:
        return array("\x6d\x69\156" => new Math_BigInteger($wl, 256), "\155\141\x78" => new Math_BigInteger($gF, 256));
    }
    function _decodeLength(&$z8)
    {
        $gM = ord($this->_string_shift($z8));
        if (!($gM & 0x80)) {
            goto Ux;
        }
        $gM &= 0x7f;
        $C3 = $this->_string_shift($z8, $gM);
        list(, $gM) = unpack("\116", substr(str_pad($C3, 4, chr(0), STR_PAD_LEFT), -4));
        Ux:
        return $gM;
    }
    function _encodeLength($gM)
    {
        if (!($gM <= 0x7f)) {
            goto nq;
        }
        return chr($gM);
        nq:
        $C3 = ltrim(pack("\116", $gM), chr(0));
        return pack("\103\x61\x2a", 0x80 | strlen($C3), $C3);
    }
    function _string_shift(&$z8, $FX = 1)
    {
        $N2 = substr($z8, 0, $FX);
        $z8 = substr($z8, $FX);
        return $N2;
    }
    function setPrivateKeyFormat($Ca)
    {
        $this->privateKeyFormat = $Ca;
    }
    function setPublicKeyFormat($Ca)
    {
        $this->publicKeyFormat = $Ca;
    }
    function setHash($hU)
    {
        switch ($hU) {
            case "\155\x64\62":
            case "\155\x64\65":
            case "\163\x68\x61\61":
            case "\163\150\x61\62\65\66":
            case "\x73\150\141\63\70\64":
            case "\163\x68\x61\x35\x31\x32":
                $this->hash = new Crypt_Hash($hU);
                $this->hashName = $hU;
                goto Nb;
            default:
                $this->hash = new Crypt_Hash("\x73\x68\x61\61");
                $this->hashName = "\163\x68\x61\61";
        }
        rD:
        Nb:
        $this->hLen = $this->hash->getLength();
    }
    function setMGFHash($hU)
    {
        switch ($hU) {
            case "\x6d\144\x32":
            case "\155\x64\65":
            case "\163\150\141\x31":
            case "\163\x68\141\62\x35\66":
            case "\x73\150\141\63\70\64":
            case "\163\150\141\x35\61\x32":
                $this->mgfHash = new Crypt_Hash($hU);
                goto tv;
            default:
                $this->mgfHash = new Crypt_Hash("\163\150\x61\61");
        }
        qH:
        tv:
        $this->mgfHLen = $this->mgfHash->getLength();
    }
    function setSaltLength($PI)
    {
        $this->sLen = $PI;
    }
    function _i2osp($rk, $vB)
    {
        $rk = $rk->toBytes();
        if (!(strlen($rk) > $vB)) {
            goto g6;
        }
        user_error("\x49\x6e\x74\145\x67\x65\162\x20\x74\157\157\x20\154\x61\162\147\145");
        return false;
        g6:
        return str_pad($rk, $vB, chr(0), STR_PAD_LEFT);
    }
    function _os2ip($rk)
    {
        return new Math_BigInteger($rk, 256);
    }
    function _exponentiate($rk)
    {
        switch (true) {
            case empty($this->primes):
            case $this->primes[1]->equals($this->zero):
            case empty($this->coefficients):
            case $this->coefficients[2]->equals($this->zero):
            case empty($this->exponents):
            case $this->exponents[1]->equals($this->zero):
                return $rk->modPow($this->exponent, $this->modulus);
        }
        bM:
        TX:
        $gd = count($this->primes);
        if (defined("\103\122\x59\120\124\137\x52\x53\101\137\104\x49\123\x41\102\x4c\x45\137\x42\x4c\x49\116\x44\x49\116\x47")) {
            goto EQ;
        }
        $UC = $this->primes[1];
        $Bi = 2;
        oW:
        if (!($Bi <= $gd)) {
            goto y0;
        }
        if (!($UC->compare($this->primes[$Bi]) > 0)) {
            goto Pz;
        }
        $UC = $this->primes[$Bi];
        Pz:
        SX:
        $Bi++;
        goto oW;
        y0:
        $kC = new Math_BigInteger(1);
        $Xg = $kC->random($kC, $UC->subtract($kC));
        $kv = array(1 => $this->_blind($rk, $Xg, 1), 2 => $this->_blind($rk, $Xg, 2));
        $Rb = $kv[1]->subtract($kv[2]);
        $Rb = $Rb->multiply($this->coefficients[2]);
        list(, $Rb) = $Rb->divide($this->primes[1]);
        $KJ = $kv[2]->add($Rb->multiply($this->primes[2]));
        $Xg = $this->primes[1];
        $Bi = 3;
        lX:
        if (!($Bi <= $gd)) {
            goto Jx;
        }
        $kv = $this->_blind($rk, $Xg, $Bi);
        $Xg = $Xg->multiply($this->primes[$Bi - 1]);
        $Rb = $kv->subtract($KJ);
        $Rb = $Rb->multiply($this->coefficients[$Bi]);
        list(, $Rb) = $Rb->divide($this->primes[$Bi]);
        $KJ = $KJ->add($Xg->multiply($Rb));
        xH:
        $Bi++;
        goto lX;
        Jx:
        goto Yn;
        EQ:
        $kv = array(1 => $rk->modPow($this->exponents[1], $this->primes[1]), 2 => $rk->modPow($this->exponents[2], $this->primes[2]));
        $Rb = $kv[1]->subtract($kv[2]);
        $Rb = $Rb->multiply($this->coefficients[2]);
        list(, $Rb) = $Rb->divide($this->primes[1]);
        $KJ = $kv[2]->add($Rb->multiply($this->primes[2]));
        $Xg = $this->primes[1];
        $Bi = 3;
        Qe:
        if (!($Bi <= $gd)) {
            goto GZ;
        }
        $kv = $rk->modPow($this->exponents[$Bi], $this->primes[$Bi]);
        $Xg = $Xg->multiply($this->primes[$Bi - 1]);
        $Rb = $kv->subtract($KJ);
        $Rb = $Rb->multiply($this->coefficients[$Bi]);
        list(, $Rb) = $Rb->divide($this->primes[$Bi]);
        $KJ = $KJ->add($Xg->multiply($Rb));
        PT:
        $Bi++;
        goto Qe;
        GZ:
        Yn:
        return $KJ;
    }
    function _blind($rk, $Xg, $Bi)
    {
        $rk = $rk->multiply($Xg->modPow($this->publicExponent, $this->primes[$Bi]));
        $rk = $rk->modPow($this->exponents[$Bi], $this->primes[$Bi]);
        $Xg = $Xg->modInverse($this->primes[$Bi]);
        $rk = $rk->multiply($Xg);
        list(, $rk) = $rk->divide($this->primes[$Bi]);
        return $rk;
    }
    function _equals($rk, $wQ)
    {
        if (!(strlen($rk) != strlen($wQ))) {
            goto LI;
        }
        return false;
        LI:
        $Mn = 0;
        $Bi = 0;
        Eu:
        if (!($Bi < strlen($rk))) {
            goto yn;
        }
        $Mn |= ord($rk[$Bi]) ^ ord($wQ[$Bi]);
        T2:
        $Bi++;
        goto Eu;
        yn:
        return $Mn == 0;
    }
    function _rsaep($KJ)
    {
        if (!($KJ->compare($this->zero) < 0 || $KJ->compare($this->modulus) > 0)) {
            goto CT;
        }
        user_error("\115\145\163\163\x61\x67\145\40\x72\145\x70\x72\x65\163\145\156\x74\x61\x74\x69\x76\145\40\x6f\x75\x74\x20\157\x66\40\162\x61\x6e\147\x65");
        return false;
        CT:
        return $this->_exponentiate($KJ);
    }
    function _rsadp($cm)
    {
        if (!($cm->compare($this->zero) < 0 || $cm->compare($this->modulus) > 0)) {
            goto uM;
        }
        user_error("\x43\151\160\150\x65\x72\164\145\x78\x74\40\x72\145\x70\162\x65\163\x65\x6e\x74\x61\164\151\x76\145\40\157\x75\164\40\x6f\146\x20\162\141\x6e\147\x65");
        return false;
        uM:
        return $this->_exponentiate($cm);
    }
    function _rsasp1($KJ)
    {
        if (!($KJ->compare($this->zero) < 0 || $KJ->compare($this->modulus) > 0)) {
            goto CH;
        }
        user_error("\x4d\145\163\163\x61\x67\x65\40\162\x65\x70\162\x65\163\145\x6e\x74\x61\x74\151\166\145\40\x6f\165\x74\x20\x6f\x66\x20\x72\141\x6e\147\145");
        return false;
        CH:
        return $this->_exponentiate($KJ);
    }
    function _rsavp1($QI)
    {
        if (!($QI->compare($this->zero) < 0 || $QI->compare($this->modulus) > 0)) {
            goto Wf;
        }
        user_error("\x53\x69\x67\x6e\x61\x74\165\162\145\40\162\x65\x70\162\145\163\x65\x6e\x74\x61\164\x69\166\x65\40\x6f\x75\164\40\x6f\146\x20\x72\x61\x6e\x67\145");
        return false;
        Wf:
        return $this->_exponentiate($QI);
    }
    function _mgf1($Kw, $b7)
    {
        $Gt = '';
        $pi = ceil($b7 / $this->mgfHLen);
        $Bi = 0;
        u0:
        if (!($Bi < $pi)) {
            goto b1;
        }
        $cm = pack("\116", $Bi);
        $Gt .= $this->mgfHash->hash($Kw . $cm);
        GS:
        $Bi++;
        goto u0;
        b1:
        return substr($Gt, 0, $b7);
    }
    function _rsaes_oaep_encrypt($KJ, $qT = '')
    {
        $er = strlen($KJ);
        if (!($er > $this->k - 2 * $this->hLen - 2)) {
            goto f9;
        }
        user_error("\x4d\x65\x73\163\x61\147\x65\40\164\157\x6f\40\x6c\x6f\156\147");
        return false;
        f9:
        $yA = $this->hash->hash($qT);
        $z2 = str_repeat(chr(0), $this->k - $er - 2 * $this->hLen - 2);
        $bd = $yA . $z2 . chr(1) . $KJ;
        $OM = crypt_random_string($this->hLen);
        $xG = $this->_mgf1($OM, $this->k - $this->hLen - 1);
        $JL = $bd ^ $xG;
        $e4 = $this->_mgf1($JL, $this->hLen);
        $dk = $OM ^ $e4;
        $bV = chr(0) . $dk . $JL;
        $KJ = $this->_os2ip($bV);
        $cm = $this->_rsaep($KJ);
        $cm = $this->_i2osp($cm, $this->k);
        return $cm;
    }
    function _rsaes_oaep_decrypt($cm, $qT = '')
    {
        if (!(strlen($cm) != $this->k || $this->k < 2 * $this->hLen + 2)) {
            goto gC;
        }
        user_error("\x44\145\x63\162\x79\x70\x74\x69\157\156\x20\145\162\x72\157\162");
        return false;
        gC:
        $cm = $this->_os2ip($cm);
        $KJ = $this->_rsadp($cm);
        if (!($KJ === false)) {
            goto mY;
        }
        user_error("\x44\x65\x63\162\171\160\x74\x69\x6f\156\40\145\x72\x72\x6f\x72");
        return false;
        mY:
        $bV = $this->_i2osp($KJ, $this->k);
        $yA = $this->hash->hash($qT);
        $wQ = ord($bV[0]);
        $dk = substr($bV, 1, $this->hLen);
        $JL = substr($bV, $this->hLen + 1);
        $e4 = $this->_mgf1($JL, $this->hLen);
        $OM = $dk ^ $e4;
        $xG = $this->_mgf1($OM, $this->k - $this->hLen - 1);
        $bd = $JL ^ $xG;
        $Ke = substr($bd, 0, $this->hLen);
        $KJ = substr($bd, $this->hLen);
        if ($this->_equals($yA, $Ke)) {
            goto vN;
        }
        user_error("\104\145\x63\x72\x79\x70\x74\151\157\x6e\40\x65\162\162\x6f\162");
        return false;
        vN:
        $KJ = ltrim($KJ, chr(0));
        if (!(ord($KJ[0]) != 1)) {
            goto l0;
        }
        user_error("\104\x65\x63\162\x79\x70\x74\151\157\x6e\40\x65\x72\162\157\x72");
        return false;
        l0:
        return substr($KJ, 1);
    }
    function _raw_encrypt($KJ)
    {
        $C3 = $this->_os2ip($KJ);
        $C3 = $this->_rsaep($C3);
        return $this->_i2osp($C3, $this->k);
    }
    function _rsaes_pkcs1_v1_5_encrypt($KJ)
    {
        $er = strlen($KJ);
        if (!($er > $this->k - 11)) {
            goto QE;
        }
        user_error("\115\145\x73\163\141\147\145\x20\164\x6f\x6f\x20\154\157\x6e\147");
        return false;
        QE:
        $VB = $this->k - $er - 3;
        $z2 = '';
        QO:
        if (!(strlen($z2) != $VB)) {
            goto EW;
        }
        $C3 = crypt_random_string($VB - strlen($z2));
        $C3 = str_replace("\0", '', $C3);
        $z2 .= $C3;
        goto QO;
        EW:
        $w1 = 2;
        if (!(defined("\103\x52\131\x50\124\137\122\123\x41\x5f\120\x4b\x43\123\x31\65\137\x43\x4f\x4d\120\101\x54") && (!isset($this->publicExponent) || $this->exponent !== $this->publicExponent))) {
            goto OJ;
        }
        $w1 = 1;
        $z2 = str_repeat("\xff", $VB);
        OJ:
        $bV = chr(0) . chr($w1) . $z2 . chr(0) . $KJ;
        $KJ = $this->_os2ip($bV);
        $cm = $this->_rsaep($KJ);
        $cm = $this->_i2osp($cm, $this->k);
        return $cm;
    }
    function _rsaes_pkcs1_v1_5_decrypt($cm)
    {
        if (!(strlen($cm) != $this->k)) {
            goto TE;
        }
        user_error("\x44\145\143\x72\x79\x70\x74\151\157\156\40\x65\x72\x72\x6f\162");
        return false;
        TE:
        $cm = $this->_os2ip($cm);
        $KJ = $this->_rsadp($cm);
        if (!($KJ === false)) {
            goto sa;
        }
        user_error("\104\x65\x63\162\x79\x70\x74\151\x6f\156\40\x65\x72\x72\x6f\162");
        return false;
        sa:
        $bV = $this->_i2osp($KJ, $this->k);
        if (!(ord($bV[0]) != 0 || ord($bV[1]) > 2)) {
            goto K_;
        }
        user_error("\x44\145\x63\162\x79\x70\x74\151\x6f\156\x20\x65\162\162\x6f\162");
        return false;
        K_:
        $z2 = substr($bV, 2, strpos($bV, chr(0), 2) - 2);
        $KJ = substr($bV, strlen($z2) + 3);
        if (!(strlen($z2) < 8)) {
            goto cv;
        }
        user_error("\x44\x65\143\x72\x79\160\164\x69\157\156\40\145\162\162\x6f\x72");
        return false;
        cv:
        return $KJ;
    }
    function _emsa_pss_encode($KJ, $IW)
    {
        $xs = $IW + 1 >> 3;
        $PI = $this->sLen !== null ? $this->sLen : $this->hLen;
        $Vb = $this->hash->hash($KJ);
        if (!($xs < $this->hLen + $PI + 2)) {
            goto qx;
        }
        user_error("\x45\156\x63\x6f\144\x69\156\147\x20\145\x72\162\157\x72");
        return false;
        qx:
        $X8 = crypt_random_string($PI);
        $Z5 = "\0\0\x0\x0\0\0\0\0" . $Vb . $X8;
        $Rb = $this->hash->hash($Z5);
        $z2 = str_repeat(chr(0), $xs - $PI - $this->hLen - 2);
        $bd = $z2 . chr(1) . $X8;
        $xG = $this->_mgf1($Rb, $xs - $this->hLen - 1);
        $JL = $bd ^ $xG;
        $JL[0] = ~chr(0xff << ($IW & 7)) & $JL[0];
        $bV = $JL . $Rb . chr(0xbc);
        return $bV;
    }
    function _emsa_pss_verify($KJ, $bV, $IW)
    {
        $xs = $IW + 1 >> 3;
        $PI = $this->sLen !== null ? $this->sLen : $this->hLen;
        $Vb = $this->hash->hash($KJ);
        if (!($xs < $this->hLen + $PI + 2)) {
            goto QU;
        }
        return false;
        QU:
        if (!($bV[strlen($bV) - 1] != chr(0xbc))) {
            goto U4;
        }
        return false;
        U4:
        $JL = substr($bV, 0, -$this->hLen - 1);
        $Rb = substr($bV, -$this->hLen - 1, $this->hLen);
        $C3 = chr(0xff << ($IW & 7));
        if (!((~$JL[0] & $C3) != $C3)) {
            goto Te;
        }
        return false;
        Te:
        $xG = $this->_mgf1($Rb, $xs - $this->hLen - 1);
        $bd = $JL ^ $xG;
        $bd[0] = ~chr(0xff << ($IW & 7)) & $bd[0];
        $C3 = $xs - $this->hLen - $PI - 2;
        if (!(substr($bd, 0, $C3) != str_repeat(chr(0), $C3) || ord($bd[$C3]) != 1)) {
            goto vV;
        }
        return false;
        vV:
        $X8 = substr($bd, $C3 + 1);
        $Z5 = "\0\0\x0\0\0\0\0\x0" . $Vb . $X8;
        $b0 = $this->hash->hash($Z5);
        return $this->_equals($Rb, $b0);
    }
    function _rsassa_pss_sign($KJ)
    {
        $bV = $this->_emsa_pss_encode($KJ, 8 * $this->k - 1);
        $KJ = $this->_os2ip($bV);
        $QI = $this->_rsasp1($KJ);
        $QI = $this->_i2osp($QI, $this->k);
        return $QI;
    }
    function _rsassa_pss_verify($KJ, $QI)
    {
        if (!(strlen($QI) != $this->k)) {
            goto qh;
        }
        user_error("\111\x6e\x76\x61\154\x69\144\x20\x73\x69\x67\156\141\164\x75\x72\x65");
        return false;
        qh:
        $ul = 8 * $this->k;
        $nP = $this->_os2ip($QI);
        $Z5 = $this->_rsavp1($nP);
        if (!($Z5 === false)) {
            goto Pw;
        }
        user_error("\111\x6e\166\141\x6c\x69\144\x20\x73\x69\x67\x6e\141\x74\165\x72\x65");
        return false;
        Pw:
        $bV = $this->_i2osp($Z5, $ul >> 3);
        if (!($bV === false)) {
            goto yQ;
        }
        user_error("\111\156\x76\x61\x6c\151\144\40\x73\x69\147\x6e\141\164\x75\x72\x65");
        return false;
        yQ:
        return $this->_emsa_pss_verify($KJ, $bV, $ul - 1);
    }
    function _emsa_pkcs1_v1_5_encode($KJ, $xs)
    {
        $Rb = $this->hash->hash($KJ);
        if (!($Rb === false)) {
            goto sX;
        }
        return false;
        sX:
        switch ($this->hashName) {
            case "\155\144\62":
                $Gt = pack("\x48\x2a", "\63\x30\62\60\63\60\60\143\60\x36\60\70\x32\141\x38\x36\x34\x38\70\x36\x66\67\x30\144\x30\62\60\x32\60\x35\x30\60\60\x34\61\x30");
                goto DC;
            case "\155\x64\65":
                $Gt = pack("\x48\x2a", "\x33\x30\62\60\x33\60\60\x63\60\66\60\70\x32\141\70\x36\64\x38\x38\x36\x66\67\x30\144\60\x32\x30\x35\60\x35\x30\x30\60\64\61\x30");
                goto DC;
            case "\163\150\141\61":
                $Gt = pack("\x48\52", "\63\60\62\x31\63\60\60\71\60\x36\60\65\x32\x62\x30\x65\60\63\x30\x32\x31\141\x30\x35\x30\60\x30\64\x31\64");
                goto DC;
            case "\163\x68\141\x32\x35\x36":
                $Gt = pack("\x48\52", "\x33\60\63\x31\63\x30\x30\x64\x30\x36\x30\x39\x36\60\70\66\64\70\60\x31\x36\65\x30\63\x30\x34\60\62\60\x31\60\x35\x30\60\60\64\62\60");
                goto DC;
            case "\163\x68\x61\x33\70\64":
                $Gt = pack("\x48\x2a", "\x33\x30\64\x31\x33\60\x30\x64\60\x36\x30\71\66\x30\x38\66\64\70\x30\x31\x36\65\60\63\x30\x34\x30\62\60\x32\60\65\60\x30\x30\64\63\60");
                goto DC;
            case "\x73\x68\x61\65\x31\x32":
                $Gt = pack("\110\x2a", "\x33\60\x35\x31\63\x30\x30\x64\60\66\60\x39\x36\60\x38\x36\x34\x38\x30\61\66\65\x30\x33\60\64\x30\x32\x30\63\x30\x35\x30\x30\60\x34\64\60");
        }
        rg:
        DC:
        $Gt .= $Rb;
        $If = strlen($Gt);
        if (!($xs < $If + 11)) {
            goto bs;
        }
        user_error("\111\x6e\x74\x65\x6e\144\x65\144\40\x65\156\143\157\x64\145\x64\x20\155\x65\163\163\141\147\x65\x20\154\x65\x6e\147\x74\150\x20\x74\157\x6f\x20\x73\150\x6f\x72\164");
        return false;
        bs:
        $z2 = str_repeat(chr(0xff), $xs - $If - 3);
        $bV = "\x0\1{$z2}\0{$Gt}";
        return $bV;
    }
    function _rsassa_pkcs1_v1_5_sign($KJ)
    {
        $bV = $this->_emsa_pkcs1_v1_5_encode($KJ, $this->k);
        if (!($bV === false)) {
            goto n1;
        }
        user_error("\122\123\101\40\x6d\157\144\x75\x6c\165\163\x20\164\x6f\157\40\163\x68\157\x72\x74");
        return false;
        n1:
        $KJ = $this->_os2ip($bV);
        $QI = $this->_rsasp1($KJ);
        $QI = $this->_i2osp($QI, $this->k);
        return $QI;
    }
    function _rsassa_pkcs1_v1_5_verify($KJ, $QI)
    {
        if (!(strlen($QI) != $this->k)) {
            goto gA;
        }
        user_error("\x49\156\166\141\x6c\x69\144\x20\x73\151\x67\156\x61\x74\x75\x72\x65");
        return false;
        gA:
        $QI = $this->_os2ip($QI);
        $Z5 = $this->_rsavp1($QI);
        if (!($Z5 === false)) {
            goto sV;
        }
        user_error("\x49\x6e\x76\x61\x6c\x69\144\x20\163\151\147\156\x61\x74\x75\x72\145");
        return false;
        sV:
        $bV = $this->_i2osp($Z5, $this->k);
        if (!($bV === false)) {
            goto mo;
        }
        user_error("\111\x6e\166\141\154\x69\144\40\163\x69\147\156\141\164\165\x72\145");
        return false;
        mo:
        $lM = $this->_emsa_pkcs1_v1_5_encode($KJ, $this->k);
        if (!($lM === false)) {
            goto R4;
        }
        user_error("\x52\x53\101\40\x6d\x6f\144\x75\x6c\165\x73\40\164\x6f\157\40\x73\x68\157\x72\x74");
        return false;
        R4:
        return $this->_equals($bV, $lM);
    }
    function setEncryptionMode($SG)
    {
        $this->encryptionMode = $SG;
    }
    function setSignatureMode($SG)
    {
        $this->signatureMode = $SG;
    }
    function setComment($JG)
    {
        $this->comment = $JG;
    }
    function getComment()
    {
        return $this->comment;
    }
    function encrypt($Ar)
    {
        switch ($this->encryptionMode) {
            case CRYPT_RSA_ENCRYPTION_NONE:
                $Ar = str_split($Ar, $this->k);
                $e7 = '';
                foreach ($Ar as $KJ) {
                    $e7 .= $this->_raw_encrypt($KJ);
                    UL:
                }
                vQ:
                return $e7;
            case CRYPT_RSA_ENCRYPTION_PKCS1:
                $gM = $this->k - 11;
                if (!($gM <= 0)) {
                    goto hW;
                }
                return false;
                hW:
                $Ar = str_split($Ar, $gM);
                $e7 = '';
                foreach ($Ar as $KJ) {
                    $e7 .= $this->_rsaes_pkcs1_v1_5_encrypt($KJ);
                    PY:
                }
                Ev:
                return $e7;
            default:
                $gM = $this->k - 2 * $this->hLen - 2;
                if (!($gM <= 0)) {
                    goto kw;
                }
                return false;
                kw:
                $Ar = str_split($Ar, $gM);
                $e7 = '';
                foreach ($Ar as $KJ) {
                    $e7 .= $this->_rsaes_oaep_encrypt($KJ);
                    pn:
                }
                gh:
                return $e7;
        }
        Lm:
        TF:
    }
    function decrypt($e7)
    {
        if (!($this->k <= 0)) {
            goto ib;
        }
        return false;
        ib:
        $e7 = str_split($e7, $this->k);
        $e7[count($e7) - 1] = str_pad($e7[count($e7) - 1], $this->k, chr(0), STR_PAD_LEFT);
        $Ar = '';
        switch ($this->encryptionMode) {
            case CRYPT_RSA_ENCRYPTION_NONE:
                $vS = "\x5f\162\141\167\137\x65\x6e\143\x72\x79\x70\164";
                goto Im;
            case CRYPT_RSA_ENCRYPTION_PKCS1:
                $vS = "\x5f\x72\163\141\145\163\x5f\160\153\143\163\61\137\166\61\x5f\65\137\144\x65\143\162\171\x70\x74";
                goto Im;
            default:
                $vS = "\137\x72\163\x61\x65\163\x5f\x6f\141\x65\x70\x5f\x64\x65\x63\162\x79\160\x74";
        }
        S8:
        Im:
        foreach ($e7 as $cm) {
            $C3 = $this->{$vS}($cm);
            if (!($C3 === false)) {
                goto vG;
            }
            return false;
            vG:
            $Ar .= $C3;
            vA:
        }
        TY:
        return $Ar;
    }
    function sign($Vw)
    {
        if (!(empty($this->modulus) || empty($this->exponent))) {
            goto r7;
        }
        return false;
        r7:
        switch ($this->signatureMode) {
            case CRYPT_RSA_SIGNATURE_PKCS1:
                return $this->_rsassa_pkcs1_v1_5_sign($Vw);
            default:
                return $this->_rsassa_pss_sign($Vw);
        }
        zi:
        Jn:
    }
    function verify($Vw, $xN)
    {
        if (!(empty($this->modulus) || empty($this->exponent))) {
            goto KF;
        }
        return false;
        KF:
        switch ($this->signatureMode) {
            case CRYPT_RSA_SIGNATURE_PKCS1:
                return $this->_rsassa_pkcs1_v1_5_verify($Vw, $xN);
            default:
                return $this->_rsassa_pss_verify($Vw, $xN);
        }
        hG:
        aG:
    }
    function _extractBER($wM)
    {
        $C3 = preg_replace("\43\x2e\x2a\x3f\136\x2d\53\x5b\x5e\x2d\135\53\x2d\53\133\x5c\x72\134\156\x20\x5d\x2a\x24\x23\155\x73", '', $wM, 1);
        $C3 = preg_replace("\x23\55\53\x5b\136\x2d\135\x2b\x2d\x2b\43", '', $C3);
        $C3 = str_replace(array("\xd", "\xa", "\40"), '', $C3);
        $C3 = preg_match("\x23\136\x5b\141\x2d\x7a\101\x2d\132\134\x64\57\x2b\135\x2a\x3d\173\x30\x2c\x32\175\44\43", $C3) ? base64_decode($C3) : false;
        return $C3 != false ? $C3 : $wM;
    }
}
