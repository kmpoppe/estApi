<?php
$fgcOptions = Array("ssl" => Array("verify_peer" => false, "verify_peer_name" => false));  
$validYearsESt = json_decode(file_get_contents("https://" . $_SERVER["HTTP_HOST"]. "/methods/validYearsESt", false, stream_context_create($fgcOptions)));
$validYearsSoli = json_decode(file_get_contents("https://" . $_SERVER["HTTP_HOST"]. "/methods/validYearsSoli", false, stream_context_create($fgcOptions)));
?>
{
	"swagger":"2.0",
	"info":{
		"version":"1.0.0",
		"title":"Einkommensteuer API",
		"license":{
			"name":"MIT"
		}
	},
	"host":"estapi.poppe.work",
	"basePath":"/",
	"schemes":[
		"https"
	],
	"consumes":[
		"application/json"
	],
	"produces":[
		"application/json"
	],
	"paths":{
		"/methods/calcESt":{
			"post":{
				"summary":"Berechnung der Jahreseinkommensteuer",
				"parameters":[
					{
						"in":"body",
						"name":"body",
						"description":"Angaben zur Berechnung",
						"schema":{
							"type":"object",
							"required":[
								"year",
								"splitting",
								"zvE"
							],
							"properties":{
								"year":{
									"name":"year",
									"type":"integer",
									"description":"Jahr, für das die Berechnung erfolgen soll",
<?php
echo str_repeat("\t", 9) . "\"minimum\":" . $validYearsESt->minimum . ",\n";
echo str_repeat("\t", 9) . "\"maximum\":" . $validYearsESt->maximum . ",\n";
?>
									"example":2018
								},
								"splitting":{
									"name":"splitting",
									"type":"boolean",
									"description":"Angabe, ob das Splittingverfahren für zusammenveranlagte steuerpflichtige Personen verwendet werden soll",
									"example":true
								},
								"zvE":{
									"name":"zvE",
									"type":"integer",
									"description":"Zu versteuerndes Einkommen",
									"minimum":0,
									"example":"35678"
								}
							}
						}
					}
				],
				"responses":{
					"200":{
						"description":"Ergebnis der Berechnung",
						"schema":{
							"type":"object",
							"properties":{
								"calledMethod":{
									"type":"string",
									"description":"Rückgabe des Namens der aufgerufenen Methode zur Kontrolle",
									"enum":"calcESt",
									"example":"calcESt"
								},
								"result":{
									"type":"string",
									"description":"OK wenn die Berechnung erfolgreich war, Error wenn ein Fehler aufgetreten ist",
									"enum": [ "OK", "Error" ],
									"example": "OK"
								},
								"errors":{
									"type":"string",
									"description":"Liste der aufgetretenen Fehler",
									"example":""
								},
								"value":{
									"type":"integer",
									"description":"Tarifliche Einkommensteuer, abgerundet auf den nächsten vollen Euro",
									"minimum":0,
									"example":3804
								}
							}
						}
					}
				}
			}
		},
		"/methods/calcSoli":{
			"post":{
				"summary":"Berechnung des Solidaritätszuschlags",
				"parameters":[
					{
						"in":"body",
						"name":"body",
						"description":"Angaben zur Berechnung",
						"schema":{
							"type":"object",
							"required":[
								"year",
								"splitting",
								"ESt"
							],
							"properties":{
								"year":{
									"name":"year",
									"type":"integer",
									"description":"Jahr, für das die Berechnung erfolgen soll",
<?php
echo str_repeat("\t", 9) . "\"minimum\":" . $validYearsSoli->minimum . ",\n";
echo str_repeat("\t", 9) . "\"maximum\":" . $validYearsSoli->maximum . ",\n";
?>
									"example":2018
								},
								"splitting":{
									"name":"splitting",
									"type":"boolean",
									"description":"Angabe, ob das Splittingverfahren für zusammenveranlagte steuerpflichtige Personen verwendet werden soll",
									"example":true
								},
								"zvE":{
									"name":"ESt",
									"type":"integer",
									"description":"Tarifliche Einkommensteuer, auf die der Solidaritätszuschlag berechent werden soll",
									"minimum":0,
									"example":"3804"
								}
							}
						}
					}
				],
				"responses":{
					"200":{
						"description":"Ergebnis der Berechnung",
						"schema":{
							"type":"object",
							"properties":{
								"calledMethod":{
									"type":"string",
									"description":"Rückgabe des Namens der aufgerufenen Methode zur Kontrolle",
									"enum":"calcESt",
									"example":"calcESt"
								},
								"result":{
									"type":"string",
									"description":"OK wenn die Berechnung erfolgreich war, Error wenn ein Fehler aufgetreten ist",
									"enum": [ "OK", "Error" ],
									"example": "OK"
								},
								"errors":{
									"type":"string",
									"description":"Liste der aufgetretenen Fehler",
									"example":""
								},
								"value":{
									"type":"number",
									"description":"Solidaritätszuschlag, abgerundet auf den nächsten Euro-Cent",
									"minimum":0,
									"example":209.22
								}
							}
						}
					}
				}
			}
		},
		"/methods/validYearsEst":{
			"get":{
				"summary":"Verfügbare Jahre für Berechnung der Einkommensteuer",
				"responses":{
					"200":{
						"description":"Jahresbereich",
						"schema":{
							"type":"object",
							"properties":{
								"calledMethod":{
									"type":"string",
									"description":"Rückgabe des Namens der aufgerufenen Methode zur Kontrolle",
									"enum":"validYearsESt",
									"example":"validYearsESt"
								},
								"minimum":{
									"type":"integer",
									"description":"Erstes Jahr, für das eine Berechnung ausgeführt werden kann",
<?php
echo str_repeat("\t", 9) . "\"example\":" . $validYearsESt->minimum . "\n";
?>
								},
								"maximum":{
									"type":"integer",
									"description":"Letztes Jahr, für das eine Berechnung ausgeführt werden kann",
<?php
echo str_repeat("\t", 9) . "\"example\":" . $validYearsESt->maximum . "\n";
?>
								}
							}
						}
					}
				}
			}
		},
		"/methods/validYearsSoli":{
			"get":{
				"summary":"Verfügbare Jahre für Berechnung des Solidaritätszuschlags",
				"responses":{
					"200":{
						"description":"Jahresbereich",
						"schema":{
							"type":"object",
							"properties":{
								"calledMethod":{
									"type":"string",
									"description":"Rückgabe des Namens der aufgerufenen Methode zur Kontrolle",
									"enum":"validYearsESt",
									"example":"validYearsESt"
								},
								"minimum":{
									"type":"integer",
									"description":"Erstes Jahr, für das eine Berechnung ausgeführt werden kann",
<?php
echo str_repeat("\t", 9) . "\"example\":" . $validYearsSoli->minimum . "\n";
?>
								},
								"maximum":{
									"type":"integer",
									"description":"Letztes Jahr, für das eine Berechnung ausgeführt werden kann",
<?php
echo str_repeat("\t", 9) . "\"example\":" . $validYearsSoli->maximum . "\n";
?>
								}
							}
						}
					}
				}
			}
		}
	}
}