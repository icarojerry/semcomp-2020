# _*_ coding:utf-8 _*_

import argparse
import string
import os
import sys
import json
import requests


class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'


def send(url, data):
    headers = {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json'
    }

    response = requests.request('POST', url, headers=headers, json=data)
    if response.status_code != 200:
        raise Exception(f"{bcolors.FAIL}Server failed with status code {response.status_code}. {response.text}{bcolors.ENDC}")
    return True



if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("-S", "--source", required=True, help="Pasta que contém as músicas a serem enviadas")
    parser.add_argument("-D", "--destination", required=True, help="Endereço para qual as músicas serão enviadas")
    args = parser.parse_args()
    songs_path = args.source
    url = args.destination

    try:
        files = sorted(os.listdir(songs_path))
        files_quantity = len(files)
        current = 0
        for filename in files:
            try:
                print(f"Preparing to send the file {filename}")
                with open(os.path.join(songs_path, filename), 'r') as f:
                    json_content = f.read()
                    current = current + 1
                    response = send(url, json_content)
                    if response:
                        print(f"{bcolors.WARNING}{filename} file successfully sent!{bcolors.ENDC}")
            except Exception as e:
                print(e, file=sys.stderr)
            print(f"{current}/{files_quantity} are completed")
    except Exception as e:
        print(f'{bcolors.FAIL}An error occurred while trying to send the files. {e}{bcolors.ENDC}', file=sys.stderr)
