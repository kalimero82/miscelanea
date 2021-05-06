<?php

/** 
 *  @author Fernando Siles
 *  @version 1.0
 *
 *  Script para, teniendo un APIKey de Mailchimp y sabiendo el listID y el interestCategoryId,
 *  poder obtener el listado de intereses de dicha categoría a través de la API de Mailchimp
 *  con los principales campos (ID, nombre y nº de suscriptores) 
**/

// variables
$apiKey = 'tu-apikey';
$dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
$listId = 'tu-listID'; 		 
$interestCategoryId = 'tu-interestCategoryID';

// url completa
$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/interest-categories/' . $interestCategoryId . '/interests?count=100';

// llamada Curl
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// respuesta
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// parseamos y mostramos la respuesta por pantalla
$res = json_decode($result);
$interests = $res->interests;

$cont = count($interests);
$i = 0;
while ($i < $cont) {
	$interest = $interests[$i];
	
	echo '<p>';
	echo 'Nombre: <b>'.utf8_decode($interest->name).'</b><br/>';
	echo 'ID: '.$interest->id.'<br/>';
	echo 'Nº de suscriptores: <b>'.$interest->subscriber_count.'</b>';
	echo '</p>';
	$i++;
}


