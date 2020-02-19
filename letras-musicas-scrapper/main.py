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
        links_content = bs.find('ul', {'class': 'cnt-list-songs'})
        if links_content is None:
            links_content = bs.find('ul', {'class': 'cnt-list-songs -counter -top-songs js-song-list'})
        links_content = links_content.find_all('a')

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

    return int(' '.join(views.stripped_strings).replace(".", ""))


def get_song(url, song_link):

    try:
        url = f"{url}{song_link}"
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
        songwriters = bs.find('div', {'class': 'letra-info_comp'})
        songwriters_ignore = songwriters.find('a')
        songwriters_ignore = ' '.join(songwriters_ignore.stripped_strings)
        songwriters = ' '.join(songwriters.stripped_strings)
        songwriters = songwriters.replace("·", "").replace(" / ", "/").replace(songwriters_ignore, "")
        songwriters = songwriters.replace("Composição: ", "").strip()
        songwriters = None if songwriters == "" else songwriters.split("/")
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
        song.update({"songwriters": songwriters})
        song.update({"lyric": lyric_raw})
        song.update({"lyric_pretty": stanzas_aux})
        song.update({"url": url})
        song.update({"song_link": song_link})

        translation = bs.find('a', {'class': 'lyric_event lm_lang lm_lang_pt'})
        translation_pending = bs.find('a', {'class': 'lyric_event lm_lang lm_lang_pt js-send-translation'})

        if not translation and not translation_pending:
            song.update({"language": "pt_br"})
        else:
            translated_url = f"{url}enviar_traducao.html" if translation_pending else f"{url}traducao.html"
            html = urlopen(translated_url)
            bs = BeautifulSoup(html, 'html.parser')
            try:
                language = bs.find('div', {'class': 'letra-menu'})

                if language is None:
                    language = bs.find('div', {'class': 'letra-menu isFixedTop'})

                language = language.find('a')
                language = language.attrs['class']
                language = language[-1].split('_')[-1]
                song.update({"language": language})
            except Exception as e:
                song.update({"language": None})
                print(f'Ocorreu algum erro ao tentar obter idioma da música. url:{translated_url} .{e}')

            song.update({"has_translation": not translation_pending})

            if not translation_pending:
                stanzas = bs.find('div', {'class': 'cnt-trad_r'}).find_all('p')

                lyric_raw = ''
                stanzas_aux = []
                for stanza in stanzas:
                    lyric_raw += ' '.join(stanza.stripped_strings)
                    lyric_raw += ' '
                    verses_aux = []
                    for verse in stanza.stripped_strings:
                        verses_aux.append(verse)
                    stanzas_aux.append(verses_aux)

                song.update({"translated_lyric": lyric_raw})
                song.update({"translated_lyric_pretty": stanzas_aux})
                song.update({"translated_url": translated_url})
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


def file_exists(file_path):
    return os.path.exists(file_path)


def save(data, file_path):
    try:
        with open(file_path, 'w', encoding='utf8') as outfile:
            json.dump(data, outfile, indent=4, ensure_ascii=False)
    except Exception as e:
        print(f'Ocorreu algum erro ao tentar gravar o arquivo. {e}')


if __name__ == "__main__":
    # TODO mover para um arquivo de configuração
    url = 'https://www.letras.mus.br'

    if not os.path.exists('lyrics'):
        os.makedirs('lyrics')

    print("Escolha um dos estilos musicais abaixo para baixar letras das músicas:")
    print("\nEstilos Musicais")

    musical_styles = get_musical_styles(url)
    index = 0
    description = "Todos"
    description = description + (" " * (20-len(description)))
    print(f"{index:02d} - {description}\t|", end=" ")
    for style in musical_styles:
        index = index + 1
        description = style["description"]
        description = description + (" " * (20-len(description)))
        end = "\n" if (index + 1) % 5 == 0 else " "
        print(f"{index:02d} - {description}\t|", end=end)

    try:
        print("\n")
        option = int(input('Opção: '))
    except (ValueError, IndexError):
        print("Opção Inválida")

    chosen_styles = []
    download_auto_mode = None
    if option == 0:
        chosen_styles = musical_styles
        print("0 - Informar quais artistas baixar")
        print("1 - Baixar tudo sem interação")

        try:
            print("\n")
            download_auto_mode = int(input('Opção: '))
            assert download_auto_mode in (0, 1)
        except (ValueError):
            print("Opção Inválida")
    else:
        chosen_styles.append(musical_styles[option - 1])

    chosen_artists = {}
    display = False
    for style in chosen_styles:
        style_description = style["description"]
        style_url = style["link"]
        print(f"\nArtistas do Estilo {style_description}")

        artists = get_artists(f"{url}{style_url}")
        if download_auto_mode == 1:
            chosen_artists.update({style_url: {"description": style_description, "artists": artists}})
        else:

            if display:
                print("-" * 8)
                print("0 - Continuar")
                print("1 - Pular")
                print("2 - Sair")

                try:
                    print("\n")
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
            artist_name = "Todos"
            artist_name = artist_name + (" " * (20-len(artist_name)))
            print(f"{index:02d} - {artist_name}\t|", end=" ")
            for artist in artists:
                index = index + 1
                artist_name = artist["name"]
                artist_name = artist_name + (" " * (20-len(artist_name)))
                end = "\n" if (index + 1) % 5 == 0 else " "
                print(f"{index:02d} - {artist_name}\t|", end=end)

            try:
                print("\n")
                option = int(input('Opção: '))
            except (ValueError, IndexError):
                print("Opção Inválida")

            if option == 0:
                chosen_artists.update({style_url: {"description": style_description, "artists": artists}})
            else:
                if not chosen_artists.get(style_url):
                    chosen_artists.update({style_url: {"description": style_description, "artists": []}})

                artists_aux = chosen_artists.get(style_url).get("artists")
                artists_aux.append(artists[option - 1])
                chosen_artists.update({style_url: {"description": style_description, "artists": artists_aux}})

    overwrite_option = None
    for style in chosen_artists:
        chosen_artists_per_style = chosen_artists.get(style)["artists"]
        style_description = chosen_artists.get(style)["description"]
        for chosen_artist in chosen_artists_per_style:
            artist_name = chosen_artist["name"]
            artist_link = chosen_artist["link"]
            artist_url = f"{url}{artist_link}"

            artist = {
                "name": artist_name,
                "url": artist_url,
                "views": get_artist_views(artist_url),
                "style": style_description,
                "scraping_date": str(date.today())
            }

            songs = []
            file_name = f"{artist_link[:-1][1:]}"
            file_path = f"lyrics/{file_name}.json"

            if overwrite_option is None:
                print(f"Digite 1 para pular os arquivos já baixados")
                overwrite_option = int(input('Opção: '))

            if overwrite_option == 1 and file_exists(file_path):
                print(f"\nMúsicas de {artist_name} já estão baixadas")
                continue

            links = None
            tries = 0
            while links is None and tries < 3:
                links = get_song_links(f"{url}/{artist_link}/mais_tocadas.html")
                tries = tries + 1

            print(f"\nMúsicas de {artist_name}")
            for link in links:
                song_name = link["name"]
                song_link = link["link"]

                print(f"\t- Obtendo letra da música {song_name}")
                songs.append(get_song(url, song_link))

            artist.update({"songs": songs})
            save(artist, file_path)
