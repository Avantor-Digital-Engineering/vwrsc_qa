<?php


class MiniorangeOAuthCustomer
{
    public $email;
    public $customerKey;
    public $transactionId;
    public $password;
    private $defaultCustomerId;
    private $defaultCustomerApiKey;
    public function __construct($fw, $lw)
    {
        $this->email = $fw;
        $this->password = $lw;
        $this->defaultCustomerId = "\61\66\x35\65\x35";
        $this->defaultCustomerApiKey = "\x66\x46\x64\62\130\x63\166\124\x47\x44\x65\155\x5a\x76\142\x77\61\142\143\125\145\x73\x4e\112\x57\105\x71\113\142\142\x55\161";
    }
    public function checkCustomer()
    {
        if (Utilities::isCurlInstalled()) {
            goto sA;
        }
        return json_encode(array("\x73\164\x61\164\x75\x73" => "\x43\125\122\114\137\x45\122\122\117\x52", "\163\164\x61\164\x75\163\115\x65\163\x73\x61\x67\145" => "\74\141\x20\150\x72\x65\x66\x3d\42\150\x74\164\x70\x3a\x2f\57\x70\150\160\x2e\156\x65\x74\57\155\x61\x6e\165\141\x6c\x2f\x65\156\x2f\143\x75\162\x6c\56\x69\x6e\x73\164\x61\154\x6c\141\164\x69\x6f\x6e\56\x70\150\x70\x22\x3e\x50\110\x50\40\x63\125\x52\114\40\145\x78\164\x65\156\163\151\x6f\x6e\74\57\x61\76\x20\x69\163\x20\156\157\164\40\151\x6e\x73\164\x61\x6c\x6c\145\144\40\157\162\x20\144\x69\x73\x61\142\x6c\145\144\x2e"));
        sA:
        $te = MiniorangeOAuthConstants::BASE_URL . "\x2f\155\x6f\141\163\57\162\x65\x73\164\x2f\143\x75\x73\x74\157\x6d\145\162\57\143\150\145\143\153\x2d\x69\x66\x2d\x65\x78\x69\163\164\163";
        $Ka = curl_init($te);
        $fw = $this->email;
        $Dh = array("\145\155\x61\151\x6c" => $fw);
        $Ai = json_encode($Dh);
        curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($Ka, CURLOPT_ENCODING, '');
        curl_setopt($Ka, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($Ka, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
        curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x43\x6f\x6e\x74\145\x6e\x74\x2d\124\171\x70\x65\72\40\141\160\x70\154\x69\143\x61\x74\151\x6f\156\57\152\163\157\x6e", "\143\x68\141\162\x73\x65\x74\x3a\40\x55\124\x46\40\x2d\40\x38", "\101\x75\x74\150\157\162\151\172\141\x74\x69\x6f\156\72\x20\102\141\x73\x69\x63"));
        curl_setopt($Ka, CURLOPT_POST, TRUE);
        curl_setopt($Ka, CURLOPT_POSTFIELDS, $Ai);
        $ON = curl_exec($Ka);
        if (!curl_errno($Ka)) {
            goto Y_;
        }
        $zx = array("\x25\x6d\145\164\150\x6f\x64" => "\x63\150\145\x63\x6b\103\x75\163\x74\157\155\x65\x72", "\x25\x66\151\x6c\x65" => "\143\165\163\164\x6f\155\145\162\137\163\145\x74\x75\x70\56\160\x68\160", "\45\x65\162\x72\x6f\162" => curl_error($Ka));
        watchdog("\x6d\151\x6e\151\157\x72\x61\156\147\x65\137\157\x61\x75\164\150", "\105\162\162\157\162\x20\x61\164\40\x25\155\145\164\150\x6f\144\x20\x6f\x66\40\45\146\x69\154\145\72\x20\x25\x65\162\x72\157\x72", $zx);
        Y_:
        curl_close($Ka);
        return $ON;
    }
    public function getCustomerKeys()
    {
        if (Utilities::isCurlInstalled()) {
            goto Qb;
        }
        return json_encode(array("\141\x70\x69\x4b\x65\171" => "\103\125\x52\x4c\x5f\x45\122\122\117\122", "\x74\157\x6b\x65\x6e" => "\x3c\x61\x20\150\162\x65\x66\x3d\x22\150\164\x74\160\72\x2f\x2f\160\x68\x70\x2e\x6e\145\x74\x2f\x6d\x61\156\165\141\x6c\57\x65\156\x2f\x63\x75\162\x6c\x2e\x69\156\163\x74\141\154\x6c\x61\x74\x69\x6f\156\56\160\150\160\x22\x3e\x50\110\x50\40\143\x55\x52\x4c\40\145\170\x74\145\156\163\151\x6f\x6e\x3c\x2f\141\x3e\x20\x69\x73\40\156\157\164\x20\151\156\163\x74\141\154\x6c\x65\144\x20\x6f\162\x20\x64\151\163\x61\142\154\145\144\56"));
        Qb:
        $te = MiniorangeOAuthConstants::BASE_URL . "\57\x6d\x6f\x61\163\57\162\x65\x73\x74\x2f\x63\x75\x73\x74\x6f\x6d\145\x72\x2f\x6b\x65\171";
        $Ka = curl_init($te);
        $fw = $this->email;
        $lw = $this->password;
        $Dh = array("\x65\x6d\141\151\x6c" => $fw, "\160\x61\163\163\x77\x6f\x72\x64" => $lw);
        $Ai = json_encode($Dh);
        curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($Ka, CURLOPT_ENCODING, '');
        curl_setopt($Ka, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($Ka, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
        curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x43\x6f\x6e\x74\145\x6e\x74\55\124\171\x70\145\72\x20\x61\160\160\154\x69\x63\x61\164\151\157\x6e\x2f\152\163\x6f\x6e", "\x63\x68\141\162\x73\145\164\72\40\125\x54\106\x20\55\40\70", "\101\x75\x74\150\x6f\x72\x69\172\x61\x74\x69\x6f\x6e\x3a\40\x42\x61\x73\x69\143"));
        curl_setopt($Ka, CURLOPT_POST, TRUE);
        curl_setopt($Ka, CURLOPT_POSTFIELDS, $Ai);
        $ON = curl_exec($Ka);
        if (!curl_errno($Ka)) {
            goto XD;
        }
        $zx = array("\x25\155\145\x74\x68\157\x64" => "\x67\145\164\103\165\163\x74\x6f\155\x65\x72\x4b\x65\x79\x73", "\45\146\151\154\145" => "\x63\165\163\164\157\x6d\145\x72\x5f\x73\x65\x74\x75\160\x2e\x70\150\x70", "\45\145\162\x72\157\162" => curl_error($Ka));
        watchdog("\155\151\156\151\157\x72\141\156\x67\145\137\x6f\141\165\x74\150", "\x45\162\162\157\162\40\141\164\x20\x25\x6d\x65\x74\150\x6f\144\40\157\x66\x20\45\146\x69\154\x65\72\40\x25\x65\x72\162\157\x72", $zx);
        XD:
        curl_close($Ka);
        return $ON;
    }
    function verifyLicense($fd)
    {
        $te = MiniorangeOAuthConstants::BASE_URL . "\x2f\x6d\x6f\x61\x73\57\x61\160\x69\57\x62\x61\x63\x6b\165\x70\x63\x6f\144\145\57\x76\145\x72\x69\146\x79";
        $Ka = curl_init($te);
        $kX = variable_get("\x6d\x69\156\151\x6f\x72\x61\156\x67\x65\x5f\x6f\141\x75\x74\x68\x5f\x63\x6c\151\x65\x6e\164\x5f\x63\x75\x73\164\x6f\155\x65\x72\x5f\x69\x64");
        $LO = variable_get("\155\x69\156\151\157\162\141\156\147\x65\x5f\x6f\141\x75\x74\150\x5f\x63\x6c\x69\x65\156\164\137\x63\x75\x73\x74\157\155\x65\x72\137\x61\160\151\137\153\145\171");
        global $base_url;
        $ML = round(microtime(TRUE) * 1000);
        $wW = $kX . number_format($ML, 0, '', '') . $LO;
        $Fc = hash("\163\x68\x61\65\x31\x32", $wW);
        $GI = "\x43\165\x73\x74\x6f\x6d\x65\x72\55\113\145\171\72\x20" . $kX;
        $q_ = "\x54\151\155\145\163\164\x61\155\x70\72\40" . number_format($ML, 0, '', '');
        $qL = "\101\x75\164\x68\157\x72\x69\172\x61\164\x69\x6f\x6e\72\x20" . $Fc;
        $Dh = '';
        $Dh = array("\x63\x6f\x64\145" => $fd, "\x63\x75\163\164\157\155\145\x72\x4b\145\171" => $kX, "\x61\x64\x64\x69\x74\x69\157\x6e\x61\154\106\x69\145\x6c\144\x73" => array("\x66\x69\145\x6c\x64\61" => $base_url));
        $Ai = json_encode($Dh);
        curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($Ka, CURLOPT_ENCODING, '');
        curl_setopt($Ka, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Ka, CURLOPT_AUTOREFERER, true);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
        curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\103\157\156\164\145\x6e\164\55\x54\x79\x70\x65\72\40\x61\160\160\154\x69\143\141\x74\151\157\156\x2f\x6a\x73\157\x6e", $GI, $q_, $qL));
        curl_setopt($Ka, CURLOPT_POST, true);
        curl_setopt($Ka, CURLOPT_POSTFIELDS, $Ai);
        curl_setopt($Ka, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($Ka, CURLOPT_TIMEOUT, 20);
        $ON = curl_exec($Ka);
        if (!curl_errno($Ka)) {
            goto XJ;
        }
        echo "\x52\145\x71\165\x65\163\164\x20\x45\162\162\x6f\x72\72" . curl_error($Ka);
        exit;
        XJ:
        curl_close($Ka);
        return $ON;
    }
    function updateStatus()
    {
        $te = MiniorangeOAuthConstants::BASE_URL . "\57\x6d\157\x61\x73\x2f\x61\x70\151\57\x62\141\143\x6b\x75\160\x63\x6f\144\145\57\165\x70\x64\x61\164\145\x73\x74\141\x74\165\163";
        $Ka = curl_init($te);
        $kX = variable_get("\155\x69\156\151\157\162\x61\156\147\x65\137\157\141\165\164\150\x5f\x63\x6c\151\x65\x6e\164\x5f\143\x75\163\164\x6f\x6d\145\x72\x5f\151\144");
        $LO = variable_get("\x6d\x69\x6e\x69\x6f\x72\x61\x6e\147\x65\x5f\157\141\165\x74\150\x5f\x63\154\x69\x65\156\164\x5f\x63\165\163\164\x6f\x6d\x65\x72\x5f\x61\x70\151\x5f\153\145\x79");
        $ML = round(microtime(TRUE) * 1000);
        $wW = $kX . number_format($ML, 0, '', '') . $LO;
        $Fc = hash("\x73\150\141\65\x31\62", $wW);
        $GI = "\x43\165\163\164\x6f\155\x65\162\x2d\x4b\145\171\72\40" . $kX;
        $q_ = "\x54\151\x6d\145\x73\x74\x61\x6d\160\72\40" . number_format($ML, 0, '', '');
        $qL = "\101\x75\x74\150\157\x72\x69\x7a\x61\164\x69\x6f\x6e\x3a\40" . $Fc;
        $aZ = variable_get("\155\x69\x6e\151\157\x72\x61\x6e\x67\145\x5f\x6f\x61\165\164\x68\x5f\x63\154\x69\x65\x6e\164\137\x63\x75\163\x74\157\155\x65\x72\137\141\x64\155\x69\156\137\164\157\x6b\145\156");
        $fd = AESEncryption::decrypt_data(variable_get("\155\x69\x6e\x69\x6f\x72\141\156\x67\145\x5f\157\x61\x75\x74\x68\x5f\x63\154\x69\x65\156\x74\x5f\154\151\143\x65\x6e\x73\x65\137\x6b\145\171"), $aZ);
        $Dh = array("\143\157\x64\145" => $fd, "\143\x75\x73\164\157\155\145\162\113\x65\171" => $kX);
        $Ai = json_encode($Dh);
        curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($Ka, CURLOPT_ENCODING, '');
        curl_setopt($Ka, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Ka, CURLOPT_AUTOREFERER, true);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
        curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x43\157\x6e\164\x65\156\x74\x2d\x54\171\x70\x65\72\40\141\x70\x70\x6c\151\x63\x61\164\151\157\156\x2f\x6a\x73\x6f\x6e", $GI, $q_, $qL));
        curl_setopt($Ka, CURLOPT_POST, true);
        curl_setopt($Ka, CURLOPT_POSTFIELDS, $Ai);
        curl_setopt($Ka, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($Ka, CURLOPT_TIMEOUT, 20);
        $ON = curl_exec($Ka);
        if (!curl_errno($Ka)) {
            goto Bl;
        }
        echo "\122\145\x71\165\x65\x73\164\40\x45\x72\162\x6f\x72\x3a" . curl_error($Ka);
        exit;
        Bl:
        curl_close($Ka);
        return $ON;
    }
    function ccl()
    {
        $te = MiniorangeOAuthConstants::BASE_URL . "\x2f\155\x6f\x61\x73\x2f\x72\x65\163\164\57\x63\x75\163\x74\x6f\155\145\162\x2f\154\x69\143\x65\x6e\x73\145";
        $Ka = curl_init($te);
        $kX = variable_get("\x6d\x69\156\151\157\x72\141\x6e\147\145\x5f\x6f\141\x75\x74\x68\137\143\154\x69\145\x6e\164\137\x63\x75\163\x74\157\155\x65\x72\137\151\x64", '');
        $LO = variable_get("\x6d\x69\156\151\x6f\162\141\156\x67\145\137\157\141\x75\164\x68\137\x63\x6c\151\145\x6e\x74\137\x63\165\163\x74\157\155\145\162\x5f\x61\160\151\x5f\153\x65\x79", '');
        $ML = round(microtime(TRUE) * 1000);
        $wW = $kX . number_format($ML, 0, '', '') . $LO;
        $Fc = hash("\163\x68\141\x35\x31\62", $wW);
        $GI = "\x43\x75\163\x74\x6f\x6d\145\162\55\x4b\145\x79\x3a\40" . $kX;
        $q_ = "\124\151\x6d\145\x73\164\141\155\160\72\40" . number_format($ML, 0, '', '');
        $qL = "\x41\165\164\150\x6f\162\151\x7a\x61\x74\151\157\156\x3a\x20" . $Fc;
        $Dh = '';
        $Dh = array("\143\x75\x73\164\x6f\155\145\x72\x49\x64" => $kX, "\x61\x70\160\154\x69\143\x61\x74\151\157\156\x4e\141\155\x65" => "\x64\162\165\160\141\154\137\x6f\x61\165\x74\150\x5f\x63\154\x69\x65\156\x74\x5f\145\156\x74\x65\162\160\162\151\x73\145\x5f\x70\154\141\x6e");
        $Ai = json_encode($Dh);
        curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($Ka, CURLOPT_ENCODING, '');
        curl_setopt($Ka, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Ka, CURLOPT_AUTOREFERER, true);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
        curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x43\157\x6e\164\x65\156\x74\x2d\x54\x79\x70\145\72\x20\x61\x70\x70\x6c\x69\143\x61\164\151\x6f\x6e\57\x6a\163\157\156", $GI, $q_, $qL));
        curl_setopt($Ka, CURLOPT_POST, true);
        curl_setopt($Ka, CURLOPT_POSTFIELDS, $Ai);
        curl_setopt($Ka, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($Ka, CURLOPT_TIMEOUT, 20);
        $ON = curl_exec($Ka);
        if (!curl_errno($Ka)) {
            goto ON;
        }
        return null;
        ON:
        curl_close($Ka);
        return $ON;
    }
}
