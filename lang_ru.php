<?php
// файл сообщений языкового пакета - РУССКИЙ (RUSSIAN) UTF-8 BOM
// Технология именования переменных:
// Всё имя переменной заглавными буквами
// Первое поле служебное и указывает на то что это переменная из языкового пакета - LANG
// Потом идёт символ подчёркивания - _
// Далее следует текст сообщения приведённый к допустимому виду используемых в переменных языка PHP заглавными буквами
// Затем снова может идти символ подчёркивания 
// Далее может следовать число от 0 до 99. Данное число необходимо, если в тексте попадаются сообщения с одинаковым 
// текстом, но в разных языках они могут обозначаться по разному.
// Например:
// $LANG_SEARCH_1 = 'Search';
// $LANG_MESS_1 = 'Text';

// Данные перенесены из файла strings.php
        $searchtip = "<p>Search in column Title, Author, Publisher, Series, Periodical</p>";
        $searchtip1 = "<p>Search in column MD5, Year, Extension, Language</p>";
	$str_prev = "&lt; &lt; &lt; ПРЕД";
	$str_next = "СЛЕД &gt; &gt; &gt;";
	$str_pp_ru = "стр.";
	$str_pp_en = "pp.";
	$str_edition_ru = "изд.";
	$str_edition_en = "ed.";
	$str_keywords = "eBooks,books,electronic library,library,science,tech,sci-tech,scientific literature,pdf,djvu,physics,medicine,biology,chemistry,geology,math,mathematics,engineering,computer,electrical engineering,электронные книги,электронная библиотека,KoLXo3,колхоз,библиотека колхоз,мехмат,mexmat,lmr,lib.mexmat.ru,homelab,хомлаб,спецхран,спец. хран.,Great Science Textbooks,техника,компьютеры,электротехника,электроника,физика,математика,химия,биология,геология,литература,электронная литература,open source,free ebooks,free books,ebook community,librarians";
// -- конец перенесенных данных


$LANG_GENESIS = 'Библиотека Генезис';
$LANG_DESCRIPTION = 'Библиотека Генезис является научным сообществом с целью коллекцинирования книг по естественным дисциплинам науке и технике.';
$LANG_SEARCH_0 = 'Поиск!';
$LANG_MESS_GB = 'Гб';
$LANG_MESS_MB = 'Мб';
$LANG_MESS_KB = 'кб';
$LANG_MESS_B = 'б';

$LANG_MESS_0 = 'Пакетный поиск для книг';
$LANG_MESS_1 = 'Тип скачивания:';
$LANG_MESS_2 = 'Оригинал';
$LANG_MESS_3 = 'Транслит';
$LANG_MESS_4 = 'Поиск по полям';
$LANG_MESS_5 = 'Название';
$LANG_MESS_6 = 'Автор';
$LANG_MESS_7 = 'Серия';
$LANG_MESS_8 = 'Периодика';
$LANG_MESS_9 = 'Издательство';
$LANG_MESS_10 = 'Год';
$LANG_MESS_11 = 'Язык';
$LANG_MESS_12 = 'Расширение';
$LANG_MESS_13 = 'Тема';
$LANG_MESS_14 = 'Ошибочный запрос';
$LANG_MESS_15 = 'Строка поиска должны содержать более 4 символов';
$LANG_MESS_16 = 'Пожалуйста, введите запрос и';
$LANG_MESS_17 = 'попробуйте ещё раз';
$LANG_MESS_18 = 'Поиск в DOI (напр. 10.1063/1.529338) или Автор+Заголовок, если не найдено - перенапр. на ';
$LANG_MESS_19 = 'Научные статьи';
$LANG_MESS_20 = 'Комиксы';
$LANG_MESS_21 = 'Иностранная <br>художественная литература';
$LANG_MESS_22 = 'книг найдено';
$LANG_MESS_22_5 = 'так же искать';
$LANG_MESS_23 = ' в разделах: ';
//$LANG_MESS_24 = 'Автор';
//$LANG_MESS_25 = 'Заголовок';
$LANG_MESS_26 = 'Размер';
//$LANG_MESS_27 = 'Год';
$LANG_MESS_28 = 'Стр.';
$LANG_MESS_29 = 'Зеркала';
$LANG_MESS_30 = 'Правка';
$LANG_MESS_31 = '';
$LANG_MESS_32 = 'Сортировать результаты по Автору';
$LANG_MESS_33 = 'Сортировать результаты по Названию';
$LANG_MESS_34 = 'Сортировать результаты по Издательству';
$LANG_MESS_35 = 'Сортировать результаты по Году';
$LANG_MESS_36 = 'Сортировать результаты по Страницам';
$LANG_MESS_37 = 'Сортировать результаты по Языку';
$LANG_MESS_38 = 'Сортировать результаты по Размеру';
$LANG_MESS_39 = 'Сортировать результаты по Расширению';
$LANG_MESS_40 = 'Логин:Пароль на форуме';
$LANG_MESS_41 = 'Скачать из ';
$LANG_MESS_42 = 'Том';
$LANG_MESS_43 = 'Издание';
$LANG_MESS_44 = 'Время добавления';
$LANG_MESS_45 = 'Время посл. ред.';
$LANG_MESS_46 = 'Библиотека';
$LANG_MESS_47 = 'Изд. библиотеки';
$LANG_MESS_48 = 'Худшая версия';
$LANG_MESS_49 = 'Старое опис.';
$LANG_MESS_50 = 'Техн. заметки';
$LANG_MESS_51 = 'Идентификаторы';
$LANG_MESS_52 = 'Параметры файла.';
$LANG_MESS_53 = 'Зеркала';
$LANG_MESS_54 = 'Редактировать';
$LANG_MESS_55 = 'Название журнала или ISSN';
$LANG_MESS_56 = 'Выпуск';
$LANG_MESS_57 = 'Статья';
$LANG_MESS_58 = 'Журнал';
$LANG_MESS_60 = 'Размер, кб';
$LANG_MESS_61 = 'Страниц';
$LANG_MESS_62 = 'Записи с';
$LANG_MESS_63 = 'по';
$LANG_MESS_64 = 'Пер.стр.';
$LANG_MESS_65 = 'Посл.стр.';
$LANG_MESS_66 = 'Месяц';
$LANG_MESS_67 = 'День';
$LANG_MESS_68 = 'из';
$LANG_MESS_69 = '(Печатн.)';
$LANG_MESS_70 = '(Электрон.)';
$LANG_MESS_71 = 'Все ссылки';
$LANG_MESS_72 = 'Описание';
$LANG_MESS_73 = 'Обложка';
$LANG_MESS_74 = 'Дата добавления';
$LANG_MESS_75 = 'Ссылки на закачку';
$LANG_MESS_76 = 'Искать на языке';
$LANG_MESS_77 = 'Найдено';
$LANG_MESS_78 = 'Укажите прямую ссылку для загрузки (макс. 200 Мб, мин. 50кБ, если возможно без *.rar, *.zip)';
$LANG_MESS_79 = 'Выберите файл для загрузки:';
$LANG_MESS_80 = 'Рассчитывает MD5 после завершения загрузки';
$LANG_MESS_81 = 'Помогает избежать нагрузки если книга есть в БД';
$LANG_MESS_82 = 'Журналы загружаем сюда';
$LANG_MESS_83 = 'Художественную литературу загружаем сюда';
$LANG_MESS_400 = 'Научные статьи загружаем сюда';
$LANG_MESS_84 = 'Перед загрузкой';
$LANG_MESS_85 = 'проверьте';
$LANG_MESS_86 = ', нет ли книги в библиотеке';
$LANG_MESS_87 = 'Library Genesis это не художественная литература.';
$LANG_MESS_88 = 'Отправить!';
$LANG_MESS_89 = 'Проверить';
$LANG_MESS_90 = 'Вы можете предварительно залить файл на наш';
$LANG_MESS_91 = 'Ввведите MD5 для просмотра записи в  БД';

$LANG_MESS_92 = 'Имя файла';
$LANG_MESS_93 = 'Место изд.';
$LANG_MESS_94 = 'Ориентация скана';
$LANG_MESS_95 = 'Закладки';
$LANG_MESS_96 = 'Сканированный';
$LANG_MESS_97 = 'Обрезанный';
$LANG_MESS_98 = 'Цветной';
$LANG_MESS_99 = 'ББК';
$LANG_MESS_100 = 'УДК';
$LANG_MESS_101 = 'Обложка';
$LANG_MESS_102 = 'MD5 лучшей версии';
$LANG_MESS_103 = 'Описание';
$LANG_MESS_104 = 'Зарегистрировать!';
$LANG_MESS_105 = 'На зеркалах появится после <br>синхронизации БД и репозитория';
$LANG_MESS_106 = 'Editing an existing record';
$LANG_MESS_107 = 'Искать ISBNs в текстовом слое:';
$LANG_MESS_108 = 'искать в:';
$LANG_MESS_109 = 'Введите ISBN или ID:';
$LANG_MESS_110 = 'MD5 хеш или ID из LibGen DB';
$LANG_MESS_111 = 'напр.:';
$LANG_MESS_112 = 'РНБ';
$LANG_MESS_113 = 'РГБ';
$LANG_MESS_114 = 'Получить метаданные из Базы данных LibGen';
$LANG_MESS_115 = 'с';
$LANG_MESS_116 = 'Редактирование существующей записи';
$LANG_MESS_117 = 'Добавление новой книги';
$LANG_MESS_118 = 'Том или год';

$LANG_MESS_119 = 'Библиографический пакетный поиск';
$LANG_MESS_120 = 'Введите строки (максимум 50)';
$LANG_MESS_121 = 'Транслитерировать';
$LANG_MESS_122 = 'Удалить расширение';
$LANG_MESS_123 = 'Убрать слова в скобках';
$LANG_MESS_124 = 'Убрать из строки слова(перечислить через ,)';
$LANG_MESS_125 = 'Где ищем (По ISBN, SiteID, Наз.+Авт.+Год+Изд.)';
$LANG_MESS_126 = 'Формат вывода результатов';
$LANG_MESS_127 = 'В строку';
$LANG_MESS_128 = 'Форматированный';
$LANG_MESS_129 = 'Убрать из строки слова =&lt; N букв';
$LANG_MESS_130 = 'Искать только MD5 хеш (по 1 MD5 в строке)';
$LANG_MESS_131 = 'Искать только ISBN (по 1 ISBN в строке)';

$LANG_MESS_132 = "<OPTION></OPTION>
<OPTION VALUE='English'>Английский</OPTION>
<OPTION VALUE='Russian'>Русский</OPTION>
<OPTION VALUE='Ukrainian'>Украинский</OPTION>
<OPTION VALUE='German'>Немецкий</OPTION>
<OPTION VALUE='French'>Французский</OPTION>
<OPTION VALUE='Italian'>Итальянский</OPTION>
<OPTION VALUE='Japanese'>Японский</OPTION>
<OPTION VALUE='Spanish'>Испанский</OPTION>
<OPTION VALUE='Portuguese'>Португальский</OPTION>
<OPTION VALUE='Latin'>Латинский</OPTION>
<OPTION VALUE='Czech'>Чешский</OPTION>
<OPTION VALUE='Bulgarian'>Болгарский</OPTION>
<OPTION VALUE='Russian (Old)'>Старо-русский</OPTION>
<OPTION VALUE=''></OPTION>
<OPTION VALUE='Abkhaz'>Абхазский</OPTION>
<OPTION VALUE='Afar'>Афар</OPTION>
<OPTION VALUE='Afrikaans'>Африкаанс</OPTION>
<OPTION VALUE='Akan'>Акан</OPTION>
<OPTION VALUE='Albanian'>Албанский</OPTION>
<OPTION VALUE='Amharic'>Амхарский</OPTION>
<OPTION VALUE='Arabic'>Арабский</OPTION>
<OPTION VALUE='Aragonese'>Арагонский</OPTION>
<OPTION VALUE='Armenian'>Армянский</OPTION>
<OPTION VALUE='Assamese'>Ассамский</OPTION>
<OPTION VALUE='Avaric'>Аравийский</OPTION>
<OPTION VALUE='Avestan'>Авестийский</OPTION>
<OPTION VALUE='Aymara'>Аймара</OPTION>
<OPTION VALUE='Azerbaijani'>Азербайджанский</OPTION>
<OPTION VALUE='Bambara'>Бамбара</OPTION>
<OPTION VALUE='Bashkir'>Башкирский</OPTION>
<OPTION VALUE='Basque'>Баскский</OPTION>
<OPTION VALUE='Belarusian'>Белорусский</OPTION>
<OPTION VALUE='Bengali'>Бенгальский</OPTION>
<OPTION VALUE='Bihari'>Бихари</OPTION>
<OPTION VALUE='Bislama'>Бислама</OPTION>
<OPTION VALUE='Bosnian'>Боснийский</OPTION>
<OPTION VALUE='Breton'>Бретонский</OPTION>
<OPTION VALUE='Burmese'>Бирманский</OPTION>
<OPTION VALUE='Catalan'>Каталонский</OPTION>
<OPTION VALUE='Chamorro'>Чаморро</OPTION>
<OPTION VALUE='Chechen'>Чеченский</OPTION>
<OPTION VALUE='Chichewa'>Чичева</OPTION>
<OPTION VALUE='Chinese'>Китайские</OPTION>
<OPTION VALUE='Chuvash'>Чувашский</OPTION>
<OPTION VALUE='Cornish'>Корниш</OPTION>
<OPTION VALUE='Corsican'>Корсиканский</OPTION>
<OPTION VALUE='Cree'>Мэнский</OPTION>
<OPTION VALUE='Croatian'>Хорватская</OPTION>
<OPTION VALUE='Danish'>Датскомах</OPTION>
<OPTION VALUE='Divehi'>Дивехи</OPTION>
<OPTION VALUE='Dutch'>Голландский</OPTION>
<OPTION VALUE='Dzongkha'>Дзонг-кэ</OPTION>
<OPTION VALUE='Esperanto'>Эсперанто</OPTION>
<OPTION VALUE='Estonian'>Эстонский</OPTION>
<OPTION VALUE='Ewe'>Эве</OPTION>
<OPTION VALUE='Faroese'>Фарерский</OPTION>
<OPTION VALUE='Fijian'>Фиджийский</OPTION>
<OPTION VALUE='Finnish'>Финскомах</OPTION>
<OPTION VALUE='Fula'>Фула</OPTION>
<OPTION VALUE='Galician'>Галисийский</OPTION>
<OPTION VALUE='Georgian'>Грузинский</OPTION>
<OPTION VALUE='Greek'>Греческий</OPTION>
<OPTION VALUE='Guaraní'>Гуарани</OPTION>
<OPTION VALUE='Gujarati'>Гуджарати</OPTION>
<OPTION VALUE='Haitian'>Гаитянский</OPTION>
<OPTION VALUE='Hausa'>Хауса</OPTION>
<OPTION VALUE='Hebrew'>Еврейский</OPTION>
<OPTION VALUE='Herero'>Гереро</OPTION>
<OPTION VALUE='Hindi'>Хинди</OPTION>
<OPTION VALUE='Hiri Motu'>Хири Моту</OPTION>
<OPTION VALUE='Hungarian'>Венгерские</OPTION>
<OPTION VALUE='Interlingua'>Интерлингва</OPTION>
<OPTION VALUE='Indonesian'>Индонезийский</OPTION>
<OPTION VALUE='Interlingue'>Интерлингва</OPTION>
<OPTION VALUE='Irish'>Ирландский</OPTION>
<OPTION VALUE='Igbo'>Игбо</OPTION>
<OPTION VALUE='Inupiaq'>Инупиак</OPTION>
<OPTION VALUE='Ido'>Идо</OPTION>
<OPTION VALUE='Icelandic'>Исландские</OPTION>
<OPTION VALUE='Inuktitut'>Инуктитут</OPTION>
<OPTION VALUE='Javanese'>Яванский</OPTION>
<OPTION VALUE='Kalaallisut'>Гренландский</OPTION>
<OPTION VALUE='Kannada'>Каннадаах</OPTION>
<OPTION VALUE='Kanuri'>Канури</OPTION>
<OPTION VALUE='Kashmiri'>Кашмирский</OPTION>
<OPTION VALUE='Kazakh'>Казахский</OPTION>
<OPTION VALUE='Khmer'>Кхмерский</OPTION>
<OPTION VALUE='Kikuyu'>Кикуйю</OPTION>
<OPTION VALUE='Kinyarwanda'>Киньяруандаах</OPTION>
<OPTION VALUE='Kyrgyz'>Кыргызский</OPTION>
<OPTION VALUE='Komi'>Коми</OPTION>
<OPTION VALUE='Kongo'>Конго</OPTION>
<OPTION VALUE='Korean'>Корейский</OPTION>
<OPTION VALUE='Kurdish'>Курдский</OPTION>
<OPTION VALUE='Kwanyama'>Кваньяма</OPTION>
<OPTION VALUE='Luxembourgish'>Люксембургский</OPTION>
<OPTION VALUE='Ganda'>Ганда</OPTION>
<OPTION VALUE='Limburgish'>Лимбургский</OPTION>
<OPTION VALUE='Lingala'>Лингала</OPTION>
<OPTION VALUE='Lao'>Лао</OPTION>
<OPTION VALUE='Lithuanian'>Литовский</OPTION>
<OPTION VALUE='Luba-Katanga'>Люба-Катанга</OPTION>
<OPTION VALUE='Latvian'>Латвийский</OPTION>
<OPTION VALUE='Manx'>Manx</OPTION>
<OPTION VALUE='Macedonian'>Македонская</OPTION>
<OPTION VALUE='Malagasy'>Малагасийский</OPTION>
<OPTION VALUE='Malay'>Малайский</OPTION>
<OPTION VALUE='Malayalam'>Малаяламах</OPTION>
<OPTION VALUE='Maltese'>Мальтийский</OPTION>
<OPTION VALUE='Māori'>Маори</OPTION>
<OPTION VALUE='Marathi'>Маратхи</OPTION>
<OPTION VALUE='Marshallese'>Маршальский</OPTION>
<OPTION VALUE='Mongolian'>Монгольский</OPTION>
<OPTION VALUE='Nauru'>Науру</OPTION>
<OPTION VALUE='Navajo'>Наваджо</OPTION>
<OPTION VALUE='Norwegian Bokmål'>Норвежский</OPTION>
<OPTION VALUE='North Ndebele'>Северная ндебеле</OPTION>
<OPTION VALUE='Nepali'>Непальский</OPTION>
<OPTION VALUE='Ndonga'>Ндонга</OPTION>
<OPTION VALUE='Norwegian Nynorsk'>Норвежский нюнорск</OPTION>
<OPTION VALUE='Norwegian'>Норвежские</OPTION>
<OPTION VALUE='Nuosu'>Носу</OPTION>
<OPTION VALUE='South Ndebele'>Южный ндебеле</OPTION>
<OPTION VALUE='Occitan'>Окситанский</OPTION>
<OPTION VALUE='Ojibwe'>Оджибве</OPTION>
<OPTION VALUE='Old Church Slavonic'>Старославянский</OPTION>
<OPTION VALUE='Oromo'>Оромо</OPTION>
<OPTION VALUE='Oriya'>Ория</OPTION>
<OPTION VALUE='Ossetian'>Осетинский</OPTION>
<OPTION VALUE='Panjabi'>Панжаби</OPTION>
<OPTION VALUE='Pāli'>Пали</OPTION>
<OPTION VALUE='Persian'>Персидский</OPTION>
<OPTION VALUE='Polish'>Польскомах</OPTION>
<OPTION VALUE='Pashto'>Пушту</OPTION>
<OPTION VALUE='Portuguese'>Португальский</OPTION>
<OPTION VALUE='Quechua'>Кечуа</OPTION>
<OPTION VALUE='Romansh'>Ретороманский</OPTION>
<OPTION VALUE='Kirundi'>Кирунди</OPTION>
<OPTION VALUE='Romanian'>Румынские</OPTION>
<OPTION VALUE='Sanskrit'>Санскрит</OPTION>
<OPTION VALUE='Sardinian'>Сардинский</OPTION>
<OPTION VALUE='Sindhi'>Синдхи</OPTION>
<OPTION VALUE='Northern Sami'>Северная Сами</OPTION>
<OPTION VALUE='Samoan'>Самоа</OPTION>
<OPTION VALUE='Sango'>Санго</OPTION>
<OPTION VALUE='Serbian'>Сербский</OPTION>
<OPTION VALUE='Scottish Gaelic'>Шотландский</OPTION>
<OPTION VALUE='Shona'>Шона</OPTION>
<OPTION VALUE='Sinhala'>Сингальский</OPTION>
<OPTION VALUE='Slovak'>Словацкий</OPTION>
<OPTION VALUE='Slovene'>Словенскомах</OPTION>
<OPTION VALUE='Somali'>Сомалийский</OPTION>
<OPTION VALUE='Southern Sotho'>Сесото</OPTION>
<OPTION VALUE='Sundanese'>Суданский</OPTION>
<OPTION VALUE='Swahili'>Суахили</OPTION>
<OPTION VALUE='Swati'>Swati</OPTION>
<OPTION VALUE='Swedish'>Шведские</OPTION>
<OPTION VALUE='Tamil'>Тамильскомах</OPTION>
<OPTION VALUE='Telugu'>Телугу</OPTION>
<OPTION VALUE='Tajik'>Таджикский</OPTION>
<OPTION VALUE='Thai'>Тайский</OPTION>
<OPTION VALUE='Tigrinya'>Тигринья</OPTION>
<OPTION VALUE='Tibetan Standard'>Тибетский Станд.</OPTION>
<OPTION VALUE='Turkmen'>Туркменский</OPTION>
<OPTION VALUE='Tagalog'>Тагальский</OPTION>
<OPTION VALUE='Tswana'>Тсвана</OPTION>
<OPTION VALUE='Tonga'>Тонга</OPTION>
<OPTION VALUE='Turkish'>Турецкие</OPTION>
<OPTION VALUE='Tsonga'>Тсонга</OPTION>
<OPTION VALUE='Tatar'>Татарскомах</OPTION>
<OPTION VALUE='Twi'>Тви</OPTION>
<OPTION VALUE='Tahitian'>Тайский</OPTION>
<OPTION VALUE='Uighur'>Уйгурский</OPTION>
<OPTION VALUE='Urdu'>Урдуах</OPTION>
<OPTION VALUE='Uzbek'>Узбекский</OPTION>
<OPTION VALUE='Venda'>Венда</OPTION>
<OPTION VALUE='Vietnamese'>Вьетнамскомах</OPTION>
<OPTION VALUE='Volapük'>Волапюк</OPTION>
<OPTION VALUE='Walloon'>Валлония</OPTION>
<OPTION VALUE='Welsh'>Валлийский</OPTION>
<OPTION VALUE='Wolof'>Волоф</OPTION>
<OPTION VALUE='Western Frisian'>Западные Фризские</OPTION>
<OPTION VALUE='Xhosa'>Коса</OPTION>
<OPTION VALUE='Yiddish'>Идиш</OPTION>
<OPTION VALUE='Yoruba'>Йоруба</OPTION>
<OPTION VALUE='Zhuang'>Чжуанский</OPTION>
<OPTION VALUE='Zulu'>Зулу</OPTION>";

$LANG_MESS_133 = "<OPTION>                                                                                   </OPTION>
<OPTION VALUE='1'>Бизнес</OPTION>
<OPTION VALUE='2'>Бизнес\\Бухгалтерский учет</OPTION>
<OPTION VALUE='3'>Бизнес\\Логистика</OPTION>
<OPTION VALUE='4'>Бизнес\\Маркетинг</OPTION>
<OPTION VALUE='5'>Бизнес\\Маркетинг: Реклама</OPTION>
<OPTION VALUE='6'>Бизнес\\менеджмент</OPTION>
<OPTION VALUE='7'>Бизнес\\Менеджмент: Управление проектами</OPTION>
<OPTION VALUE='8'>Бизнес\\МЛМ</OPTION>
<OPTION VALUE='9'>Бизнес\\Ответственность и этика бизнеса</OPTION>
<OPTION VALUE='10'>Бизнес\\Трейдинг</OPTION>
<OPTION VALUE='11'>Бизнес\\Электронная коммерция</OPTION>
<OPTION VALUE='12'>Биология</OPTION>
<OPTION VALUE='13'>Биология\\Eстествознанание</OPTION>
<OPTION VALUE='14'>Биология\\Антропология</OPTION>
<OPTION VALUE='15'>Биология\\Антропология: Теория эволюции</OPTION>
<OPTION VALUE='16'>Биология\\Биостатистика</OPTION>
<OPTION VALUE='17'>Биология\\Биотехнология</OPTION>
<OPTION VALUE='18'>Биология\\Биофизика</OPTION>
<OPTION VALUE='19'>Биология\\Биохимия</OPTION>
<OPTION VALUE='20'>Биология\\Биохимия: Ферментология</OPTION>
<OPTION VALUE='21'>Биология\\Вирусология</OPTION>
<OPTION VALUE='22'>Биология\\Генетика</OPTION>
<OPTION VALUE='23'>Биология\\Зоология</OPTION>
<OPTION VALUE='24'>Биология\\Зоология: Палеонтология</OPTION>
<OPTION VALUE='25'>Биология\\Зоология: Рыбы</OPTION>
<OPTION VALUE='26'>Биология\\Микробиология</OPTION>
<OPTION VALUE='27'>Биология\\Молекулярная</OPTION>
<OPTION VALUE='28'>Биология\\Молекулярная: Биоинформатика</OPTION>
<OPTION VALUE='29'>Биология\\Растения: Ботаника</OPTION>
<OPTION VALUE='30'>Биология\\Растения: Сельское и лесное хозяйство</OPTION>
<OPTION VALUE='31'>Биология\\Экология</OPTION>
<OPTION VALUE='32'>География</OPTION>
<OPTION VALUE='33'>География\\Геодезия. Картография</OPTION>
<OPTION VALUE='34'>География\\Краеведение</OPTION>
<OPTION VALUE='35'>География\\Краеведение: Туризм</OPTION>
<OPTION VALUE='36'>География\\Метеорология, Климатология</OPTION>
<OPTION VALUE='37'>География\\Россия</OPTION>
<OPTION VALUE='38'>Геология</OPTION>
<OPTION VALUE='39'>Геология\\Гидрогеология</OPTION>
<OPTION VALUE='40'>Геология\\Горное дело</OPTION>
<OPTION VALUE='41'>Домоводство, досуг</OPTION>
<OPTION VALUE='42'>Домоводство, досуг\\Аквариумистика</OPTION>
<OPTION VALUE='43'>Домоводство, досуг\\Астрология</OPTION>
<OPTION VALUE='44'>Домоводство, досуг\\Домашние питомцы</OPTION>
<OPTION VALUE='45'>Домоводство, досуг\\Игры: Карточные игры</OPTION>
<OPTION VALUE='46'>Домоводство, досуг\\Игры: Шахматы</OPTION>
<OPTION VALUE='47'>Домоводство, досуг\\Коллекционирование</OPTION>
<OPTION VALUE='48'>Домоводство, досуг\\Красота, имидж</OPTION>
<OPTION VALUE='49'>Домоводство, досуг\\Кулинария</OPTION>
<OPTION VALUE='50'>Домоводство, досуг\\Мода, украшения</OPTION>
<OPTION VALUE='51'>Домоводство, досуг\\Охота и охотничье хозяйство</OPTION>
<OPTION VALUE='52'>Домоводство, досуг\\Пособия самодельщикам</OPTION>
<OPTION VALUE='53'>Домоводство, досуг\\Профессии и ремесла</OPTION>
<OPTION VALUE='54'>Домоводство, досуг\\Рукоделие</OPTION>
<OPTION VALUE='55'>Домоводство, досуг\\Рукоделие: Кройка и шитье</OPTION>
<OPTION VALUE='56'>Домоводство, досуг\\Сад, огород</OPTION>
<OPTION VALUE='57'>Искусство</OPTION>
<OPTION VALUE='58'>Искусство\\Архитектура</OPTION>
<OPTION VALUE='59'>Искусство\\Графические виды искусства</OPTION>
<OPTION VALUE='60'>Искусство\\Кинематография</OPTION>
<OPTION VALUE='61'>Искусство\\Музыка</OPTION>
<OPTION VALUE='62'>Искусство\\Музыка: Гитара</OPTION>
<OPTION VALUE='63'>Искусство\\Фотография</OPTION>
<OPTION VALUE='64'>История</OPTION>
<OPTION VALUE='65'>История\\Американистика</OPTION>
<OPTION VALUE='66'>История\\Археология</OPTION>
<OPTION VALUE='67'>История\\Военная история</OPTION>
<OPTION VALUE='68'>История\\Мемуары, Биографии</OPTION>
<OPTION VALUE='69'>Компьютеры</OPTION>
<OPTION VALUE='70'>Компьютеры\\Web-дизайн</OPTION>
<OPTION VALUE='71'>Компьютеры\\Алгоритмы и структуры данных</OPTION>
<OPTION VALUE='72'>Компьютеры\\Алгоритмы и структуры данных: Криптография</OPTION>
<OPTION VALUE='73'>Компьютеры\\Алгоритмы и структуры данных: Обработка изображений</OPTION>
<OPTION VALUE='74'>Компьютеры\\Алгоритмы и структуры данных: Распознавание образов</OPTION>
<OPTION VALUE='75'>Компьютеры\\Алгоритмы и структуры данных: Цифровые водяные знаки</OPTION>
<OPTION VALUE='76'>Компьютеры\\Базы данных</OPTION>
<OPTION VALUE='77'>Компьютеры\\Безопасность</OPTION>
<OPTION VALUE='78'>Компьютеры\\Информационные системы</OPTION>
<OPTION VALUE='79'>Компьютеры\\Информационные системы: ИС предприятий</OPTION>
<OPTION VALUE='80'>Компьютеры\\Кибернетика</OPTION>
<OPTION VALUE='81'>Компьютеры\\Кибернетика: Искусственный интеллект</OPTION>
<OPTION VALUE='82'>Компьютеры\\Криптография</OPTION>
<OPTION VALUE='83'>Компьютеры\\Лекции, монографии</OPTION>
<OPTION VALUE='84'>Компьютеры\\Мультимедиа</OPTION>
<OPTION VALUE='85'>Компьютеры\\Операционные системы</OPTION>
<OPTION VALUE='86'>Компьютеры\\Организация и обработка данных</OPTION>
<OPTION VALUE='87'>Компьютеры\\Программирование</OPTION>
<OPTION VALUE='88'>Компьютеры\\Программирование: Библиотеки API</OPTION>
<OPTION VALUE='89'>Компьютеры\\Программирование: Игры</OPTION>
<OPTION VALUE='90'>Компьютеры\\Программирование: Компиляторы</OPTION>
<OPTION VALUE='91'>Компьютеры\\Программирование: Языки моделирования</OPTION>
<OPTION VALUE='92'>Компьютеры\\Программирование: Языки программирования</OPTION>
<OPTION VALUE='93'>Компьютеры\\Программы: TeX, LaTeX</OPTION>
<OPTION VALUE='94'>Компьютеры\\Программы: Офисные программы</OPTION>
<OPTION VALUE='95'>Компьютеры\\Программы: Продукты Adobe</OPTION>
<OPTION VALUE='96'>Компьютеры\\Программы: Продукты Macromedia</OPTION>
<OPTION VALUE='97'>Компьютеры\\Программы: САПР</OPTION>
<OPTION VALUE='98'>Компьютеры\\Программы: Системы научных расчетов</OPTION>
<OPTION VALUE='99'>Компьютеры\\Сети</OPTION>
<OPTION VALUE='100'>Компьютеры\\Сети: Интернет</OPTION>
<OPTION VALUE='101'>Компьютеры\\Системное администрирование</OPTION>
<OPTION VALUE='102'>Литература</OPTION>
<OPTION VALUE='103'>Литература\\Беллетристика</OPTION>
<OPTION VALUE='104'>Литература\\Библиотечное дело</OPTION>
<OPTION VALUE='105'>Литература\\Детектив</OPTION>
<OPTION VALUE='106'>Литература\\Детская</OPTION>
<OPTION VALUE='107'>Литература\\Комиксы</OPTION>
<OPTION VALUE='108'>Литература\\Литературоведение</OPTION>
<OPTION VALUE='109'>Литература\\Поэзия</OPTION>
<OPTION VALUE='110'>Литература\\Проза</OPTION>
<OPTION VALUE='111'>Литература\\Фольклор</OPTION>
<OPTION VALUE='112'>Литература\\Фэнтази</OPTION>
<OPTION VALUE='113'>Математика</OPTION>
<OPTION VALUE='114'>Математика\\Алгебра</OPTION>
<OPTION VALUE='115'>Математика\\Алгебра: Линейная алгебра</OPTION>
<OPTION VALUE='116'>Математика\\Алгоритмы и структуры данных</OPTION>
<OPTION VALUE='117'>Математика\\Анализ</OPTION>
<OPTION VALUE='118'>Математика\\Вейвлеты,обработка сигналов</OPTION>
<OPTION VALUE='119'>Математика\\Вероятность</OPTION>
<OPTION VALUE='120'>Математика\\Вычислительная математика</OPTION>
<OPTION VALUE='121'>Математика\\Геометрия и топология</OPTION>
<OPTION VALUE='122'>Математика\\Головоломки</OPTION>
<OPTION VALUE='123'>Математика\\Динамические системы</OPTION>
<OPTION VALUE='124'>Математика\\Дискретная математика</OPTION>
<OPTION VALUE='125'>Математика\\Дифференциальные уравнения</OPTION>
<OPTION VALUE='126'>Математика\\Комбинаторика</OPTION>
<OPTION VALUE='127'>Математика\\Комплексная переменная</OPTION>
<OPTION VALUE='128'>Математика\\Компьютерная алгебра</OPTION>
<OPTION VALUE='129'>Математика\\Лекции</OPTION>
<OPTION VALUE='130'>Математика\\Математическая логика</OPTION>
<OPTION VALUE='131'>Математика\\Математическая статистика</OPTION>
<OPTION VALUE='132'>Математика\\Математическая физика</OPTION>
<OPTION VALUE='133'>Математика\\Непрерывные дроби</OPTION>
<OPTION VALUE='134'>Математика\\Нечеткая логика и приложения</OPTION>
<OPTION VALUE='135'>Математика\\Оптимальное управление</OPTION>
<OPTION VALUE='136'>Математика\\Оптимизация. Исследование операций.</OPTION>
<OPTION VALUE='137'>Математика\\Прикладная математика</OPTION>
<OPTION VALUE='138'>Математика\\Симметрия и группы</OPTION>
<OPTION VALUE='139'>Математика\\Теория автоматического управления</OPTION>
<OPTION VALUE='140'>Математика\\Теория графов</OPTION>
<OPTION VALUE='141'>Математика\\Теория игр</OPTION>
<OPTION VALUE='142'>Математика\\Теория операторов</OPTION>
<OPTION VALUE='143'>Математика\\Теория чисел</OPTION>
<OPTION VALUE='144'>Математика\\Функциональный анализ</OPTION>
<OPTION VALUE='145'>Математика\\Численные методы</OPTION>
<OPTION VALUE='146'>Математика\\Элементарный уровень</OPTION>
<OPTION VALUE='147'>Медицина</OPTION>
<OPTION VALUE='148'>Медицина\\Анатомия и физиология человека</OPTION>
<OPTION VALUE='149'>Медицина\\Анестезиология и интенсивная терапия</OPTION>
<OPTION VALUE='150'>Медицина\\Болезни</OPTION>
<OPTION VALUE='151'>Медицина\\Болезни: Внутренние болезни</OPTION>
<OPTION VALUE='152'>Медицина\\Гистология</OPTION>
<OPTION VALUE='153'>Медицина\\Гомеопатия</OPTION>
<OPTION VALUE='154'>Медицина\\Дерматология</OPTION>
<OPTION VALUE='155'>Медицина\\Диабет</OPTION>
<OPTION VALUE='156'>Медицина\\Иммунология</OPTION>
<OPTION VALUE='157'>Медицина\\Инфекционные болезни</OPTION>
<OPTION VALUE='158'>Медицина\\Йога</OPTION>
<OPTION VALUE='159'>Медицина\\Кардиология</OPTION>
<OPTION VALUE='160'>Медицина\\Китайская медицина</OPTION>
<OPTION VALUE='161'>Медицина\\Клиническая медицина</OPTION>
<OPTION VALUE='162'>Медицина\\Молекулярная медицина</OPTION>
<OPTION VALUE='163'>МЕдицина\\Натуральная медицина</OPTION>
<OPTION VALUE='164'>Медицина\\Научно-популярная литература</OPTION>
<OPTION VALUE='165'>Медицина\\Неврология</OPTION>
<OPTION VALUE='166'>Медицина\\Онкология</OPTION>
<OPTION VALUE='167'>Медицина\\Оториноларингология</OPTION>
<OPTION VALUE='168'>Медицина\\Офтальмология</OPTION>
<OPTION VALUE='169'>Медицина\\Педиатрия</OPTION>
<OPTION VALUE='170'>Медицина\\Стоматология, ортодонтия</OPTION>
<OPTION VALUE='171'>Медицина\\Судебная</OPTION>
<OPTION VALUE='172'>Медицина\\Терапия</OPTION>
<OPTION VALUE='173'>Медицина\\Фармакология</OPTION>
<OPTION VALUE='174'>Медицина\\Фэн-шуй</OPTION>
<OPTION VALUE='175'>Медицина\\Хирургия, Ортопедия</OPTION>
<OPTION VALUE='176'>Медицина\\Эндокринология</OPTION>
<OPTION VALUE='177'>Медицина\\Эпидемиология</OPTION>
<OPTION VALUE='178'>Наука (общее)</OPTION>
<OPTION VALUE='179'>Наука (общее)\\Международные конференции и симпозиумы</OPTION>
<OPTION VALUE='180'>Наука (общее)\\Науковедение</OPTION>
<OPTION VALUE='181'>Наука (общее)\\Научно-популярное</OPTION>
<OPTION VALUE='182'>Наука (общее)\\Научно-популярное: Публицистика</OPTION>
<OPTION VALUE='183'>Образование</OPTION>
<OPTION VALUE='184'>Образование\\Диссертации авторефераты</OPTION>
<OPTION VALUE='185'>Образование\\Международные конференции и симпозиумы</OPTION>
<OPTION VALUE='186'>Образование\\Самоучители</OPTION>
<OPTION VALUE='187'>Образование\\Элементарный уровень</OPTION>
<OPTION VALUE='188'>Образование\\Энциклопедии</OPTION>
<OPTION VALUE='189'>Общественные науки прочие</OPTION>
<OPTION VALUE='190'>Общественные науки прочие\\Журналистика, СМИ</OPTION>
<OPTION VALUE='191'>Общественные науки прочие\\Культурология</OPTION>
<OPTION VALUE='192'>Общественные науки прочие\\Политика</OPTION>
<OPTION VALUE='193'>Общественные науки прочие\\Политика: Международные отношения</OPTION>
<OPTION VALUE='194'>Общественные науки прочие\\Социология</OPTION>
<OPTION VALUE='195'>Общественные науки прочие\\Философия</OPTION>
<OPTION VALUE='196'>Общественные науки прочие\\Философия: Критическое мышление</OPTION>
<OPTION VALUE='197'>Общественные науки прочие\\Этнография</OPTION>
<OPTION VALUE='198'>Психология</OPTION>
<OPTION VALUE='199'>Психология\\Гипноз</OPTION>
<OPTION VALUE='200'>Психология\\Искусство общения</OPTION>
<OPTION VALUE='201'>Психология\\Любовь, эротика</OPTION>
<OPTION VALUE='202'>Психология\\Нейро-лингвистическое программирование</OPTION>
<OPTION VALUE='203'>Психология\\Педагогика</OPTION>
<OPTION VALUE='204'>Психология\\Творческое мышление</OPTION>
<OPTION VALUE='205'>Религия</OPTION>
<OPTION VALUE='206'>Религия\\Буддизм</OPTION>
<OPTION VALUE='207'>Религия\\Каббалистика</OPTION>
<OPTION VALUE='208'>Религия\\Православие</OPTION>
<OPTION VALUE='209'>Религия\\Эзотерика, мистика</OPTION>
<OPTION VALUE='210'>Техника</OPTION>
<OPTION VALUE='211'>Техника\\Автоматизация</OPTION>
<OPTION VALUE='212'>Техника\\Аэрокосмическое оборудование</OPTION>
<OPTION VALUE='213'>Техника\\Водоочистка</OPTION>
<OPTION VALUE='214'>Техника\\Военная техника</OPTION>
<OPTION VALUE='215'>Техника\\Военная техника: Оружие</OPTION>
<OPTION VALUE='216'>Техника\\Издательское дело</OPTION>
<OPTION VALUE='217'>Техника\\Космические исследования</OPTION>
<OPTION VALUE='218'>Техника\\Легкая промышленность</OPTION>
<OPTION VALUE='219'>Техника\\Материаловедение</OPTION>
<OPTION VALUE='220'>Техника\\Машиностроение</OPTION>
<OPTION VALUE='221'>Техника\\Металлургия</OPTION>
<OPTION VALUE='222'>Техника\\Метрология</OPTION>
<OPTION VALUE='223'>Техника\\Надежность и безопасность</OPTION>
<OPTION VALUE='224'>Техника\\Нанотехнологии</OPTION>
<OPTION VALUE='225'>Техника\\Нефтегазовые технологии</OPTION>
<OPTION VALUE='226'>Техника\\Нефтегазовые технологии: Трубопроводы</OPTION>
<OPTION VALUE='227'>Техника\\Нормативная литература</OPTION>
<OPTION VALUE='228'>Техника\\Патентное дело. Изобретательство. Рационализаторство</OPTION>
<OPTION VALUE='229'>Техника\\Пищевые производства</OPTION>
<OPTION VALUE='230'>Техника\\Приборостроение</OPTION>
<OPTION VALUE='231'>Техника\\Промышленность: Металлургия</OPTION>
<OPTION VALUE='232'>Техника\\Промышленое оборудование и технологии</OPTION>
<OPTION VALUE='233'>Техника\\Ракетная техника</OPTION>
<OPTION VALUE='234'>Техника\\Связь</OPTION>
<OPTION VALUE='235'>Техника\\Связь: Телекоммуникации</OPTION>
<OPTION VALUE='236'>Техника\\Строительство</OPTION>
<OPTION VALUE='237'>Техника\\Строительство</OPTION>
<OPTION VALUE='238'>Техника\\Строительство: Вентиляция и кондиционирование</OPTION>
<OPTION VALUE='239'>Техника\\Строительство: Ремонт и дизайн помещений</OPTION>
<OPTION VALUE='240'>Техника\\Строительство: Ремонт и дизайн помещений: Бани и сауны</OPTION>
<OPTION VALUE='241'>Техника\\Строительство: Цементная промышленность</OPTION>
<OPTION VALUE='242'>Техника\\Теплотехника</OPTION>
<OPTION VALUE='243'>Техника\\Топливные технологии</OPTION>
<OPTION VALUE='244'>Техника\\Транспорт</OPTION>
<OPTION VALUE='245'>Техника\\Транспорт: Авиация</OPTION>
<OPTION VALUE='246'>Техника\\Транспорт: Автомобили, мотоциклы</OPTION>
<OPTION VALUE='247'>Техника\\Транспорт: Железнодорожный транспорт</OPTION>
<OPTION VALUE='248'>Техника\\Транспорт: Корабли</OPTION>
<OPTION VALUE='249'>Техника\\Холодильная техника</OPTION>
<OPTION VALUE='250'>Техника\\Электроника</OPTION>
<OPTION VALUE='251'>Техника\\Электроника: Аппаратура</OPTION>
<OPTION VALUE='252'>Техника\\Электроника: Волоконная оптика</OPTION>
<OPTION VALUE='253'>Техника\\Электроника: Домашняя электроника</OPTION>
<OPTION VALUE='254'>Техника\\Электроника: Микропроцессорная техника</OPTION>
<OPTION VALUE='255'>Техника\\Электроника: Обработка сигналов</OPTION>
<OPTION VALUE='256'>Техника\\Электроника: Радио</OPTION>
<OPTION VALUE='257'>Техника\\Электроника: Робототехника</OPTION>
<OPTION VALUE='258'>Техника\\Электроника: СБИС</OPTION>
<OPTION VALUE='259'>Техника\\электроника: Телевидение. Видеотехника</OPTION>
<OPTION VALUE='260'>Техника\\Электроника: Телекоммуникации</OPTION>
<OPTION VALUE='261'>Техника\\Электроника: Электротехника</OPTION>
<OPTION VALUE='262'>Техника\\Энергетика</OPTION>
<OPTION VALUE='263'>Техника\\Энергетика: Возобновляемая энергетика</OPTION>
<OPTION VALUE='264'>Физика</OPTION>
<OPTION VALUE='265'>Физика\\Астрономия</OPTION>
<OPTION VALUE='266'>Физика\\Астрономия: Астрофизика</OPTION>
<OPTION VALUE='267'>Физика\\Геофизика</OPTION>
<OPTION VALUE='268'>Физика\\Квантовая механика</OPTION>
<OPTION VALUE='269'>Физика\\Квантовая физика</OPTION>
<OPTION VALUE='270'>Физика\\Кристаллофизика</OPTION>
<OPTION VALUE='271'>Физика\\Механика</OPTION>
<OPTION VALUE='272'>Физика\\Механика: Колебания и волны</OPTION>
<OPTION VALUE='273'>Физика\\Механика: Механика деформируемого тела</OPTION>
<OPTION VALUE='274'>Физика\\Механика: Механика жидкости и газа</OPTION>
<OPTION VALUE='275'>Физика\\Механика: Нелинейная динамика, хаос</OPTION>
<OPTION VALUE='276'>Физика\\Механика: Сопротивление материалов</OPTION>
<OPTION VALUE='277'>Физика\\Механика: Теория упругости</OPTION>
<OPTION VALUE='278'>Физика\\Общие курсы</OPTION>
<OPTION VALUE='279'>Физика\\Оптика</OPTION>
<OPTION VALUE='280'>Физика\\Спектроскопия</OPTION>
<OPTION VALUE='281'>Физика\\Теория относительности и гравитация</OPTION>
<OPTION VALUE='282'>Физика\\Термодинамика и статистическая физика</OPTION>
<OPTION VALUE='283'>Физика\\Физика атмосферы</OPTION>
<OPTION VALUE='284'>Физика\\Физика лазеров</OPTION>
<OPTION VALUE='285'>Физика\\Физика плазмы</OPTION>
<OPTION VALUE='286'>Физика\\Физика твердого тела</OPTION>
<OPTION VALUE='287'>Физика\\Электричество и магнетизм</OPTION>
<OPTION VALUE='288'>Физика\\Электродинамика</OPTION>
<OPTION VALUE='289'>Физкультура и спорт</OPTION>
<OPTION VALUE='290'>Физкультура и спорт\\Бодибилдинг</OPTION>
<OPTION VALUE='291'>Физкультура и спорт\\Боевые искусства</OPTION>
<OPTION VALUE='292'>Физкультура и спорт\\Велосипед</OPTION>
<OPTION VALUE='293'>Физкультура и спорт\\Выживание</OPTION>
<OPTION VALUE='294'>Физкультура и спорт\\Спортивное рыболовство</OPTION>
<OPTION VALUE='295'>Физкультура и спорт\\Фехтование</OPTION>
<OPTION VALUE='296'>Химия</OPTION>
<OPTION VALUE='297'>Химия\\Аналитическая химия</OPTION>
<OPTION VALUE='298'>Химия\\Материаловедение</OPTION>
<OPTION VALUE='299'>Химия\\Неорганическая химия</OPTION>
<OPTION VALUE='300'>Химия\\Органическая химия</OPTION>
<OPTION VALUE='301'>Химия\\Пиротехника и взрывчатые вещества</OPTION>
<OPTION VALUE='302'>Химия\\Фармакология</OPTION>
<OPTION VALUE='303'>Химия\\Физическая химия</OPTION>
<OPTION VALUE='304'>Химия\\Химические технологии</OPTION>
<OPTION VALUE='305'>Экономика</OPTION>
<OPTION VALUE='306'>Экономика\\Инвестиции</OPTION>
<OPTION VALUE='307'>Экономика\\Математическая экономика</OPTION>
<OPTION VALUE='308'>Экономика\\Популярные</OPTION>
<OPTION VALUE='309'>Экономика\\Рынки</OPTION>
<OPTION VALUE='310'>Экономика\\Эконометрика</OPTION>
<OPTION VALUE='311'>Юридические науки\\Криминология, криминалистика</OPTION>
<OPTION VALUE='312'>Юридические науки\\Криминология: Суд. экспертиза</OPTION>
<OPTION VALUE='313'>Юридические науки\\Право</OPTION>
<OPTION VALUE='314'>Языкознание</OPTION>
<OPTION VALUE='315'>Языкознание\\Иностранные</OPTION>
<OPTION VALUE='316'>Языкознание\\Иностранные: Английский язык</OPTION>
<OPTION VALUE='317'>Языкознание\\Иностранные: Французский язык</OPTION>
<OPTION VALUE='318'>Языкознание\\Компаративистика</OPTION>
<OPTION VALUE='319'>Языкознание\\Лингвистика</OPTION>
<OPTION VALUE='320'>Языкознание\\Риторика</OPTION>
<OPTION VALUE='321'>Языкознание\\Русский язык</OPTION>
<OPTION VALUE='322'>Языкознание\\Словари</OPTION>
<OPTION VALUE='323'>Языкознание\\Стилистика</OPTION>";

$LANG_MESS_134 = 'ISBN найденные в файле';
$LANG_MESS_135 = 'Открыть в браузере';

$LANG_MESS_136 = 'Пакетный поиск книг';
$LANG_MESS_137 = 'Сообщить об ошибке';

$LANG_MESS_138 = 'Вернуться на предыдущую страницу';
$LANG_MESS_139 = 'и попробовать еще';
$LANG_MESS_140 = 'Введите DOI в';
$LANG_MESS_141 = 'Файл не выбран';
$LANG_MESS_142 = "Нажмите 'Обзор' для выбора файла на своем компьютере, и 'Отправить' чтобы загрузить его";
$LANG_MESS_143 = 'Недопустимое расширение, только';
$LANG_MESS_144 = 'Битый файл!';

$LANG_MESS_145 = 'Ошибка загрузки';
$LANG_MESS_146 = 'DOI владелец';
$LANG_MESS_147 = 'Посмотреть описание книги';
$LANG_MESS_148 = 'Вернуться на главную страницу';
$LANG_MESS_149 = 'Спасибо!';
$LANG_MESS_150 = 'Вернуться на страницу загрузки';
$LANG_MESS_151 = 'Загрузка книги завершена успешно!';
$LANG_MESS_152 = 'MD5 хеш залитой книги:';
$LANG_MESS_153 = 'DOI уже в базе. Редактируем существующую запись';
$LANG_MESS_154 = 'Вводим новую запись';
$LANG_MESS_155 = 'Посмотреть залитую статью';
$LANG_MESS_156 = 'Перейти на страницу последних добавленных книг';
$LANG_MESS_157 = 'DOI не найден в базе данных';
$LANG_MESS_158 = 'Тип ошибки';
$LANG_MESS_159 = 'Сообщение';
$LANG_MESS_160 = 'Сообщение об ошибке отправлено администратору';
$LANG_MESS_161 = 'Если некорректное описание статьи';
$LANG_MESS_162 = 'Редактируйте через загрузчик';
$LANG_MESS_163 = 'Неправильный DOI';
$LANG_MESS_164 = 'Только превью статьи';
$LANG_MESS_165 = 'Группировать результаты поиска';
$LANG_MESS_166 = 'Если у статьи нет DOI, то указывайте фиктивный, формата 10.0000/&lt;сайт&gt;/&lt;ID статьи на сайте&gt; <br>(напр. URL статьи http://elibrary.ru/item.asp?id=18212587 =&gt; DOI: 10.0000/elibrary.ru/18212587)';

$LANG_MESS_167 = 'Вывод результатов';
$LANG_MESS_168 = 'Простой';
$LANG_MESS_169 = 'Подробный';
$LANG_MESS_170 = 'записей';
$LANG_MESS_171 = 'Прочее';
$LANG_MESS_172 = 'Ошибки';
$LANG_MESS_173 = 'С докачкой, имя файла ориг.';
$LANG_MESS_174 = 'С докачкой, имя файла транслит.';
$LANG_MESS_175 = 'С докачкой, имя файла - MD5 хеш';
$LANG_MESS_176 = 'Открыть в браузере';
$LANG_MESS_177 = 'Без докачки, имя файла ориг.';
$LANG_MESS_178 = 'Без докачки, имя файла транслит.';
$LANG_MESS_179 = 'Без докачки, имя файла - MD5 хеш';
$LANG_MESS_180 = 'Журналы';
$LANG_MESS_181 = 'Ничего не найдено: поискать на ';
$LANG_MESS_182 = 'Содержание ';
$LANG_MESS_183 = 'Пакетный поиск для комиксов';
$LANG_MESS_184 = 'Последнее обновление индекса';
$LANG_MESS_185 = 'Год приблизительно';

$LANG_MESS_186 = 'Исходная строка';
$LANG_MESS_187 = 'Итоговая строка+ссылка';
$LANG_MESS_188 = 'Найдено';
$LANG_MESS_189 = 'Показаны первые ';
$LANG_MESS_190 = ' результатов поиска';
$LANG_MESS_191 = 'Книга не добавлена в библиотеку!';
$LANG_MESS_192 = 'Если вы залили вариант книги лучшего качества, то не забудьте проставить у книги худшего качества md5 книги лучшего качества';
$LANG_MESS_193 = 'В библиотеке найдены книги похожие по описанию на заливаемую вами, а именно: ';
$LANG_MESS_194 = 'Если вы уверены что ваша книга не дубль или дубль, но лучшего качества, то нажмите на "Добавить", в противном случае - на "Отменить"';
$LANG_MESS_195 = 'Добавить';
$LANG_MESS_196 = 'Отменить';
$LANG_MESS_197 = 'Набор колонок по умолчанию';
$LANG_MESS_198 = 'Колонки: Заглавие,Автор(ы),Серия,Периодика,Издательство,Год,Том';
$LANG_MESS_199 = 'показаны первые ';
$LANG_MESS_200 = 'Редактирование записи завершено успешно!';
$LANG_MESS_201 = 'Используйте ftp-клиенты с возможностью докачки';
$LANG_MESS_202 = 'Не заливайте зашифрованные архивы и файлы с DRM';
$LANG_MESS_203 = 'макс. 200 Мб, мин. 50кБ если возможно без *.rar, *.zip';
$LANG_MESS_204 = 'возможные расширения:';
$LANG_MESS_205 = 'Такая книга уже есть в БД. <br>С момента загрузки книги прошло более суток, редактирование доступно только библиотекарям,<br> так же если вы обнаружили ошибку в описании можете сообщить <a href="http://genofond.org/viewtopic.php?t=6423">сюда</a>.';

$LANG_DESCRIPTION = 'Библиотека Генезис является научным сообществом с целью коллекцинирования книг по естественным дисциплинам науке и технике';

$libgennews = '<a href="http://genofond.org/viewtopic.php?f=8&t=7271"><font color=red><b>Собираем на продление аренды сидбокса</b></font></a><p> 
<a href="http://genofond.org/viewtopic.php?f=1&t=7134">Локальный LibGen на базе Sphinx</a>';
//<a href='http://genofond.org/viewtopic.php?f=17&t=6769'>Library Genesis in USENET</a>
?>