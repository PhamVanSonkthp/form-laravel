<style>
    #drop-region {
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.05);
        /*width:400px;*/
        padding: 20px;
        /*text-align: center;*/
        /*cursor: pointer;*/
        transition: .3s;
        min-height: 314px;
        position: relative;
    }

    #drop-region:hover {
        box-shadow: 0 0 45px rgba(0, 0, 0, 0.1);
    }

    #image-preview {
        margin-top: 20px;
    }

    #image-preview .image-view {
        display: inline-block;
        position: relative;
        margin-right: 13px;
        margin-bottom: 13px;
    }

    #image-preview .image-view img {
        max-width: 102px;
        max-height: 220px;
        box-shadow: rgb(0 0 0 / 20%) 0px 0px 1px inset;
        border-radius: 12px;
    }

    #image-preview .overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        right: 0;
        z-index: 2;
        background: rgba(255, 255, 255, 0.5);
    }

    #drop-message {
        position: absolute;
        transform: translate(-50%, -50%);
        left: 50%;
        bottom: 50%;
    }

    .delete-button{
        width: 0px;
        color: red;
        font-size: 25px;
        position: absolute;
        left: -5px;
        top: -5px;
    }

    .delete-button:hover{
        cursor: pointer;
    }

    .delete-button{
        visibility: hidden;
    }

    .image-view{
        cursor: pointer;
    }
    .image-view:hover .delete-button{
        visibility: visible;
    }

    .container-spinner{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<div id="drop-region">
    <div id="drop-message">
        Drag & Drop images or click to upload
    </div>
    <ul id="image-preview"></ul>
</div>

<script>

    let i = 0 ;

    $("#image-preview").sortable({
        update: function (event, ui) {
            dropIndex = ui.item.index();

            var imageIdsArray = [];
            $('#image-preview li').each(function (index) {
                // if (index <= dropIndex) {
                var id = $(this).attr('id');
                if (isDefine(id)){
                    var split_id = id.split("_");
                    imageIdsArray.push(split_id);
                    console.log(split_id)
                }

                // }
            });

        },
    });


    var // where files are dropped + file selector is opened
        dropRegion = document.getElementById("drop-region"),
        // where images are previewed
        imagePreviewRegion = document.getElementById("image-preview");


    // open file selector when clicked on the drop region
    var fakeInput = document.createElement("input");
    fakeInput.type = "file";
    fakeInput.accept = "image/*";
    fakeInput.multiple = true;
    // dropRegion.addEventListener('click', function () {
    //     fakeInput.click();
    // });

    fakeInput.addEventListener("change", function () {
        var files = fakeInput.files;
        handleFiles(files);
    });


    function preventDefault(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    dropRegion.addEventListener('dragenter', preventDefault, false)
    dropRegion.addEventListener('dragleave', preventDefault, false)
    dropRegion.addEventListener('dragover', preventDefault, false)
    dropRegion.addEventListener('drop', preventDefault, false)


    function handleDrop(e) {
        var dt = e.dataTransfer,
            files = dt.files;

        if (files.length) {

            handleFiles(files);

        } else {

            // check for img
            var html = dt.getData('text/html'),
                match = html && /\bsrc="?([^"\s]+)"?\s*/.exec(html),
                url = match && match[1];


            if (url) {
                uploadImageFromURL(url);
                return;
            }

        }


        function uploadImageFromURL(url) {
            var img = new Image;
            var c = document.createElement("canvas");
            var ctx = c.getContext("2d");

            img.onload = function () {
                c.width = this.naturalWidth;     // update canvas size to match image
                c.height = this.naturalHeight;
                ctx.drawImage(this, 0, 0);       // draw in image
                c.toBlob(function (blob) {        // get content as PNG blob

                    // call our main function
                    handleFiles([blob]);

                }, "image/png");
            };
            img.onerror = function () {
                alert("Error in uploading");
            }
            img.crossOrigin = "";              // if from different origin
            img.src = url;
        }

    }

    dropRegion.addEventListener('drop', handleDrop, false);


    function handleFiles(files) {
        for (var i = 0, len = files.length; i < len; i++) {
            if (validateImage(files[i]))
                previewAnduploadImage(files[i]);
        }
    }

    function validateImage(image) {
        // check the type
        var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (validTypes.indexOf(image.type) === -1) {
            alert("Invalid File Type");
            return false;
        }

        // check the size
        var maxSizeInBytes = 10e6; // 10MB
        if (image.size > maxSizeInBytes) {
            alert("File too large");
            return false;
        }

        return true;

    }

    function previewAnduploadImage(image) {

        $('#drop-message').hide()

        // container
        var imgView = document.createElement("li");
        imgView.className = "image-view";
        imgView.id = "drop_image__"+ ++i;

        imagePreviewRegion.appendChild(imgView);

        // previewing image
        var img = document.createElement("img");
        imgView.appendChild(img);

        // progress overlay
        var overlay = document.createElement("i");
        overlay.className = "overlay";
        imgView.appendChild(overlay);

        // spinner overlay
        var container_spinner = document.createElement("span");
        container_spinner.className = "container-spinner";
        var spinner = document.createElement("i");
        spinner.className = "fa fa-spin fa-spinner";
        container_spinner.appendChild(spinner);
        imgView.appendChild(container_spinner);

        // delete button
        var delete_button = document.createElement("i");
        delete_button.onclick = function(){
            if($('#image-preview').children().length == 0){
                $('#drop-message').show()
            }

            const removed_id = imgView.id.split('__')[1]
            imgView.remove()

            ajax.open("DELETE", '{{$delete_api}}', true);

        };
        delete_button.className = "fa fa-minus-square-o delete-button";
        imgView.appendChild(delete_button);

        // read the image...
        var reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
        }
        reader.readAsDataURL(image);

        // create FormData
        var formData = new FormData();
        formData.en
        formData.append('image', image);

        // upload the image
        formData.append('key', 'bb63bee9d9846c8d5b7947bcdb4b3573');

        console.log(image)

        var ajax = new XMLHttpRequest();
        ajax.open("POST", '{{$post_api}}', true);
        ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        ajax.setRequestHeader("Content-Type","multipart/form-data");
        ajax.setRequestHeader("boundary","----WebKitFormBoundaryyrV7KO0BoCBuDbTL");

        ajax.onreadystatechange = function (e) {
            if (ajax.readyState === 4) {
                if (ajax.status === 200) {
                    // done!
                    container_spinner.remove()
                    overlay.style.width = 100;

                    console.log(e)

                } else {
                    // error!
                    console.log(e)
                }
            }
        }

        ajax.upload.onprogress = function (e) {

            // change progress
            // (reduce the width of overlay)

            var perc = (e.loaded / e.total * 100) || 100,
                width = 100 - perc;

            overlay.style.width = width;

            // if (perc == 100){
            //     container_spinner.remove()
            // }
            console.log(perc)

            $("#image-preview").sortable( "refresh" );

        }

        ajax.send(formData);

    }
</script>
