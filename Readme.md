


# Aufgabe: T9 Telefonbuch

## Voraussetzungen
Getestet wurde die Anwendung mit PHP 8.3., composer 2.6.6 und mySQL 8.2.0, die lokal auf dem Rechner installiert waren.
Theoretisch müsste die Anwendung aber auch noch teilweise abwärtskompatibel sein.

## Einrichten und Ausführen der Anwendung

Die Konfiguration der MySQL Datenbank lässt sich über die .env Datei im Root Verzeichnis anpassen. 
Die Database und Datatables werden automatisch angelegt, wenn sie noch nicht existieren.

Für die Installation der Abhängigkeiten wird composer verwendet:

    composer install

Aufgrund der begrenzten Zeit habe ich das Projekt nicht verdockert, sondern die Anwendung über den integrierten PHP Webserver gestartet: 
    
    php -S localhost:8000

Die Anwendung ist dann unter `http://localhost:8000` erreichbar.


## Aufgabenstellung
### Projekt:

Programmieren Sie ein Telefonbuch mit einer Suche vergleichbar dem T9 bei Mobiltelefonen. Zu jedem Eintrag werden nur die Eigenschaften Nachname, Vorname, Telefonnummer erfasst.

Zum Suchen gibt der Benutzer eine Zahlenfolge ein. Als Ergebnis werden alle Einträge gezeigt deren Vornamen oder Nachnamen mit den aus den Zahlen abgeleiteten Buchstaben beginnen (gemeint sind die Buchstaben die auf der Handytastatur über den Zahlen stehen, die Suche nach 688 passt also z.B. für OTTo und NUTzer, die 724 für SCHmidt und RAHmen).

Die Suche soll auch bei >1 Mio. Datensätzen schnell Ergebnisse liefern.



### Umfang

Erstellen Sie eine geeignete Datenbankstruktur (mit SQLite oder MySQL, Setupskript oder Dump der Initialen DB mit Create-Table-Anweisungen beifügen)

Erstellen Sie eine Demo-Anwendung mit diesen beiden Use-Cases:

Eintragen eines Datensatzes per Formular (ohne Benutzerauthentifizierung)

Abfragen der Datenbank durch Eingabe einer Zahl (Standard-HTML-Form) und Ausgabe der Ergebnisse (Standard-HTML-Tabelle)

Wenn Sie bereits mit UnitTests gearbeitet haben: Erstellen Sie die UnitTests, die Sie für sinnvoll erachten



### Hinweise

Die Lösung soll minimal und leicht nachvollziehbar sein

Verzichten Sie auf CSS, JavaScript, unnötige Metatags, Frameworks, etc.

Programmieren Sie für PHP Version 7.1 oder höher und error_reporting = E_ALL|E_STRICT

Programmieren Sie objektorientiert und strukturieren Sie Ihren Code sauber und übersichtlich

Verwenden Sie sinnvolle, sprechende Namen für alle Bezeichner

Dokumentieren Sie Parameter und Rückgabewerte im PHPDoc-Stil und ergänzen Sie falls nötig

eigene Kommentaren zum besseren Verständnis