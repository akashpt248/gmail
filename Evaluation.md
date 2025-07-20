Project Name: Gmail Email Fetcher (PHP + OAuth2)
Date: 20-08-25
Developer: Akash P T

| Test Case        | Description                                     | Expected Result                         | Status        |
| ---------------- | ----------------------------------------------- | --------------------------------------- | ------------- |
| Token Generation | Run `get-token.php` and authenticate via Google | Redirects, shows access & refresh token | Passed |
| Token Storage    | Refresh token stored securely in `.env`         | `.env` contains token, not in code      | Passed |
| Email Fetching   | Run `fetch-emails.php`                          | Displays a list of recent emails        | Passed |
| Email Fields     | Each email shows From, Subject, Date, Snippet   | Data matches Gmail inbox                | Passed |
| Token Refresh    | Token refreshes without re-login                | Emails load with just refresh token     | Passed |
