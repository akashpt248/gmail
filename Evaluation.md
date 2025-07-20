Project Name: Gmail Email Fetcher (PHP + OAuth2)
Date: 20-08-25
Developer: Akash P T

1.Functional Evaluation

| Test Case        | Description                                     | Expected Result                         | Status        |
| ---------------- | ----------------------------------------------- | --------------------------------------- | ------------- |
| Token Generation | Run `get-token.php` and authenticate via Google | Redirects, shows access & refresh token | Passed |
| Token Storage    | Refresh token stored securely in `.env`         | `.env` contains token, not in code      | Passed |
| Email Fetching   | Run `fetch-emails.php`                          | Displays a list of recent emails        | Passed |
| Email Fields     | Each email shows From, Subject, Date, Snippet   | Data matches Gmail inbox                | Passed |
| Token Refresh    | Token refreshes without re-login                | Emails load with just refresh token     | Passed |


2.Security Evaluation

| Test Case             | Description                           | Expected Result                                  | Status        |
| --------------------- | ------------------------------------- | ------------------------------------------------ | ------------- |
| No Plaintext Secrets  | No sensitive keys in PHP files        | All secrets inside `.env` only                   | Passed |
| Token Scope           | Only read-only Gmail access requested | `https://www.googleapis.com/auth/gmail.readonly` | Passed |
| Token Expiry Handling | Graceful handling of token expiry     | Message: “Access token expired”                  | Passed |


3.Code Evaluation

| Test Case             | Description                     | Expected Result                 | Status        |
| --------------------- | ------------------------------- | ------------------------------- | ------------- |
| Code Clarity          | Well-structured, commented code | Easy to read/extend             | ☐ Passed |
| Reusability           | Token & email logic separable   | Can be imported into other apps | Passed |
| Dependency Management | Composer used for libraries     | `vendor` folder auto-generated  | Passed |


