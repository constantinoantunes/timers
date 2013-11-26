#!/usr/bin/env bash
#
# Minifies all assets
#

MYPATH=`dirname $(readlink -f $0)`

cssFiles=$(cat <<EOF
public/assets/bootstrap/css/bootstrap.min.css
public/assets/bootstrap/css/bootstrap.min.css
EOF
)

jsFrameworkFiles=$(cat <<EOF
public/assets/jquery-1.10.2.js
public/assets/underscore.js
public/assets/bootstrap/js/bootstrap.js
EOF
)

jsAppFiles=$(cat <<EOF
public/assets/timers.js
EOF
)

echo "compressing css..."
java -jar ${MYPATH}/yuicompressor-2.4.8.jar --type css <(cat $cssFiles) 		-o public/assets/style.min.css
echo "compressing js frameworks..."
java -jar ${MYPATH}/yuicompressor-2.4.8.jar --type js <(cat $jsFrameworkFiles) 	-o public/assets/frameworks.min.js
echo "compressing js app..."
java -jar ${MYPATH}/yuicompressor-2.4.8.jar --type js <(cat $jsAppFiles) 		-o public/assets/app.min.js
echo "Done!"