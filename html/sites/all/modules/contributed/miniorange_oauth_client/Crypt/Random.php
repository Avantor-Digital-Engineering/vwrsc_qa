<?php


if (!function_exists("\x63\x72\x79\160\x74\137\x72\141\156\144\x6f\x6d\x5f\x73\164\162\151\156\x67")) {
    define("\x43\x52\131\x50\x54\x5f\122\101\x4e\104\117\x4d\x5f\x49\123\x5f\x57\x49\116\104\117\127\123", strtoupper(substr(PHP_OS, 0, 3)) === "\127\x49\116");
    function crypt_random_string($gM)
    {
        if ($gM) {
            goto In;
        }
        return '';
        In:
        if (CRYPT_RANDOM_IS_WINDOWS) {
            goto Fz;
        }
        if (!(extension_loaded("\157\160\x65\x6e\x73\x73\154") && version_compare(PHP_VERSION, "\x35\56\63\x2e\60", "\x3e\x3d"))) {
            goto iz;
        }
        return openssl_random_pseudo_bytes($gM);
        iz:
        static $VO = true;
        if (!($VO === true)) {
            goto D0;
        }
        $VO = @fopen("\x2f\x64\x65\166\x2f\x75\x72\x61\156\x64\x6f\155", "\162\x62");
        D0:
        if (!($VO !== true && $VO !== false)) {
            goto NU;
        }
        return fread($VO, $gM);
        NU:
        if (!extension_loaded("\155\x63\162\x79\160\164")) {
            goto NF;
        }
        NF:
        goto mI;
        Fz:
        if (!(extension_loaded("\155\x63\162\171\x70\x74") && version_compare(PHP_VERSION, "\x35\x2e\63\x2e\60", "\76\x3d"))) {
            goto EC;
        }
        EC:
        if (!(extension_loaded("\x6f\x70\145\156\x73\163\154") && version_compare(PHP_VERSION, "\65\x2e\x33\x2e\x34", "\76\x3d"))) {
            goto Mj;
        }
        return openssl_random_pseudo_bytes($gM);
        Mj:
        mI:
        static $dc = false, $Bh;
        if (!($dc === false)) {
            goto W6;
        }
        $J8 = session_id();
        $Df = ini_get("\x73\145\163\x73\151\x6f\x6e\56\165\x73\145\x5f\x63\157\157\153\151\145\x73");
        $ME = session_cache_limiter();
        $hF = isset($_SESSION) ? $_SESSION : false;
        if (!($J8 != '')) {
            goto U2;
        }
        session_write_close();
        U2:
        session_id(1);
        ini_set("\163\x65\163\163\151\157\x6e\x2e\165\x73\145\137\x63\157\x6f\x6b\x69\145\163", 0);
        session_cache_limiter('');
        session_start();
        $Bh = $OM = $_SESSION["\x73\145\145\x64"] = pack("\110\52", sha1((isset($_SERVER) ? phpseclib_safe_serialize($_SERVER) : '') . (isset($_POST) ? phpseclib_safe_serialize($_POST) : '') . (isset($_GET) ? phpseclib_safe_serialize($_GET) : '') . (isset($_COOKIE) ? phpseclib_safe_serialize($_COOKIE) : '') . phpseclib_safe_serialize($GLOBALS) . phpseclib_safe_serialize($_SESSION) . phpseclib_safe_serialize($hF)));
        if (isset($_SESSION["\x63\x6f\165\156\x74"])) {
            goto ad;
        }
        $_SESSION["\x63\x6f\165\156\x74"] = 0;
        ad:
        $_SESSION["\x63\157\x75\x6e\x74"]++;
        session_write_close();
        if ($J8 != '') {
            goto zq;
        }
        if ($hF !== false) {
            goto Cc;
        }
        unset($_SESSION);
        goto sd;
        Cc:
        $_SESSION = $hF;
        unset($hF);
        sd:
        goto FY;
        zq:
        session_id($J8);
        session_start();
        ini_set("\163\x65\163\x73\151\157\156\x2e\x75\163\145\x5f\x63\x6f\157\153\x69\x65\163", $Df);
        session_cache_limiter($ME);
        FY:
        $aZ = pack("\110\x2a", sha1($OM . "\101"));
        $ZE = pack("\x48\52", sha1($OM . "\103"));
        switch (true) {
            case phpseclib_resolve_include_path("\x43\x72\x79\160\164\57\x41\x45\123\56\x70\x68\160"):
                if (class_exists("\x43\162\x79\160\164\x5f\x41\x45\x53")) {
                    goto Uf;
                }
                include_once "\x41\105\123\x2e\160\150\160";
                Uf:
                $dc = new Crypt_AES(CRYPT_AES_MODE_CTR);
                goto UP;
            case phpseclib_resolve_include_path("\103\x72\171\160\164\57\124\167\x6f\x66\151\x73\150\56\160\x68\x70"):
                if (class_exists("\x43\162\171\x70\x74\137\x54\167\157\146\151\x73\x68")) {
                    goto lV;
                }
                include_once "\x54\x77\157\x66\151\163\x68\x2e\160\150\x70";
                lV:
                $dc = new Crypt_Twofish(CRYPT_TWOFISH_MODE_CTR);
                goto UP;
            case phpseclib_resolve_include_path("\x43\x72\171\160\164\x2f\102\154\x6f\x77\146\x69\x73\150\56\x70\x68\160"):
                if (class_exists("\103\162\171\160\x74\137\102\x6c\x6f\167\x66\151\163\x68")) {
                    goto tC;
                }
                include_once "\102\x6c\x6f\x77\146\x69\163\x68\x2e\x70\x68\x70";
                tC:
                $dc = new Crypt_Blowfish(CRYPT_BLOWFISH_MODE_CTR);
                goto UP;
            case phpseclib_resolve_include_path("\103\162\x79\x70\164\57\124\x72\x69\160\x6c\145\x44\x45\x53\x2e\160\x68\160"):
                if (class_exists("\x43\x72\171\x70\x74\x5f\124\162\x69\160\x6c\145\x44\x45\123")) {
                    goto T1;
                }
                include_once "\x54\x72\151\160\154\145\104\x45\x53\x2e\x70\150\x70";
                T1:
                $dc = new Crypt_TripleDES(CRYPT_DES_MODE_CTR);
                goto UP;
            case phpseclib_resolve_include_path("\x43\x72\x79\x70\164\57\x44\x45\123\56\160\x68\x70"):
                if (class_exists("\103\162\x79\x70\x74\x5f\104\x45\x53")) {
                    goto TM;
                }
                include_once "\104\105\123\x2e\x70\150\160";
                TM:
                $dc = new Crypt_DES(CRYPT_DES_MODE_CTR);
                goto UP;
            case phpseclib_resolve_include_path("\x43\162\x79\x70\164\57\122\x43\x34\x2e\x70\150\x70"):
                if (class_exists("\103\162\x79\x70\x74\137\x52\x43\64")) {
                    goto ic;
                }
                include_once "\x52\103\x34\x2e\160\150\x70";
                ic:
                $dc = new Crypt_RC4();
                goto UP;
            default:
                user_error("\x63\x72\x79\160\x74\137\162\141\x6e\144\157\x6d\x5f\x73\x74\162\x69\x6e\x67\x20\162\145\161\165\x69\x72\x65\163\40\x61\164\x20\x6c\x65\141\x73\x74\40\x6f\156\x65\x20\163\171\x6d\155\x65\x74\162\x69\x63\40\143\151\x70\150\145\x72\40\x62\x65\40\x6c\157\x61\144\145\144");
                return false;
        }
        Aa:
        UP:
        $dc->setKey($aZ);
        $dc->setIV($ZE);
        $dc->enableContinuousBuffer();
        W6:
        $Mn = '';
        NI:
        if (!(strlen($Mn) < $gM)) {
            goto iG;
        }
        $Bi = $dc->encrypt(microtime());
        $Xg = $dc->encrypt($Bi ^ $Bh);
        $Bh = $dc->encrypt($Xg ^ $Bi);
        $Mn .= $Xg;
        goto NI;
        iG:
        return substr($Mn, 0, $gM);
    }
}
if (!function_exists("\x70\x68\160\163\145\x63\x6c\151\x62\x5f\x73\x61\146\x65\x5f\163\x65\162\x69\x61\x6c\151\172\x65")) {
    function phpseclib_safe_serialize(&$G_)
    {
        if (!is_object($G_)) {
            goto zE;
        }
        return '';
        zE:
        if (is_array($G_)) {
            goto mU;
        }
        return serialize($G_);
        mU:
        if (!isset($G_["\137\137\x70\150\160\163\145\x63\154\151\x62\137\155\141\x72\153\145\x72"])) {
            goto KO;
        }
        return '';
        KO:
        $l8 = array();
        $G_["\137\137\x70\x68\160\x73\145\x63\x6c\x69\x62\x5f\x6d\141\x72\153\x65\x72"] = true;
        foreach (array_keys($G_) as $aZ) {
            if (!($aZ !== "\137\137\x70\x68\x70\163\145\x63\154\x69\142\137\155\141\162\153\x65\x72")) {
                goto Es;
            }
            $l8[$aZ] = phpseclib_safe_serialize($G_[$aZ]);
            Es:
            et:
        }
        Wv:
        unset($G_["\x5f\x5f\160\150\160\163\145\143\154\151\142\137\155\141\162\153\x65\x72"]);
        return serialize($l8);
    }
}
if (!function_exists("\160\x68\x70\x73\145\143\x6c\x69\x62\137\162\145\x73\x6f\x6c\166\x65\x5f\151\156\x63\154\165\x64\145\137\x70\141\164\150")) {
    function phpseclib_resolve_include_path($Qb)
    {
        if (!function_exists("\163\x74\x72\145\x61\x6d\x5f\162\145\163\157\154\x76\145\137\x69\156\143\x6c\165\x64\145\x5f\x70\141\x74\150")) {
            goto VT;
        }
        return stream_resolve_include_path($Qb);
        VT:
        if (!file_exists($Qb)) {
            goto MB;
        }
        return realpath($Qb);
        MB:
        $p8 = PATH_SEPARATOR == "\x3a" ? preg_split("\43\x28\77\74\x21\x70\x68\141\x72\x29\72\x23", get_include_path()) : explode(PATH_SEPARATOR, get_include_path());
        foreach ($p8 as $su) {
            $JX = substr($su, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
            $al = $su . $JX . $Qb;
            if (!file_exists($al)) {
                goto PI;
            }
            return realpath($al);
            PI:
            Uu:
        }
        Dr:
        return false;
    }
}
