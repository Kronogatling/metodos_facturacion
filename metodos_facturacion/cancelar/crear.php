<?php 
include ("../conexiones/conexion.php");


$statement = $conexion->prepare('SELECT * FROM detallesPedido WHERE idCompra = "438" ');
$statement->execute();
$datos = $statement->fetchAll();



$documento = new DOMDocument('1.0', 'UTF-8');
#Nodo principal root
$Comprobante = $documento->createElementNS('Comprobante', 'cfdi:Comprobante');
$Comprobante->setAttribute('schemaLocation', 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv3.xsd');
$Comprobante->setAttribute('version', '3.0');
$Comprobante->setAttribute('fecha', '2019-07-09');
$Comprobante->setAttribute('sello', 'HE33G23Y23GY2');
$Comprobante->setAttribute('formaDePago', 'En una sola exhibición');
$Comprobante->setAttribute('noCertificado', '0101011010101');
$Comprobante->setAttribute('certificado', '0000000000');
$Comprobante->setAttribute('subTotal', '40.00');
$Comprobante->setAttribute('total', '45.982');
$Comprobante->setAttribute('tipoDeComprobante', 'ingreso');


#--------------------------------------------------------------------------
#Nodos secundarios
$Emisor = $documento->createElement('Emisor');
$Emisor->setAttribute('nombre', 'PICE Software S.A de C.V'); 
$Emisor->setAttribute('rfc', 'APR0412108C5');

#nodos terciarios
$DomicilioFiscal = $documento->createElement('DomicilioFiscal');
$DomicilioFiscal->setAttribute('calle', 'Jesús García'); 
$DomicilioFiscal->setAttribute('noExterior', '3020'); 
$DomicilioFiscal->setAttribute('colonia', 'Prados Providencia');
$DomicilioFiscal->setAttribute('localidad', 'Jalisco');
$DomicilioFiscal->setAttribute('municipio', 'Guadalajara');
$DomicilioFiscal->setAttribute('estado', 'Jalisco');
$DomicilioFiscal->setAttribute('pais', 'México');
$DomicilioFiscal->setAttribute('codigoPostal', '44100');
#nodos terciarios
$ExpedidoEn = $documento->createElement('ExpedidoEn');
$ExpedidoEn->setAttribute('calle', 'Independencia');
$ExpedidoEn->setAttribute('noExterior', '606');
$ExpedidoEn->setAttribute('colonia', 'Zona Centro');
$ExpedidoEn->setAttribute('localidad', 'Jalisco');
$ExpedidoEn->setAttribute('municipio', 'Guadalajara');
$ExpedidoEn->setAttribute('estado', 'Jalisco');
$ExpedidoEn->setAttribute('pais', 'México');
$ExpedidoEn->setAttribute('codigoPostal', '44100');
 
#Agregamos los nodos hijos.
$Emisor->appendChild($DomicilioFiscal);
$Emisor->appendChild($ExpedidoEn);

#----------------------------------------------------------------------------

#--------------------------------------------------------------------------
#Nodos secundarios
$Receptor = $documento->createElement('Receptor');
$Receptor->setAttribute('nombre', 'Público en general'); 
$Receptor->setAttribute('rfc', 'XAXX010101000');

#nodos terciarios
$Domicilio = $documento->createElement('Domicilio');
$Domicilio->setAttribute('calle', '(SIN DIRECCIÓN)'); 
$Domicilio->setAttribute('colonia', '(SIN COLONIA)');
$Domicilio->setAttribute('localidad', '(SIN CIUDAD)');
$Domicilio->setAttribute('estado', '(SIN ESTADO)');
$Domicilio->setAttribute('pais', '(México)');
$Domicilio->setAttribute('codigoPostal', '(00000)');

#Agregamos los nodos hijos.
$Receptor->appendChild($Domicilio);

#----------------------------------------------------------------------------

#--------------------------------------------------------------------------
#Nodos secundarios
$Conceptos = $documento->createElement('Conceptos');


foreach ($datos as $dato) { 

$precio = number_format($dato['precio'], 2);
$importe = number_format($dato['total'], 2);

#nodos terciarios
$concepto = $documento->createElement('concepto');
$concepto->setAttribute('cantidad', $dato['cantidad']); 
$concepto->setAttribute('unidad', 'Pza');
$concepto->setAttribute('noIdentificacion', $dato['nombreProducto']);
$concepto->setAttribute('descripcion', 'Pestaña postiza');
$concepto->setAttribute('valorUnitario', $precio);
$concepto->setAttribute('importe', $importe);

#Agregamos los nodos hijos.
$Conceptos->appendChild($concepto);
}



#----------------------------------------------------------------------------

#--------------------------------------------------------------------------
#Nodos secundarios
$Impuestos = $documento->createElement('Impuestos');
$Impuestos->setAttribute('totalImpuestosTrasladados', '2478.933'); 

#nodos terciarios
$Traslados = $documento->createElement('Traslados');

$Traslado = $documento->createElement('Traslado');
$Traslado->setAttribute('impuesto', 'IEPS'); 
$Traslado->setAttribute('tasa', '0.36'); 
$Traslado->setAttribute('importe', '7.02'); 

#Agregamos los nodos hijos.
$Traslados->appendChild($Traslado);
$Impuestos->appendChild($Traslados);

#----------------------------------------------------------------------------


$Comprobante->appendChild($Emisor);
$Comprobante->appendChild($Receptor);
$Comprobante->appendChild($Conceptos);
$Comprobante->appendChild($Impuestos);

//Agregamos todo el árbol al objeto.
$documento->appendChild($Comprobante);
//Guardamos el XML.
$documento->save('Comprobante.xml'); 


?>