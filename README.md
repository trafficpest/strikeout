# StrikeOut

StrikeOut is a web app that helps you integrate and account payments
with ease. Using StrikeOut for your website and business, you can 
accept multiple forms of payment including PayPal, Credit Cards, Venmo, and 
Bitcoin. With Bitcoin you can receive local currency without any fees to the 
merchant using a service called strike. For more on Strike, visit 
https://strike.me

StrikeOut uses a modular payment method and webhook plugin system. You can 
configure and mix and match your desired payments methods and webhook actions.
If there isnt something you want you can add it.

StrikeOut comes with a modified version of the open source accounting software
FrontAccounting found in `books/` directory. It can generate QR codes on paper
and autoemailed invoices for clients to pay their account. For more on 
FrontAccounting, visit https://frontaccounting.com/

### Requirements:

- HTTP server (Apache, Nginx, etc.)
- PHP installed
- Payment Method API keys such as Strike or PayPal to activate payment methods. 

### Optional:

- mySQL server to setup the included frontaccounting app. 
- Webhook setup for triggering actions when an event is done, such as 
generating a CSV file of transactions and recording 
entries in your accounting software.

### Installation:

- To use the current release
1. Download the latest StrikeOut release zip file 
2. On the desired web server in a hosted folder navigate to the parent 
directory where you wish to install StrikeOut create a directory and unzip
the file contents inside the the desired directory.

- To use the bleeding edge repo (Could have bugs)
1. On the desired web server in a hosted folder navigate to the parent 
directory where you wish to install StrikeOut, 
for example: `cd public_html/`.
2. Make a directory, for example: `mkdir strikeout` or whatever name you want.
3. Enter the directory, for example: `cd strikeout`.
4. Clone the git to your server in the new directory. Use the following 
command from the directory you want to install StrikeOut to: 
`git clone https://github.com/trafficpest/strikeout.git .`

### Usage:

Visit the wiki https://github.com/trafficpest/strikeout/wiki for more clarity.

- Open your web browser and navigate to the directory where you installed 
StrikeOut. You will get a login screen. The default password is empty 
(i.e. not set). When you log in, you will enter the applications principal page 
Click the StikeOut icon to enter the applications global configuration page 
to enter your settings, including your password.

To create an invoice, load `checkout.php` with at least `amount` set 
in `POST` or `GET`. In each payment method page there are `Create Invoice` forms
to generate invoices and test your settings.

Webhooks are supported and can be created in the app. The app 
comes with two webhook plugins already available:

- CSV Payment: to record payments to a CSV for easy data export/import.
- FrontAccounting: to automate payment entries, including to proper 
customer accounts receivable. FrontAccounting is an open-source web-based 
double-entry accounting system. For more information, visit 
https://frontaccounting.com/.

### Note:

You should be able to add your own payment methods or webhook plugins pretty 
easily. To create payment method, make a new folder in the `methods` directory 
with any required source and assets inside. To create webhook, make a new 
folder in the `webhooks` directory with any required source and assets then 
place the webhook PHP file in the `webhooks` folder for StrikeOut to list it. 
Please share your work with others.
