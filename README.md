# StrikeOut

StrikeOut is a web app to help you integrate Bitcoin payments as USD
as easily as possible. Using Strike's API For your website and business. 
Strike allows you to accept Bitcoin in local currency without any fees
to the merchant. For more info on Strike look at https://strike.me 

Requires:
HTTP server (Apache, Nginx, etc)
PHP installed
Strike account API_key

Optional:
Strike webhook subscription setup for triggering actions when an event is
done. Such as, generating a csv file of transactions and recording 
entries in your accounting software.

Usage:
Navigate to the parent directory to where you wish to install StrikeOut
ex: `cd public_html/

Make a directory ex:`mkdir strikeout` or whatever name you want

Enter the directory ex: `cd strikeout`
Clone the git to your server in the new directory
example of command from the directory you want to install strikeout to.

`git clone https://github.com/trafficpest/strikeout.git .`

After installation
Open your web browser and navigate to the directory where you installed
strikeout. You will get a login screen. The default password is empty
ie. not set. When you log in you will enter the configuration page to enter
your settings including your password.

To create an invoice load checkout.php with at least 'amount' set in POST.
invoice.php is a test page to generate your invoice and test your settings.
You can see a basic HTML form example in the source there.

Strike webhooks are supported and can be created in the app.
App comes with two available webhooks already available. 
CSV Payment, to record payments to a CSV for easy data export/import.
FrontAccounting to automate payment entries including to proper customer
accounts receivable.
FrontAccounting is open source web based double entry accounting system
More info is available at https://frontaccounting.com/

You should be able to add your own accounting software / plugins pretty 
easily. To create or install one make a folder in webhooks directory 
and place the webhook php file in webhooks folder for SrikeOut to list it. 
Please share your work for others.
