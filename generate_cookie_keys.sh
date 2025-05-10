#!/bin/bash

# Fungsi untuk generate key gaya Yii2
generate_key() {
  openssl rand -base64 32 | cut -c1-32 | sed 'y/+=\//_.-/'
}

# Generate keys
key_be=$(generate_key)
key_fe=$(generate_key)

# Target file
ENV_FILE=".env"

# Update / add key to file
update_env() {
  local var=$1
  local value=$2

  if grep -q "^$var=" "$ENV_FILE"; then
    sed -i "s/^$var=.*/$var=$value/" "$ENV_FILE"
    echo "Updated $var in $ENV_FILE"
  else
    echo "$var=$value" >> "$ENV_FILE"
    echo "Added $var to $ENV_FILE"
  fi
}

#  update
update_env "COOKIE_VALIDATION_KEY_BE" "$key_be"
update_env "COOKIE_VALIDATION_KEY_FE" "$key_fe"
