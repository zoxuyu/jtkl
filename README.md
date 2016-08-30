# Zoxzuyu-Joomla-Toolkit-Libray
## Wofür ist ZJTK da?
ZJTK ist eine PHP-Bibliothek zur Unterstützung der Entwicklung von Joomla!-Templates. Sie ermöglicht einem innerhalb der Template-Definitionen auf den Alias des Artikels zuzugreifen. Dies ist zum Beispiel dann wünschenswert, wenn man unterschiedlichen Seiten unterschiedliche Farben zuweisen möchte. Weiterhin gibt es die Möglichkeit Präfixe und Suffixe (Sprachen) in CSS-Klassen umzuwandeln (Alias-Class-Umleitung). Dadurch ist es möglich mehreren Seiten eine Farbe zuzuweisen, ohne für jede Seite eine eigene Klasse einzubauen. Ebenso erhöht dies die Flexibilität und Wartbarkeit der Seite in puncto Seiten hinzufügen, löschen und die Farbe ändern.

Allerdings muss man ebenfalls an die Suchmaschinenoptimierung (SEO) denken. Da Joomla! den Beitragsalias zur URL-Generierung verwendet, sollte dieser nicht genutzt werden. Darum nutzt ZJTK ein einfaches Prinzip. Wenn ein Menüalias vorhanden ist (wird nicht für URL-Generierung verwendet), wird dieser verwendet. Ansonsten wird der Beitragsalias genutzt. Der Menüalias ist normalerweise nur bei Kontakt-, Kategorie- und Startseiten nicht vorhanden.
## Wie benutzt man ZJTK
Die folgenden zwei Abschnitte treffen nur zu, wenn man die Alias-Class-Umleitung nutzen will. Wenn du nur den Alias ausgeben willst, springe direkt zu dem Abschnitt "Manipulationen im PHP-Bereich der Template-Datei". Bevor einzelne Details und Code-Schnipsel gezeigt werden sollen, wird erst noch das Prinzip der Alias-Class-Umleitung erläutert.
### Die Alias-Class-Umleitung
Ein Alias, der in eine Klasse umgewandelt werden soll, muss bestimmten Kriterien entsprechen. Im folgenden ist das Token wiedergegeben, mit dem ein Alias identifiziert wird:
```
(<[$char$++] PREFIX><[$char$*1] PREFIX_DIVIDER>)<[$char$++] CUSTOM_ALIAS>(<[$char$*1] SUFFIX_DIVIDER><[$char$+] SUFFIX / LANGUAGE>)
```
Im folgenden wird eine Erklärung zu jedem Subtoken genannt.

Subtoken | Erklärung
------------- | -------------
<[$char$++] PREFIX> | Mehrere Zeichen als Präfix, optional, nur wenn das auch Präfix-Divider
<[$char$*1] PREFIX-DIVIDER> | Ein Zeichen um Präfix und Alias zu unterscheiden, konditional. Bsp.: "-" oder "_"
<[$char$++] CUSTOM-ALIAS> | Ein eigener, obligatorischer Alias-Text
<[$char$*1] SUFFIX-DIVIDER> | Ein Zeichen um Suffix und Alias zu unterscheiden, konditional. Bsp.: "-" oder "_"
<[$char$++] SUFFFIX / LANGUAGE> | Mehrere Zeichen als SUFFIX / SPRACHE optional, nur wenn das auch Suffix-Divider

Im Klartext heißt dies, dass folgende Aliase korrekt sind. (Präfix- und Suffixdivider aus Erklärungszwecken auf "-" gesetzt.)

- prefix-alias-language
- prefix-alias
- alias-language
- alias

### Manipulation im Joomla! Backend
Öffnen Sie die Menüs der zu bearbeitenden Joomla!-Seite. Gehen Sie zu jedem Artikel und ändern Sie den Alias nach dem oben genannten Schema ab. EINMAL FESTGELEGTE PRÄFIX-/SUFFIX-DIVIDER MÜSSEN BEI ALLEN ALIASEN BEIBEHALTEN WERDEN.
### Manipulationen im PHP-Bereich der Template-Datei
Fügen Sie folgenden Zeile in den PHP-Abschnitt des Templates, indem Dateien eingebunden werden:
```php
@require_once("zjtk.php") or die("DIE ZJTK.PHP-DATEI WURDE NICHT GEFUNDEN!!!");
```
Anschließend fügen Sie nach dieser Zeile folgenden PHP-Code ein.
```php
$alias = new Alias();
$alias->Config("prefixDivider", "<IHR PREFIX DIVIDER>");
$alias->Config("suffixDivider", "<IHR SUFFIX DIVIDER>");
```
Fügen Sie dann für jedes Präfix folgende Zeile direkt nach dem vorhergehenden Code ein.
```php
$alias->AddPrefix("<PRÄFIX>", "<PRÄFIX-ERSATZ (CSS-KLASSE)>");
```
Fügen Sie dann für jede Sprache folgende Zeile direkt nach dem vorhergehenden Code ein.
```php
$alias->AddLanguage("<SHORTCODE>", "<LONG REPLACEMENT (CSS-KLASSE)>");
```
