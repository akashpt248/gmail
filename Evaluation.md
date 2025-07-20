| Test Case        | Description                                     | Expected Result                         | Status        |
| ---------------- | ----------------------------------------------- | --------------------------------------- | ------------- |
| Token Generation | Run `get-token.php` and authenticate via Google | Redirects, shows access & refresh token | ☐ Pass ☐ Fail |
| Token Storage    | Refresh token stored securely in `.env`         | `.env` contains token, not in code      | ☐ Pass ☐ Fail |
| Email Fetching   | Run `fetch-emails.php`                          | Displays a list of recent emails        | ☐ Pass ☐ Fail |
| Email Fields     | Each email shows From, Subject, Date, Snippet   | Data matches Gmail inbox                | ☐ Pass ☐ Fail |
| Token Refresh    | Token refreshes without re-login                | Emails load with just refresh token     | ☐ Pass ☐ Fail |
