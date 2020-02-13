# _*_ coding:utf-8 _*_

import string
import os
import sys
from urllib.request import urlopen
import json
from bs4 import BeautifulSoup
from datetime import date


def get_song_links(url):

    try:
        links = []
        ctrl_page = set()
        html = urlopen(url)
        bs = BeautifulSoup(html, 'html.parser')
        links_content = bs.find('ul', {'class': 'cnt-list-songs'}).find_all('a')

        for link in links_content:
            if 'href' in link.attrs:
                if link.attrs['href'] not in ctrl_page:
                    ctrl_page.add(f"{link.attrs['href']}")
                    links.append({
                        "name": ' '.join(link.stripped_strings),
                        "link": link.attrs['href']
                    })
        return links
    except Exception as e:
        print(f'Ocorreu algum erro ao tentar acessar o site. {e}')


def get_artist_views(url):
    html = urlopen(url)
    bs = BeautifulSoup(html, 'html.parser')
    views = bs.find('div', {'class': 'cnt-info_exib'}).find('b')

    return ' '.join(views.stripped_strings)


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


def get_musical_styles(url):
    html = urlopen(f"{url}/estilos/")
    bs = BeautifulSoup(html, 'html.parser')

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

    return musical_styles


def get_artists(url):
    html = urlopen(f"{url}todosartistas.html")
    bs = BeautifulSoup(html, 'html.parser')

    ctrl_page = set()
    artists = []
    artists_content = bs.find('ul', {'class': 'cnt-list cnt-list--col3'}).find_all('a')
    for artist_content in artists_content:
        if 'href' in artist_content.attrs:
            if artist_content.attrs['href'] not in ctrl_page:
                ctrl_page.add(f"{artist_content.attrs['href']}")
                artist = {
                    "name": ' '.join(artist_content.stripped_strings),
                    "link": f"{artist_content.attrs['href']}"
                }
                artists.append(artist)
    return artists


def save(data, file_name):

    try:
        if not os.path.exists('lyrics'):
            os.makedirs('lyrics')
        with open(f"lyrics/{file_name}.json", 'w') as outfile:
            json.dump(data, outfile, indent=4)
    except Exception as e:
        print(f'Ocorreu algum erro ao tentar gravar o arquivo. {e}')


if __name__ == "__main__":
    # TODO mover para um arquivo de configuração
    url = 'https://www.letras.mus.br'

    print("Escolha um dos estilos musicais abaixo para baixar letras das músicas:")

    musical_styles = get_musical_styles(url)
    index = 0
    print("Estilos Musicais")
    for style in musical_styles:
        if index == 0:
            description = "Todos"
        else:
            description = style["description"]

        description = description + (" " * (20-len(description)))
        end = "\n" if (index + 1) % 5 == 0 else " "
        print(f"{index:02d} - {description}\t|", end=end)
        index = index + 1

    try:
        option = int(input('\nOpção: '))
    except (ValueError, IndexError):
        print("Opção Inválida")

    chosen_styles = []
    download_auto_mode = None
    if option == 0:
        chosen_styles = musical_styles
        print("0 - Informar quais artistas baixar")
        print("1 - Baixar tudo sem interação")

        try:
            download_auto_mode = int(input('Opção: '))
            assert download_auto_mode in (0, 1)
        except (ValueError):
            print("Opção Inválida")
    else:
        chosen_styles.append(musical_styles[option - 1])

    chosen_artists = []
    display = False
    for style in chosen_styles:
        style_description = style["description"]
        style_url = style["link"]
        artists = get_artists(f"{url}{style_url}")

        print(f"Artistas do Estilo {style_description}")
        if download_auto_mode == 1:
            chosen_artists = chosen_artists + artists
        else:

            if display:
                print("-" * -8)
                print("0 - Continuar")
                print("1 - Pular")
                print("2 - Sair")

                try:
                    option = int(input('Opção: '))
                    assert option in (0, 1, 2)
                    if option == 1:
                        continue
                    elif option == 2:
                        break
                    else:
                        pass
                except (ValueError, IndexError):
                    print("Opção Inválida")
            else:
                display = True

            index = 0
            print(f"{index} - Todos")
            for artist in artists:
                index = index + 1
                artist_name = artist["name"]
                print(f"{index} - {artist_name}")

            try:
                option = int(input('Opção: '))
            except (ValueError, IndexError):
                print("Opção Inválida")

            if option == 0:
                chosen_artists = chosen_artists + artists
            else:
                chosen_artists.append(artists[option - 1])

    for chosen_artist in chosen_artists:

        artist_name = chosen_artist["name"]
        artist_link = chosen_artist["link"]

        print(f"Músicas de {artist_name}")

        artist_url = f"{url}{artist_link}"
        artist = {
            "name": artist_name,
            "url": artist_url,
            "views": get_artist_views(artist_url),
            "scraping_date": str(date.today())
        }

        songs = []
        links = get_song_links(f"{url}/{artist_link}/mais_tocadas.html")
        for link in links:
            song_name = link["name"]
            song_link = link["link"]

            print(f"Obtendo letra da música {song_name}")
            songs.append(get_song(f"{url}{song_link}"))

        artist.update({"songs": songs})
        save(artist, f"{artist_link[:-1][1:]}")

