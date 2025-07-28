<?php

function randomPassword() {
    $characterList = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-!';
    $pass = array();
    $charsLength = strlen($characterList) - 1;
    for ($i = 0; $i < 16; $i++) {
        $n = rand(0, $charsLength);
        $pass[] = $characterList[$n];
    }
    return implode($pass);
}

$password = randomPassword();

try
{
  // Parameter für die API-Funktion
  $Params = array(  'database_password' => $password,
                    'database_comment' => 'kas-api-database',
                    'database_allowed_hosts' => '217.29.146.116');

  $SoapRequest = new SoapClient('https://kasapi.kasserver.com/soap/wsdl/KasApi.wsdl');
  $req = $SoapRequest->KasApi(json_encode(array(
              'kas_login' => 'w0112399',                // KAS-User
              'kas_auth_type' => 'plain',             // Auth per Sessiontoken
              'kas_auth_data' => 'F24oJCyoxpR2JEVS',      // Auth-Token
              'kas_action' => 'add_database',      // API-Funktion
              'KasRequestParams' => $Params          // Parameter an die API-Funktion
              )));
}

// Fehler abfangen und ausgeben
catch (SoapFault $fault)
{
    trigger_error(" Fehlernummer: {$fault->faultcode},
                    Fehlermeldung: {$fault->faultstring},
                    Verursacher: {$fault->faultactor},
                    Details: {$fault->detail}", E_USER_ERROR);
}

?>

<?php

  echo "<pre>";
  print_r($req);
  echo "</pre?>\n";

?>