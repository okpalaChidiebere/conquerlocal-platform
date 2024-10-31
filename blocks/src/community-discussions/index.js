import edit from './edit';

export const name = cl_blocks.i18n.block_community_discussions_name;

export const settings = {
    title: cl_blocks.i18n.block_community_discussions_title,
	description: cl_blocks.i18n.block_community_discussions_description,
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