# Sudoku Solver

Jednoduchy a efektivny nastroj na riesenie Sudoku mriezky napisany v PHP. Balik podporuje rozne formaty vystupu (text, HTML) a je pripraveny na integraciu do Nette projektov.

## Instalacia

Balik je mozne nainstalovat pomocou nastroja Composer:

```bash
composer require romanpiller/sudoku
```

## Poziadavky

- PHP 8.2 alebo vyssie

## Pouzitie

Hlavnym vstupnym bodom pre pracu s balikom je `SudokuFacade`.

### Priklad pouzitia

```php
use Sudoku\Facades\SudokuFacade;

// Inicializacia fasady (idealne cez DI kontajner)
// $facade = $container->getByType(SudokuFacade::class);

// Ak je fasada nakonfigurovana cez DI, staci zavolat solve len s nazvom suboru
$result = $facade->solve('zadanie.txt');

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

Najlepsi sposob ako zaregistrovat balik do Nette je pouzit DI extension:

```neon
extensions:
    sudoku: Sudoku\Config\Extension

sudoku:
    loadPath: %appDir%/data/sudoku/load
    savePath: %appDir%/data/sudoku/save
    stdOut: true
```

## Vyvoj a testovanie

Projekt obsahuje sadu nastrojov pre udrzanie kvality kodu:


### Staticka analyza (PHPStan)
```bash
composer phpstan
```

### Kontrola cistoty kodu (PHP CodeSniffer)
```bash
composer phpcodesniffer
```
### Unit testy (Nette Tester)
```bash
composer unit
```

### Pokrytie testov
```bash
composer cover
```
### Manualne testy
```bash
composer manual
```

## Licencia

Tento projekt je licencovany pod MIT licenciou.
