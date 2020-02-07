## How to run ##

1. On intial run we need to create access token, run php script create_token.php for access token creatation.
	a. Click on link given when script run.
	b. Provide access to drive for app and get the approval token
	c. Enter the approval token	
2. Run upload_script.php script to upload file.
	a. php upload_script.php   -- Default file(drive_upload_files/default.txt) will be uploaded.
	b. php upload_script.php <filepath> -- Specfic file will be uploaded

## Setup new account for uploading file ##

1. Turn on the Drive API
	a. Use this wizard to create or select a project in the Google Developers Console and automatically turn on the API. 		   Click Continue, then Go to credentials.
	b. On the Add credentials to your project page, click the Cancel button.
	c. At the top of the page, select the OAuth consent screen tab. Select an Email address, enter a Product name if not 		   already set, and click the Save button.
	d. Select the Credentials tab, click the Create credentials button and select OAuth client ID.
	e. Select the application type Other, enter the name "Drive API Quickstart", and click the Create button.
	f. Click OK to dismiss the resulting dialog.
	g. Click the file_download (Download JSON) button to the right of the client ID.
2. Move this JSON file to your working_directory/credentials and rename it client_secret.json.
3. Run php script create_token.php for access token creatation.
