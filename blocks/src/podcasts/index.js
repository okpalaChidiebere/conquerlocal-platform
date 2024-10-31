import edit from './edit';

export const name = cl_blocks.i18n.block_podcasts_name;

export const settings = {
    title: cl_blocks.i18n.block_podcasts_title,
	description: cl_blocks.i18n.block_podcasts_description,
	icon: 'category',
	category: 'conquer-local', 
	supports: {
		customClassName: false,
	},
	edit,
	// Render via PHP
	save: function( props ) {
		return null;
	},
}