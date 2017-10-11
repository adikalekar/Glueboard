
<?php 
function valid($id)
{
?>
<div class='modal-header'>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class='modal-title'>Upload School Policies</h4>
</div>
<div class='modal-body'>
						
				
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <input type="hidden" id="userid" value="<?php echo $id; ?>">
            <input id="file-1" type="file" name="schoolfiles" multiple class="file" data-overwrite-initial="false" data-min-file-count="1">
        </div>
    </form>
 </div>
<?php
}
include('../includes/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{
$id = $_GET['id'];

valid($id);
}
else
{
echo "No results!";
}

?>
    <script type="text/javascript">
        
        $("#file-1").fileinput({
        uploadUrl: 'upload.php', // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['pdf'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
            uploadExtraData: function() {
            return {
                userid: $("#userid").val()
                
            };
        },
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });
    </script>
