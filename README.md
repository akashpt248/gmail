Gmail Email Fetcher (PHP + OAuth2)
----------------------------------

This project allows you to securely fetch and display Gmail messages using the Google Gmail API, OAuth 2.0, and PHP. It uses .env files to safely store credentials and supports offline access with refresh tokens for seamless integration without requiring user re-login.


1. Project Structure

	gmail/
	 ┣ 📄 get-token.php
	 ┣ 📄 oauth2callback.php
	 ┣ 📄 fetch-emails.php
	 ┣ 📄 .env
	 ┣ 📄 composer.json
	 ┣ 📄 vendor/ (Generated via Composer)

 2. Prerequisites

	PHP 7.4 or later
	Composer
	Gmail account
	Google Cloud project with Gmail API enabled


3. Setup

3.1 Clone or Download this Repository:

	git clone https://github.com/yourusername/gmail-fetcher-php.git
	cd gmail-fetcher-php

3.2 Install Dependencies:

     composer require google/apiclient vlucas/phpdotenv

	 Setup Google OAuth Credentials

3.3 Setup Google OAuth Credentials

	Go to Google Cloud Console:

	Create OAuth 2.0 credentials

	Add http://localhost:8000/oauth2callback.php as an authorized redirect URI

	Then fill in the .env file like this:

	GOOGLE_CLIENT_ID=your-client-id.apps.googleusercontent.com
	GOOGLE_CLIENT_SECRET=your-client-secret
	GOOGLE_REDIRECT_URI=http://localhost:8000/oauth2callback.php
	GOOGLE_REFRESH_TOKEN=your-refresh-token-after-auth


4. Workflow


        4.1 Running the Project Locally (via Terminal)

	cd path/to/your/project
	php -S localhost:8000


	4.2 Get OAuth2 Token

	http://localhost:8000/get-token.php
	You'll be redirected to Google's consent screen. After allowing access, Google will redirect back to your oauth2callback.php and display your access/refresh token.

	4.3  Store the Refresh Token

	Copy the "refresh_token" from the output and paste it into your .env file:

	   In Test Mode: The refresh_token will expire after 7 days unless the test user logs in again.	 Only 100 test users are allowed to use the OAuth app.
	   Each new login from the same user may issue a new refresh token and invalidate the previous one if not handled properly.

	   In Production Mode (after app is published):
	   The refresh_token will not expire unless:
	   The user manually revokes access.
	   You change the scopes or reset credentials.
	   You exceed token limits.

	GOOGLE_REFRESH_TOKEN=your-refresh-token-here


	4.4 Fetch Gmail Messages

	http://localhost:8000/fetch-emails.php



5.How It Works

	OAuth2 Flow:
	-----------

	get-token.php initiates Google auth and redirects to oauth2callback.php.

	oauth2callback.php receives the auth code, exchanges it for an access and refresh token.

	Token Reuse:
	-----------

	fetch-emails.php uses the refresh token to generate a valid access token automatically.

	Email Display:
	-----------

	Uses the Gmail API to get the last 3 emails (snippet, from, subject, date) and display them in an HTML table.


6. Security
	All sensitive credentials are stored securely in a .env file.

	Refresh tokens are used to avoid storing user passwords or prompting re-auth.


7.Customization

	To fetch more than 3 emails:

	<?php
	$optParams = ['maxResults' => 10]; 

	?>






