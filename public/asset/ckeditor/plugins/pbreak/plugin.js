CKEDITOR.plugins.add( 'pbreak',
{
	init: function( editor )
	{
		 var pluginName = 'pbreak';
          editor.ui.addButton( 'pbreak',
			{
				label: 'Add Page Break',
				command: 'addPageBreak',
				icon: this.path + 'image/page_break_insert.png'
			});
       var cmd = editor.addCommand( 'addPageBreak',{exec:addPageBreak});
	}
});

function addPageBreak(e)
{
	e.insertHtml("<hr class='page-break'>");
}




