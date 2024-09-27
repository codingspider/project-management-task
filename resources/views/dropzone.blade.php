<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dropzone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>
</head>

<body>
    <div class="dropzone" id="myDragAndDropUploader"></div>
    <p id="message"></p>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}">
    </script>
    <script type="text/javascript">
    var maxFilesizeVal = 12;
    var maxFilesVal = 2;

    // Note that the name "myDragAndDropUploader" is the camelized id of the form.
    Dropzone.options.myDragAndDropUploader = {
        url: "file", // The name that will be used to transfer the file
        paramName: "file",
        maxFilesize: maxFilesizeVal, // MB
        maxFiles: maxFilesVal,
        resizeQuality: 1.0,
        acceptedFiles: ".jpeg,.jpg,.png,.webp",
        addRemoveLinks: false,
        timeout: 60000,
        dictDefaultMessage: "Drop your files here or click to upload",
        dictFallbackMessage: "Your browser doesn't support drag and drop file uploads.",
        dictFileTooBig: "File is too big. Max filesize: " + maxFilesizeVal + "MB.",
        dictInvalidFileType: "Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed.",
        dictMaxFilesExceeded: "You can only upload up to " + maxFilesVal + " files.",
        maxfilesexceeded: function(file) {
            this.removeFile(file);
            // this.removeAllFiles(); 
        },
        sending: function(file, xhr, formData) {
            $('#message').text('Image Uploading...');
        },
        success: function(file, response) {
            $('#message').text(response.success);
            console.log(response.success);
            console.log(response);
        },
        error: function(file, response) {
            $('#message').text('Something Went Wrong! ' + response);
            console.log(response);
            return false;
        }
    };
    </script>
</body>

</html>