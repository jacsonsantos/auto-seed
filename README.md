# Auto Seed
Popula a base de dados automaticamente

Você precisa ter em sua maquina o php instalado, caso use Windows, uma dica é instalar o WAMP Server ou Xampp.
O Auto Seed serve apenas para banco MySQL e MariaDB. <br>
Após baixar o Auto Seed, entre no diretorio **auto_seed** e abra o mesmo no terminal ou cmd. 

Adicione as configurações de seu banco no arquivo: config.php

execute no terminal ou cmd:
```
php -S localhost:4040
```
Quantidade de registros é adicionado em N: <br>
http://localhost:4040/?n=5

ou execute no terminal:
```
php autoseed
```
Assim vai gerar 10 registros automaticos
