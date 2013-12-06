# Bootstrap-Simple-Uploadform #

This is a simple upload form for twitters bootstrap 3, it's all written in javascript.

## Features ##

- Upload multiple files with html5
- AMD ready
- easy to use
- simple, straightfoward uploadform

## Dependencies ##

- jQuery > 1.7


## Mark Up ##
```html
	<div class="modal fade uploadform in" id="imageUploadDialog" aria-hidden="false">
	    <!--    form action is used to configure the target url of the upload process
	            e.g. "/api/upload/photo/"
	    -->
	    <form action="upload.php?action=" method="POST" enctype="multipart/form-data" id="imageUploadForm">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <a aria-hidden="true" data-dismiss="modal" class="close">
	                        <i class="glyphicon glyphicon-remove-circle"></i>
	                    </a>
	                    <h4 class="modal-title">Choose image files to upload</h4>
	                </div>
	                <div class="modal-body">
	                    <div class="col-lg-12">
	                        <input type="file" multiple="multiple"
	                               name="files" accept="image/*" style="display:none" id="files[]">
	                        <button class="openDialog btn btn-default">Choose Files</button>
	                        <!--
	                            optional folder
	                        -->
	                        <select class="push-right folder">
	                            <option>testfolder</option>
	                            <option>testfolder2</option>
	                        </select> (optional folder, maybe for an album)
	                    </div>
	                    <ul class="fileContainer thumbnails col-lg-12">
	                        no files selected...
	                    </ul>
	                    <!--
	                        additional input controls
	                    -->
	                    <div class="form-group">
	                        <label for="artist">Artist*</label>
	                        <input id="artist" class="form-control" type="text">
	                    </div>
	                    <div class="alert clearfix"></div>
	                </div>
	                <div class="modal-footer">
	                    <div class="progress">
	                        <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60"
	                             role="progressbar" class="progress-bar"></div>
	                    </div>
	                    <button id="closeUploadform" class="btn btn-close" type="button">Close</button>
	                    <button class="btn btn-primary btnUpload" type="button" disabled="disabled">Upload</button>
	                </div>
	            </div>
	        </div>
	    </form>
	</div>
```

## Activate the Plugin ##
```javascript
	$("#musicUploadDialog").bsUploadform({
		//optional Callback
		onServerResponse: this.onServerResponse
	});
```

## Deactivate the Plugin ##
```javascript
	$("#musicUploadDialog").bsUploadform('destroy');
```

## Options ##

- defaultIcon: string  `"<i class='glyphicon glyphicon-file'></i>"`
- filetypeIcons: object  `filetypeIcons: {
                image: "<i class='glyphicon glyphicon-camera'></i>",
                audio: "<i class='glyphicon glyphicon-music'></i>"
            }`
- onServerResponse: function => empty

## Demo ##

[http://www.devcross.net/JsComponents/Uploadform/example/](http://devcross.net/JsComponents/Uploadform/example/ "Demo")

## Quick start

Two quick start options are available:

* [Download the latest release](https://github.com/devCrossNet/Bootstrap-Simple-Uploadform/archive/master.zip).
* Clone the repo: `git clone https://github.com/devCrossNet/Bootstrap-Simple-Uploadform.git`.

## Versioning

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

## Compiling CSS and JavaScript

run `grunt dist` in the rootfolder.

### Install Grunt

From the command line:

1. Install `grunt-cli` globally with `npm install -g grunt-cli`.
2. Navigate to the root directory, then run `npm install`. npm will look at [package.json](package.json) and automatically install the necessary local dependencies listed there.

When completed, you'll be able to run the various Grunt commands provided from the command line.

**Unfamiliar with `npm`? Don't have node installed?** That's a-okay. npm stands for [node packaged modules](http://npmjs.org/) and is a way to manage development dependencies through node.js. [Download and install node.js](http://nodejs.org/download/) before proceeding.


### Available Grunt commands

#### Only compile CSS and JavaScript - `grunt dist`
`grunt dist` creates the `/dist` directory with compiled files.

## Authors

**Johannes Werner**

+ <https://www.facebook.com/johannes.werner.98>

## Copyright and license

Copyright 2013 Johannes Werner under [the Apache 2.0 license](LICENSE).