## How to run ##

1. On intial run we need to create access token, run php script create_token.php for access token creatation.
	1. Click on link given when script run.
	2. Provide access to drive for app and get the approval token
	3. Enter the approval token	
2. Run upload_script.php script to upload file.
	1. php upload_script.php   -- Default file(drive_upload_files/default.txt) will be uploaded.
	2. php upload_script.php <filepath> -- Specfic file will be uploaded

## Setup new account for uploading file ##

1. Turn on the Drive API
	1. Use this wizard to create or select a project in the Google Developers Console and automatically turn on the API. 		   Click Continue, then Go to credentials.
	2. On the Add credentials to your project page, click the Cancel button.
	c. At the top of the page, select the OAuth consent screen tab. Select an Email address, enter a Product name if not 		   already set, and click the Save button.
	3. Select the Credentials tab, click the Create credentials button and select OAuth client ID.
	4. Select the application type Other, enter the name "Drive API Quickstart", and click the Create button.
	5. Click OK to dismiss the resulting dialog.
	6. Click the file_download (Download JSON) button to the right of the client ID.
2. Move this JSON file to your working_directory/credentials and rename it client_secret.json.
3. Run php script create_token.php for access token creatation.
