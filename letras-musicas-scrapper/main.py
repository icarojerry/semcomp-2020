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


def save(data):

    try:
        with open('data.json', 'w') as outfile:
            json.dump(data, outfile, indent=4).encode('utf8')
    except Exception as e:
        print(f'Ocorreu algum erro ao tentar gravar o arquivo. {e}')


if __name__ == "__main__":
    # TODO obter lista de artistas por estilo musical ou letra 
    artist_name = 'caetano-veloso'
    # TODO mover para um arquivo de configuração
    url = 'https://www.letras.mus.br'

    artist = {
        "name": artist_name,
        "url": f"{url}/{artist_name}"
        "scraping_date": date.today()
    }

    songs = []
    links = get_links(f"{url}/{artist_name}/mais_tocadas.html")
    for link in links:
        songs.append(get_song(f"{url}{link}"))

    artist.update({"songs": songs})
    save(artist)
