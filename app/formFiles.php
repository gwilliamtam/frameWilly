<?php
include_once "Template.php";
include_once('utils.php');

$template = new Template();

$template->setTitle('Form');
$template->header();


$date = date('y-m-d H:i:s');

if (!array_key_exists('sessionId', $_SESSION)) {
    $sessionId = getGUID();
    $_SESSION['sessionId'] = $sessionId;
} else {
    $sessionId = $_SESSION['sessionId'];
}

echo <<< HTML
<div class="container main">

    <form action="upload" method="post" id="upload-files-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value='$sessionId'>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="text" class="form-control" id="date" placeholder="Date" value="$date" readonly>
        </div>  
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
        </div>  
        
        <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea class="form-control" id="instructions" name="instructions" rows="3"></textarea>
        </div> 
                    
        <div class="form-group">
            Image <input id="input-file" name="inputFile" type='file' oninput="readFile()" value="">
        </div>
  
        <div class="form-group">
            <img id="img" width=300"><br>
        </div>
        <button type="button" id="submit-button" class="btn btn-primary">Submit</button>
    </form>

</div>

<script>
    $(document).ready(function(){

        document.getElementById("input-file").addEventListener("change", readFile);
        
        $('#submit-button').on('click', function(){
            let form =  $("#upload-files-form");
           if (validateForm()) {
               form.submit();
           } else {
               alert('Incomplete data in form');
           }
        });
    });
    
    function readFile() {
    
        if (this.files && this.files[0]) {
    
            let FR= new FileReader();
   
            FR.addEventListener("load", function(e) {
                document.getElementById("img").src = e.target.result;
            });
   
            FR.readAsDataURL( this.files[0] );
    
        }
    }
    
    function validateForm()
    {
        let name = $("#name");
        let instructions = $("#instructions");
        let inputFiles = $("#input-file");
        if (name.val().length === 0) {
            return false;
        }
        if (instructions.val().length === 0) {
            return false;
        }
        if (inputFiles[0].files[0].size === 0) {
            return false;
        }
        return true;
    }
    
</script>

HTML;

$template->footer();