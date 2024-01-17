![Static Badge](https://img.shields.io/badge/3%2B-joomla?logo=joomla&label=Joomla&logoColor=white&color=blue&labelColor=black&style=for-the-badge)
![Static Badge](https://img.shields.io/badge/7.4%2B-joomla?logo=php&label=PHP&logoColor=white&color=darkgreen&labelColor=black&style=for-the-badge)

This is a simple script to test the email sending functionality of Joomla.
It allows sending an email to a specific address with a specific subject and body.
This helps to confirm that the email settings are correct and the emails are sent correctly.

# Usage
1. Download the script
2. Upload it to the root of your Joomla installation
3. Run the script from console (SSH)

## Parameters
Script accepts 3 parameters:
1. Email address of recipient (required)
2. Email subject (optional)
3. Email body (optional)

Usage example:
```bash
php email-test.php user@example.org "Test email" "This is a test email"
```

# Useful links
- The recommended service to test the mail settings is:
https://www.mail-tester.com/