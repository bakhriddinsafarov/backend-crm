paketlarni o'rnatamiz: composer i

Loyiha bilan malumotlar bazasi bilan aloqani o'rnatamiz: .env database_url ni sozlang

Malumotlar omborida jadval yaratamiz: php bin/console doctrine:database:create

Loyihadagi migratsiyani yurgizamiz: php bin/console doctrine:migrations:migrate

Loyihada token paketlarni: php bin/console lexik:jwt:generate-keypair

localhostni ishga tushurish: php -S localhost:(port) -t public
