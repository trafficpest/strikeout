# strikeout

strikeout is to help you integrate Bitcoin payments as USD
Using Strike's API For your website and business.

Requires:
HTTP server (Apache, Nginx, etc) 
PHP installed and
Strike account API_key

Usage:
Clone the git to your server in the desired location

Adjust the /config.php array to your settings

$config = array(<br>
'api_key' => 'your strike key here',<br>
'qr_img_dir' => './qr-images/', // dir to save qr codes /tmp etc<br>
'payee_name' => 'your company here',<br>
'action_url' => './index.php' // your action page after paymemt<br>
  );

To create an invoice load start.php with at least 'amount' set in POST.
index.php is a test page to generate your invoice you can see a basic HTML
Form example there.

Coming soon:
Default CSS styling for invoice page and a pay button
Strike payment webhook support with CSV logging like a statement.
Frontaccounting integration for automated payment accounting. Most
The webhook stuff is already done but not tested yet. Will be finished
And uploaded soon. You should be able to add your own accounting
software pretty easily.
