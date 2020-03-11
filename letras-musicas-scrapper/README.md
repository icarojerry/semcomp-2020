# letras-musicas-scrapper

## Introdução
Um scrapper simples para baixar letras de músicas do site www.letras.mus.br/. Este programa captura todas as músicas de um determinados artista, a partir da escolha de um estilo musical (ou todos eles).

### Objetivo

Esse programa foi desenvolvido com o objetivo de obter uma massa de dados considerável para poder ser aplicado no estudo de Search Engine.

### Instalação
```bash
pipenv install

pipenv shell
```

### Como usar
```bash
python main.py
```
### Exemplo de um Resultado
```json
{
    "name": "Belchior",
    "url": "https://www.letras.mus.br/belchior/",
    "views": 9551363,
    "style": "MPB",
    "scraping_date": "2020-02-19",
    "songs": [
        {
            "title": "Sujeito de Sorte",
            "views": 293698,
            "genre": "MPB",
            "songwriters": [
                "Belchior"
            ],
            "lyric": "Presentemente eu posso me considerar um sujeito de sorte Porque apesar de muito moço, me sinto são e salvo e forte E tenho comigo pensado, Deus é brasileiro e anda do meu lado E assim já não posso sofrer no ano passado Tenho sangrado demais, tenho chorado pra cachorro Ano passado eu morri, mas esse ano eu não morro Tenho sangrado demais, tenho chorado pra cachorro Ano passado eu morri, mas esse ano eu não morro Ano passado eu morri, mas esse ano eu não morro Ano passado eu morri, mas esse ano eu não morro Presentemente eu posso me considerar um sujeito de sorte Porque apesar de muito moço, me sinto são e salvo e forte E tenho comigo pensado, Deus é brasileiro e anda do meu lado E assim já não posso sofrer no ano passado Tenho sangrado demais, tenho chorado pra cachorro Ano passado eu morri, mas esse ano eu não morro Tenho sangrado demais, tenho chorado pra cachorro Ano passado eu morri, mas esse ano eu não morro Ano passado eu morri, mas esse ano eu não morro Ano passado eu morri, mas esse ano eu não morro Presentemente eu posso me considerar um sujeito de sorte Porque apesar de muito moço, me sinto são e salvo e forte E tenho comigo pensado, Deus é brasileiro e anda do meu lado E assim já não posso sofrer no ano passado Tenho sangrado demais, tenho chorado pra cachorro Ano passado eu morri, mas esse ano eu não morro Tenho sangrado demais, tenho chorado pra cachorro Ano passado eu morri, mas esse ano eu não morro Ano passado eu morri, mas esse ano eu não morro Ano passado eu morri, mas esse ano eu não morro ",
            "lyric_pretty": [
                [
                    "Presentemente eu posso me considerar um sujeito de sorte",
                    "Porque apesar de muito moço, me sinto são e salvo e forte",
                    "E tenho comigo pensado, Deus é brasileiro e anda do meu lado",
                    "E assim já não posso sofrer no ano passado"
                ],
                [
                    "Tenho sangrado demais, tenho chorado pra cachorro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Tenho sangrado demais, tenho chorado pra cachorro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Ano passado eu morri, mas esse ano eu não morro"
                ],
                [
                    "Presentemente eu posso me considerar um sujeito de sorte",
                    "Porque apesar de muito moço, me sinto são e salvo e forte",
                    "E tenho comigo pensado, Deus é brasileiro e anda do meu lado",
                    "E assim já não posso sofrer no ano passado"
                ],
                [
                    "Tenho sangrado demais, tenho chorado pra cachorro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Tenho sangrado demais, tenho chorado pra cachorro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Ano passado eu morri, mas esse ano eu não morro"
                ],
                [
                    "Presentemente eu posso me considerar um sujeito de sorte",
                    "Porque apesar de muito moço, me sinto são e salvo e forte",
                    "E tenho comigo pensado, Deus é brasileiro e anda do meu lado",
                    "E assim já não posso sofrer no ano passado"
                ],
                [
                    "Tenho sangrado demais, tenho chorado pra cachorro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Tenho sangrado demais, tenho chorado pra cachorro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Ano passado eu morri, mas esse ano eu não morro",
                    "Ano passado eu morri, mas esse ano eu não morro"
                ]
            ],
            "url": "https://www.letras.mus.br/belchior/344922/",
            "song_link": "/belchior/344922/",
            "language": "pt_br"
        }
    ]
}
```

Caso a letra da música esteja em outra língua e tenha uma tradução disponível, ela será retornada com a letra original e a tradução, além disso, retorna o código da língua (seguindo o padrão ISO 639.2) em que a letra original está. Veja o exemplo abaixo:

```json
{
    "title": "Nine Out Of Ten",
    "views": 81010,
    "genre": "MPB",
    "songwriters": [
        "Caetano Veloso"
    ],
    "lyric": "Walk down portobello road to the sound of reggae I'm alive The age of gold, yes the age of The age of old The age of gold The age of music is past I hear them talk as I walk Yes, I hear them talk I hear they say \"Expect the final blast\" Walk down portobello road to the sound of reggae I'm alive I'm alive and vivo muito vivo, vivo, vivo Feel the sound of music banging in my belly Know that one day I must die I'm alive I'm alive and vivo muito vivo, vivo, vivo In the eletric cinema or on the telly, telly, telly Nine out of ten movie stars make me cry I'm alive And nine out of ten film stars make me cry I'm alive ",
    "lyric_pretty": [
        [
            "Walk down portobello road to the sound of reggae",
            "I'm alive",
            "The age of gold, yes the age of",
            "The age of old",
            "The age of gold",
            "The age of music is past",
            "I hear them talk as I walk",
            "Yes, I hear them talk",
            "I hear they say",
            "\"Expect the final blast\"",
            "Walk down portobello road to the sound of reggae",
            "I'm alive"
        ],
        [
            "I'm alive and vivo muito vivo, vivo, vivo",
            "Feel the sound of music banging in my belly",
            "Know that one day I must die",
            "I'm alive"
        ],
        [
            "I'm alive and vivo muito vivo, vivo, vivo",
            "In the eletric cinema or on the telly, telly, telly",
            "Nine out of ten movie stars make me cry",
            "I'm alive",
            "And nine out of ten film stars make me cry",
            "I'm alive"
        ]
    ],
    "url": "https://www.letras.mus.br/caetano-veloso/423776/",
    "song_link": "/caetano-veloso/423776/",
    "language": "en",
    "has_translation": true,
    "translated_lyric": "Caminhe pela Portobello estrada ao som de reggae Eu estou vivo A idade de ouro, sim a idade A idade de velho A idade de ouro A idade da música é passado Eu ouço-os falarem enquanto eu ando Sim, eu ouço-os falarem Eu ouço eles dizerem \"Espere a explosão final\" Caminho pela estrada Portobello ao som do reggae Eu estou vivo Eu estou vivo e vivo muito vivo, vivo, vivo Sinto o som da música batendo na minha barriga Sei que um dia eu devo morrer Eu estou vivo Eu estou vivo e vivo muito vivo, vivo, vivo No cinema elétrico ou na televisão, televisão, televisão Nove entre dez estrelas de cinema me fazem chorar Eu estou vivo E nove entre dez estrelas de cinema me fazem chorar Eu estou vivo ",
    "translated_lyric_pretty": [
        [
            "Caminhe pela Portobello estrada ao som de reggae",
            "Eu estou vivo",
            "A idade de ouro, sim a idade",
            "A idade de velho",
            "A idade de ouro",
            "A idade da música é passado",
            "Eu ouço-os falarem enquanto eu ando",
            "Sim, eu ouço-os falarem",
            "Eu ouço eles dizerem",
            "\"Espere a explosão final\"",
            "Caminho pela estrada Portobello ao som do reggae",
            "Eu estou vivo"
        ],
        [
            "Eu estou vivo e vivo muito vivo, vivo, vivo",
            "Sinto o som da música batendo na minha barriga",
            "Sei que um dia eu devo morrer",
            "Eu estou vivo"
        ],
        [
            "Eu estou vivo e vivo muito vivo, vivo, vivo",
            "No cinema elétrico ou na televisão, televisão, televisão",
            "Nove entre dez estrelas de cinema me fazem chorar",
            "Eu estou vivo",
            "E nove entre dez estrelas de cinema me fazem chorar",
            "Eu estou vivo"
        ]
    ],
    "translated_url": "https://www.letras.mus.br/caetano-veloso/423776/traducao.html"
}     
```
