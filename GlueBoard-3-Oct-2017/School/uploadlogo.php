<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="../themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
       <script src="../css/fileinput.js"></script>  
    <script src="../css/sortable.js" type="text/javascript"></script>
    <script src="../css/fileinput.js" type="text/javascript"></script>
    <script src="../css/fr.js" type="text/javascript"></script>
    <script src="../css/es.js" type="text/javascript"></script>
    <script src="../css/theme.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
           
    <form enctype="multipart/form-data">
      <div class="form-group">
            <input id="file-1" name="images" type="file" class="file" data-overwrite-initial="false" data-min-file-count="1">
        </div>
    </form>
    </body><script>
   
    $("#file-1").fileinput({
        uploadUrl: 'upload.php', // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        
    });
</script>
</html>
