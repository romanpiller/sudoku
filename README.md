# Sudoku Solver

Jednoduchy a efektivny nastroj na riesenie Sudoku mriezky napisany v PHP. Balik podporuje rozne formaty vystupu (text, HTML) a je pripraveny na integraciu do Nette projektov.

## Instalacia

Balik je mozne nainstalovat pomocou nastroja Composer:

```bash
composer require romanpiller/sudoku
```

## Poziadavky

- PHP 8.5 alebo vyssie

## Pouzitie

Hlavnym vstupnym bodom pre pracu s balikom je `SudokuFacade`.

### Priklad pouzitia

```php
use Sudoku\Facades\SudokuFacade;

// Inicializacia fasady (idealne cez DI kontajner)
// $facade = $container->getByType(SudokuFacade::class);

$result = $facade->solve(
    'zadanie.txt',    // Nazov suboru so zadanim
    __DIR__ . '/data', // Cesta k adresaru so zadanim
    true,              // Vypisat vysledok do konzoly (optional, default false)
    'vysledok.html',   // Nazov suboru pre ulozenie riesenia (optional)
    __DIR__ . '/temp'  // Cesta pre ulozenie riesenia (optional)
);

if ($result) {
    echo "Sudoku bolo uspesne vyriesene.";
} else {
    echo "Sudoku sa nepodarilo vyriesit.";
}
```

### Format vstupneho suboru

Vstupny subor by mal obsahovat 81 cisiel (hodnoty 0-9) oddelenych ciarkami. Nula (0) predstavuje prazdne policko. Biele znaky (medzery, tabulatory) a nove riadky su pri spracovani ignorovane.

Priklad `zadanie.txt`:
```
5,3,0,0,7,0,0,0,0,
6,0,0,1,9,5,0,0,0,
0,9,8,0,0,0,0,6,0,
8,0,0,0,6,0,0,0,3,
4,0,0,8,0,3,0,0,1,
7,0,0,0,2,0,0,0,6,
0,6,0,0,0,0,2,8,0,
0,0,0,4,1,9,0,0,5,
0,0,0,0,8,0,0,7,9
```

## Konfiguracia v Nette

Ak pouzivate Nette Framework, mozete si sluzby zaregistrovat v `config.neon`:

```neon
services:
    - Sudoku\Facades\SudokuFacade
    - Sudoku\Data\Services\GridService
    - Sudoku\Services\SudokuService
    - Sudoku\View\ViewService
    - Sudoku\View\Text\TextFieldFactory
    - Sudoku\View\Html\HtmlFieldFactory
```

## Vyvoj a testovanie

Projekt obsahuje sadu nastrojov pre udrzanie kvality kodu:

### Unit testy (Nette Tester)
```bash
composer unit-test
```

### Staticka analyza (PHPStan)
```bash
composer phpstan
```

### Kontrola cistoty kodu (PHP CodeSniffer)
```bash
composer phpcodesniffer
```

### Pokrytie testov
```bash
composer cover
```

## Licencia

Tento projekt je licencovany pod MIT licenciou.
