<?php


class MiniOrange_oauth_support
{
    public $email;
    public $phone;
    public $query;
    public function __construct($fw, $aE, $o3)
    {
        $this->email = $fw;
        $this->phone = $aE;
        $this->query = $o3;
    }
    public function sendSupportQuery()
    {
        $this->query = "\x5b\104\x72\x75\160\x61\154\x2d\x37\40\x4f\101\165\x74\150\40\103\x6c\x69\145\x6e\x74\x20\105\156\x74\145\x72\x70\x72\151\x73\x65\x20\x4d\157\144\165\x6c\145\135\x20" . $this->query;
        $Dh = array("\x63\157\x6d\x70\141\x6e\x79" => $_SERVER["\123\105\x52\x56\105\x52\137\x4e\101\115\105"], "\x65\155\x61\x69\x6c" => $this->email, "\143\143\105\x6d\141\151\154" => "\x64\x72\x75\160\x61\154\x73\x75\x70\x70\157\162\x74\100\x78\x65\x63\165\162\151\x66\x79\x2e\x63\157\x6d", "\x70\150\157\156\145" => $this->phone, "\161\165\x65\x72\171" => $this->query, "\x73\165\142\152\145\143\x74" => "\x44\162\x75\160\141\x6c\x2d\x37\x20\117\x41\x75\164\x68\x20\x43\154\151\x65\156\x74\x20\105\156\x74\145\162\x70\162\151\163\x65\x20\121\x75\x65\x72\x79");
        $Ai = json_encode($Dh);
        $te = "\x68\x74\164\160\163\x3a\x2f\x2f\154\157\147\151\156\x2e\x78\145\143\165\162\151\146\171\56\x63\157\x6d\57\155\x6f\141\163\57\x72\145\x73\x74\x2f\x63\x75\163\x74\x6f\x6d\145\x72\x2f\143\157\x6e\164\x61\x63\x74\x2d\x75\x73";
        $Ka = curl_init($te);
        curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($Ka, CURLOPT_ENCODING, '');
        curl_setopt($Ka, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($Ka, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
        curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\103\157\x6e\164\x65\x6e\x74\x2d\124\171\x70\x65\72\40\141\x70\x70\154\x69\x63\141\164\151\157\x6e\x2f\x6a\163\157\x6e", "\x63\150\x61\162\163\x65\164\72\40\125\x54\106\x2d\x38", "\x41\165\164\150\157\162\151\172\141\x74\151\157\156\72\x20\x42\141\163\151\143"));
        curl_setopt($Ka, CURLOPT_POST, TRUE);
        curl_setopt($Ka, CURLOPT_POSTFIELDS, $Ai);
        $ON = curl_exec($Ka);
        if (!curl_errno($Ka)) {
            goto i7;
        }
        $zx = array("\x25\155\x65\164\150\x6f\144" => "\163\x65\156\x64\123\165\160\160\157\162\x74\121\165\145\162\x79", "\45\x66\151\154\145" => "\155\151\156\151\157\x72\x61\156\x67\x65\137\117\x41\165\x74\150\137\163\x75\160\x70\157\162\164\56\160\150\x70", "\45\145\x72\x72\157\x72" => curl_error($Ka));
        watchdog("\x6d\x69\156\151\157\x72\x61\156\147\145\x5f\117\x41\x75\x74\x68", "\143\x55\122\x4c\40\105\162\162\157\162\x20\x61\x74\40\45\155\x65\164\x68\x6f\x64\40\x6f\146\x20\x25\x66\x69\154\145\x3a\40\45\145\162\x72\157\162", $zx);
        return FALSE;
        i7:
        curl_close($Ka);
        return TRUE;
    }
}
