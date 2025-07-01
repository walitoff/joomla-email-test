![Joomla Badge](https://img.shields.io/badge/3%2C4%2C5-joomla?logo=joomla&label=Joomla&logoColor=white&color=blue&labelColor=black&style=for-the-badge)
![PHP Badge](https://img.shields.io/badge/7.4%2B-joomla?logo=php&label=PHP&logoColor=white&color=darkgreen&labelColor=black&style=for-the-badge)

![Banner](media/email-tester.jpg)

# Joomla Email Test CLI Tool

A command-line utility for testing email functionality in Joomla sites. This tool sends a test email using your Joomla's
configured email settings, allowing administrators to verify that their email configuration is working correctly.

## Features

- ✅ **Multi-version support**: Compatible with Joomla 3.x, 4.x, and 5.x
- ✅ **Native integration**: Uses Joomla's built-in email configuration
- ✅ **Command-line interface**: Perfect for automation and server management
- ✅ **Customizable content**: Set custom email subject and body
- ✅ **Zero configuration**: Uses your existing Joomla email settings
- ✅ **Multiple mail methods**: Supports SMTP, sendmail, PHPMailer, and all Joomla mail options

## Requirements

- PHP 7.4 or newer
- Joomla 3.0 or newer (tested with Joomla 3.x, 4.x, and 5.x)
- CLI environment (command line access)
- Must be run from Joomla root directory

## Installation

1. Download the script [`email-test.php`](src/email-test.php)
2. Upload it to the root directory of your Joomla installation

## Usage

```bash
php email-test.php email-recipient [email-subject] [email-body]
```

### Parameters

| Parameter         | Type     | Description                             | Default                             |
|-------------------|----------|-----------------------------------------|-------------------------------------|
| `email-recipient` | Required | Email address to send the test email to | -                                   |
| `email-subject`   | Optional | Custom email subject                    | "Test email from Joomla"            |
| `email-body`      | Optional | Custom email body (plain text)          | "This is a test email from Joomla." |

### Examples

**Basic usage:**

```bash
php email-test.php user@example.org
```

**With custom subject:**

```bash
php email-test.php user@example.org "My Test Subject"
```

**With custom subject and body:**

```bash
php email-test.php user@example.org "Server Test" "Testing email functionality from production server."
```

## Sample Output

```console
user@server:/var/www/joomla# php email-test.php test@example.com
Detected PHP 8.2.12
Detected Joomla 5.0.3
Email recipient: test@example.com
Email subject: Test email from Joomla
Email body: This is a test email from Joomla.
Email sent. Check the mailbox.
```

## Testing Email Deliverability

For comprehensive email testing, we recommend using:

- **[Mail Tester](https://www.mail-tester.com/)** - Tests spam score and deliverability
- **[MailHog](https://github.com/mailhog/MailHog)** - Local email testing for development

Example with Mail Tester:

```bash
php email-test.php test-abc123@srv1.mail-tester.com "Production Test" "Testing from live server"
```

