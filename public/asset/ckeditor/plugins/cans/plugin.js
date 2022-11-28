CKEDITOR.plugins.add( 'cans',
{
	init: function( editor )
	{
		 var pluginName = 'cans';
          editor.ui.addButton( 'cans',
			{
				label: 'Correct Answer',
				command: 'insertCorrectAnswer',
				icon: this.path + 'image/ok.png'
			});
       var cmd = editor.addCommand( 'insertCorrectAnswer',{exec:addCorrectAnswer});
	}
});

function addCorrectAnswer(e)
{
	e.insertHtml('@@');
}




