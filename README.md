

Command resolver by Dmitry Fedorov

## Installation
  

   Add to composer.json

    {
    "repositories": [
        {
        "type": "vcs",
        "url": "ssh://git@github.com:22/Uoan2/ConsoleApplication.git"
        }
    ],
        "require": {
            "dmitry-fedorov/console-test": "@dev"
        }
    }

    composer install
## Usage


    
    для вывода всех доступных комманд 

        php vendor/dmitry-fedorov/console-test/src/commandResolver.php

    для вывода конкретной комманды введите

        php vendor/dmitry-fedorov/console-test/src/commandResolver.php "help" 

    для вывода комманды с аргументами и опциями введите
        php vendor/dmitry-fedorov/console-test/src/commandResolver.php "help {argument1} 
        {argument1,argument2,argument3}[option=argument] [option1={argument1,argument2,argument3}]" 



    !!!Важно оборачивать комманду в двойные кавычки "" !!!  

    (Я не смог реализовать нормальное и рабочее решение через глобальную переменную $agrv, т.к параметры
     типа {agrv} преобразуются к виду agrv, что в конечном итоге позволяет использовать просто agrv 
     и приводит к неккоректной работе программы.

    Также пытался реализовать через bash скрипты, но к сожалению достать комманду из истории невозможно 
    без завершения выполнения данного скрипта, либо нужно вводить комманды дебага 
    до выполнения скрипта что не возможно по условиям задачи.)



    Для добавления новых комманд добавьте в папку "App/Commands" классы наследники, от класса 

        "DmitryFedorov\ConsoleTest\AbstractClasses\AbstractBaseCommand"
    


    Для расширения\изменения директории по умолчанию "App/Commands" создайте конфигурационных файл в корневой директории 

    путем ввода комманды 
    
       php vendor/dmitry-fedorov/console-test/src/configPublisher.php


    В Добавленном файле измените или расширьте массив 

       "additional_paths_for_commands"

    указав конкретные директории ваших комманд.






