<?php
require_once('cliente_consultar.php');
header('Content-type: text/html; charset=utf-8');
try {

	set_time_limit(0);
	date_default_timezone_set("America/Mexico_City");


	#Datos que ocupara el XML 
	$filename ="ConsultarEstatusCFDI1_Request.xml"; 
	

	$clienteFD = new ClienteConsultar($filename);

	$Accesos = new Autenticar();
	$Accesos->usuario = "pruebasWS";
	$Accesos->password = "pruebasWS";

	$parametros = new Parametros();
	$parametros->accesos = $Accesos;
	
	#Recibe el XML sellado 
	$parametros->xml = '<?xml version="1.0" encoding="UTF-8"?>
	<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/3" 
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Certificado="MIIFxTCCA62gAwIBAgIUMjAwMDEwMDAwMDAzMDAwMjI4MTUwDQYJKoZIhvcNAQELBQAwggFmMSAwHgYDVQQDDBdBLkMuIDIgZGUgcHJ1ZWJhcyg0MDk2KTEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMSkwJwYJKoZIhvcNAQkBFhphc2lzbmV0QHBydWViYXMuc2F0LmdvYi5teDEmMCQGA1UECQwdQXYuIEhpZGFsZ28gNzcsIENvbC4gR3VlcnJlcm8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQRGlzdHJpdG8gRmVkZXJhbDESMBAGA1UEBwwJQ295b2Fjw6FuMRUwEwYDVQQtEwxTQVQ5NzA3MDFOTjMxITAfBgkqhkiG9w0BCQIMElJlc3BvbnNhYmxlOiBBQ0RNQTAeFw0xNjEwMjUyMTUyMTFaFw0yMDEwMjUyMTUyMTFaMIGxMRowGAYDVQQDExFDSU5ERU1FWCBTQSBERSBDVjEaMBgGA1UEKRMRQ0lOREVNRVggU0EgREUgQ1YxGjAYBgNVBAoTEUNJTkRFTUVYIFNBIERFIENWMSUwIwYDVQQtExxMQU43MDA4MTczUjUgLyBGVUFCNzcwMTE3QlhBMR4wHAYDVQQFExUgLyBGVUFCNzcwMTE3TURGUk5OMDkxFDASBgNVBAsUC1BydWViYV9DRkRJMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgvvCiCFDFVaYX7xdVRhp/38ULWto/LKDSZy1yrXKpaqFXqERJWF78YHKf3N5GBoXgzwFPuDX+5kvY5wtYNxx/Owu2shNZqFFh6EKsysQMeP5rz6kE1gFYenaPEUP9zj+h0bL3xR5aqoTsqGF24mKBLoiaK44pXBzGzgsxZishVJVM6XbzNJVonEUNbI25DhgWAd86f2aU3BmOH2K1RZx41dtTT56UsszJls4tPFODr/caWuZEuUvLp1M3nj7Dyu88mhD2f+1fA/g7kzcU/1tcpFXF/rIy93APvkU72jwvkrnprzs+SnG81+/F16ahuGsb2EZ88dKHwqxEkwzhMyTbQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAJ/xkL8I+fpilZP+9aO8n93+20XxVomLJjeSL+Ng2ErL2GgatpLuN5JknFBkZAhxVIgMaTS23zzk1RLtRaYvH83lBH5E+M+kEjFGp14Fne1iV2Pm3vL4jeLmzHgY1Kf5HmeVrrp4PU7WQg16VpyHaJ/eonPNiEBUjcyQ1iFfkzJmnSJvDGtfQK2TiEolDJApYv0OWdm4is9Bsfi9j6lI9/T6MNZ+/LM2L/t72Vau4r7m94JDEzaO3A0wHAtQ97fjBfBiO5M8AEISAV7eZidIl3iaJJHkQbBYiiW2gikreUZKPUX0HmlnIqqQcBJhWKRu6Nqk6aZBTETLLpGrvF9OArV1JSsbdw/ZH+P88RAt5em5/gjwwtFlNHyiKG5w+UFpaZOK3gZP0su0sa6dlPeQ9EL4JlFkGqQCgSQ+NOsXqaOavgoP5VLykLwuGnwIUnuhBTVeDbzpgrg9LuF5dYp/zs+Y9ScJqe5VMAagLSYTShNtN8luV7LvxF9pgWwZdcM7lUwqJmUddCiZqdngg3vzTactMToG16gZA4CWnMgbU4E+r541+FNMpgAZNvs2CiW/eApfaaQojsZEAHDsDv4L5n3M1CC7fYjE/d61aSng1LaO6T1mh+dEfPvLzp7zyzz+UgWMhi5Cs4pcXx1eic5r7uxPoBwcCTt3YI1jKVVnV7/w=" Fecha="2020-01-10T17:29:43" Folio="0" FormaPago="99" LugarExpedicion="45018" MetodoPago="PUE" Moneda="MXN" NoCertificado="20001000000300022815" Sello="G4zNqK4J8mSLTZNoizc5OPPuUl2BFLpjnAGrsAg3gO2VaOJlFiVn4I/58oTBuSSXkI/kzhY9s0WOTfei1hh4ZLP4duuBvatDT2zkPqzxmdaR6VKddQhQldQj44YtWNhWsGwxBZyXum1d6cLBKxsn7qbGl7pdkSdL2BFstqoHvy5OBXaPcZxZdeeHEFpBSQjGtItqjBZ0lWCcftPSRk8wImC4rDraHupg6WonBumBK8bAzlpgwq0BcPiXezfY9D9//p71k72cZqlJyJgg0M3e1JJ4whlZ/jBiT/FsZfdy9odD++xUpaTlZ94AHKtwPUXNFoOrldIOhZN4BJ6Otz1bAg==" Serie="EX" SubTotal="6500" TipoCambio="1" TipoDeComprobante="I" Total="7540" Version="3.3" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd">
		<cfdi:Emisor RegimenFiscal="601" Rfc="LAN7008173R5"/>
		<cfdi:Receptor Rfc="TUCA5703119R5" UsoCFDI="D10"/>
		<cfdi:Conceptos>
			<cfdi:Concepto Cantidad="50" ClaveProdServ="10191508" ClaveUnidad="ACT" Descripcion="D17" Importe="1500" NoIdentificacion="34006" ValorUnitario="30">
				<cfdi:Impuestos>
					<cfdi:Traslados>
						<cfdi:Traslado Base="1500" Importe="240" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa"/>
					</cfdi:Traslados>
				</cfdi:Impuestos>
			</cfdi:Concepto>
			<cfdi:Concepto Cantidad="50" ClaveProdServ="10191508" ClaveUnidad="ACT" Descripcion="D59" Importe="1500" NoIdentificacion="34006" ValorUnitario="30">
				<cfdi:Impuestos>
					<cfdi:Traslados>
						<cfdi:Traslado Base="1500" Importe="240" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa"/>
					</cfdi:Traslados>
				</cfdi:Impuestos>
			</cfdi:Concepto>
			<cfdi:Concepto Cantidad="100" ClaveProdServ="10191508" ClaveUnidad="ACT" Descripcion="S01" Importe="3500" NoIdentificacion="34006" ValorUnitario="35">
				<cfdi:Impuestos>
					<cfdi:Traslados>
						<cfdi:Traslado Base="3500" Importe="560" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa"/>
					</cfdi:Traslados>
				</cfdi:Impuestos>
			</cfdi:Concepto>
		</cfdi:Conceptos>
		<cfdi:Impuestos TotalImpuestosTrasladados="1040">
			<cfdi:Traslados>
				<cfdi:Traslado Importe="1040" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa"/>
			</cfdi:Traslados>
		</cfdi:Impuestos>
		<cfdi:Complemento>
			<tfd:TimbreFiscalDigital xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" 
				xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" FechaTimbrado="2020-01-10T17:29:44" NoCertificadoSAT="20001000000300022323" RfcProvCertif="FCG840618N51" SelloCFD="G4zNqK4J8mSLTZNoizc5OPPuUl2BFLpjnAGrsAg3gO2VaOJlFiVn4I/58oTBuSSXkI/kzhY9s0WOTfei1hh4ZLP4duuBvatDT2zkPqzxmdaR6VKddQhQldQj44YtWNhWsGwxBZyXum1d6cLBKxsn7qbGl7pdkSdL2BFstqoHvy5OBXaPcZxZdeeHEFpBSQjGtItqjBZ0lWCcftPSRk8wImC4rDraHupg6WonBumBK8bAzlpgwq0BcPiXezfY9D9//p71k72cZqlJyJgg0M3e1JJ4whlZ/jBiT/FsZfdy9odD++xUpaTlZ94AHKtwPUXNFoOrldIOhZN4BJ6Otz1bAg==" SelloSAT="LLSyD9BdW+thPu7iov06qJmPbyLZ5ZHK1vPZAQagjsS7WsBWzoQ4ODt9TpIius0mNfAYoYO0depDldwxP+PLBTAnSImsu5VXy26rGY1sKmbKa/Sxu2t+XJPeK0GFcdQA5qpTYZG1gREDIx4n8jr+J7aUptjd7g4B1HC1JI/Ue6mc88TYJhBQ63hnrLEkJ2o61N7i2DuOnDWn9CmI3OmbOKUy6/7WEQGrdQKWlN+v/GI+jbB39KoeBAwrvPRP3F2c1GKTryD+osm2dY1sQooma+7+HxCsaU+aycDYJe2IhvdEW5eaYcL/XsriYuumdzhDbDRvdB8NVDJD1QsHZxDeSA==" UUID="98CA3B09-2B20-4B08-A04E-A9B7814BA74F" Version="1.1" xsi:schemaLocation="http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/timbrefiscaldigital/TimbreFiscalDigitalv11.xsd"/>
		</cfdi:Complemento>
	</cfdi:Comprobante>
	';


	
    $responseTimbre = $clienteFD->consultar($parametros);

    //echo "codigoErr: " . $responseTimbre->return . "<br>";

    var_dump($responseTimbre);

	die();

	if (isset($responseTimbre->acuseCFDI->error)) {
		echo "codigoErr: " . $responseTimbre->acuseCFDI->error . "<br>";
	}

	if ($responseTimbre->acuseCFDI->xmlTimbrado) {
		echo 'XML TMIBRADO:<BR> <textarea>' . $responseTimbre->acuseCFDI->xmlTimbrado . '</textarea>';
	
	}
} catch (SoapFault $e) {
	print("Auth Error:::: $e");
}



class Autenticar
{
	public $usuario;
	public $password;
}


class Parametros
{
	
	
	public $accesos;
	public $xml;
}
