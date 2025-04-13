#!/bin/bash
PSALM_OUTPUT=$(vendor/bin/psalm --config=psalm.xml --show-info=true --threads=6 "$@")

# Read OS_APP_DIRECTORY value from .env
ENV_FILE="public/include/global.php"
OS_APP_DIRECTORY=$(grep "define('OS_APP_DIRECTORY'" "$ENV_FILE" | sed -E "s/.*define\('OS_APP_DIRECTORY', '([^']+)'\);.*/\1/")

# Base path to replace
BASE_PATH="file://$OS_APP_DIRECTORY"

# Convert the paths to the specified base path in file:/// URL format
#CLICKABLE_OUTPUT=$(echo "$PSALM_OUTPUT" | sed -E "s#(?<!app\\\\)(modules|helpers|components|jobs)#$BASE_PATH\1#g")
# Don't handle routes, starting from app\...
CLICKABLE_OUTPUT=$(echo "$PSALM_OUTPUT" | perl -pe "s#(?<!app\\\\)(src|classes)#${BASE_PATH}\1#g")

# Output the result
echo "$CLICKABLE_OUTPUT"
