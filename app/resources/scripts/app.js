// Script

import ace from 'brace'
import 'brace/mode/javascript'
import 'brace/theme/ambiance'
import 'brace/worker/javascript'

function appendAce( $el ) {
	jQuery( $el ).each(function () {
		if(jQuery(jQuery(this)).is(":visible")) {
			var textarea = jQuery(this);
			var mode = textarea.data('editor');
			var editDiv = jQuery('<div>', {
					position: 'absolute',
					width: '100%',
					height: textarea.closest('.acf-field').height(),
					'class': textarea.attr('class')
			}).insertBefore(textarea);
			textarea.css('display', 'none').removeClass('aced');
			var editor = ace.edit(editDiv[0]);
			editor.renderer.setShowGutter(true);
			editor.getSession().setValue(textarea.val());
			editor.getSession().setMode({path:"ace/mode/javascript", inline:true});
			editor.setTheme("ace/theme/ambiance");
			// editor.setTheme("ace/theme/idle_fingers");

			// copy back to textarea on form submit...
			textarea.closest('form').submit(function () {
					textarea.val(editor.getSession().getValue());
			})
		}
	});
}
jQuery( document ).ready(function() {
	 jQuery('.acf-code textarea').addClass('aced');

	 appendAce('.acf-code textarea.aced');

	 if(typeof acf !== 'undefined') {
		 acf.add_action('append', function( $el ){
		 	appendAce('.acf-code textarea.aced');
		 })
	 }

	 if(typeof acf !== 'undefined') {
		 acf.add_action('show_field', function( $field, context ){
		 	appendAce('.acf-code textarea.aced');
		 });
	 }

});
