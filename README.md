# DNS Updater

If you are tired of your current dynamic DNS service provider and are a DigitalOcean
client you can use this tool to replace your current service with this (very) simple solution.

It relies on DigitalOcean's API v2 to update a given A record of your domain.

Pull Requests supporting additional DNS services are welcome.

## Quick Start

### 1. Install the dependencies

    composer install

### 2. Get your secrets

By now you should have a Personal Access Token from DigitalOcean. If you don't,
[check this instructions](https://www.digitalocean.com/community/tutorials/how-to-use-the-digitalocean-api-v2)
and create a new Personal Access Token with the `write` permission.

You'll also need an OTP secret that can be obtained with the following command:

    bin/console otp:generate-secret

### 2. Configure your Environment

You'll need to set the environment variables listed in the `.env.dist` file.
You can do so by copying it removing the `.dist` suffix and editing it's contents.

    cp .env.dist .env

### 3. Setup your OTP Generator (Google Authenticator or similar)

After configuring your `.env` variables you'll be able to generate a link to the QR Code
used for setting up your OTP Generator app. Just type:

    bin/console otp:get-qr-code

### 4. Taking it for a spin

You can now run it locally to test it:

    bin/console server:run
    