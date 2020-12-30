<?PHP
// =================================
// Script zum Einfügen der Losungen:
// =================================


// Einstellungen:
// ==============

// Bibeltext fett ausgeben: (1 = fett    0 = nicht fett)
$LphpBibeltextFett = 1;

// Stellenangabe als Link zur Internetbibel: (1 = Link    0 = kein Link)
$LphpBibelLink = 0;

// Überschrift einfügen: ("" = keine Überschrift)
$LphpTitelText = "Losung und Lehrtext für";

// Datumsangabe allein oder hinter Überschrift:
$LphpTitelDatum = 2;

// mögliche Werte: (Beispiel 04.02.2008)
// 0 = (keine Datumsangabe)
// 1 = "04.02.2008"
// 2 = "Montag, 4. Februar 2008"
// 3 = "4. Februar 2008"

// Doppelpunkt hinter Überschrift / Datum (1 = Doppelpunkt    0 = keiner)
$LphpTitelDoppelpunkt = 1;


// =================================================================
// Den nachfolgenden Code bitte nur ändern, wenn Sie sich auskennen!
// =================================================================

// Datendatei zum aktuellen Jahr ermitteln: 
$LphpDatei = "losungphp" . date("Y") . ".dat";

// Die Daten aus der Datendatei einlesen:
$LphpFp = @fopen($LphpDatei,"rb");
if ($LphpFp){
	$LphpTagID = date("z") +1;
	fseek ($LphpFp, ($LphpTagID * 12) - 12);
	$LphpPoLa = fread($LphpFp, 12);
	$LphpPo = intval(substr($LphpPoLa, 0, 6)) -1;
	$LphpLa = intval(substr($LphpPoLa, 6, 6));
	fseek ($LphpFp, $LphpPo);
	$LphpText = fread($LphpFp, $LphpLa);
	$Lphp = explode("§", $LphpText);
	fclose($LphpFp);
}

// Variablen für die Datumsangabe in der Überschrift
// Wochentagsname: (z.B.: "Montag")
$LphpWT = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
$LphpWochentagName = $LphpWT[date("w")];

// Monatsname: (z.B.: "Februar")
$LphpM = array("", "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
$LphpMonatName = htmlentities($LphpM[date("n")]);

// Tag als Zahl: (z.B.: kurz = "4" / lang = "04")
$LphpTagKurz = date("j");
$LphpTagLang = date("d");

// Monat als Zahl: (z.B.: kurz = "2" / lang = "02")
$LphpMonatKurz = date("n");
$LphpMonatLang = date("m");

// Jahr als Zahl: (z.B.: kurz = "08" / lang = "2008")
$LphpJahrKurz = date("y");
$LphpJahrLang = date("Y");

// Bibeltext ggf. Fett:
if($LphpBibeltextFett==1){
	$Lphp[1] = "<b>" . $Lphp[1] . "</b>";
	$Lphp[5] = "<b>" . $Lphp[5] . "</b>";
}

// Stellenangabe ggf. als Link zur Internetbibel
if($LphpBibelLink==1){
	$Lphp[2] = "<a title='Zum Bibeltext' href='" . $Lphp[3] . "' target='_blank'>" . $Lphp[2] . "</a>";
	$Lphp[6] = "<a title='Zum Bibeltext' href='" . $Lphp[7] . "' target='_blank'>" . $Lphp[6] . "</a>";
}

// Überschrift zusammenstellen:
$LphpTitel = "";
if($LphpTitelText != ""){$LphpTitel = htmlentities(trim($LphpTitelText));}

// Datum zusammenstellen:
$LphpDatum = "";
if($LphpTitelDatum <1 or $LphpTitelDatum >3){
	$LphpDatum = "";
}elseif($LphpTitelDatum==1){
	$LphpDatum = $LphpTagLang . "." . $LphpMonatLang . "." . $LphpJahrLang;
}elseif($LphpTitelDatum==2){
	$LphpDatum = $LphpWochentagName  . ", " . $LphpTagKurz . ". " . $LphpMonatName . " " . $LphpJahrLang;
}elseif($LphpTitelDatum==3){
	$LphpDatum = $LphpTagKurz . ". " . $LphpMonatName . " " . $LphpJahrLang;
}

if($LphpTitel != "" and $LphpDatum != ""){$LphpTitel = $LphpTitel . " ";}
$LphpTitel = $LphpTitel . $LphpDatum;
if($LphpTitel != "" and $LphpTitelDoppelpunkt==1){$LphpTitel=$LphpTitel . ":";}

// Titel ausgeben:
if($LphpTitel != ""){echo $LphpTitel . "<br><br>";}

// Losung ausgeben:
echo $Lphp[0] . $Lphp[1] . "<br>"; 
echo $Lphp[2] . "<br><br>";

// Lehrtext ausgeben:
echo $Lphp[4] . $Lphp[5] . "<br>";
echo $Lphp[6];

?>
