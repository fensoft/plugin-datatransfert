#!/bin/bash
sudo apt-get update
sudo apt-get -y install zip wget
cd `dirname $0`
VERSION=v1.40

chmod a+x *.sh
rm -rf rclone-$VERSION-osx-386.zip rclone-$VERSION-osx-386 jeedom-rclone-configurator.app jeedom-rclone-configurator.zip
wget https://downloads.rclone.org/$VERSION/rclone-$VERSION-osx-386.zip
unzip rclone-$VERSION-osx-386.zip
mkdir jeedom-rclone-configurator.app
mkdir -p jeedom-rclone-configurator.app/Contents/MacOS jeedom-rclone-configurator.app/Contents/Resources
cp datatransfert_icon.icns jeedom-rclone-configurator.app/Contents/Resources/iconfile.icns
cp Info.plist jeedom-rclone-configurator.app/Contents
mv rclone-$VERSION-osx-386/rclone jeedom-rclone-configurator.app/Contents/MacOS/rclone.bin
cp rclone.sh jeedom-rclone-configurator.app/Contents/MacOS/jeedom-rclone-configurator
zip -r jeedom-rclone-configurator jeedom-rclone-configurator.app
rm -rf rclone-$VERSION-osx-386.zip rclone-$VERSION-osx-386 jeedom-rclone-configurator.app