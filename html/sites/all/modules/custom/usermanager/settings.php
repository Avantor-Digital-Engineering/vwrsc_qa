<?php
  /**
   * SAMPLE Code to demonstrate how provide SAML settings.
   *
   * The settings are contained within a SamlSettings object. You need to
   * provide, at a minimum, the following things:
   *  - idp_sso_target_url: This is the URL to forward to for auth requests.
   *    It will be provided by your IdP.
   *  - x509certificate: This is a certificate required to authenticate your
   *    request. This certificate should be provided by your IdP.
   *  - assertion_consumer_service_url: The URL that the IdP should redirect
   *    to once the authorization is complete. You must provide this, and it
   *    should point to the consume.php script or its equivalent.
   */

  /**
   * Return a SamlSettings object with user settings.
   */
  function saml_get_settings() {
    // This function should be modified to return the SAML settings for the current user

    $settings = new SamlSettings();

    // When using Service Provider Initiated SSO (starting at index.php), this URL asks the IdP to authenticate the user.
    $settings->idp_sso_target_url             = "https://sso.vwr.com/sso/login.jsp?j_app_name=SupplierCentral";

    // The certificate for the users account in the IdP
    $settings->x509certificate                = <<<ENDCERTIFICATE
-----BEGIN CERTIFICATE-----
MIICHzCCAYigAwIBAgIET5KpFjANBgkqhkiG9w0BAQUFADBUMQswCQYDVQQGEwJVUzELMAkGA1UE
CBMCUEExDzANBgNVBAcTBlJhZG5vcjEMMAoGA1UEChMDVldSMQswCQYDVQQLEwJJVDEMMAoGA1UE
AxMDVldSMB4XDTEyMDQyMTEyMzMyNloXDTI3MDgyMTEyMzMyNlowVDELMAkGA1UEBhMCVVMxCzAJ
BgNVBAgTAlBBMQ8wDQYDVQQHEwZSYWRub3IxDDAKBgNVBAoTA1ZXUjELMAkGA1UECxMCSVQxDDAK
BgNVBAMTA1ZXUjCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAnIHfIbFriNmSasUkMN5iwyjR
kjbMT1nvinczFOhrued/b/KOsqFhwEiq8doyj7TOIrTQqmJ5+JMChVA8KQw/5z35HBsF1KGfcsUp
YX4YWkBqHp9L1DpQ/vtjCudG9UE5dMM9+/3aSnvCf22nQPJXy3uV8en2cnJPx4Rx8s2leNECAwEA
ATANBgkqhkiG9w0BAQUFAAOBgQBS6bI9NiMTvW+kNPuwpSy03EBlNgN5NAKyL7RFlALOfYodgnbj
T7Kc98XAYrPMByebQTG0xZBPBNLlSgY+piU9089NwEFXZ7bOa5WqWuXeWgEEgNDlhpypW5kMGKCO
pTOB0qJpb1sWEfjODWv2OD43ygpmbYWLlw8yEHuHYuCuAg==
-----END CERTIFICATE-----
ENDCERTIFICATE;
    // Tells the IdP to return the email address of the current user
    $settings->name_identifier_format         = "urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress";


    return $settings;
  }

?>