# Sintegra Crawler

## Executar com Tusk
### Dependências
É preciso ter [docker](https://docs.docker.com/install/), [docker compose](https://docs.docker.com/compose/install/) e o [tusk](https://github.com/rliebz/tusk) instalados em sua máquina, para instalar o tusk execute:

    $ sudo su 
    # curl -sL https://git.io/tusk | bash -s -- -b /usr/local/bin latest
    # exit

### Executar
Com isso, na pasta principal do projeto, execute o seguinte comando:

    $ tusk setup

Se tudo ocorrer bem, você pode executar o seguinte comando para inciar o Sintegra Crawler:

    $ tusk crawler

Ao executar será criado um arquivo JPEG chamado **captcha.jpeg** na raiz do projeto, onde neste estará o captcha para digitar no Sintegra Crawler

Para mais informações sobre tusk rode:

    $ tusk -h

## Executar sem Tusk
### Dependências
É preciso ter [composer](https://getcomposer.org/) e PHP 8.0+

### Executar
Com isso, na pasta principal do projeto, execute o seguinte comando:

    $ composer install

Se tudo ocorrer bem, você pode executar o seguinte comando para inciar o Sintegra Crawler:

    $ php index.php

Ao executar será criado um arquivo JPEG chamado **captcha.jpeg** na raiz do projeto, onde neste estará o captcha para digitar no Sintegra Crawler
