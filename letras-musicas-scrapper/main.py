# _*_ coding:utf-8 _*_

import string
import sys
from urllib.request import urlopen
import json
from bs4 import BeautifulSoup
from datetime import date


def get_links(url):

    try:
        links = []
        ctrl_page = set()
        html = urlopen(url)
        bs = BeautifulSoup(html, 'html.parser')
        for link in bs.find('ul', {'class': 'cnt-list-songs'}).find_all('a'):
            if 'href' in link.attrs:
                if link.attrs['href'] not in ctrl_page:
                    ctrl_page.add(f"{link.attrs['href']}")
                    links.append(link.attrs['href'])
        return links
    except Exception as e:
        print(f'Ocorreu algum erro ao tentar acessar o site. {e}')


def get_artist(url):
    # Obter views do artista
    # Obter estilo musical associado ao artista
    pass


def get_song(url):

    try:
        song = {}
        html = urlopen(url)
        bs = BeautifulSoup(html, 'html.parser')

        title = bs.find('div', {'class': 'cnt-head'}).find('h1')
        title = ' '.join(title.stripped_strings)
        views = bs.find('div', {'class': 'cnt-info_exib'}).find('b')
        views = ' '.join(views.stripped_strings)
        views = int(views.replace('.', ''))
        genre = bs.find('div', {'class': 'breadcrumb cor_1 g-1'}).find_all('a')
        genre = ' '.join(genre[1].stripped_strings)
        songwriter = bs.find('div', {'class': 'letra-info_comp'})
        songwriter = ' '.join(songwriter.stripped_strings)
        stanzas = bs.find('div', {'class': 'cnt-letra p402_premium'}).find_all('p')

        lyric_raw = ''
        stanzas_aux = []
        for stanza in stanzas:
            lyric_raw += ' '.join(stanza.stripped_strings)
            lyric_raw += ' '
            verses_aux = []
            for verse in stanza.stripped_strings:
                verses_aux.append(verse)
            stanzas_aux.append(verses_aux)

        song.update({"title": title})
        song.update({"title": title})
        song.update({"views": views})
        song.update({"genre": genre})
        song.update({"songwriter": songwriter})
        song.update({"lyric": lyric_raw})
        song.update({"lyric_pretty": stanzas_aux})
        song.update({"url": url})
    except Exception as e:
        print(f'Ocorreu algum erro ao tentar acessar o site. {e}')

    return song


def list_musical_styles(url):
    html = urlopen(f"{url}/estilos/")
    bs = BeautifulSoup(html, 'html.parser')
    title_content = bs.find('h1', {'class': 'h2'})
    title = ' '.join(title_content.stripped_strings)

    ctrl_page = set()
    musical_styles = []
    musical_styles_content = bs.find('ul', {'class': 'cnt-list cnt-list--col2'}).find_all('a')
    for musical_style_content in musical_styles_content:
        if 'href' in musical_style_content.attrs:
            if musical_style_content.attrs['href'] not in ctrl_page:
                ctrl_page.add(f"{musical_style_content.attrs['href']}")
                style = {
                    "description": ' '.join(musical_style_content.stripped_strings),
                    "link": f"{musical_style_content.attrs['href']}"
                }
                musical_styles.append(style)

    return {
        "title": title,
        "styles": musical_styles
    }


def save(data):

    try:
        with open('data.json', 'w') as outfile:
            json.dump(data, outfile, indent=4).encode('utf8')
    except Exception as e:
        print(f'Ocorreu algum erro ao tentar gravar o arquivo. {e}')


if __name__ == "__main__":
    # TODO mover para um arquivo de configuração
    url = 'https://www.letras.mus.br'

    print("Escolha um dos estilos musicais abaixo para baixar letras das músicas:")

    musical_styles = list_musical_styles(url)
    index = 0
    print(musical_styles["title"])
    print(f"{index} - Todos")
    for style in musical_styles["styles"]:
        index = index + 1
        description = style["description"]
        print(f"{index} - {description}")

    try:
        option = int(input('Opção: '))
    except (ValueError, IndexError):
        print("Opção Inválida")

    chosen_styles = []
    if option == 0:
        chosen_styles = musical_styles["styles"]
    else:
        chosen_styles.append(musical_styles["styles"][option - 1])

    print(chosen_styles)

    exit(1)

    # TODO obter lista de artistas por estilo musical ou letra 
    artist_name = 'caetano-veloso'

    artist = {
        "name": artist_name,
        "url": f"{url}/{artist_name}",
        "scraping_date": date.today()
    }

    songs = []
    links = get_links(f"{url}/{artist_name}/mais_tocadas.html")
    for link in links:
        songs.append(get_song(f"{url}{link}"))

    artist.update({"songs": songs})
    save(artist)

# https://www.letras.mus.br/estilos/mpb/artistas.html
# https://www.letras.mus.br/mais-acessadas/mpb/