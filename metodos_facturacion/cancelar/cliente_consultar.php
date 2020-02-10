
	<?php 
    class ClienteConsultar{
    

    private $xmlFirst;
    private $xmlSecond;
    private $autentica;

	

	#Se genera el XML vacío	
	public function __construct($file) {
        //$this->xmlFirst = new DOMDocument('1.0', 'UTF-8');
        $this->xmlSecond = new DOMDocument('1.0', 'UTF-8');
		$this->xmlSecond->load($file) or die("XML invalido");
		
	}


	public function consultar($parametros){
		/* conexion al web service */
		
		$client = new SoapClient('http://dev33.facturacfdi.mx/WSConsultaService?wsdl');
		return $client->ConsultaCFDI($parametros);
	}

	public function sellarXML(){

		#Acciones para encriptar (sellar) XML.
	
      
	
		
		#Se generan los nodos que tendrá el XML

        #Nodo principal
        
        /*
		$Consulta=$this->xmlFirst->createElement('ConsultarEstatusCFDI_2');
		$Consulta->setAttribute('xmlns:ns2','http://www.w3.org/2000/09/xmldsig#');
		$Consulta->setAttribute('xmlns:ns3','http://cancelacfd.sat.gob.mx');
		$Consulta->setAttribute('xmlns:ns4','http://wservicios/');


		#Nodos secundarios
		$rfcEmisor=$this->xmlFirst->createElement('rfcEmisor',$this->xmlSecond);
		

		$Accesos=$this->xmlFirst->createElement('accesos');
		$passA=$this->xmlFirst->createElement('password',$autentica->password);
		$usuarioA=$this->xmlFirst->createElement('usuario',$autentica->usuario);

		$Accesos->appendChild($passA);		
		$Accesos->appendChild($usuarioA);	
		
		
		
		
		$Consulta->appendChild($xmlCFDI);
	
		$Consulta->appendChild($Accesos);			
		$this->xml->appendChild($Consulta);		
		
		#Se guarda el XML en disco y se retorna
        $this->xmlFirst->save('pruebaF.xml');
        */

		return 	$this->xmlSecond->saveXML();
	

		}

		
}
?>