<?php


	require_once("geoip.php");

	$objGeoIP = new GeoIP();
	$objGeoIP->search_ip("<YOUR IP>");

	if ($objGeoIP->found())
	{
		echo "Country Code: " 	. $objGeoIP->getCountryCode() 	. "<br/>";
		echo "Country Name: " 	. $objGeoIP->getCountryName() 	. "<br/>";
		echo "IP Class Start: " . $objGeoIP->getStartIp() 		. "<br/>";
		echo "IP Class End: " 	. $objGeoIP->getEndIp() 		. "<br/>";
	}
	else
		echo "NOT FOUND!";


?>

