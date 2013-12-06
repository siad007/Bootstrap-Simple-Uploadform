<html>

<head>
    <title>Bootstrap-Simple-Uploadform Example</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Bootstrap-Simple-Uploadform.css">
    <style>
        body { padding-top: 70px; }
        .table {
            font-size: 14px;
            margin-bottom: 20px;
            width: 100%;
        }
    </style>
</head>

<body>

<!--
    Navigation
-->

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">devCross.net</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="#example">Example</a></li>
            <li><a href="#markup">Markup</a></li>
            <li><a href="#javascript">Javascript</a></li>
            <li><a href="#options">Options</a></li>
            <li><a href="../Bootstrap-Simple-Uploadform.zip">Download</a></li>
            <li><a href="https://github.com/devCrossNet/Bootstrap-Simple-Uploadform">GitHub Project</a></li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>


<!--
    Documentation
-->

<div class="col-xs-12">
    <div class="container">
        <div id="example" class="page-header">
            <h1>Bootstrap-Simple-Uploadform Example</h1>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <button id="btnshow" class="btn btn-primary btn-large">show UploadForm</button>
            </div>
        </div>
        <div class="col-xs-12 alert alert-info">
            <h3>Log</h3>
            <ul id="log"></ul>
        </div>

        <div id="markup" class="page-header">
            <h2>Markup</h2>
        </div>

        <pre class="prettyprint linenumbs">
    &lt;div class=&quot;modal fade uploadform in&quot; id=&quot;imageUploadDialog&quot; aria-hidden=&quot;false&quot;&gt;
        &lt;!--    form action is used to configure the target url of the upload process
                e.g. &quot;/api/upload/photo/&quot;
        --&gt;
        &lt;form action=&quot;upload.php?action=&quot; method=&quot;POST&quot; enctype=&quot;multipart/form-data&quot; id=&quot;imageUploadForm&quot;&gt;
            &lt;div class=&quot;modal-dialog&quot;&gt;
                &lt;div class=&quot;modal-content&quot;&gt;
                    &lt;div class=&quot;modal-header&quot;&gt;
                        &lt;a aria-hidden=&quot;true&quot; data-dismiss=&quot;modal&quot; class=&quot;close&quot;&gt;
                            &lt;i class=&quot;glyphicon glyphicon-remove-circle&quot;&gt;&lt;/i&gt;
                        &lt;/a&gt;
                        &lt;h4 class=&quot;modal-title&quot;&gt;Choose image files to upload&lt;/h4&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;modal-body&quot;&gt;
                        &lt;div class=&quot;col-lg-12&quot;&gt;
                            &lt;input type=&quot;file&quot; multiple=&quot;multiple&quot;
                                   name=&quot;files&quot; accept=&quot;image/*&quot; style=&quot;display:none&quot; id=&quot;files[]&quot;&gt;
                            &lt;button class=&quot;openDialog btn btn-default&quot;&gt;Choose Files&lt;/button&gt;
                            &lt;!--
                                optional folder
                            --&gt;
                            &lt;select class=&quot;push-right folder&quot;&gt;
                                &lt;option&gt;testfolder&lt;/option&gt;
                                &lt;option&gt;testfolder2&lt;/option&gt;
                            &lt;/select&gt; (optional folder, maybe for an album)
                        &lt;/div&gt;
                        &lt;ul class=&quot;fileContainer thumbnails col-lg-12&quot;&gt;
                            no files selected...
                        &lt;/ul&gt;
                        &lt;!--
                            additional input controls
                        --&gt;
                        &lt;div class=&quot;form-group&quot;&gt;
                            &lt;label for=&quot;artist&quot;&gt;Artist*&lt;/label&gt;
                            &lt;input id=&quot;artist&quot; class=&quot;form-control&quot; type=&quot;text&quot;
                        &lt;/div&gt;
                        &lt;div class=&quot;alert clearfix&quot;&gt;&lt;/div&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;modal-footer&quot;&gt;
                        &lt;div class=&quot;progress&quot;&gt;
                            &lt;div style=&quot;width: 0%;&quot; aria-valuemax=&quot;100&quot; aria-valuemin=&quot;0&quot; aria-valuenow=&quot;60&quot;
                                 role=&quot;progressbar&quot; class=&quot;progress-bar&quot;&gt;&lt;/div&gt;
                        &lt;/div&gt;
                        &lt;button id=&quot;closeUploadform&quot; class=&quot;btn btn-close&quot; type=&quot;button&quot;&gt;Close&lt;/button&gt;
                        &lt;button class=&quot;btn btn-primary btnUpload&quot; type=&quot;button&quot; disabled=&quot;disabled&quot;&gt;Upload&lt;/button&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/form&gt;
    &lt;/div&gt;</pre>

        <div id="javascript" class="page-header">
            <h2>Javascript</h2>
        </div>

        <pre class="prettyprint linenumbs">
        &lt;script&gt;
            $(document).ready(function () {

                // function to display the response from the server
                function echo(response) {
                    response = JSON.parse(response);
                    $(&quot;#log&quot;).append(&quot;&lt;li&gt;&quot; + response.status + &quot;: &quot; + response.file.name + &quot; (&quot; + response.file.size + &quot;)&lt;/li&gt;&quot;);
                }

                // initialize the plugin and show the dialog
                $(&quot;#btnshow&quot;).click(function (e) {
                    $(&quot;#imageUploadDialog&quot;).bsUploadform({
                        //optional Callback
                        onServerResponse: echo
                    });
                    $(&quot;#imageUploadDialog&quot;).modal(&quot;show&quot;);
                });

                // unload plugin and hide the dialog
                $(&quot;#closeUploadform&quot;).click(function () {
                    $(&quot;#imageUploadDialog&quot;).bsUploadform('destroy');
                    $(&quot;#imageUploadDialog&quot;).modal(&quot;hide&quot;);
                });
                $(&quot;.close&quot;, $(&quot;#imageUploadDialog&quot;)).click(function () {
                    $(&quot;#imageUploadDialog&quot;).bsUploadform('destroy');
                    $(&quot;#imageUploadDialog&quot;).modal(&quot;hide&quot;);
                });
            });
        &lt;/script&gt;</pre>

        <div id="options" class="page-header">
            <h2>Options</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="width: 100px;">Name</th>
                    <th style="width: 50px;">type</th>
                    <th style="width: 50px;">default</th>
                    <th>description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>defaultIcon</td>
                    <td>string</td>
                    <td><code>&lt;i class='glyphicon glyphicon-file'&gt;&lt;/i&gt;</code></td>
                    <td>default icon for non specific files.
                    </td>
                </tr>
                <tr>
                    <td>filetypeIcons</td>
                    <td>object</td>
                    <td><pre class="prettyprint linenumbs">
filetypeIcons: {
    image: &quot;&lt;i class='glyphicon glyphicon-camera'&gt;&lt;/i&gt;&quot;,
    audio: &quot;&lt;i class='glyphicon glyphicon-music'&gt;&lt;/i&gt;&quot;
}</pre>
                    </td>
                    <td>mimeType specific icons. key => mimetype, value => icon</td>
                </tr>
                <tr>
                    <td>onServerResponse</td>
                    <td>function</td>
                    <td>empty</td>
                    <td>is called after the server response</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<!--
    Upload Form
-->
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

<!--
    Javascript section
-->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="../js/Bootstrap-Simple-Uploadform.js"></script>
<script>
    $(document).ready(function () {

        // function to display the response from the server
        function echo(response) {
            $("#log").append("<li>" + response + "</li>");
        }

        // initialize the plugin and show the dialog
        $("#btnshow").click(function (e) {
            $("#imageUploadDialog").bsUploadform({
                //optional Callback
                onServerResponse: echo
            });
            $("#imageUploadDialog").modal("show");
        });

        // unload plugin and hide the dialog
        $("#closeUploadform").click(function () {
            $("#imageUploadDialog").bsUploadform('destroy');
            $("#imageUploadDialog").modal("hide");
        });
        $(".close", $("#imageUploadDialog")).click(function () {
            $("#imageUploadDialog").bsUploadform('destroy');
            $("#imageUploadDialog").modal("hide");
        });
    });
</script>
<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

</body>

</html>