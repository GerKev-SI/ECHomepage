<?PHP
// =================================
// Script zum Einf�gen der Losungen:
// =================================
//
// TIPP: Zeigen Sie dieses Script im Windows-Editor (notepad.exe) an,
// deaktivieren Sie im Men� "Format" die Funktion "Zeilenumbruch" und
// w�hlen Sie die Schriftart "Courier New" - das erleichtert die Arbeit!


// Daten aus der Datendatei einlesen:
// ==================================
// geben Sie hier ggf. den relativen Pfad zur Datei "losungphp????.dat" an,
// wenn sich die Datendatei nicht im gleichen Ordner wie das Script befindet:
$LphpPfad = "";

// Datendatei zum aktuellen Jahr ermitteln:
$LphpDatei = $LphpPfad . "losungphp" . date("Y") . ".dat";

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
	if (strpos($LphpText,"�") !==false) {
		$Lphp = explode("�", $LphpText);
	} else if(strpos($LphpText,"|") !==false) {
		$Lphp = explode("|", $LphpText);
	} else {
		$LphpText = str_replace("?", "@", $LphpText);
		$pos = strpos($LphpText, "http://") -1;
		$z = substr($LphpText, $pos, 1);
		$LphpText = str_replace($z, "|", $LphpText);
		$LphpText = str_replace("@", "?", $LphpText);
		$Lphp = explode("|", $LphpText);
	}
	fclose($LphpFp);
}

// Die Losungsdaten liegen nun in folgenden Variablen vor:
// $Lphp[0] = Vortext, der nicht zum Bibeltext geh�rt - z.B.: "Mose sagte: "
// $Lphp[1] = Bibeltext der Losung
// $Lphp[2] = Stellenangabe zur Losung
// $Lphp[3] = Link zur Internetbibel
//
// $Lphp[4] = Vortext zum Lehrtext
// $Lphp[5] = Bibeltext des Lehrtextes
// $Lphp[6] = Stellenangabe zum Lehrtext
// $Lphp[7] = Link zur Internetbibel
//
// z.B. Losungsdaten vom 04.02.2008:
// $Lphp[0] = "";
// $Lphp[1] = "Wenn der HERR nicht das Haus baut, so arbeiten umsonst ...";
// $Lphp[2] = "Psalm 127,1";
// $Lphp[3] = "http://www.combib.de/bibel/ue/psal127.html#1";
//
// $Lphp[4] = "Paulus schreibt:&#160;";
// $Lphp[5] = "Wir sind Gottes Mitarbeiter; ihr seid Gottes Ackerfeld... ";
// $Lphp[6] = "1.Korinther 3,9";
// $Lphp[7] = "http://www.combib.de/bibel/ue/1kor3.html#9";


// Variablen f�r die Datumsangabe in der �berschrift
// =================================================
// Wochentagsname: (z.B.: "Montag")
$LphpWT = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
$LphpWochentagName = $LphpWT[date("w")];

// Monatsname: (z.B.: "Februar")
$LphpM = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
$LphpMonatName = $LphpM[date("n")];

// Tag als Zahl: (z.B.: kurz = "4" / lang = "04")
$LphpTagKurz = date("j");
$LphpTagLang = date("d");

// Monat als Zahl: (z.B.: kurz = "2" / lang = "02")
$LphpMonatKurz = date("n");
$LphpMonatLang = date("m");

// Jahr als Zahl: (z.B.: kurz = "08" / lang = "2008")
$LphpJahrKurz = date("y");
$LphpJahrLang = date("Y");


// �berschrift zusammenstellen 
// ===========================
//
// Beispiel: "Losung und Lehrtext f�r heute:"
// $LphpTitel = "Losung und Lehrtext f&uuml;r heute:";
//
// Beispiel: "Losung und Lehrtext zum 04.02.2008:"
// $LphpTitel = "Losung und Lehrtext zum " . $LphpTagLang . "." . $LphpMonatLang . "." . $LphpJahrLang . ":";
//
// Beispiel: "Losung und Lehrtext f�r Montag, 4. Februar 2008"
// $LphpTitel = "Losung und Lehrtext f&uuml;r " . $LphpWochentagName  . ", " . $LphpTagKurz . ". " . $LphpMonatName . " " . $LphpJahrLang . ":";
//
// Ihr Text:
$LphpTitel = $LphpWochentagName  . ", " . $LphpTagKurz . ". " . $LphpMonatName . " " . $LphpJahrLang;


// Datentext formatieren:
// ======================
//
// Bibeltext Fett ausgeben: (1=fett  0=nicht fett)
$LphpBibeltextFett = 0; 
if($LphpBibeltextFett==1){
	$Lphp[1] = "<b>" . $Lphp[1] . "</b>";
	$Lphp[5] = "<b>" . $Lphp[5] . "</b>";
}

// Stellenangaben als Link zur Internetbibel: (1=Link  0=kein Link)
$LphpBibelLink = 0;
if($LphpBibelLink==1){
	$Lphp[2] = "<a title='Zum Bibeltext' href='" . $Lphp[3] . "' target='_blank'>" . $Lphp[2] . "</a>";
	$Lphp[6] = "<a title='Zum Bibeltext' href='" . $Lphp[7] . "' target='_blank'>" . $Lphp[6] . "</a>";
}


// Textausgabe: (z.B. so)
// ======================

// �berschrift: 
if($LphpTitel != ""){echo $LphpTitel . "<br><br>";}

// Losung:
echo $Lphp[0] . $Lphp[1] . "<br>"; // Bibeltext
echo $Lphp[2] . "<br><br>";        // Stellenangabe

// Lehrtext:
echo $Lphp[4] . $Lphp[5] . "<br>"; // Bibeltext
echo $Lphp[6];                     // Stellenangabe

?>
