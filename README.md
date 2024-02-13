![Joomla Badge](https://img.shields.io/badge/3%2C4-joomla?logo=joomla&label=Joomla&logoColor=white&color=blue&labelColor=black&style=for-the-badge)
![PHP Badge](https://img.shields.io/badge/7.4%2B-joomla?logo=php&label=PHP&logoColor=white&color=darkgreen&labelColor=black&style=for-the-badge)

![Banner](media/email-tester.jpg)

This is a simple script to test the email sending functionality of Joomla.
It allows sending an email to a specific address with a specific subject and body.
This helps to confirm that the email settings are correct and the emails are sent correctly.
The script supports all available Joomla mail configuration options, including SMTP and PHPMailer.

# Usage
1. Download the script [`email-test.php`](https://github.com/walitoff/joomla-email-test/blob/main/src/email-test.php)
2. Upload it to the root of your Joomla installation
3. Run the script from console (SSH)

## Parameters
Script accepts 3 parameters:
1. Email address of recipient (required)
2. Email subject (optional)
3. Email body (optional)

## Usage example
```bash
php email-test.php user@example.org "Test email" "This is a test email"
```

## Sample output
```console
user@server:/var/www/web# php email-test.php test-prdnmijk9@srv1.mail-tester.com
Detected PHP 8.2.12
Detected Joomla 3.10.12
Email recipient: test-prdnmijk9@srv1.mail-tester.com
Email subject: Test email from Joomla
Email body: This is a test email from Joomla.
Email sent. Check the mailbox.
```

# Useful links
- The recommended service to test the mail settings is:
https://www.mail-tester.com/
