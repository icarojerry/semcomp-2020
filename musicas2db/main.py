# _*_ coding:utf-8 _*_

import argparse
import string
import os
import sys
import json
import requests


def send(url, data):
    headers = {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json'
    }

    response = requests.request('POST', url, headers=headers, json=data)
    if response.status_code != 200:
        raise Exception(f"Server failed with status code {response.status_code}. {response.text}")

    print(f"{response.text}")
    return True



if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("-S", "--source", required=True, help="Pasta que contém as músicas a serem enviadas")
    parser.add_argument("-D", "--destination", required=True, help="Endereço para qual as músicas serão enviadas")
    args = parser.parse_args()
    songs_path = args.source
    url = args.destination

    try:
        for filename in os.listdir(songs_path):
            try:
                print(f"Preparing to send the file {filename}")
                with open(os.path.join(songs_path, filename), 'r') as f:
                    json_content = f.read()
                    response = send(url, json_content)
                    if response:
                        print(f"{filename} file successfully sent")
            except Exception as e:
                print(e)
                continue
    except Exception as e:
        print(f'An error occurred while trying to send the files. {e}')
