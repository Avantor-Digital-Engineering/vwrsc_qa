<?php


function mo_oauth_client_initiateLogin()
{
    $Qs = variable_get("\155\x69\156\x69\x6f\162\141\156\147\145\137\x6f\x61\165\164\x68\x5f\143\154\x69\x65\x6e\x74\x5f\x75\x70\x67\162\141\144\145\137\165\162\x6c");
    if (!(is_null($Qs) || empty($Qs) || strpos($Qs, "\57\155\x6f\x61\x73\x2f\x61\160\151\57\x70\154\x75\147\151\156\x2f\144\x72\x75\160\141\x6c\112\157\157\x6d\154\141\125\160\x64\x61\x74\145\57") === FALSE)) {
        goto jj;
    }
    $Bo = MiniorangeOAuthConstants::BASE_URL;
    $jL = "\144\162\x75\x70\x61\154\x5f\157\141\165\164\150\x5f\143\x6c\151\145\156\164\x5f\145\156\164\145\162\160\162\151\163\x65\x5f\x70\154\141\x6e";
    $jG = "\x44\x52\125\x50\101\114\x5f\x4f\101\x55\124\110\137\x43\114\x49\105\x4e\x54\x5f\x45\116\x54\x45\x52\120\122\111\x53\105\137\115\117\104\x55\114\x45";
    $NQ = variable_get("\155\x69\x6e\x69\157\x72\x61\x6e\147\145\x5f\x6f\141\165\164\x68\x5f\143\x6c\151\145\156\x74\137\x63\x75\x73\164\157\x6d\x65\x72\137\x69\x64");
    $LO = variable_get("\155\151\x6e\151\157\x72\141\156\x67\145\x5f\x6f\141\165\164\x68\137\143\x6c\151\x65\156\x74\x5f\x63\165\163\x74\x6f\155\145\162\137\x61\x70\x69\x5f\153\x65\x79");
    $aZ = variable_get("\155\151\x6e\151\x6f\162\x61\x6e\x67\145\x5f\x6f\x61\x75\x74\150\x5f\x63\x6c\151\145\x6e\x74\x5f\x63\x75\163\x74\157\155\x65\162\137\x61\x64\155\x69\156\137\164\x6f\153\145\x6e");
    $fd = AESEncryption::decrypt_data(variable_get("\155\x69\156\x69\x6f\162\x61\x6e\147\x65\x5f\157\x61\165\164\150\137\143\x6c\x69\x65\156\x74\137\154\151\143\145\156\x73\145\137\153\x65\x79"), $aZ);
    $Qs = Utilities::createUpdateUrl($fd, $jL, $jG, $LO, $NQ, $Bo);
    variable_set("\x6d\x69\156\x69\x6f\x72\x61\x6e\147\145\x5f\157\141\165\164\150\137\x63\154\x69\145\156\164\x5f\x75\x70\147\162\x61\x64\x65\x5f\x75\x72\154", $Qs);
    jj:
    $_SESSION["\x6e\x61\166\x69\147\x61\x74\151\157\x6e\x5f\165\x72\x6c"] = $_SERVER["\x48\x54\124\x50\137\122\105\106\105\122\105\x52"];
    variable_set("\155\151\x6e\151\157\162\141\156\147\x65\x5f\157\141\x75\x74\150\137\143\x6c\x69\x65\x6e\x74\137\162\145\x64", $_SERVER["\110\x54\x54\120\137\x52\x45\x46\105\x52\105\x52"]);
    $kx = variable_get("\x6d\x69\x6e\x69\157\x72\141\156\147\145\137\141\x75\164\150\x5f\143\154\x69\x65\156\164\x5f\x61\160\x70\137\156\141\x6d\x65", '');
    $tg = variable_get("\x6d\151\156\151\157\x72\141\x6e\147\x65\x5f\141\165\x74\x68\x5f\x63\x6c\151\x65\156\x74\x5f\x63\x6c\151\x65\156\164\137\151\x64", '');
    $R6 = variable_get("\155\151\156\x69\x6f\162\x61\x6e\x67\x65\x5f\141\165\x74\x68\137\143\x6c\x69\x65\156\164\x5f\143\x6c\x69\145\x6e\x74\x5f\163\x65\143\x72\x65\164", '');
    $aW = variable_get("\155\151\x6e\x69\x6f\x72\141\156\147\x65\137\x61\165\164\x68\137\143\x6c\x69\145\x6e\x74\137\163\x63\157\160\145", '');
    $RK = variable_get("\x6d\151\156\151\x6f\x72\x61\156\x67\145\137\141\165\164\x68\x5f\143\154\x69\145\x6e\x74\x5f\141\x75\x74\x68\x6f\x72\151\172\145\137\145\156\144\x70\157\x69\156\x74", '');
    $jW = variable_get("\155\151\x6e\x69\x6f\162\x61\x6e\x67\145\x5f\157\141\165\x74\150\137\x63\x61\x6c\154\142\x61\143\153", '');
    $Vs = base64_encode($kx);
    $RK = $RK . "\x3f\143\x6c\x69\145\156\164\137\x69\x64\75" . $tg . "\46\163\143\x6f\x70\x65\x3d" . $aW . "\46\162\x65\144\151\162\145\143\164\137\x75\x72\151\75" . $jW . "\46\162\x65\x73\160\x6f\x6e\163\145\137\x74\x79\x70\145\75\143\x6f\144\x65\x26\x73\x74\141\x74\145\x3d" . $Vs;
    $_SESSION["\157\x61\x75\x74\150\62\163\x74\x61\164\145"] = $Vs;
    $_SESSION["\141\x70\160\156\x61\155\145"] = $kx;
    header("\x4c\x6f\143\x61\164\151\157\x6e\x3a\x20" . $RK);
    drupal_goto($RK);
}
function mo_oauth_client_logout()
{
    $S1 = variable_get("\x6d\151\x6e\151\157\x72\141\156\x67\145\x5f\x6f\141\165\x74\x68\x5f\143\x6c\151\x65\x6e\164\137\141\x75\164\x6f\137\162\x65\x64\151\x72\x65\x63\164\x5f\164\157\x5f\151\x64\160", false);
    $Y7 = variable_get("\x6d\151\x6e\151\157\x72\x61\x6e\x67\x65\137\x6f\x61\165\x74\x68\x5f\143\154\x69\x65\156\164\x5f\x66\x6f\162\143\x65\137\x61\165\164\150", false);
    $Or = variable_get("\x6d\151\156\151\157\x72\141\x6e\147\145\x5f\157\x61\165\x74\x68\x5f\143\154\151\145\156\x74\137\x6c\157\147\x6f\165\164\137\x75\x72\x6c", '');
    if (!($Or != '')) {
        goto Dh;
    }
    session_destroy();
    drupal_goto($Or);
    Dh:
}
function getAccessToken($Iq, $aK, $pG, $RZ, $fd, $fn, $Bm, $qR)
{
    $Ka = curl_init($Iq);
    curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($Ka, CURLOPT_ENCODING, '');
    curl_setopt($Ka, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($Ka, CURLOPT_AUTOREFERER, true);
    curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
    curl_setopt($Ka, CURLOPT_POST, true);
    if ($Bm && !$qR) {
        goto Ky;
    }
    if (!$Bm && $qR) {
        goto My;
    }
    curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x41\165\164\150\x6f\x72\151\x7a\141\x74\151\157\x6e" => "\102\x61\163\151\143\40" . base64_encode($pG . "\72" . $RZ), "\x41\143\x63\145\160\x74\72\x20\141\160\x70\154\x69\x63\141\x74\x69\157\156\x2f\152\163\157\x6e"));
    curl_setopt($Ka, CURLOPT_POSTFIELDS, "\162\x65\x64\151\162\145\143\164\137\165\162\x69\x3d" . urlencode($fn) . "\46\x67\x72\x61\x6e\x74\137\164\x79\160\145\75" . $aK . "\x26\x63\x6c\x69\x65\156\164\x5f\x69\144\x3d" . $pG . "\x26\x63\x6c\x69\145\x6e\x74\137\x73\x65\x63\162\x65\x74\75" . $RZ . "\x26\143\x6f\x64\145\75" . $fd);
    goto FG;
    My:
    curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x41\x63\143\145\160\x74\72\40\141\x70\160\x6c\x69\x63\x61\x74\x69\157\156\x2f\152\x73\x6f\x6e"));
    curl_setopt($Ka, CURLOPT_POSTFIELDS, "\x72\x65\x64\x69\x72\x65\143\164\137\165\x72\x69\x3d" . urlencode($fn) . "\46\x67\162\141\156\x74\137\164\171\160\x65\75" . $aK . "\46\143\x6c\151\145\156\x74\137\151\x64\x3d" . $pG . "\x26\x63\154\x69\145\156\164\x5f\x73\145\143\x72\145\x74\75" . $RZ . "\x26\143\x6f\x64\x65\x3d" . $fd);
    FG:
    goto xl;
    Ky:
    curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\101\165\164\x68\157\x72\x69\x7a\141\x74\151\x6f\156" => "\x42\x61\163\x69\x63\40" . base64_encode($pG . "\72" . $RZ), "\101\x63\x63\x65\160\164\72\40\x61\x70\160\x6c\x69\x63\141\x74\x69\157\156\x2f\152\x73\157\156"));
    curl_setopt($Ka, CURLOPT_POSTFIELDS, "\162\x65\x64\151\162\145\x63\x74\137\165\162\151\75" . urlencode($fn) . "\x26\147\162\141\156\164\137\x74\x79\x70\145\x3d" . $aK . "\x26\143\157\144\145\75" . $fd);
    xl:
    $ON = curl_exec($Ka);
    if (!curl_error($Ka)) {
        goto Xo;
    }
    echo "\74\142\76\x52\x65\163\160\x6f\x6e\x73\x65\40\x3a\x20\x3c\57\x62\76\x3c\142\162\x3e";
    print_r($ON);
    echo "\74\x62\162\76\74\x62\x72\x3e";
    exit(curl_error($Ka));
    Xo:
    if (is_array(json_decode($ON, true))) {
        goto Li;
    }
    echo "\74\x62\x3e\122\x65\x73\160\157\x6e\x73\145\x20\x3a\40\x3c\57\x62\76\74\x62\x72\76";
    print_r($ON);
    echo "\74\142\162\76\74\x62\162\76";
    exit("\111\x6e\166\141\154\151\144\x20\162\x65\163\160\x6f\156\x73\x65\x20\162\x65\x63\145\x69\166\x65\144\56");
    Li:
    $ON = json_decode($ON, true);
    if (isset($ON["\x65\162\x72\x6f\x72\137\144\145\163\143\162\151\x70\164\x69\x6f\x6e"])) {
        goto h2;
    }
    if (isset($ON["\x65\x72\162\x6f\x72"])) {
        goto rL;
    }
    if (isset($ON["\141\143\x63\x65\163\x73\x5f\164\157\x6b\x65\156"])) {
        goto t1;
    }
    echo "\74\x62\76\122\x65\163\160\x6f\x6e\x73\x65\x20\72\x20\x3c\x2f\142\x3e\x3c\142\x72\76";
    print_r($ON);
    echo "\x3c\x62\x72\x3e\x3c\142\x72\76";
    exit("\111\x6e\x76\x61\154\151\x64\40\x72\145\x73\160\x6f\x6e\163\145\x20\x72\145\143\x65\151\x76\145\x64\40\146\162\x6f\x6d\x20\117\101\165\x74\x68\x20\x50\x72\157\166\x69\144\145\162\x2e\x20\103\157\x6e\x74\141\x63\x74\40\171\157\165\x72\40\141\144\155\151\156\x69\163\x74\162\141\x74\157\162\40\146\x6f\162\40\x6d\x6f\162\145\40\144\x65\164\141\x69\154\163\56");
    goto Ox;
    t1:
    $mw = $ON["\x61\x63\143\145\x73\x73\137\x74\x6f\x6b\x65\x6e"];
    Ox:
    goto IM;
    rL:
    exit($ON["\145\162\162\x6f\x72"]);
    IM:
    goto Hm;
    h2:
    exit($ON["\145\162\162\157\x72\137\x64\145\163\143\162\151\x70\164\151\157\x6e"]);
    Hm:
    return $mw;
}
function getResourceOwner($Bj, $mw)
{
    $Ka = curl_init($Bj);
    curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($Ka, CURLOPT_ENCODING, '');
    curl_setopt($Ka, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($Ka, CURLOPT_AUTOREFERER, true);
    curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
    curl_setopt($Ka, CURLOPT_POST, false);
    curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x41\x75\x74\150\x6f\x72\151\172\141\x74\x69\x6f\x6e\72\x20\102\x65\141\x72\145\162\x20" . $mw));
    $b3 = curl_version();
    curl_setopt($Ka, CURLOPT_USERAGENT, "\x63\x75\x72\x6c\x2f" . $b3["\166\145\x72\x73\151\157\x6e"]);
    $ON = curl_exec($Ka);
    if (!curl_error($Ka)) {
        goto O8;
    }
    echo "\74\142\76\122\x65\x73\160\x6f\x6e\x73\145\40\x3a\x20\74\x2f\x62\76\x3c\142\162\76";
    print_r($ON);
    echo "\x3c\x62\x72\x3e\x3c\x62\162\x3e";
    exit(curl_error($Ka));
    O8:
    if (is_array(json_decode($ON, true))) {
        goto ds;
    }
    echo "\x3c\142\x3e\122\x65\163\160\157\156\x73\x65\40\72\x20\74\57\142\x3e\x3c\x62\162\76";
    print_r($ON);
    echo "\74\142\162\76\74\142\162\x3e";
    exit("\111\x6e\166\141\x6c\x69\x64\x20\162\145\x73\160\x6f\156\x73\x65\x20\x72\145\x63\145\x69\x76\145\x64\56");
    ds:
    $ON = json_decode($ON, true);
    if (isset($ON["\145\162\162\157\x72\137\x64\x65\x73\143\162\151\160\164\x69\157\156"])) {
        goto Pl;
    }
    if (!isset($ON["\145\162\x72\157\162"])) {
        goto uJ;
    }
    if (is_array($ON["\x65\x72\162\157\162"])) {
        goto V3;
    }
    echo $ON["\145\x72\x72\x6f\162"];
    goto mg;
    V3:
    print_r($ON["\145\x72\162\x6f\x72"]);
    mg:
    exit;
    uJ:
    goto u4;
    Pl:
    if (is_array($ON["\145\162\x72\x6f\162\x5f\x64\x65\163\143\162\151\x70\164\x69\157\156"])) {
        goto bd;
    }
    echo $ON["\145\x72\162\157\x72\x5f\144\145\163\x63\x72\151\x70\164\151\x6f\x6e"];
    goto i3;
    bd:
    print_r($ON["\x65\162\162\157\162\137\144\x65\163\x63\162\x69\160\164\x69\x6f\156"]);
    i3:
    exit;
    u4:
    return $ON;
}
function getToken($Iq, $aK, $pG, $RZ, $fd, $fn, $Bm, $qR)
{
    $Ka = curl_init($Iq);
    curl_setopt($Ka, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($Ka, CURLOPT_ENCODING, '');
    curl_setopt($Ka, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($Ka, CURLOPT_AUTOREFERER, true);
    curl_setopt($Ka, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($Ka, CURLOPT_MAXREDIRS, 10);
    curl_setopt($Ka, CURLOPT_POST, true);
    if ($Bm && !$qR) {
        goto Vv;
    }
    if (!$Bm && $qR) {
        goto d7;
    }
    curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\101\x75\x74\x68\157\x72\x69\x7a\141\164\151\157\156" => "\x42\141\163\x69\143\40" . base64_encode($pG . "\72" . $RZ), "\101\143\x63\x65\160\x74\72\40\141\x70\160\154\x69\143\141\164\151\x6f\x6e\x2f\152\x73\157\x6e"));
    curl_setopt($Ka, CURLOPT_POSTFIELDS, "\162\x65\x64\151\x72\145\x63\164\x5f\165\x72\151\75" . urlencode($fn) . "\46\x67\x72\x61\x6e\x74\x5f\x74\171\x70\145\75" . $aK . "\x26\143\x6c\x69\x65\156\164\x5f\x69\x64\x3d" . $pG . "\x26\143\x6c\x69\x65\x6e\x74\x5f\x73\145\143\162\x65\x74\x3d" . $RZ . "\46\143\x6f\144\145\x3d" . $fd);
    goto Ai;
    d7:
    curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x41\143\143\145\160\164\x3a\40\x61\160\x70\154\x69\x63\x61\164\x69\157\156\57\x6a\x73\157\x6e"));
    curl_setopt($Ka, CURLOPT_POSTFIELDS, "\162\x65\x64\x69\x72\x65\143\164\x5f\165\x72\151\75" . urlencode($fn) . "\46\147\x72\x61\156\x74\137\x74\171\x70\145\x3d" . $aK . "\x26\x63\x6c\x69\145\156\x74\137\x69\x64\x3d" . $pG . "\46\143\154\151\145\x6e\x74\137\x73\x65\x63\x72\x65\x74\x3d" . $RZ . "\46\x63\x6f\x64\145\75" . $fd);
    Ai:
    goto FA;
    Vv:
    curl_setopt($Ka, CURLOPT_HTTPHEADER, array("\x41\165\164\150\x6f\x72\x69\x7a\x61\164\151\157\x6e" => "\102\x61\163\x69\143\40" . base64_encode($pG . "\72" . $RZ), "\101\143\x63\x65\x70\164\x3a\40\141\160\x70\x6c\x69\x63\141\x74\x69\157\156\57\x6a\163\157\x6e"));
    curl_setopt($Ka, CURLOPT_POSTFIELDS, "\x72\145\144\x69\x72\145\143\x74\137\165\x72\151\75" . urlencode($fn) . "\46\147\162\141\156\x74\x5f\x74\171\x70\145\75" . $aK . "\46\143\x6f\144\145\x3d" . $fd);
    FA:
    $ka = curl_exec($Ka);
    if (!curl_error($Ka)) {
        goto GL;
    }
    print_r($ka);
    exit(curl_error($Ka));
    GL:
    if (is_array(json_decode($ka, true))) {
        goto RX;
    }
    print_r($ka);
    exit("\111\156\166\141\x6c\151\x64\x20\162\145\163\x70\x6f\156\x73\x65\40\x72\x65\x63\145\151\x76\145\x64\40\x67\x65\x74\x74\x69\x6e\147\x20\141\143\x63\x65\x73\163\137\164\157\153\x65\156\x20\x66\x72\157\155\40\x75\162\154\x20" . $Iq);
    RX:
    $ON = json_decode($ka, true);
    if (isset($ON["\x65\162\x72\x6f\162\137\144\x65\x73\143\162\x69\x70\x74\151\157\x6e"])) {
        goto U0;
    }
    if (!isset($ON["\x65\162\162\157\x72"])) {
        goto RB;
    }
    print_r($ka);
    exit($ON["\145\162\162\x6f\162"]);
    RB:
    goto yl;
    U0:
    print_r($ka);
    exit($ON["\x65\162\x72\157\x72\x5f\144\145\163\x63\162\x69\160\164\x69\157\156"]);
    yl:
    return $ka;
}
function getIdToken($Iq, $aK, $pG, $RZ, $fd, $fn, $Bm, $qR)
{
    $ka = getToken($Iq, $aK, $pG, $RZ, $fd, $fn, $Bm, $qR);
    $ON = json_decode($ka, true);
    if (isset($ON["\151\144\137\x74\x6f\x6b\145\156"])) {
        goto Tm;
    }
    echo "\x49\156\166\141\x6c\151\x64\40\162\145\x73\160\157\156\x73\145\x20\x72\145\143\145\151\x76\x65\x64\x20\x66\x72\157\155\40\x4f\x70\x65\x6e\111\x64\x20\x50\x72\157\166\x69\x64\x65\x72\x2e\x20\103\157\156\164\141\143\x74\x20\171\157\165\x72\x20\141\144\x6d\151\156\151\163\x74\162\x61\x74\x6f\162\40\146\157\x72\40\155\x6f\162\145\40\144\145\x74\141\x69\154\x73\x2e\x3c\142\162\x3e\74\x62\x72\x3e\74\142\x3e\x52\x65\x73\x70\157\156\x73\145\x20\x3a\40\74\57\x62\76\x3c\x62\x72\76" . $ka;
    exit;
    goto AX;
    Tm:
    return $ON;
    AX:
}
function getResourceOwnerFromIdToken($w4)
{
    $R7 = explode("\56", $w4);
    if (!isset($R7[1])) {
        goto b7;
    }
    $fR = base64_decode($R7[1]);
    if (!is_array(json_decode($fR, true))) {
        goto Nq;
    }
    return json_decode($fR, true);
    Nq:
    b7:
    echo "\x49\156\x76\x61\154\151\x64\40\162\x65\x73\x70\x6f\x6e\x73\145\40\162\145\143\x65\151\166\145\x64\x2e\74\142\x72\x3e\74\x62\x3e\x49\144\x5f\164\x6f\153\145\156\x20\72\x20\x3c\x2f\142\76" . $w4;
    exit;
}
