# gestionEcoleS5
# Installation
1. Clonez le dépot chez vous 
2. installer la base de données : `php bin/console doctrine:database:create`
3. lancer la migration de la base de données : `php bin/console make:migration`
4. Lancez la migration : `php bin/console doctrine:migrations:migrate`
5. Lancez la fixture --Pas de Fixtures :( : `php bin/console d:f:l --no-interaction`
6. Lancez le serveur interne : `php bin/console s:r` ou `symfony server:start -d`
