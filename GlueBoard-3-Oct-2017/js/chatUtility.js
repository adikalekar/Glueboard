$(document).ready(function(){
    getNotes();
    $('.msg_wrap').slideToggle('slow');
    
	$('#toggleNotes').click(function(){
		$('.msg_wrap').slideToggle('slow');
	});
		
	$('#reset').click(function(){
		 $('#newMsgBox').val('');
	});
    
    $('#refreshNotes').click(function(){
        getNotes();
	});
    
    $('#addNote').click(function(e){
		 e.preventDefault();
         var bullyId = $('#bullyId').val();
         var message = $('#newMsgBox').val();
         var sentBy = $('#name').val();
         var role = $('#role').val();
         var hideFromStudent = "N";
         if(document.getElementById('hideNote').checked) {
            hideFromStudent = "Y";
         }
			if(message!='')			
            sendNote(bullyId,message,sentBy,role,hideFromStudent);
	});
    
function sendNote(bullyId,message,sentBy,role,hideFromStudent) {
  $.ajax({
    url: '../Bully/addNote.php',
    method: 'post',
    data: {bullyId: bullyId,
           message: message,
           sentBy: sentBy,
           role: role,
           hideFromStudent: hideFromStudent
           },
    success: function(data) {
      $('#newMsgBox').val('');
      $('#hideNote').attr('checked', false);
      getNotes();
    }
  });
}

/**
 * Get's the chat messages.
 */
function getNotes() {
    var bullyId = $('#bullyId').val();
    var counselorId = $('#counselorId').val();
    var timeZone = $('#timeZone').val();
  $.ajax({
    url: '../Bully/getNotes.php',
    method: 'GET',
    data: {bullyId: bullyId,
           counselorId: counselorId,
           timeZone: timeZone
    },
    success: function(data) {
      $('.msg_body').html(data);
      $('#messageBox').show();
    }
  });
}
});