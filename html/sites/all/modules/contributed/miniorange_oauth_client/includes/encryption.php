<?php


class AESEncryption
{
    public static function encrypt_data($D9, $aZ)
    {
        $aZ = openssl_digest($aZ, "\163\150\141\62\x35\x36");
        $Vy = "\101\105\123\55\61\62\70\55\103\102\x43";
        $yz = openssl_cipher_iv_length($Vy);
        $ZE = openssl_random_pseudo_bytes($yz);
        $DN = openssl_encrypt($D9, $Vy, $aZ, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $ZE);
        return base64_encode($ZE . $DN);
    }
    public static function decrypt_data($D9, $aZ, $Vy = "\101\x45\123\x2d\x31\x32\x38\55\x43\x42\103")
    {
        $sv = base64_decode($D9);
        $aZ = openssl_digest($aZ, "\163\150\x61\x32\65\x36");
        $yz = openssl_cipher_iv_length($Vy);
        $ZE = substr($sv, 0, $yz);
        $D9 = substr($sv, $yz);
        $ak = openssl_decrypt($D9, $Vy, $aZ, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $ZE);
        return $ak;
    }
}
