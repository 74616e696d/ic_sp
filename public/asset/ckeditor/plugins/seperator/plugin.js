CKEDITOR.plugins.add( 'seperator',
{
	init: function( editor )
	{
		 var pluginName = 'seperator';
          editor.ui.addButton( 'seperator',
			{
				label: 'Ans Seperator',
				command: 'insertSeperator',
				icon: this.path + 'image/menu.png'
			});
       var cmd = editor.addCommand( 'insertSeperator',{exec:addSeperator});
	}
});

function addSeperator(e)
{
	e.insertHtml('///');
}




