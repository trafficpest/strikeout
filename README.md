# strikeout

strikeout is to help you integrate Bitcoin payments as USD
Using Strike's API For your website and business.

Requires:
HTTP server (Apache, Nginx, etc) 
PHP installed and
Strike account API_key

Optional:
Strike webhook subscription (free) for generating csv of transactions
and recording entries in your accounting software.

Usage:
Clone the git to your server in the desired location
example of command from the directory you want to install strikeout to.

`git clone https://github.com/trafficpest/strikeout.git .`

copy or rename config.php.sample to config.php and adjust the array 
to your settings

$config = array(<br>
'api_key' => 'your strike key here',<br>
'qr_img_dir' => './qr-images/', // dir to save qr codes /tmp etc<br>
'payee_name' => 'your company here',<br>
'action_url' => './index.php' // your action page after paymemt<br>
  );

To create an invoice load start.php with at least 'amount' set in POST.
index.php is a test page to generate your invoice and test your settings. 
You can see a basic HTML form example in the source there.

Strike webhook is supported make a webhook at (need to put api-key)

https://docs.strike.me/api/create-subscription

make sure to have "invoice.updated" as an eventType
payments will be logged in a csv file at strikeout/webhooks/payments.csv


Coming soon:
Default CSS styling for invoice page and a pay button
Frontaccounting integration for automated payment accounting. Most
the stuff is already done but not tested yet. Will be finished
and uploaded soon. You should be able to add your own accounting
software pretty easily.
