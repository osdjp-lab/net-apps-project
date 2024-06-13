<?php
require_once 'init.php';
// Rozszerzenia w aplikacji bazodanowej:
// - nowe pola dla konfiguracji połączenia z bazą danych w klasie Config
// - inicjalizacja połączenia z bazą w skrypcie init.php, za pomocą funkcji getDB() - podobnie jak dla wcześniejszych obiektów

// Do połączenia z bazą danych wykorzystujemy "maleńką" bibliotekę Medoo, która obudowuje standardowy obiekt PDO za pomocą klasy Medoo.
// Biblioteka Medoo ułatwia dostęp do bazy dla większości standardowych rodzajów zapytań, przez brak konieczności używania SQL'a.

// Jeżeli użytkownik chce jednak używać bezpośrednio PDO, to biblioteki używamy jedynie w celu połączenia z bazą, a później
// pobieramy obiekt PDO po połączeniu (metoda pdo() obiektu klasy Medoo).

getRouter()->setDefaultRoute('welcomePage'); // akcja/ścieżka domyślna
getRouter()->setLoginRoute('login'); // akcja/ścieżka na potrzeby logowania (przekierowanie, gdy nie ma dostępu)

getRouter()->addRoute('welcomePage',    'HomeCtrl');

getRouter()->addRoute('loginShow',		'LoginCtrl');
getRouter()->addRoute('login',			'LoginCtrl');
getRouter()->addRoute('logout',			'LoginCtrl');

// PersonList controls
getRouter()->addRoute('personList',		'PersonListCtrl');
getRouter()->addRoute('personNew',		'PersonEditCtrl',	['user','admin']);
getRouter()->addRoute('personEdit',		'PersonEditCtrl',	['user','admin']);
getRouter()->addRoute('personSave',		'PersonEditCtrl',	['user','admin']);
getRouter()->addRoute('personDelete',	'PersonEditCtrl',	['admin']);

// TreeList controls
getRouter()->addRoute('treeList',		'TreeListCtrl');
getRouter()->addRoute('treeNew',		'TreeEditCtrl',	['user','admin']);
getRouter()->addRoute('treeEdit',		'TreeEditCtrl',	['user','admin']);
getRouter()->addRoute('treeSave',		'TreeEditCtrl',	['user','admin']);
getRouter()->addRoute('treeDelete',	    'TreeEditCtrl',	['admin']);

// HerbList controls
getRouter()->addRoute('herbList',		'HerbListCtrl');
getRouter()->addRoute('herbNew',		'HerbEditCtrl',	['user','admin']);
getRouter()->addRoute('herbEdit',		'HerbEditCtrl',	['user','admin']);
getRouter()->addRoute('herbSave',		'HerbEditCtrl',	['user','admin']);
getRouter()->addRoute('herbDelete',	    'HerbEditCtrl',	['admin']);

getRouter()->go();
