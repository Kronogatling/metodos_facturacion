
	<?php 
    class ClienteCancelacionFormasDigitales{

    private $xml;
    private $autentica;

	var $cadena_original_xslt;

	#Se genera el XML vacío	
	public function __construct() {
		$this->xml = new DOMDocument('1.0', 'UTF-8');
		
		$this->cadena_original_xslt ='resources/cadenaoriginal_3_3.xslt';
	}


	public function cancelar($parametros){
		/* conexion al web service */
		$client = new SoapClient('http://dev33.facturacfdi.mx/WSCancelacionService?wsdl');
		return $client->Cancelacion_1($parametros);
	}

	public function sellarXML($certFile, $keyFile,$rfc,$folio,$pass,$autentica){

		#Acciones para encriptar (sellar) XML.
	

		$cert = file_get_contents($certFile);
		$key = file_get_contents($keyFile);
	
		$publicKey = base64_encode($cert);
		$privateKey = base64_encode($key);		
	
		$fecha_actual = substr( date('c'), 0, 19);
	
		
		#Se generan los nodos que tendrá el XML

		#Nodo principal
		$Cancelacion=$this->xml->createElement('ns4:Cancelacion_1');
		$Cancelacion->setAttribute('xmlns:ns2','http://www.w3.org/2000/09/xmldsig#');
		$Cancelacion->setAttribute('xmlns:ns3','http://cancelacfd.sat.gob.mx');
		$Cancelacion->setAttribute('xmlns:ns4','http://wservicios/');


		#Nodos secundarios
		$rfcEmisor=$this->xml->createElement('rfcEmisor',$rfc);
		$fechaX=$this->xml->createElement('fecha',$fecha_actual);
		$foliosX=$this->xml->createElement('folios',$folio);
		$publicKeyX=$this->xml->createElement('publicKey',$publicKey);
		$privateKeyX=$this->xml->createElement('privateKey',$privateKey);
		$passX=$this->xml->createElement('password',$pass);

		$Accesos=$this->xml->createElement('accesos');
		$passA=$this->xml->createElement('password',$autentica->password);
		$usuarioA=$this->xml->createElement('usuario',$autentica->usuario);

		$Accesos->appendChild($passA);		
		$Accesos->appendChild($usuarioA);	
		
		
		
		
		$Cancelacion->appendChild($rfcEmisor);
		$Cancelacion->appendChild($fechaX);	
		$Cancelacion->appendChild($foliosX);	
		$Cancelacion->appendChild($publicKeyX);	
		$Cancelacion->appendChild($privateKeyX);	
		$Cancelacion->appendChild($passX);	
		$Cancelacion->appendChild($Accesos);			
		$this->xml->appendChild($Cancelacion);		
		
		#Se guarda el XML en disco y se retorna
		$this->xml->save('prueba.xml');

		return $this->xml->saveXML();
	

		}

		function getNoCertificado($serial){
			$noCertificado = "";
			
			if((strlen($serial) % 2) == 1){
				$serial = " " . $serial;
			}

			for($i=0; $i < strlen($serial)/2; $i++){
				$aux = substr($serial, $i*2, ($i * 2) + 2);
				$noCertificado .=  substr($aux,1,1);
			}

			return $noCertificado;
		}

	public function generarCadenaOriginal(){
		$XSL = new DOMDocument();
		$XSL->load($this->cadena_original_xslt);
		$proc = new XSLTProcessor();
		@$proc->importStyleSheet($XSL);
		return $proc->transformToXML($this->xml);   
	}
}
?>