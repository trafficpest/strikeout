# StrikeOut

StrikeOut is a web app that helps you integrate Bitcoin payments as USD 
with ease. Using Strike's API for your website and business, you can 
accept Bitcoin in local currency without any fees to the merchant. For 
more information on Strike, visit https://strike.me.

### Requirements:

- HTTP server (Apache, Nginx, etc.)
- PHP installed
- Strike account API key

### Optional:

- Strike webhook subscription setup for triggering actions when an event 
is done, such as generating a CSV file of transactions and recording 
entries in your accounting software.

### Installation:

1. Navigate to the parent directory where you wish to install StrikeOut, 
for example: `cd public_html/`.
2. Make a directory, for example: `mkdir strikeout` or whatever name you want.
3. Enter the directory, for example: `cd strikeout`.
4. Clone the git to your server in the new directory. Use the following 
command from the directory you want to install StrikeOut to: 
`git clone https://github.com/trafficpest/strikeout.git .`

### Usage:

- View https://github.com/trafficpest/strikeout/wiki for more clarity.
Open your web browser and navigate to the directory where you installed 
StrikeOut. You will get a login screen. The default password is empty 
(i.e. not set). When you log in, you will enter the configuration page 
to enter your settings, including your password.

To create an invoice, load `checkout.php` with at least `amount` set 
in `POST` or `GET`. `invoice.php` is a test page to generate invoices and test 
your settings. You can see a basic HTML form example in the source there.

Strike webhooks are supported and can be created in the app. The app 
comes with two webhooks already available:

- CSV Payment: to record payments to a CSV for easy data export/import.
- FrontAccounting: to automate payment entries, including to proper 
customer accounts receivable. FrontAccounting is an open-source web-based 
double-entry accounting system. For more information, visit 
https://frontaccounting.com/.

### Note:

You should be able to add your accounting software/plugins pretty easily. 
To create one, make a new folder in the `webhooks` directory with any 
required source and assets then place the webhook PHP file in the `webhooks` 
folder for StrikeOut to list it. Please share your work with others.
