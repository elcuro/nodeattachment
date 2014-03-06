var NA = {
	node_id: false,
	pluginPath: Croogo.basePath+'admin/nodeattachment/nodeattachments/'
};

// Methods on document ready
NA.documentReady = function() {
	NA.loadFileuploader();
	NA.editable();
	NA.remoteUpload();
	NA.sortable();
	NA.deletable();
};

// Return current node id
NA.nodeId = function() {
	if (NA.node_id == false) {
		NA.node_id = $('#nodeattachment-container').data('node-id');
	}
	return NA.node_id;
};

// Load file uploader
NA.loadFileuploader = function() {	
	var actionPath = NA.pluginPath+'upload/'+NA.nodeId()+'.json';
	NA.fileuploader = new qq.FileUploader({
	    element: document.getElementById('file-uploader'),
	    action: actionPath,
	    debug: false,
	    onComplete: function(id, fileName, json) {
	    	$(json.html).prependTo("table#listing > tbody");
	    	NA.editable();
	    	NA.deletable();
            NA.thickbox.reinit();
	    }
	}); 
};

// Load remote upload
NA.remoteUpload = function() {
	$('.remote-upload').editable({
		url: Croogo.basePath+'admin/nodeattachment/nodeattachments/remote.json',
		type: 'text',
	    display: false,
        success: function (response, newValue) {
            $("table#listing > tbody").prepend(response.html)
	    	NA.editable();
	    	NA.deletable(); 
            NA.thickbox.reinit();
        },
        error: function (response, newValue) {
            return response.responseText;
        }
	});
};

// Load editable
NA.editable = function() {
	$('.editable').editable({
		url: Croogo.basePath+'admin/nodeattachment/nodeattachments/update',
		type: 'text'
	});
};

// Sortable fnc
NA.sortable = function() {
	$('.sortable').sortable({
		stop: function(e, ui) {
			var actionPath = NA.pluginPath+'sort.json?'+ $(this).sortable('serialize');
			$.get(actionPath, function(data) {
			});
		}
	});
};

// Delete nodeattachment
NA.deletable = function() {
	$('a.delete').click(function(e) {
		var actionPath = $(this).attr('href');
		var row = $(this);
		$.ajax({
			url: actionPath,
			type: 'post'})			
			.done(function(data) {				
				if (data.success == true) {
					row.closest('tr').remove();
				}
			});		
		return false;
	});
};

// remove all thickbox from page
NA.thickbox = {
    remove: function () {
        $('.thickbox').each(function(i) {
            $(this).unbind('click');
        })},
    init: function () {
        tb_init('a.thickbox, area.thickbox, input.thickbox');        
    }
};

// reinit thickbox 
NA.thickbox.reinit = function() {
    NA.thickbox.remove();
    NA.thickbox.init();
}

// Document ready
$(document).ready(function() {
		NA.documentReady();
});